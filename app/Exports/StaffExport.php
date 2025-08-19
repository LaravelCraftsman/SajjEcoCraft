<?php

namespace App\Exports;
use App\Models\User;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StaffExport implements FromQuery, WithMapping, WithHeadings {

    public function query() {
        return User::query()->where( 'role', 'staff' );
    }

    public function map( $user ): array {
        return [
            $user->name,
            $user->email,
            $user->phone,
            $user->create ? '✅' : '❌',
            $user->edit ? '✅' : '❌',
            $user->delete ? '✅' : '❌',
            // $user->created_at->format( 'd-M-Y g:i A' ),
        ];
    }

    public function headings(): array {
        return [
            'Name',
            'Email',
            'Phone',
            'Create Permission',
            'Edit Permission',
            'Delete Permission',
            // 'Created At',
        ];
    }
}