<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\Exportable;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ExportParticipants implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return collect($this->data);
    }

    public function headings(): array
    {
        // $dynamicHeadings = ['Usia'];
        // $allHeadings = array_merge(['No', 'Rekrutmen', 'Nama Peserta', 'No. Handphone', 'Alamat', 'Email', 'Status Berkas', 'Status Peserta'], $dynamicHeadings);
        return [
            'No',
            'Rekrutmen',
            'Nama Peserta',
            'No. Handphone',
            'Alamat',
            'Email',
            // 'Tinggi Badan (persyaratan)',
            // 'Berat Badan (persyaratan)',
            'Status Berkas',
            'Status Peserta',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Mengatur style untuk heading
        $sheet->getRowDimension(1)->setRowHeight(30);
        
        $sheet->getStyle('A1:H1')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 12,
            ],
            'fill' => [
                'fillType' => 'solid',
                'color' => [
                    'rgb' => 'FFA500',
                ],
            ],
            'alignment' => [
                'horizontal' => 'center',
                'vertical' => 'center',
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => 'thin',
                    'color' => [
                        'rgb' => '000000',
                    ],
                ],
            ],
            'padding' => [
                'top' => 10,
                'bottom' => 10,
                'left' => 10,
                'right' => 10,
            ],
        ]);
        // $sheet->getDefaultRowDimension()->setRowHeight(30);
    }
}
