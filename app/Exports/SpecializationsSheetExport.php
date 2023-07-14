<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;

class SpecializationsSheetExport implements WithHeadings, FromArray, WithColumnWidths, WithEvents
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

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $event->sheet->protectCells('', 'PASSWORD');
                $event->sheet->getDelegate()->getProtection()->setSheet(true);
            },
        ];
    }

}
