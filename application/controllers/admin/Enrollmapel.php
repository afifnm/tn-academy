<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Enrollmapel extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('EnrollMapel_model');
        $this->load->model('Mapel_model');
    }

    public function index() {
        $data = [
            'title'        => 'Enroll Mapel',
            'kelas'        => $this->EnrollMapel_model->get_kelas(),
            'tahun_ajaran' => $this->EnrollMapel_model->get_tahun_ajaran(),
            'mapel'        => $this->Mapel_model->get_all(),
            'enrolled'     => [],
            'not_enrolled' => [],
            'filter'       => []
        ];

        $this->template->load('template', 'enroll/mapel', $data);
    }

    public function filter() {
        $id_ta    = $this->input->get('id_ta');
        $id_kelas = $this->input->get('id_kelas');

        $data = [
            'title'        => 'Enroll Mapel',
            'kelas'        => $this->EnrollMapel_model->get_kelas(),
            'tahun_ajaran' => $this->EnrollMapel_model->get_tahun_ajaran(),
            'mapel'        => $this->Mapel_model->get_all(),
            'enrolled'     => $this->EnrollMapel_model->get_enrolled($id_ta, $id_kelas),
            'not_enrolled' => $this->EnrollMapel_model->get_not_enrolled($id_ta, $id_kelas),
            'filter'       => ['id_ta' => $id_ta, 'id_kelas' => $id_kelas]
        ];

        $this->template->load('template', 'enroll/mapel', $data);
    }

    public function enroll_bulk() {
        $mapel_ids = $this->input->post('mapel_ids');
        $id_ta     = $this->input->post('id_ta');
        $id_kelas  = $this->input->post('id_kelas');

        if (!empty($mapel_ids) && $id_ta && $id_kelas) {
            $success_count = 0;

            foreach ($mapel_ids as $id_mapel) {
                if ($this->EnrollMapel_model->add([
                    'id_mapel' => $id_mapel,
                    'id_kelas' => $id_kelas,
                    'id_ta'    => $id_ta
                ])) $success_count++;
            }

            if ($success_count > 0)
                $this->session->set_flashdata('success', "$success_count mapel berhasil di-enroll.");
            else
                $this->session->set_flashdata('error', "Semua mapel sudah ter-enroll sebelumnya.");
        } else {
            $this->session->set_flashdata('error', 'Pilih mapel dan pastikan filter terisi.');
        }

        redirect('admin/enrollmapel/filter?id_ta='.$id_ta.'&id_kelas='.$id_kelas);
    }

    public function delete($id_enroll_mapel) {
        $this->EnrollMapel_model->delete($id_enroll_mapel);
        $this->session->set_flashdata('success', 'Enroll mapel berhasil dihapus.');
        redirect($_SERVER['HTTP_REFERER']);
    }
}
