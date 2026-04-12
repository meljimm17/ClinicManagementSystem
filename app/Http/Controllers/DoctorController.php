<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Doctor;
use App\Models\PatientQueue;
use App\Models\MedicalRecord;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    // Show doctor dashboard with queue filtered by their room
    public function dashboard()
    {
        $doctor     = Auth::user()->doctor;
        $doctorRoom = $doctor?->assigned_room ?? null;

        $queue = PatientQueue::with('patient')
            ->whereDate('created_at', today())
            ->whereIn('status', ['waiting', 'diagnosing']) // only show active patients
            ->orderBy('created_at')
            ->get();

        $activeQueue = $queue->firstWhere('status', 'diagnosing');

        return view('doctor.dashboard', compact('queue', 'activeQueue', 'doctor'));
    }

    // Show full patient queue page for doctor
    public function queue()
    {
        $doctor     = Auth::user()->doctor;
        $doctorRoom = $doctor?->assigned_room ?? null;

        // Only show waiting/diagnosing — done patients go to medical records
        $queue = PatientQueue::with('patient')
            ->whereDate('created_at', today())
            ->whereIn('status', ['waiting', 'diagnosing'])
            ->orderBy('created_at')
            ->get();

        return view('doctor.patientqueue', compact('queue', 'doctor'));
    }

    // Mark a queue entry as "diagnosing" when doctor starts consultation
    public function startConsultation(PatientQueue $patientQueue)
    {
        $patientQueue->update([
            'status'    => 'diagnosing',
            'called_at' => now(),
        ]);

        return response()->json(['success' => true]);
    }

    // Mark patient as "diagnosing" when clicked by doctor (AJAX)
    public function callPatient(PatientQueue $patientQueue)
    {
        // Reset any previously diagnosing patient back to waiting
        PatientQueue::where('status', 'diagnosing')
            ->whereDate('created_at', today())
            ->where('id', '!=', $patientQueue->id)
            ->update(['status' => 'waiting', 'called_at' => null]);

        // Mark selected patient as diagnosing
        $patientQueue->update([
            'status'    => 'diagnosing',
            'called_at' => now(),
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
            ->with('success', 'Patient ' . $patientQueue->queue_number . ' marked as done.');
    }

    // Save the medical record and mark queue as done
    public function storeRecord(Request $request)
    {
        $request->validate([
            'queue_id'          => 'nullable|exists:patient_queue,id',
            'patient_id'        => 'required|exists:patients,id',
            'doctor_id'         => 'nullable|exists:doctors,id',
            'diagnosis'         => 'nullable|string',
            'prescription'      => 'nullable|string',
            'notes'             => 'nullable|string',
            'record_status'     => 'required|in:draft,held_for_labs,completed',
            'consultation_date' => 'required|date',
            'consultation_time' => 'nullable',
        ]);

        // Save the medical record
        MedicalRecord::create([
            'queue_id'          => $request->queue_id,
            'patient_id'        => $request->patient_id,
            'doctor_id'         => $request->doctor_id,
            'symptoms'          => PatientQueue::find($request->queue_id)?->symptoms,
            'diagnosis'         => $request->diagnosis,
            'prescription'      => $request->prescription,
            'notes'             => $request->notes,
            'record_status'     => $request->record_status,
            'assigned_room'     => Auth::user()->doctor?->assigned_room,
            'consultation_date' => $request->consultation_date,
            'consultation_time' => $request->consultation_time,
        ]);

        // Mark queue entry as done — patient disappears from queue and goes to medical records
        if ($request->queue_id) {
            PatientQueue::find($request->queue_id)?->update([
                'status'       => 'done',
                'completed_at' => now(),
            ]);
        }

        $messages = [
            'completed'     => 'Medical record saved and patient marked as done!',
            'held_for_labs' => 'Patient held for labs. Record saved as pending.',
            'draft'         => 'Draft saved.',
        ];

        return redirect()->route('doctor.queue')
            ->with('success', $messages[$request->record_status]);
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