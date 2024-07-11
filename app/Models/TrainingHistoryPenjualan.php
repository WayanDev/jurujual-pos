<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingHistoryPenjualan extends Model
{
    use HasFactory;
    protected $table = 'training_histories_penjualan';

    protected $fillable = ['training_time', 'start_year', 'end_year', 'model_version', 'training_result'];
    // Cast the 'training_result' attribute to array
    protected $casts = [
        'training_result' => 'array',
    ];
}
