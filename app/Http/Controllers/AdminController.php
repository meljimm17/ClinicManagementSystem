<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\PatientQueue;
use App\Models\MedicalRecord;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Display the Admin Dashboard.
     */
    public function dashboard()
    {
        $recentQueue = PatientQueue::with('patient')->latest()->take(5)->get();

        // Real stats from DB
        $totalPatients          = Patient::count();
        $completedConsultations = MedicalRecord::where('record_status', 'completed')->count();
        $activeQueueCount       = PatientQueue::whereIn('status', ['waiting', 'diagnosing'])
                                    ->whereDate('created_at', today())
                                    ->count();

        // For the dashboard user table
        $recentUsers = User::latest()->take(6)->get();

        // Daily patient volume for the bar chart (last 7 days, Mon–Sun of current week)
        $weekData = [];
        for ($i = 6; $i >= 0; $i--) {
            $day = now()->subDays($i);
            $weekData[] = [
                'label' => $day->format('D'),
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

        return view('admin.dashboard', compact(
            'recentQueue',
            'totalPatients',
            'completedConsultations',
            'activeQueueCount',
            'recentUsers',
            'weekData',
            'topDiagnoses',
            'diagTotal'
        ));
    }

    /**
     * User Management View.
     */
    public function administration()
    {
        $users = User::all();
        return view('admin.administration', compact('users'));
    }

    public function schedule()
    {
        return view('admin.schedule');
    }

    public function reports()
    {
        $totalPatients          = Patient::count();
        $totalConsultations     = MedicalRecord::where('record_status', 'completed')->count();
        $recordsFiled           = MedicalRecord::whereMonth('created_at', now()->month)->count();

        // Average wait time in minutes (queued_at → called_at)
        $avgWaitMinutes = PatientQueue::whereNotNull('called_at')
            ->selectRaw('AVG(TIMESTAMPDIFF(MINUTE, queued_at, called_at)) as avg_wait')
            ->value('avg_wait');
        $avgWaitMinutes = $avgWaitMinutes ? round($avgWaitMinutes) : 0;

        // Daily volume for chart (last 7 days)
        $weekData = [];
        for ($i = 6; $i >= 0; $i--) {
            $day = now()->subDays($i);
            $weekData[] = [
                'label' => $day->format('D'),
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

        // Per-doctor summary for the monthly table
        $doctorStats = Doctor::with('user')
            ->withCount([
                'medicalRecords as patients_seen' => fn($q) =>
                    $q->whereMonth('consultation_date', now()->month),
            ])
            ->withAvg(
                ['medicalRecords as avg_duration' => fn($q) =>
                    $q->whereMonth('consultation_date', now()->month)
                      ->whereNotNull('duration_minutes')],
                'duration_minutes'
            )
            ->get();

        return view('admin.reports', compact(
            'totalPatients',
            'totalConsultations',
            'recordsFiled',
            'avgWaitMinutes',
            'weekData',
            'topDiagnoses',
            'diagTotal',
            'doctorStats'
        ));
    }

    /**
     * Store new appointments from the schedule modal.
     */
    public function storeSchedule(Request $request)
    {
        $request->validate(['title' => 'required', 'date' => 'required']);
        // Add your Appointment model creation logic here
        return back()->with('success', 'Appointment scheduled successfully.');
    }

    /**
     * User CRUD Operations.
     */
    public function storeUser(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:8',
            'role'     => 'required',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
            'status'   => 'active',
        ]);

        return back()->with('success', 'User created successfully.');
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update($request->only(['name', 'email', 'role', 'status']));
        return back()->with('success', 'User updated successfully.');
    }

    public function destroyUser($id)
    {
        User::findOrFail($id)->delete();
        return back()->with('success', 'User removed.');
    }

    public function saveSettings(Request $request)
    {
        return back()->with('success', 'Clinic settings updated.');
    }

    public function exportReports()
    {
        // Logic for CSV export
        return back()->with('success', 'Report export started.');
    }
}