<?php
namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CustomerExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return User::where('role',3)->orderBy('id', 'desc') // Correcting the orderBy method call
            ->get()
            ->map(function($user, $index) {
                return [
                    'id' => $index + 1,
                    'company' => $user->company,
                    'name' => $user->name,
                    'email' => $user->email,
                    'phone' => $user->phone,
                    'status' => ($user->status == 1) ? 'Active' : 'Inactive',
                    'groups' => $user->groups,
                    'created_at' => $user->created_at
                ];
            });
    }

    public function headings(): array
    {
        return [
            'ID',
            'Company',
            'Name',
            'Email',
            'Phone',
            'Active',
            'Groups',
            'Date Created'
        ];
    }
}
