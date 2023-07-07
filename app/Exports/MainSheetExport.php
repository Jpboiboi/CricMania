<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MainSheetExport implements WithHeadings
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

