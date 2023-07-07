<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BallingTypeSheetExport implements WithHeadings, FromArray, WithColumnWidths
{
    public function headings(): array
    {
        return [
            'ID',
            'Balling Type',
        ];
    }

    public function columnWidths(): array
    {
        return [
            'B' => 10,
        ];
    }

    public function array(): array
    {
        $formattedTypes = [];

        $types = ['fast','spin','medium-fast'];
        for ($i=0; $i < sizeof($types) ; $i++) {
            $index = $i+1;
            $type = [ 0 => "$index", 1 => $types[$i] ];
            $formattedTypes[$i] = $type;
        }

        // $states = [
        //     [0 => "1", 1 => "Maharashtra"]
        // ];
        return $formattedTypes;
    }

}
