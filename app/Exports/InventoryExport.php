<?php

namespace App\Exports;

use App\Models\Item;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class InventoryExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithEvents
{
    protected $period;

    public function __construct($period = null)
    {
        $this->period = $period ?? Carbon::now()->format('Y-m');
    }

   public function collection()
    {
        // Pecah periode untuk filter Excel
        $parsedDate = Carbon::createFromFormat('Y-m', $this->period);

        return Item::with('category')
            ->whereYear('updated_at', $parsedDate->year)
            ->whereMonth('updated_at', $parsedDate->month)
            ->orderBy('item_name', 'asc')
            ->get();
    }

    // 1. Membuat Judul Laporan & Header Tabel
    public function headings(): array
    {
        $formattedMonth = Carbon::createFromFormat('Y-m', $this->period)->format('F Y');

        return [
            ['MONTHLY INVENTORY REPORT'],                            // Baris 1
            ['Site / Location', 'IBP'],                              // Baris 2
            ['Report Period', $formattedMonth],                      // Baris 3
            ['Downloaded At', Carbon::now()->format('d M Y H:i')],   // Baris 4
            [''],                                                    // Baris 5 (Spasi)
            [                                                        // Baris 6 (Header Tabel)
                'No',
                'Item Name',
                'Part Number',
                'Category',
                'Current Stock',
                'Unit',
                'Damaged / Defect',
                'Last Updated'
            ]
        ];
    }

    // 2. Memetakan Data ke Baris (Mulai dari Baris 7 ke bawah)
    public function map($item): array
    {
        static $rowNumber = 0;
        $rowNumber++;

        return [
            $rowNumber,
            $item->item_name,
            $item->part_number ?? '-',
            $item->category->category_name ?? 'Uncategorized',
            $item->stock,
            $item->units ?? 'pcs',
            $item->damaged_stock ?? 0,
            Carbon::parse($item->updated_at)->format('d M Y H:i')
        ];
    }

    // 3. EVENT LISTENER: Styling Profesional tingkat lanjut
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                
                // Mendapatkan baris terakhir yang berisi data
                $highestRow = $sheet->getHighestRow();
                $highestColumn = 'H'; // Karena kolom kita sampai H (Last Updated)

                // --- A. FORMATTING HEADER LAPORAN (BARIS 1-4) ---
                $sheet->mergeCells('A1:H1');
                $sheet->getStyle('A1')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 16, 'color' => ['argb' => 'FF1E293B']],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);

                // Menebalkan label Site, Period, Downloaded At
                $sheet->getStyle('A2:A4')->applyFromArray([
                    'font' => ['bold' => true, 'color' => ['argb' => 'FF475569']],
                ]);

                // --- B. FORMATTING HEADER TABEL (BARIS 6) ---
                $sheet->getStyle('A6:H6')->applyFromArray([
                    'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['argb' => 'FF4F46E5'], // Warna Indigo
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                ]);

                // --- C. MENAMBAHKAN BARIS "GRAND TOTAL" DI PALING BAWAH ---
                $totalRow = $highestRow + 1; // Baris baru setelah data terakhir
                
                // Teks "TOTAL"
                $sheet->setCellValue('A' . $totalRow, 'GRAND TOTAL');
                $sheet->mergeCells("A{$totalRow}:D{$totalRow}"); // Gabung kolom A sampai D
                
                // Memasukkan Rumus (Formula) Excel untuk Sum otomatis
                $sheet->setCellValue('E' . $totalRow, "=SUM(E7:E{$highestRow})");
                $sheet->setCellValue('G' . $totalRow, "=SUM(G7:G{$highestRow})");

                // Styling untuk baris Grand Total
                $sheet->getStyle("A{$totalRow}:H{$totalRow}")->applyFromArray([
                    'font' => ['bold' => true],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['argb' => 'FFF1F5F9'], // Abu-abu muda
                    ],
                ]);

                // --- D. MERATAKAN TEXT (ALIGNMENT) DATA ---
                // No, Stock, Unit, Defect diratakan tengah
                $sheet->getStyle("A7:A{$totalRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle("E7:G{$totalRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                // --- E. MEMBERIKAN BORDER (GARIS TABEL) KESELURUHAN ---
                // Memberi garis pada tabel mulai dari Header (baris 6) sampai ke baris Total
                $sheet->getStyle("A6:H{$totalRow}")->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['argb' => 'FFCBD5E1'], // Garis warna abu-abu kalem
                        ],
                    ],
                ]);
            },
        ];
    }
}