<?php

namespace App\Imports;

use App\Models\Lead;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Row;

class LeadImport implements OnEachRow, WithStartRow
{
    public function onRow(Row $row)
    {
        $rowIndex = $row->getIndex(); // The row index
        $row = $row->toArray();
    
        // Process each row
        Lead::create([
            'name'=> $row[0],
            'position'=> $row[1],
            'company'=> $row[2],
            'description'=> $row[3],
            'zipcode'=> $row[5],
            'city'=> $row[6],
            'address'=> $row[8],
            'email'=> $row[11],
            'website'=> $row[12],
            'phone'=> $row[13],
            'lead_value'=> $row[14],
            'tag'=> $row[15],
            'import_update'=>1
        ]);
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
