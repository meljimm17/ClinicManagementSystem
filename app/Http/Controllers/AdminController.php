<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\PatientQueue;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Display the Admin Dashboard.
     */
    public function dashboard()
    {
        // Fixes "Undefined variable $recentQueue" for Admin
        $recentQueue = PatientQueue::with('patient')->latest()->take(5)->get();
        return view('admin.dashboard', compact('recentQueue'));
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
        return view('admin.reports');
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
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'role' => 'required'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'status' => 'active'
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
        // Example: Save to a settings table or config
        return back()->with('success', 'Clinic settings updated.');
    }

    public function exportReports() 
    {
        // Logic for CSV export
        return back()->with('success', 'Report export started.');
    }
}