<?php

namespace App\Imports;

use Carbon\Carbon;
use Modules\Sale\Entities\Sale;
use Modules\People\Entities\Customer;
use Modules\Product\Entities\Product;
use Modules\Sale\Entities\SaleDetail;
use Modules\Sale\Entities\SaleDetails;
use Modules\Sale\Entities\SalePayment;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SalesImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Convert Excel date to PHP date format
        $date = Carbon::createFromTimestamp(($row['tanggal'] - 25569) * 86400)->format('Y-m-d');

        // Find or create customer
        $customer = Customer::firstOrCreate(['customer_name' => $row['pembeli']]);

        // Calculate payment status based on due amount
        $total_amount = intval($row['qty']) * intval($row['hargajual']) * (1 - intval($row['diskon']) / 100);
        $paid_amount = (int) $row['subtotal'];
        $due_amount = $total_amount - $paid_amount;

        if ($due_amount == $total_amount) {
            $payment_status = 'Unpaid';
        } elseif ($due_amount > 0) {
            $payment_status = 'Partial';
        } else {
            $payment_status = 'Paid';
        }

        // Create sale
        $sale = Sale::create([
            'date' => $date,
            'customer_id' => $customer->id,
            'customer_name' => $customer->customer_name,
            'tax_percentage' => 0,
            'tax_amount' => 0,
            'discount_percentage' => (int) $row['diskon'],
            'discount_amount' => (int) $row['diskon'],
            'shipping_amount' => 0,
            'total_amount' => $total_amount,
            'paid_amount' => $paid_amount,
            'due_amount' => $due_amount,
            'status' => 'Completed',
            'payment_status' => $payment_status,
            'payment_method' => $row['tipetransaksi'],
            'note' => '',
        ]);

        // Find product by code or name
        $product = Product::where('product_code', $row['kode_barang'])->first();

        if (!$product) {
            // Optionally, you can also search by name
            $product = Product::where('product_name', $row['nama_barang'])->first();
        }

        // If product is not found, create a new product
        if (!$product) {
            $product = Product::create([
                'product_code' => $row['kode_barang'],
                'product_name' => $row['nama_barang'],
                'product_price' => intval($row['hargajual']),  // You might need to add more fields as per your requirement
            ]);
        }

        // Create sale details
        SaleDetails::create([
            'sale_id' => $sale->id,
            'product_id' => $product->id,
            'product_name' => $product->product_name,
            'product_code' => $product->product_code,
            'quantity' => intval($row['qty']),
            'price' => intval($row['hargajual']),
            'unit_price' => intval($row['hargajual']),
            'sub_total' => intval($row['subtotal']),
            'product_discount_amount' => (int) $row['diskon'],
            'product_discount_type' => 'fixed',
            'product_tax_amount' => 0,
        ]);

        // Create sale payment
        SalePayment::create([
            'sale_id' => $sale->id,
            'amount' => $paid_amount,
            'date' => $date,
            'reference' => 'INV/' . $sale->reference, // or any other reference you want to use
            'payment_method' => $row['tipetransaksi'],
            'note' => '',
        ]);

        return $sale;
    }
}
