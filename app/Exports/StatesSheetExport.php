<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;

class StatesSheetExport implements WithHeadings, FromArray, WithColumnWidths, WithEvents
{
    public function headings(): array
    {
        return [
            'ID',
            'State',
        ];
    }

    public function columnWidths(): array
    {
        return [
            'B' => 17,
        ];
    }

    public function array(): array
    {
        $states = ["Andhra Pradesh", "Arunachal Pradesh", "Assam", "Bihar", "Chhattisgarh", "Goa", "Gujarat", "Haryana", "Himachal Pradesh", "Jharkhand", "Karnataka", "Kerala", "Madhya Pradesh", "Maharashtra", "Manipur", "Meghalaya", "Mizoram", "Nagaland", "Odisha", "Punjab", "Rajasthan", "Sikkim", "Tamil Nadu", "Telangana", "Tripura", "Uttar Pradesh", "Uttarakhand", "West Bengal"];

        $formattedStates = [];
        for ($i=0; $i < sizeof($states) ; $i++) {
            $index = $i +1;
            $state = [ 0 => "$index", 1 => $states[$i] ];
            $formattedStates[$i] = $state;
        }

        // $states = [
        //     [0 => "1", 1 => "Maharashtra"]
        // ];
        return $formattedStates;
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
