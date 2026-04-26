<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\PatientQueue;
use App\Models\MedicalRecord;
use App\Models\ReportSnapshot;
use App\Models\Setting;
use App\Models\CheckupType;
use App\Models\Payment;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Schema;

class AdminController extends Controller
{
    /**
     * Display the Admin Dashboard.
     */
    public function dashboard()
    {
        $recentQueue = PatientQueue::with('patient')
            ->latest('queued_at')
            ->take(5)
            ->get();

        // Real stats from DB
        $totalPatients          = Patient::count();
        $completedConsultations = MedicalRecord::where('record_status', 'completed')->count();
        $activeQueueCount       = PatientQueue::whereIn('status', ['waiting', 'diagnosing'])
                                    ->whereDate('created_at', today())
                                    ->count();

        // For the dashboard user table
        $recentUsers = User::latest()->take(6)->get();

        // Daily patient volume for this week (Mon -> Sun)
        $weekData = [];
        $weekStart = now()->copy()->startOfWeek(Carbon::MONDAY);
        $today = now()->copy()->startOfDay();
        $weekEnd = $weekStart->copy()->addDays(6);
        for ($day = $weekStart->copy(); $day->lte($weekEnd); $day->addDay()) {
            $weekData[] = [
                'label' => $day->format('l'),
                'count' => PatientQueue::whereDate('created_at', $day->toDateString())->count(),
            ];
        }

        // Daily patient volume for this month (month start -> today)
        $monthData = [];
        $monthStart = now()->copy()->startOfMonth();
        for ($day = $monthStart->copy(); $day->lte($today); $day->addDay()) {
            $monthData[] = [
                'label' => $day->format('M j'),
                'count' => PatientQueue::whereDate('created_at', $day->toDateString())->count(),
            ];
        }

        // Top diagnoses
        $topDiagnoses = MedicalRecord::whereNotNull('diagnosis')
            ->selectRaw('diagnosis, COUNT(*) as total')
            ->groupBy('diagnosis')
            ->orderByDesc('total')
            ->limit(6)
            ->get();

        $diagTotal = $topDiagnoses->sum('total') ?: 1; // avoid division by zero

        // Patient demographics distribution (age groups)
        $demographicsData = [
            ['label' => 'Children (0-12)', 'count' => Patient::whereBetween('age', [0, 12])->count()],
            ['label' => 'Teens (13-17)', 'count' => Patient::whereBetween('age', [13, 17])->count()],
            ['label' => 'Adults (18-59)', 'count' => Patient::whereBetween('age', [18, 59])->count()],
            ['label' => 'Seniors (60+)', 'count' => Patient::where('age', '>=', 60)->count()],
        ];

        // Billing stats
        $todayRevenue = Payment::whereDate('created_at', today())
            ->where('status', 'paid')
            ->sum('amount');
        
        $todayPatients = PatientQueue::whereDate('created_at', today())->count();
        
        $todayPaidCount = Payment::whereDate('created_at', today())
            ->where('status', 'paid')
            ->count();
        
        $todayUnpaidCount = Payment::whereDate('created_at', today())
            ->where('status', 'unpaid')
            ->count();

        // Most common checkup type today
        $mostCommonCheckup = PatientQueue::whereDate('created_at', today())
            ->whereNotNull('checkup_type_id')
            ->selectRaw('checkup_type_id, COUNT(*) as total')
            ->groupBy('checkup_type_id')
            ->orderByDesc('total')
            ->first();
        
        $mostCommonCheckupType = null;
        if ($mostCommonCheckup) {
            $mostCommonCheckupType = CheckupType::find($mostCommonCheckup->checkup_type_id);
        }

        return view('admin.dashboard', compact(
            'recentQueue',
            'totalPatients',
            'completedConsultations',
            'activeQueueCount',
            'recentUsers',
            'weekData',
            'monthData',
            'topDiagnoses',
            'diagTotal',
            'demographicsData',
            'todayRevenue',
            'todayPatients',
            'todayPaidCount',
            'todayUnpaidCount',
            'mostCommonCheckupType'
        ));
    }

    /**
     * User Management View.
     */
    public function administration()
    {
        $users = User::with('doctor')->orderByDesc('created_at')->orderByDesc('id')->get();
        return view('admin.administration', compact('users'));
    }

    public function support()
    {
        return view('support');
    }

    /**
     * Checkup Types Management
     */
    public function checkupTypes()
    {
        $checkupTypes = CheckupType::orderBy('name')->get();
        return view('admin.checkup-types', compact('checkupTypes'));
    }

    public function storeCheckupType(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:checkup_types,name',
            'fee' => 'required|numeric|min:0|max:999999.99',
            'is_active' => 'nullable|boolean',
        ]);

        CheckupType::create([
            'name' => $request->name,
            'fee' => $request->fee,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->back()->with('success', 'Check-up type created successfully!');
    }

    public function updateCheckupType(Request $request, CheckupType $checkupType)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:checkup_types,name,' . $checkupType->id,
            'fee' => 'required|numeric|min:0|max:999999.99',
            'is_active' => 'nullable|boolean',
        ]);

        $checkupType->update([
            'name' => $request->name,
            'fee' => $request->fee,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->back()->with('success', 'Check-up type updated successfully!');
    }

    public function destroyCheckupType(CheckupType $checkupType)
    {
        $checkupType->delete();
        return redirect()->back()->with('success', 'Check-up type deleted successfully!');
    }

    /**
     * Billing Reports
     */
    public function billing(Request $request)
    {
        $date = $request->get('date', today()->toDateString());
        
        $payments = Payment::with(['visit.patient', 'visit.checkupType'])
            ->whereHas('visit', function ($query) use ($date) {
                $query->whereDate('queue_date', $date);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        $totalRevenue = $payments->where('status', 'paid')->sum('amount');
        $totalPending = $payments->where('status', 'unpaid')->sum('amount');
        $totalPatients = $payments->count();

        return view('admin.billing', compact('payments', 'date', 'totalRevenue', 'totalPending', 'totalPatients'));
    }

    public function schedule()
    {
        $staffList = Doctor::with('user')->orderBy('name')->get();

        $todayAssignments = MedicalRecord::with(['doctor.user', 'queue'])
            ->whereDate('consultation_date', today())
            ->whereNotNull('doctor_id')
            ->latest('consultation_time')
            ->get()
            ->groupBy('doctor_id')
            ->map(function ($records) {
                $record = $records->first();
                $doctorName = $record->doctor?->name
                    ?: $record->doctor?->user?->name
                    ?: 'Unknown Staff';

                $startTime = $record->consultation_time
                    ? Carbon::parse($record->consultation_time)->format('h:i A')
                    : 'N/A';

                return [
                    'name' => $doctorName,
                    'room' => $record->queue?->assigned_room ?: $record->doctor?->assigned_room ?: '1',
                    'shift' => $startTime . ' onwards',
                ];
            })
            ->values();

        $calendarEvents = MedicalRecord::selectRaw('DATE(consultation_date) as event_date, COUNT(*) as total')
            ->whereNotNull('consultation_date')
            ->whereBetween('consultation_date', [now()->subMonths(3)->startOfMonth(), now()->addMonths(3)->endOfMonth()])
            ->groupBy('event_date')
            ->get()
            ->keyBy('event_date')
            ->map(fn ($row) => (int) $row->total);

        return view('admin.schedule', compact('staffList', 'todayAssignments', 'calendarEvents'));
    }

    public function reports()
    {
        $data = $this->getReportData();

        return view('admin.reports', $data);
    }

    private function getReportData(): array
    {
        $totalPatients          = Patient::count();
        $totalConsultations     = MedicalRecord::where('record_status', 'completed')->count();
        $recordsFiled           = MedicalRecord::whereMonth('created_at', now()->month)->count();

        // Average wait time in minutes (queued_at → called_at)
        $avgWaitMinutes = PatientQueue::whereNotNull('called_at')
            ->selectRaw('AVG(TIMESTAMPDIFF(MINUTE, queued_at, called_at)) as avg_wait')
            ->value('avg_wait');
        $avgWaitMinutes = $avgWaitMinutes ? round($avgWaitMinutes) : 0;

        // Daily volume for this week (Mon -> Sun)
        $weekData = [];
        $weekStart = now()->copy()->startOfWeek(Carbon::MONDAY);
        $weekEnd = $weekStart->copy()->addDays(6);
        for ($day = $weekStart->copy(); $day->lte($weekEnd); $day->addDay()) {
            $weekData[] = [
                'label' => $day->format('l'),
                'count' => PatientQueue::whereDate('created_at', $day->toDateString())->count(),
            ];
        }

        // Daily volume for this month (month start -> today)
        $monthData = [];
        $monthStart = now()->copy()->startOfMonth();
        $today = now()->copy()->startOfDay();
        for ($day = $monthStart->copy(); $day->lte($today); $day->addDay()) {
            $monthData[] = [
                'label' => $day->format('M j'),
                'count' => PatientQueue::whereDate('created_at', $day->toDateString())->count(),
            ];
        }

        // Top diagnoses
        $topDiagnoses = MedicalRecord::whereNotNull('diagnosis')
            ->selectRaw('diagnosis, COUNT(*) as total')
            ->groupBy('diagnosis')
            ->orderByDesc('total')
            ->limit(6)
            ->get();

        $diagTotal = $topDiagnoses->sum('total') ?: 1;

        $demographicsData = [
            ['label' => 'Children (0-12)', 'count' => Patient::whereBetween('age', [0, 12])->count()],
            ['label' => 'Teens (13-17)', 'count' => Patient::whereBetween('age', [13, 17])->count()],
            ['label' => 'Adults (18-59)', 'count' => Patient::whereBetween('age', [18, 59])->count()],
            ['label' => 'Seniors (60+)', 'count' => Patient::where('age', '>=', 60)->count()],
        ];

        // Per-doctor summary for the monthly table
        $doctorStats = Doctor::with('user')
            ->withCount([
                'medicalRecords as patients_seen' => fn($q) =>
                    $q->whereMonth('consultation_date', now()->month),
            ])
            ->orderBy('name', 'asc')
            ->get();

        // Better consultation-time metric: use queue timestamps (called -> completed)
        $queueBasedAverages = MedicalRecord::query()
            ->join('patient_queue', 'medical_records.queue_id', '=', 'patient_queue.id')
            ->whereNotNull('medical_records.doctor_id')
            ->whereNull('patient_queue.deleted_at')
            ->whereNotNull('patient_queue.called_at')
            ->whereNotNull('patient_queue.completed_at')
            ->whereMonth('medical_records.consultation_date', now()->month)
            ->selectRaw('medical_records.doctor_id, AVG(TIMESTAMPDIFF(MINUTE, patient_queue.called_at, patient_queue.completed_at)) as avg_consultation')
            ->groupBy('medical_records.doctor_id')
            ->pluck('avg_consultation', 'medical_records.doctor_id');

        $doctorStats = $doctorStats->map(function ($doctor) use ($queueBasedAverages) {
            $queueAvg = $queueBasedAverages->get($doctor->id);
            $doctor->consultation_avg = $queueAvg !== null
                ? round((float) $queueAvg, 1)
                : null;
            return $doctor;
        });

        if (Schema::hasTable('report_snapshots')) {
            ReportSnapshot::updateOrCreate(
                ['snapshot_date' => now()->toDateString()],
                [
                    'total_patients' => $totalPatients,
                    'total_consultations' => $totalConsultations,
                    'records_filed' => $recordsFiled,
                    'avg_wait_minutes' => $avgWaitMinutes,
                    'top_diagnoses' => $topDiagnoses->map(fn ($item) => [
                        'diagnosis' => $item->diagnosis,
                        'total' => (int) $item->total,
                    ])->values()->all(),
                    'doctor_stats' => $doctorStats->map(fn ($doctor) => [
                        'doctor_id' => $doctor->id,
                        'name' => $doctor->name ?: ($doctor->user->name ?? 'Unknown Doctor'),
                        'specialization' => $doctor->specialization ?: 'N/A',
                        'patients_seen' => (int) $doctor->patients_seen,
                        'consultation_avg' => $doctor->consultation_avg,
                    ])->values()->all(),
                    'meta' => [
                        'generated_at' => now()->toDateTimeString(),
                        'timezone' => config('app.timezone'),
                    ],
                ]
            );
        }

        return compact(
            'totalPatients',
            'totalConsultations',
            'recordsFiled',
            'avgWaitMinutes',
            'weekData',
            'monthData',
            'topDiagnoses',
            'diagTotal',
            'doctorStats',
            'demographicsData'
        );
    }

    /**
     * Store new appointments from the schedule modal.
     */
    public function storeSchedule(Request $request)
    {
        $validated = $request->validate([
            'staff_id' => 'required|exists:doctors,id',
            'room_number' => 'required|string|max:20',
            'shift_type' => 'nullable|string|max:50',
            'start_at' => 'required|date',
            'end_at' => 'required|date|after:start_at',
        ]);

        Doctor::whereKey($validated['staff_id'])->update([
            'assigned_room' => $validated['room_number'],
        ]);

        return back()->with('success', 'Room assignment updated successfully.');
    }

    /**
     * User CRUD Operations.
     */
    public function storeUser(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'username' => [
                'required',
                'string',
                'max:255',
                Rule::unique('users', 'username')->whereNull('deleted_at'),
            ],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->whereNull('deleted_at'),
            ],
            'contact_number' => 'required|string|max:30',
            'address' => 'required|string|max:255',
            'password' => 'required|min:8',
            'password_confirmation' => 'required|same:password',
            'role'     => 'required',
            'specialization' => 'required_if:role,doctor|string|max:255',
            'license_number' => 'required_if:role,doctor|string|max:255|unique:doctors,license_number',
            'assigned_room' => 'required_if:role,doctor|string|max:50',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'contact_number' => $request->contact_number,
            'address' => $request->address,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
        ]);

        if ($request->role === 'doctor') {
            Doctor::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'name' => $request->name,
                    'specialization' => $request->specialization,
                    'license_number' => $request->license_number,
                    'assigned_room' => $request->assigned_room,
                ]
            );
        }

        return back()->with('success', 'User created successfully.');
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => [
                'required',
                'string',
                'max:255',
                Rule::unique('users', 'username')
                    ->whereNull('deleted_at')
                    ->ignore($user->id),
            ],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')
                    ->whereNull('deleted_at')
                    ->ignore($user->id),
            ],
            'contact_number' => 'required|string|max:30',
            'address' => 'required|string|max:255',
            'role' => 'required|in:admin,doctor,staff',
            'specialization' => 'required_if:role,doctor|string|max:255',
            'license_number' => [
                'required_if:role,doctor',
                'string',
                'max:255',
                Rule::unique('doctors', 'license_number')
                    ->ignore($user->doctor?->id),
            ],
            'assigned_room' => 'required_if:role,doctor|string|max:50',
        ]);

        $user->update($request->only(['name', 'username', 'email', 'contact_number', 'address', 'role']));

        if ($request->role === 'doctor') {
            Doctor::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'name' => $request->name,
                    'specialization' => $request->specialization,
                    'license_number' => $request->license_number,
                    'assigned_room' => $request->assigned_room,
                ]
            );
        } else {
            Doctor::where('user_id', $user->id)->delete();
        }

        return back()->with('success', 'User updated successfully.');
    }

    public function destroyUser($id)
    {
        User::findOrFail($id)->delete();
        return back()->with('success', 'User removed.');
    }

    public function saveSettings(Request $request)
    {
        $validated = $request->validate([
            'clinic_name' => 'required|string|max:255',
            'queue_format' => [
                'required',
                'string',
                'max:20',
                'regex:/^[A-Za-z0-9#-]*0*[1-9][0-9]*$/',
            ],
            'default_role' => 'required|in:admin,doctor,staff',
        ]);

        Setting::setMany([
            'clinic_name' => $validated['clinic_name'],
            'queue_format' => strtoupper($validated['queue_format']),
            'default_role' => $validated['default_role'],
        ]);

        return back()->with('success', 'Clinic settings updated.');
    }

    public function exportReports()
    {
        $data = $this->getReportData();
        $data['generatedAt'] = now();

        $pdf = Pdf::loadView('admin.reports_pdf', $data)->setPaper('a4', 'portrait');

        return $pdf->download('CuraSure-Report-' . now()->format('Y-m-d') . '.pdf');
    }
}