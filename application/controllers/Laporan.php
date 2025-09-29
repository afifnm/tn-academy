<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan extends MY_Controller {

    public function __construct() {
        parent::__construct();
            $this->only_principal_allowed();

    }

    public function index() {
        $data['title'] = 'Laporan Nilai Siswa';
        $this->template->load('template','laporan', $data);
    }
}