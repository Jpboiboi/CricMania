<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class UsersFailureReport implements WithHeadings, WithColumnWidths, WithStyles, FromView
{
    private $failures;
    public function __construct(Collection $failures)
    {
        // dd($failures[0]->values()['first_name']);
        $this->failures = $failures;
    }

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

    public function columnWidths(): array
    {
        return [
            'A' => 9,
            'B' => 9,
            'C' => 15,
            'D' => 11,
            'E' => 10,
            'F' => 13.3,
            'G' => 11,
            'H' => 11,
            'I' => 8,
            'J' => 10,
            'K' => 10,
            'L' => 16,
            'M' => 20,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $alignment = [
            'alignment' => [
                'vertical' => Alignment::VERTICAL_TOP, // Set the desired vertical alignment
            ],
        ];
        return array_fill_keys(range('A', 'Z'), $alignment);
    }

    public function view(): View
    {
        $failuresArray = [];
        $failures = $this->failures;
        foreach ($failures as $failure) {
            // dd($failure->row());
            $failuresArray += [
                $failure->row() => [
                    'values' => $failure->values(),
                    'attribute' => [],
                    'errors' => []
                ]
            ];
            array_push($failuresArray[$failure->row()]['attribute'], $failure->attribute());
            array_push($failuresArray[$failure->row()]['errors'], $failure->errors()[0]);
        }
        return view('frontend.exports.users-failure-report', compact('failuresArray'));
    }

}
