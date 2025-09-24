<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Nilai extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Nilai_model');
        $this->load->model('Enroll_model');
        $this->load->model('Kelas_model');
        $this->load->model('Mapel_model');
    }

    public function index() {
        $data['title'] = 'Input Nilai Siswa';
        $data['kelas'] = $this->Kelas_model->get_all();
        $data['tahun_ajaran'] = $this->db->get('tahun_ajaran')->result();

        $id_kelas = $this->input->get('id_kelas');
        $id_ta = $this->input->get('id_ta');

        if($id_kelas && $id_ta) {
            // Siswa & mapel untuk form input
            $data['siswa'] = $this->Enroll_model->get_siswa_by_kelas($id_kelas, $id_ta);
            $data['kelas_mapel'] = $this->Mapel_model->get_mapel_by_kelas($id_kelas);
            foreach($data['kelas_mapel'] as $mapel) {
                $mapel->komponen = $this->Nilai_model->get_komponen_by_mapel($mapel->id_mapel);
            }

            // Nilai yang sudah ada untuk tabel kanan
            $data['nilai_terisi'] = $this->Nilai_model->get_nilai_by_kelas_ta($id_kelas, $id_ta);

            $data['id_kelas'] = $id_kelas;
            $data['id_ta'] = $id_ta;
        } else {
            $data['siswa'] = [];
            $data['kelas_mapel'] = [];
            $data['nilai_terisi'] = [];
            $data['id_kelas'] = null;
            $data['id_ta'] = null;
        }

        $this->template->load('template','nilai/index', $data);
    }


    public function save() {
        $post = $this->input->post();

        foreach($post['nilai'] as $id_enroll => $mapel_nilai) {
            foreach($mapel_nilai as $id_kelas_mapel => $komponen_nilai) {
                foreach($komponen_nilai as $id_komponen => $skor) {
                    $this->Nilai_model->save_nilai([
                        'id_enroll' => $id_enroll,
                        'id_kelas_mapel' => $id_kelas_mapel,
                        'id_komponen' => $id_komponen,
                        'skor' => $skor,
                        'id_guru' => $this->session->userdata('id_guru')
                    ]);
                }
            }
        }

        $this->session->set_flashdata('success', 'Nilai berhasil disimpan!');
        redirect($_SERVER['HTTP_REFERER']);
    }

}
