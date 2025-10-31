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

        // Jika kelas & TA dipilih, ambil daftar mapel yang relevan
        if ($id_kelas && $id_ta) {
            $data['mapel_list'] = $this->Mapel_model->get_mapel_enrolled_by_kelas_ta($id_kelas, $id_ta);
        } else {
            $data['mapel_list'] = [];
        }

        // Jika semua dipilih, siapkan data untuk form
        if ($id_kelas && $id_ta && $id_mapel) {
            $data['siswa'] = $this->Enroll_model->get_siswa_by_kelas($id_kelas, $id_ta);
            
            // Cari mapel_terpilih dari mapel_list
            $mapel_terpilih = null;
            foreach ($data['mapel_list'] ?? [] as $m) {
                if ($m['id_mapel'] == $id_mapel) {
                    // Konversi ke objek agar kompatibel dengan view lama
                    $mapel_terpilih = (object) $m;
                    // Tambahkan id_kelas_mapel (diperlukan untuk input name)
                    $kelas_mapel = $this->db->get_where('kelas_mapel', [
                        'id_kelas' => $id_kelas,
                        'id_mapel' => $id_mapel
                    ])->row();
                    $mapel_terpilih->id_kelas_mapel = $kelas_mapel ? $kelas_mapel->id_kelas_mapel : null;
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

        // ✅ Redirect ke URL dengan semua parameter
        $url = 'nilai?';
        $url .= 'id_kelas=' . $post['id_kelas'];
        $url .= '&id_ta=' . $post['id_ta'];
        $url .= '&id_mapel=' . $post['id_mapel'];

        redirect($url);
    }

}
