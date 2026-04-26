<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Doctor;
use App\Models\PatientQueue;
use App\Models\MedicalRecord;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DoctorController extends Controller
{
    // Show doctor dashboard with queue filtered by their room
    public function dashboard()
{
    $user       = Auth::user();
    $doctor     = $user->doctor;
    $doctorId   = $doctor?->id;
    $doctorRoom = $doctor?->assigned_room ?? null;

    $queue = PatientQueue::with(['patient', 'priority'])
        ->whereDate('created_at', today())
        ->where(function ($query) use ($doctorRoom) {
            $query->where('status', 'waiting');

            if ($doctorRoom) {
                $query->orWhere(function ($subQuery) use ($doctorRoom) {
                    $subQuery->where('status', 'diagnosing')
                        ->where('assigned_room', $doctorRoom);
                });
            }
        })
        ->orderByDesc(
            DB::table('patient_queue_priorities')
                ->selectRaw('1')
                ->whereColumn('patient_queue_priorities.patient_queue_id', 'patient_queue.id')
                ->limit(1)
        )
        ->orderBy('queued_at', 'asc')
        ->orderBy('id', 'asc')
        ->get();

    $activeQueue = $queue->firstWhere('status', 'diagnosing');

    // Missing variables
    $patientsSeen = MedicalRecord::where('doctor_id', $doctorId)
        ->whereDate('consultation_date', today())
        ->count();

    $avgMinutes = MedicalRecord::query()
        ->join('patient_queue', 'medical_records.queue_id', '=', 'patient_queue.id')
        ->where('medical_records.doctor_id', $doctorId)
        ->whereNull('patient_queue.deleted_at')
        ->whereDate('medical_records.consultation_date', today())
        ->whereNotNull('patient_queue.called_at')
        ->whereNotNull('patient_queue.completed_at')
        ->selectRaw('AVG(TIMESTAMPDIFF(MINUTE, patient_queue.called_at, patient_queue.completed_at)) as avg_minutes')
        ->value('avg_minutes');

    $avgMinutes = $avgMinutes ? round($avgMinutes) : null;

    $remainingCount = $queue->where('status', 'waiting')->count();

    $recentActivity = PatientQueue::with('patient')
        ->whereDate('created_at', today())
        ->whereIn('status', ['diagnosing', 'done'])
        ->orderByDesc('updated_at')
        ->orderByDesc('id')
        ->take(10)
        ->get();

    return view('doctor.dashboard', compact(
        'queue', 'activeQueue', 'doctor',
        'patientsSeen', 'avgMinutes', 'remainingCount', 'recentActivity'
    ));
}

    // Show full patient queue page for doctor
    public function queue()
    {
        $doctor     = Auth::user()->doctor;
        $doctorRoom = $doctor?->assigned_room ?? null;

        // Only show waiting/diagnosing — done patients go to medical records
        $queue = PatientQueue::with(['patient', 'priority'])
            ->whereDate('created_at', today())
            ->where(function ($query) use ($doctorRoom) {
                $query->where('status', 'waiting');

                if ($doctorRoom) {
                    $query->orWhere(function ($subQuery) use ($doctorRoom) {
                        $subQuery->where('status', 'diagnosing')
                            ->where('assigned_room', $doctorRoom);
                    });
                }
            })
            ->orderByDesc(
                DB::table('patient_queue_priorities')
                    ->selectRaw('1')
                    ->whereColumn('patient_queue_priorities.patient_queue_id', 'patient_queue.id')
                    ->limit(1)
            )
            ->orderBy('queued_at', 'asc')
            ->orderBy('id', 'asc')
            ->get();

        return view('doctor.patientqueue', compact('queue', 'doctor'));
    }

    // Mark a queue entry as "diagnosing" when doctor starts consultation
    public function startConsultation(PatientQueue $patientQueue)
    {
        $doctorRoom = Auth::user()?->doctor?->assigned_room;

        $patientQueue->update([
            'status'    => 'diagnosing',
            'called_at' => now(),
            'assigned_room' => $doctorRoom ?: $patientQueue->assigned_room,
        ]);

        return response()->json(['success' => true]);
    }

    // Mark patient as "diagnosing" when clicked by doctor (AJAX)
    public function callPatient(PatientQueue $patientQueue)
    {
        $doctorRoom = Auth::user()?->doctor?->assigned_room;

        // Reset any previously diagnosing patient back to waiting
        PatientQueue::where('status', 'diagnosing')
            ->whereDate('created_at', today())
            ->where('id', '!=', $patientQueue->id)
            ->update(['status' => 'waiting', 'called_at' => null]);

        // Mark selected patient as diagnosing
        $patientQueue->update([
            'status'    => 'diagnosing',
            'called_at' => now(),
            'assigned_room' => $doctorRoom ?: $patientQueue->assigned_room,
        ]);

        return response()->json(['success' => true]);
    }

    // Mark patient as "done" when consultation is complete
    public function completePatient(PatientQueue $patientQueue)
    {
        $patientQueue->update([
            'status'       => 'done',
            'completed_at' => now(),
        ]);

        return redirect()->route('doctor.queue')
            ->with('success', 'Patient ' . $patientQueue->display_queue_number . ' marked as done.');
    }

    // Save the medical record and mark queue as done
     public function storeRecord(Request $request)
{
    $request->validate([
        'diagnosis'  => 'required|string',
    ]);

    // 1. Get the authenticated doctor's profile
    $doctor = Auth::user()->doctor;

    if (!$doctor) {
        return back()->with('error', 'Critical Error: No doctor profile found for your account.');
    }

    $queue = $request->queue_id ? PatientQueue::with('patient')->find($request->queue_id) : null;

    // 2. Save the record with automatic fields
    $payload = [
        'queue_id'          => $request->queue_id,
        'doctor_id'         => $doctor->id,
        'patient_id'        => $queue?->patient_id,
        'patient_name'      => $queue?->patient_name ?? $queue?->patient?->name ?? 'Unknown Patient',
        'symptoms'          => $request->symptoms ?? $queue?->symptoms,
        'diagnosis'         => $request->diagnosis,
        'prescription'      => $request->prescription,
        'notes'             => $request->notes,
        'record_status'     => $request->record_status ?? 'completed',
        'consultation_date' => now()->format('Y-m-d'),
        'consultation_time' => now()->format('H:i:s'),
    ];
    MedicalRecord::updateOrCreate(
        ['queue_id' => $payload['queue_id']],
        [
            'patient_id'        => $payload['patient_id'],
            'patient_name'      => $payload['patient_name'],
            'doctor_id'         => $payload['doctor_id'],
            'symptoms'          => $payload['symptoms'],
            'diagnosis'         => $payload['diagnosis'],
            'prescription'      => $payload['prescription'],
            'notes'             => $payload['notes'],
            'record_status'     => $payload['record_status'],
            'consultation_date' => $payload['consultation_date'],
            'consultation_time' => $payload['consultation_time'],
        ]
    );

    // 3. Close the queue entry
    if ($request->queue_id) {
        PatientQueue::find($request->queue_id)?->update([
            'status'       => 'done',
            'completed_at' => now(),
            'assigned_room' => $doctor->assigned_room,
        ]);
    }

    return redirect()->route('doctor.queue')
        ->with('success', 'Consultation saved for ' . $doctor->assigned_room);
}

    // Generate a printable PDF prescription from the current diagnosis form (without saving)
    public function printPrescription(Request $request)
    {
        $request->validate([
            'queue_id'     => 'required|exists:patient_queue,id',
            'diagnosis'    => 'nullable|string',
            'prescription' => 'nullable|string',
            'notes'        => 'nullable|string',
            'symptoms'     => 'nullable|string',
        ]);

        $doctor = Auth::user()->doctor;
        $queue = PatientQueue::with('patient')->findOrFail($request->queue_id);

        $data = [
            'doctorName'       => $doctor?->name ?? Auth::user()->name,
            'patientName'      => $queue->patient?->name ?? 'N/A',
            'consultationDate' => now()->format('M d, Y'),
            'consultationTime' => now()->format('h:i A'),
            'symptoms'         => $request->symptoms ?? $queue->symptoms,
            'diagnosis'        => $request->diagnosis,
            'prescription'     => $request->prescription,
            'notes'            => $request->notes,
            'generatedAt'      => now(),
        ];

        $pdf = Pdf::loadView('doctor.prescription-draft-pdf', $data)->setPaper('a4', 'portrait');

        return $pdf->stream('Prescription-Draft-' . $queue->id . '.pdf');
    }

    // Manage doctors list (admin use)
    public function index()
    {
        $doctors = Doctor::all();
        return view('doctors', compact('doctors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'           => 'required|string|max:255',
            'specialization' => 'nullable|string|max:255',
            'license_number' => 'nullable|string|unique:doctors,license_number',
            'assigned_room'  => 'nullable|string|max:50',
        ]);

        Doctor::create($request->all());

        return redirect()->back()->with('success', 'Doctor added successfully!');
    }
}