<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\DataTables\PredictionsDataTable;
use App\DataTables\SalesPredictionsDataTable;
use App\Models\TrainingHistoryPenjualan;

class SalesPredictionController extends Controller
{

    public function showTrainForm()
    {
        $trainingHistoriesPenjualan = TrainingHistoryPenjualan::orderByDesc('training_time')->paginate(10);
        return view('predictions-penjualan.train', compact('trainingHistoriesPenjualan'));
    }
    public function deleteTrainingHistory($id)
    {
        try {
            $history = TrainingHistoryPenjualan::findOrFail($id);
            $history->delete();

            return redirect()->route('train-model-penjualan')->with('status', 'History training berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('train-model-penjualan')->with('status', 'Gagal menghapus history training.');
        }
    }


    private $apiBaseUrl = 'http://127.0.0.1:5000'; // Ganti dengan URL Flask API Anda

    public function index()
    {
        return view('predictions-penjualan.index');
    }

    public function predictSales(Request $request, SalesPredictionsDataTable $dataTable)
    {
        $years = $request->input('years');

        try {
            $response = Http::timeout(300)->post($this->apiBaseUrl . '/predict-penjualan', [
                'years' => $years,
            ]);

            if ($response->successful()) {
                $predictions = $response->json()['predictions'];
                return $dataTable->with('data', collect($predictions))->render('predictions-penjualan.index');
            } else {
                return $dataTable->with('data', collect([]))->render('predictions-penjualan.index', ['error' => 'Gagal mengambil data prediksi.']);
            }
        } catch (\Exception $e) {
            return $dataTable->with('data', collect([]))->render('predictions-penjualan.index', ['error' => 'Server Machine Learning Belum Berjalan.']);
        }
    }

    public function trainModel(Request $request)
    {
        try {
            $response = Http::post($this->apiBaseUrl . '/train-penjualan');

            if ($response->successful()) {
                $evaluation = $response->json()['evaluation'];
                return redirect()->back()->with('status', 'Model berhasil dilatih.')->with('evaluation', $evaluation);
            } else {
                return redirect()->back()->with('status', 'Gagal melatih model.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('status', 'Server Machine Learning Belum Berjalan.');
        }
    }

    public function reset()
    {
        try {
            $resetResponse = Http::post('http://127.0.0.1:5000/reset-penjualan');
            return redirect()->route('train-model-penjualan')->with('status', 'Model berhasil di-reset.');
        } catch (\Exception $e) {
            return redirect()->route('train-model-penjualan')->with('status', 'Server Machine Learning Belum Berjalan.');
        }
    }
}
