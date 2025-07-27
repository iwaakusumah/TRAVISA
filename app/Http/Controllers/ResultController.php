<?php

namespace App\Http\Controllers;

use App\Models\Period;
use App\Models\Result;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ResultController extends Controller
{
    public function showForm()
    {
        $periods = Period::all(); // Get all periods from database
        return view('results.form', compact('periods'));
    }
    public function index(Request $request)
    {
        $periods = Period::all();
        $periodId = $request->input('period_id');

        if (!$periodId) {
            // Jika belum pilih periode, tampilkan halaman dengan dropdown saja
            return view('results.index', compact('periods'))->with('results', collect());
        }

        $results = Result::with(['student', 'class', 'period'])->where('period_id', $periodId)->get();


        return view('results.index', compact('results', 'periods', 'periodId'));
    }
    public function exportPdf(Request $request)
    {
        $periodId = $request->input('period_id');
        $period = Period::find($periodId);

        if (!$period) {
            return redirect()->back()->with('error', 'Periode tidak ditemukan.');
        }

        $results = Result::with(['student', 'class', 'period'])
            ->where('period_id', $periodId)
            ->get();

        // ==== Auto-generate letter number ====
        $today = Carbon::now();
        $month = $today->translatedFormat('F');
        $year = $today->year;

        
        $suratCountThisYear = 4; 
        $number = str_pad($suratCountThisYear + 1, 3, '0', STR_PAD_LEFT); // misalnya 004

        $letterNumber = "TRAVINA-PRIMA/BEA/{$number}/{$month}/{$year}";

        $principalName = 'Sabaruddin Sinulingga, S.T., M.M';

        $sanitizedName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $period->name);
        $filename = 'hasil_periode_' . $sanitizedName . '.pdf';

        $city = config('app.city', 'Bekasi');
        $today = Carbon::now()->translatedFormat('d F Y');

        $pdf = Pdf::loadView('results.pdf', compact(
            'results',
            'period',
            'principalName',
            'letterNumber',
            'city',
            'today'
        ));

        return $pdf->stream($filename);
    }
}
