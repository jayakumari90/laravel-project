<?php

namespace App\Imports;

use App\Models\Lead;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Row;
use Illuminate\Support\Facades\Log;

class LeadImport implements OnEachRow, WithStartRow
{
    public function onRow(Row $row)
    {
        $rowIndex = $row->getIndex(); // The row index
        $row = $row->toArray();

        try {
            Log::info('Processing row', ['rowIndex' => $rowIndex, 'row' => $row]);

            // Validate the data (you can add more validation rules as needed)
            // if (empty($row[0]) || empty($row[11])) {
            //     Log::warning('Skipping row due to missing required fields', ['row' => $row]);
            //     return;
            // }

            // Process each row
            Lead::create([
                'name' => $row[0],
                'position' => $row[1],
                'company' => $row[2],
                'description' => $row[3],
                'zipcode' => $row[5],
                'city' => $row[6],
                'email' => $row[11],
                'address' => $row[8],
                'status' => 1,
                'source' => $row[10],
                'website' => $row[12],
                'phone' => $row[13],
                'lead_value' => $row[14],
                'tag' => $row[15],
                'import_update' => 1
            ]);

            //Log::info('Row imported successfully', ['rowIndex' => $rowIndex]);

        } catch (\Exception $e) {
            // Log the error for further investigation
            //Log::error('Error importing row', ['rowIndex' => $rowIndex, 'row' => $row, 'error' => $e->getMessage()]);
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

