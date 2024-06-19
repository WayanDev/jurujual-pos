<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PredictionController extends Controller
{
    public function index()
    {
        return view('upload');
    }

    public function uploadFile(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        $file = $request->file('file');

        // Menggunakan metode store untuk mengunggah file ke storage Laravel
        $filePath = $file->storeAs('uploads', $file->getClientOriginalName());

        // Mendapatkan path lengkap dari file yang diunggah
        $fileFullPath = storage_path('app/' . $filePath);

        // Mengirim file Excel ke Flask API
        $response = Http::attach(
            'file',
            file_get_contents($fileFullPath),
            $file->getClientOriginalName()
        )->post('http://127.0.0.1:5000/predict');

        // Mendapatkan respons dari Flask API
        $data = $response->json();

        // Mengonversi nama kolom "Product Line" menjadi "Product_Line" agar sesuai dengan notasi laravel
        $predictions = collect($data['Prediction'])->map(function ($item) {
            return [
                'Product_Line' => $item['Product Line'],
                'Random_Forest_Regressor' => $item['Predicted Quantity'], // Sesuaikan dengan nama kolom yang dihasilkan oleh Flask
                'Safe_Stock' => $item['Safe Stock'] // Tambahkan kolom Safe Stock jika diperlukan
            ];
        });

        // Mengonversi nama kolom "Model" menjadi "Model_Name" agar sesuai dengan notasi laravel
        $accuracy = collect($data['Accuracy'])->map(function ($item) {
            return [
                'Model_Name' => $item['Model'],
                'MSE' => $item['MSE'],
                'RMSE' => $item['RMSE'],
                'R_squared' => $item['R-squared']
            ];
        });

        return view('upload', ['predictions' => $predictions, 'accuracy' => $accuracy]);
    }
}
