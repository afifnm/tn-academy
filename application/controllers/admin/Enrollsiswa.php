<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Enrollsiswa extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Enroll_model');
    }

    public function index() {
        $data = array(
            'title'        => 'Penempatan Siswa (Enroll)',
            'siswa'        => $this->Enroll_model->get_siswa(),
            'kelas'        => $this->Enroll_model->get_kelas(),
            'tahun_ajaran' => $this->Enroll_model->get_tahun_ajaran(),
            'enroll'       => $this->Enroll_model->get_enroll()
        );

        $this->template->load('template', 'enroll/siswa', $data);
    }
}
