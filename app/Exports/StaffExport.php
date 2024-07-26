<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StaffExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $data = User::whereIn('role',[3,4])->with('getRole')->orderBy('id', 'desc') // Correcting the orderBy method call
            ->get()
            ->map(function($user, $index) {
                return [
                    'id' => $index + 1,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->getRole->role_type,
                    'last_login,' => $user->last_login,
                    'status' => ($user->status == 1) ? 'Active' : 'Inactive',
                ];
            });
    }

    public function headings(): array
    {
        return [
            'ID',
            'Full Name',
            'Email',
            'Role',
            'Last Login',
            'Status'
        ];
    }
}
