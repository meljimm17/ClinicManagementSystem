<?php

namespace App\Http\Controllers;

use App\Models\User; 
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function index()
    {
        // Fetches staff from your database to populate the table
        $staffData = User::where('role', 'staff')->get(); 

        return view('admin.reports', compact('staffData'));
    }

    public function exportPdf()
    {
        $staffData = User::where('role', 'staff')->get();
        
        // Ensure you have created the reports_pdf.blade.php file we discussed earlier
        $pdf = Pdf::loadView('admin.reports_pdf', compact('staffData'));
        
        return $pdf->download('CuraSure-Report-' . now()->format('Y-m-d') . '.pdf');
    }
}