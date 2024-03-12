<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ReportExport implements FromCollection, WithHeadings
{
    private $reportData;

    private $headings;

    public function __construct($reportData, $headings)
    {
        $this->reportData = $reportData;
        $this->headings = $headings;
    }

    public function collection()
    {
        return new Collection($this->reportData);
    }

    public function headings(): array
    {
        return array_values($this->headings);
    }
}
