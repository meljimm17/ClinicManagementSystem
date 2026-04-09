<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
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
        ]);

        Doctor::create($request->all());

        return redirect()->back()->with('success', 'Doctor added successfully!');
    }
}