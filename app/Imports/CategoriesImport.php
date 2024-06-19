<?php

namespace App\Imports;

use Modules\Product\Entities\Category;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CategoriesImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Category([
            'category_code' => $this->generateCategoryCode(),
            'category_name' => $row['kategori'], // Sesuaikan dengan header kolom di file Excel
        ]);
    }

    private function generateCategoryCode()
    {
        $prefix = 'CA_';
        $uniqueId = strtoupper(uniqid());

        return $prefix . $uniqueId;
    }
}
