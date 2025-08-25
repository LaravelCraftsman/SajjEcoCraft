<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CustomerExport implements FromQuery, WithMapping, WithHeadings {
    public function query() {
        return User::query()->where( 'role', 'customer' );
    }

    public function map( $user ): array {
        return [
            $user->name,
            $user->email,
            $user->phone,
            // $user->created_at->format( 'd-M-Y g:i A' ),
        ];
    }

    public function headings(): array {
        return [
            'Name',
            'Email',
            'Phone',
            // 'Created At',
        ];
    }
}
