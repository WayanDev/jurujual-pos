<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\DataTables\PredictionsDataTable;
use App\DataTables\SalesPredictionsDataTable;

class SalesPredictionController extends Controller
{
    private $apiBaseUrl = 'http://127.0.0.1:5000'; // Ganti dengan URL Flask API Anda

    public function index()
    {
        return view('predictions-penjualan.index'); // Adjust the view name as per your application structure
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
            return redirect()->route('prediksi-penjualan')->with('status', 'Model berhasil di-reset.');
        } catch (\Exception $e) {
            return redirect()->route('prediksi-penjualan')->with('status', 'Server Machine Learning Belum Berjalan.');
        }
    }
}
