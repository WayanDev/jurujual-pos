<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\DataTables\StockPredictionsDataTable;

class StockPredictionController extends Controller
{
    private $apiBaseUrl = 'http://127.0.0.1:5000'; // Ganti dengan URL Flask API Anda

    public function index()
    {
        $dataTable = new StockPredictionsDataTable();
        return $dataTable->render('predictions-stok.index'); // Sesuaikan dengan nama view yang tepat
    }

    public function predictStock(Request $request, StockPredictionsDataTable $dataTable)
    {
        $choice = $request->input('choice');
        $years = $request->input('years');

        $response = Http::timeout(300)->post($this->apiBaseUrl . '/predict-stok', [
            'choice' => $choice,
            'years' => $years,
        ]);

        if ($response->successful()) {
            $predictions = $response->json()['predictions'];
            return $dataTable->with('data', collect($predictions))->render('predictions-stok.index');
        } else {
            return $dataTable->with('data', collect([]))->render('predictions-stok.index', ['error' => 'Gagal mengambil data prediksi.']);
        }
    }


    public function trainStockModel()
    {
        // Kirim permintaan POST ke endpoint Flask '/train-stok'
        $response = Http::post($this->apiBaseUrl . '/train-stok');

        if ($response->successful()) {
            $evaluation = $response->json()['evaluation'];
            return redirect()->back()->with('status', 'Model stok berhasil dilatih.')->with('evaluation', $evaluation);
        } else {
            return redirect()->back()->with('status', 'Gagal melatih model stok.');
        }
    }

    public function resetStockPredictions()
    {
        // Kirim permintaan reset ke Flask
        $resetResponse = Http::post($this->apiBaseUrl . '/reset-stok');

        // Redirect kembali ke halaman prediksi dengan pesan status
        return redirect()->route('prediksi-stok')->with('status', 'Hasil prediksi stok berhasil di-reset.');
    }
}
