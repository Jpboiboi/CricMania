<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SpecializationsSheetExport implements WithHeadings, FromArray, WithColumnWidths
{
    public function headings(): array
    {
        return [
            'ID',
            'Specialization',
        ];
    }

    public function columnWidths(): array
    {
        return [
            'B' => 12,
        ];
    }

    public function array(): array
    {
        $formattedSpecializations = [];

        $specializations = ["batsman", "baller", "all-rounder"];

        for ($i=0; $i < sizeof($specializations) ; $i++) {
            $index = $i +1;
            $specialization = [ 0 => "$index", 1 => $specializations[$i] ];
            $formattedSpecializations[$i] = $specialization;
        }

        // $states = [
        //     [0 => "1", 1 => "Maharashtra"]
        // ];
        return $formattedSpecializations;
    }

}
