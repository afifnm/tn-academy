<?php
define('FCPATH', __DIR__ . DIRECTORY_SEPARATOR);

// Aktifkan error reporting untuk debug
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Load autoloader PhpSpreadsheet
require_once FCPATH . 'application/third_party/PhpSpreadsheet/AutoLoader.php';

// Cek apakah class bisa diload
if (!class_exists('PhpOffice\\PhpSpreadsheet\\Spreadsheet')) {
    die('ERROR: Class Spreadsheet tidak ditemukan. Periksa struktur folder.');
}

// Buat spreadsheet sederhana
$spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setCellValue('A1', 'Test Excel - Berhasil!');

// Set header untuk download
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="test_import_siswa.xlsx"');
header('Cache-Control: max-age=0');

// Output file
$writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
$writer->save('php://output');

exit();