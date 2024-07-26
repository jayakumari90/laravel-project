<?php
namespace App\Imports;

use App\Models\User;
use App\Models\CustomerBilling;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Row;
use Auth;
class CustomerImport implements OnEachRow, WithStartRow
{
    public function onRow(Row $row)
    {
        $rowIndex = $row->getIndex(); // The row index
        $row = $row->toArray();

        try {
           // dd('erer');
            // Process each row
            $user = User::create([
                'name' => $row[0],
                'email' => $row[1],
                'phone_number' => $row[2],
                'position' => $row[3],
                'company' => $row[4],
                'vat_number' => $row[5],
                //'country' => $row[6],
                 'zipcode' => $row[7],
                'city' => $row[8],
                // 'state' => $row[9],
                 'address' => $row[10],
                'website' => $row[11],
                'role'=>5,
                'import_update' => 1
            ]);
           // dd($user->id);
            CustomerBilling::create([
                'customer_id' => $user->id,
                'billing_address' => $row[12],
                'billing_city' => $row[13],
                //'billing_state' => $row[14],
                'billing_zipcode' => $row[15],
                //'billing_country' => $row[16],
                'shipping_address' => $row[17],
                'shipping_city' => $row[18],
                //'shipping_state' => $row[19],
                'shipping_zipcode' => $row[20],
                //'shipping_country' => $row[21],
                'added_by'=>auth()->user()->id
            ]);
        } catch (\Exception $e) {
            ///dd('gretrtrt');
            // Handle the exception, e.g., log the error or notify an admin
           //Log::error('Error importing row ' . $rowIndex . ': ' . $e->getMessage());
        }
    }

    /**
     * Start importing from the second row.
     *
     * @return int
     */
    public function startRow(): int
    {
        return 2;
    }
}
