<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'third_party/PhpSpreadsheet/AutoLoader.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as ReaderXlsx;
use PhpOffice\PhpSpreadsheet\Reader\Xls as ReaderXls;

class Spreadsheet_loader {
    public function __construct() {}

    public function loadXlsx($file_tmp) {
        $reader = new ReaderXlsx();
        $reader->setReadDataOnly(true);
        $reader->setReadEmptyCells(false);
        return $reader->load($file_tmp);
    }

    public function loadXls($file_tmp) {
        $reader = new ReaderXls();
        $reader->setReadDataOnly(true);
        $reader->setReadEmptyCells(false);
        return $reader->load($file_tmp);
    }
}
