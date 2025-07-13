<?php

namespace App\Http\Controllers;

use App\Models\Criteria;
use App\Models\Weight;
use App\Service\GeneticAlgorithmService;
use Illuminate\Http\Request;

class WeightController extends Controller
{
    public function index()
    {
        $criterias = Criteria::all();
        $saveWeights = Weight::with('criteria')->get();

        // Ambil data session jika ada hasil bobot terbaru
        $result = session('bobot_terbaik');

        return view('weights.index', compact('criterias', 'saveWeights', 'result'));
    }

    public function store(Request $request)
    {
        $force = $request->input('force') === 'true';

        // Jika data sudah ada dan tidak ada konfirmasi, jangan lanjutkan
        if (Weight::exists() && !$force) {
            return redirect()->back()->with('error', 'Data bobot sudah ada. Klik Generate lagi untuk mengonfirmasi penggantian.');
        }

        // Hapus bobot lama (jika ada dan user sudah konfirmasi)
        Weight::truncate();

        // Jalankan Genetic Algorithm
        $ga = new GeneticAlgorithmService();
        $result = $ga->run();

        $chromosome = $result['chromosome'];
        $generation = $result['generation'];
        $fitness = $result['fitness'];

        $criteria = Criteria::orderBy('id')->get();

        foreach ($criteria as $i => $criterium) {
            Weight::create([
                'criteria_id' => $criterium->id,
                'weight' => $chromosome[$i],
                'generation' => $generation
            ]);
        }

        return redirect()->route('staff-student.weights.index')->with('bobot_terbaik', [
            'chromosome' => $chromosome,
            'fitness' => $fitness,
            'generation' => $generation,
        ]);
    }

    public function editAll()
    {
        $weights = Weight::with('criteria')->orderBy('criteria_id')->get();

        if ($weights->isEmpty()) {
            return redirect()->route('staff-student.weights.index')->with('error', 'Data bobot belum tersedia. Silakan jalankan generate terlebih dahulu.');
        }

        return view('weights.edit', compact('weights'));
    }

    public function updateAll(Request $request)
    {
        $validated = $request->validate([
            'weights' => 'required|array',
            'weights.*' => 'numeric|min:0|max:1'
        ]);

        $totalWeight = array_sum($validated['weights']);

        foreach ($validated['weights'] as $id => $weight) {
            $model = Weight::find($id);
            if ($model) {
                $model->update([
                    'weight' => $weight,
                ]);
            }
        }

        return redirect()->route('staff-student.weights.index')->with('success', 'Bobot berhasil diperbarui secara manual.');
    }
}
