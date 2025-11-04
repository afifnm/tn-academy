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

        // Ambil parameter dari GET
        $id_kelas = $this->input->get('id_kelas');
        $id_ta = $this->input->get('id_ta');
        $id_mapel = $this->input->get('id_mapel');

        $data['id_kelas'] = $id_kelas;
        $data['id_ta'] = $id_ta;
        $data['id_mapel'] = $id_mapel;

        if ($id_kelas && $id_ta) {
            $data['mapel_list'] = $this->Mapel_model->get_mapel_enrolled_by_kelas_ta($id_kelas, $id_ta);
        } else {
            $data['mapel_list'] = [];
        }

        if ($id_kelas && $id_ta && $id_mapel) {
            $data['siswa'] = $this->Enroll_model->get_siswa_by_kelas($id_kelas, $id_ta);
            

            $mapel_terpilih = null;
            foreach ($data['mapel_list'] ?? [] as $m) {
                if ($m['id_mapel'] == $id_mapel) {
                    $mapel_terpilih = new stdClass();
                    $mapel_terpilih->id_mapel = $m['id_mapel'];
                    $mapel_terpilih->nama_mapel = $m['nama_mapel'];
                    $mapel_terpilih->id_guru = $m['id_guru'];
                    $mapel_terpilih->komponen = $m['komponen'];

                    $kelas_mapel = $this->db->get_where('kelas_mapel', [
                        'id_kelas' => $id_kelas,
                        'id_mapel' => $id_mapel
                    ])->row();

                    if ($kelas_mapel) {
                        $mapel_terpilih->id_kelas_mapel = $kelas_mapel->id_kelas_mapel;
                    }else {
                        $this->db->insert('kelas_mapel', [
                            'id_kelas' => $id_kelas,
                            'id_mapel' => $id_mapel
                        ]);
                        $mapel_terpilih->id_kelas_mapel = $this->db->insert_id();}
                    break;
                }
            }
            $data['mapel_terpilih'] = $mapel_terpilih;
            $data['nilai_terisi'] = $this->Nilai_model->get_nilai_by_kelas_ta($id_kelas, $id_ta);
        } else {
            $data['siswa'] = [];
            $data['mapel_terpilih'] = null;
            $data['nilai_terisi'] = [];
        }

        $this->template->load('template', 'nilai/index', $data);
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

        $url = 'nilai?';
        $url .= 'id_kelas=' . $post['id_kelas'];
        $url .= '&id_ta=' . $post['id_ta'];
        $url .= '&id_mapel=' . $post['id_mapel'];

        redirect($url);
    }

    public function daftar($id_kelas, $id_ta, $id_mapel) {
        $data['title'] = 'Daftar Nilai';
        $data['kelas'] = $this->Kelas_model->get_all();
        $data['tahun_ajaran'] = $this->db->get('tahun_ajaran')->result();

        $data['id_kelas'] = $id_kelas;
        $data['id_ta'] = $id_ta;
        $data['id_mapel'] = $id_mapel;

        $data['nilai_terisi'] = $this->Nilai_model->get_nilai_by_kelas_ta($id_kelas, $id_ta);

        $this->template->load('template', 'nilai/daftar', $data);
    }
}