<?php

namespace App\Imports;

use Modules\People\Entities\Customer;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CustomerImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // Generate email from customer name
        $email = strtolower(str_replace(' ', '', $row['pembeli'])) . '@gmail.com';

        return new Customer([
            'customer_name' => $row['pembeli'],
            'customer_email' => $email,
            'customer_phone' => '1234567890', // default phone
            'city' => 'Semarang', // default city
            'country' => 'Indonesia', // default country
            'address' => 'Jl. Prof. Soedarto, Tembalang, Kota Semarang, Jawa Tengah.', // default address
        ]);
    }
}

