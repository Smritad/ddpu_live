<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\IOFactory;

class GenericExport implements FromCollection, WithMapping, WithHeadings
{
    protected $filePath;
    protected $rows = [];

    public function __construct($filePath)
    {
        $this->filePath = storage_path('app/' . $filePath);

        // Read Excel file and store rows
        $spreadsheet = IOFactory::load($this->filePath);
        $sheet = $spreadsheet->getActiveSheet();
        $this->rows = $sheet->toArray();
    }

    // Return collection of rows
    public function collection()
    {
        return collect($this->rows);
    }

    // Optional: map each row (here we just return as is)
    public function map($row): array
    {
        return $row;
    }

    // Optional: include headings (first row)
    public function headings(): array
    {
        return $this->rows[0] ?? [];
    }
}
