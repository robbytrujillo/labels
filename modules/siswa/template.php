<?php
require '../../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

// Buat spreadsheet
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// ================= HEADER =================
$sheet->setCellValue('A1', 'NISN');
$sheet->setCellValue('B1', 'Nama');
$sheet->setCellValue('C1', 'Kelas');
$sheet->setCellValue('D1', 'Absen');

// ================= STYLE HEADER =================
$sheet->getStyle('A1:D1')->applyFromArray([
    'font' => [
        'bold' => true,
        'color' => ['argb' => 'FFFFFFFF']
    ],
    'fill' => [
        'fillType' => Fill::FILL_SOLID,
        'startColor' => ['argb' => 'FF4F46E5'] // warna ungu modern
    ],
    'alignment' => [
        'horizontal' => Alignment::HORIZONTAL_CENTER
    ]
]);

// ================= AUTO WIDTH =================
foreach(range('A','D') as $col){
    $sheet->getColumnDimension($col)->setAutoSize(true);
}

// ================= CONTOH DATA =================
$sheet->setCellValue('A2', '1234567890');
$sheet->setCellValue('B2', 'Andi Saputra');
$sheet->setCellValue('C2', 'XI RPL 1');
$sheet->setCellValue('D2', '1');

$sheet->setCellValue('A3', '1234567891');
$sheet->setCellValue('B3', 'Budi Santoso');
$sheet->setCellValue('C3', 'XI RPL 1');
$sheet->setCellValue('D3', '2');

// ================= BORDER BIAR RAPI =================
$sheet->getStyle('A1:D3')->applyFromArray([
    'borders' => [
        'allBorders' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
        ],
    ],
]);

// ================= FREEZE HEADER =================
$sheet->freezePane('A2');

// ================= DOWNLOAD =================
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="template_siswa.xlsx"');
header('Cache-Control: max-age=0');

// OUTPUT
$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;