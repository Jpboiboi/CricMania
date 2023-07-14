<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithConditionalSheets;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class UsersImport implements WithMultipleSheets, SkipsOnFailure
{
    use WithConditionalSheets,Importable, SkipsFailures;

    private $sheets;

    public function conditionalSheets(): array
    {
        $this->sheets = [
            "Worksheet" => new MainSheetImport(),
        ];

        return $this->sheets;
    }

    public function failures()
        {
        $array = [];
        foreach($this->sheets as $key => $sheet)
        {
            $array[$key] = $sheet->failures();
        }
        return $array;
    }
}
