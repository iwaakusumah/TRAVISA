<?php

namespace App\Http\Controllers;

use App\Enums\Role;
use App\Models\Criteria;
use App\Models\Period;
use App\Models\Result;
use App\Service\PrometheeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CalculationController extends Controller
{
    // Method untuk menampilkan form
    public function showForm()
    {
        $periods = Period::all(); // Get all periods from database
        return view('calculations.form', compact('periods'));
    }
    // Menampilkan halaman utama dengan dropdown periode
    protected PrometheeService $prometheeService;

    public function __construct(PrometheeService $prometheeService)
    {
        $this->prometheeService = $prometheeService;
    }

    public function index(Request $request)
    {
        $periodId = $request->get('period_id');
        if (!$periodId) {
            return redirect()->back()->with('error', 'Periode belum dipilih.');
        }

        $data = $this->prometheeService->calculateByPeriod($periodId);
        $criteriaNames = Criteria::pluck('name', 'id')->toArray();
        $period = Period::find($periodId);

        // Tambahkan pengecekan role di sini
        $canSave = Auth::check() && Auth::user()->role !== 'headmaster';

        return view('calculations.index', [
            'allResults' => $data['results'],
            'evaluationMatrices' => $data['evaluationMatrices'],
            'preferenceMatrices' => $data['preferenceMatrices'],
            'differenceMatrices' => $data['differenceMatrices'],
            'allHMatrix' => $data['allHMatrix'],
            'criteriaNames' => $criteriaNames,
            'period' => $period,
            'canSave' => $canSave, // <-- kirim ke view
        ]);
    }

    public function storeLolos(Request $request)
    {
        $periodId = $request->input('period_id');

        if (!$periodId) {
            return redirect()->back()->with('error', 'Periode tidak ditemukan.');
        }

        // Hapus data lama di periode ini agar tidak ada data ganda
        Result::where('period_id', $periodId)->delete();

        $data = $this->prometheeService->calculateByPeriod($periodId);

        // Kirim seluruh hasil grouped, savePassingStudents hanya simpan rank 1 per group
        $this->prometheeService->savePassingStudents($data['results'], $periodId);

        return redirect()->back()->with('success', 'Data hasil seleksi berhasil disimpan.');
    }
}
