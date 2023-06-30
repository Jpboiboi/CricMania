<?php

namespace App\Exports;

use App\Models\Users;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsersExport implements WithHeadings
{
    public function headings(): array
    {
        return [
            'First Name',
            'Last Name',
            'Email',
            'State',
            'DOB',
            'Fav Playing Spot',
            'Specialization',
            'Batting Hand',
            'Jersey Number',
            'Balling Hand',
            'Balling Type',
        ];
    }
}
