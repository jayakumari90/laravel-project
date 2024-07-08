<?php
namespace App\Exports;

use App\Models\Lead;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LeadsExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Lead::with([
            'getLeadStatus:id,lead',
            'getSource:id,source',
            'getStaff:id,name',
            'getCountry:id,name',
            'getState:id,name',
            'getDefaultLanguage:id,name'
        ])
        ->get()
        ->map(function($lead, $index) {
            return [
                'id' =>  $index + 1,
                'name' => $lead->name,
                'company' => $lead->company,
                'email' => $lead->email,
                'phone' => $lead->phone,
                'lead_value' => $lead->lead_value,
                'tag' => $lead->tag,
                'assigned' => $lead->getStaff->name ?? '',
                'lead_status' => $lead->getLeadStatus->lead ?? '',
                'source' => $lead->getSource->source ?? '',
                'created_at' => $lead->created_at
            ];
        });
    }

    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'Company',
            'Email',
            'Phone',
            'Lead Value',
            'Tags',
            'Assigned',
            'Lead Status',
            'Source',
            'Created'
        ];
    }
}
