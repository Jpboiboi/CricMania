<?php

namespace App\Exports;

use App\Models\Users;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class UsersExport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            "WorkSheet" => new MainSheetExport(),
            "States" => new StatesSheetExport(),
            "Specialization" => new SpecializationsSheetExport(),
            "BallingType" => new BallingTypeSheetExport(),
        ];
    }
}
