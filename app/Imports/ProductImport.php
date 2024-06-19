<?php

namespace App\Imports;

use Modules\Product\Entities\Product;
use Modules\Product\Entities\Category;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // dd($row); // Uncomment for debugging

        // Create or find the category based on 'kategori' column from the imported data
        $category = Category::firstOrCreate(['category_name' => $row['kategori']]);

        // Return new Product model with mapped columns
        return new Product([
            'category_id' => $category->id,
            'product_name' => $row['nama_barang'],
            'product_code' => $row['kode_barang'],
            'product_quantity' => $row['stok'],
            'product_price' => $row['harga_jual'],
            'product_unit' => $row['satuan'],
        ]);
    }
}

