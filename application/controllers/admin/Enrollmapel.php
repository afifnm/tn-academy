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

        if (!$id_ta || !$id_kelas) {
            $this->set_flash('Pilih Tahun Ajaran dan Kelas.', 'error');
            redirect('admin/enrollmapel');
        }

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

        if (empty($mapel_ids) || !$id_ta || !$id_kelas) {
            $this->set_flash('Pilih mapel dan pastikan filter terisi.', 'error');
            redirect('admin/enrollmapel');
        }

        $success_count = 0;
        foreach ($mapel_ids as $id_mapel) {
            $data = [
            'id_mapel' => $id_mapel,
            'id_kelas' => $id_kelas,
            'id_ta'    => $id_ta
            ];

            // Insert enroll mapel
            $inserted = $this->EnrollMapel_model->add($data);
            if ($inserted) {
            $success_count++;

            // Ambil ID enroll yang baru dibuat (model bisa mengembalikan ID atau true)
            $id_enroll = (is_numeric($inserted) && $inserted > 0) ? $inserted : $this->db->insert_id();

            if ($id_enroll) {
                // Tambahkan komponen default ASTS dan ASAS untuk enroll yang baru dibuat
                $this->EnrollMapel_model->save_komponen_baru($id_enroll, ['ASTS', 'ASAS']);
            }
            }
        }
        if ($success_count > 0) {
            $this->set_flash( "$success_count mapel berhasil di-enroll.", 'success');
        } else {
            $this->set_flash("Semua mapel sudah ter-enroll di kelas ini.", 'warning');
        } 
        redirect('admin/enrollmapel/filter?id_ta='.$id_ta.'&id_kelas='.$id_kelas);
    }

    public function delete($id_enroll_mapel) {
        $this->EnrollMapel_model->delete($id_enroll_mapel);
        $this->set_flash( 'Enroll mapel berhasil dihapus.', 'success',);

        $referer = $_SERVER['HTTP_REFERER'] ?? site_url('admin/enrollmapel');
        redirect($referer);
    }

    public function edit_detail($id_enroll_mapel) {
        if (!is_numeric($id_enroll_mapel)) show_404();

        $enroll = $this->EnrollMapel_model->get_by_id($id_enroll_mapel);
        if (!$enroll) {
            $this->set_flash('Data tidak ditemukan.', 'error');
            redirect('admin/enrollmapel');
        }
  
        // Ambil komponen yang sudah dipilih untuk enroll inis
        $selected_komponen = $this->EnrollMapel_model->get_komponen_by_enroll($id_enroll_mapel);

        $data = [
            'title' => 'Atur Detail Mapel: ' . $enroll['nama_mapel'],
            'enroll' => $enroll,
            'guru' => $this->db->get('guru')->result_array(),
            'selected_komponen' => $selected_komponen,
            'filter' => [
                'id_ta' => $enroll['id_ta'],
                'id_kelas' => $enroll['id_kelas']
            ]
        ];

        $this->template->load('template', 'enroll/mapel_detail', $data);
    }

    public function update_detail() {
        $id = $this->input->post('id_enroll_mapel');
        $id_guru = $this->input->post('id_guru') ?: null;
        $komponen_baru = $this->input->post('komponen_baru'); // Array dari inputan user

        if (!$id) {
            $this->set_flash('ID tidak valid.', 'error');
            redirect($_SERVER['HTTP_REFERER'] ?? 'admin/enrollmapel');
        }

        // Update guru pengajar
        $this->EnrollMapel_model->update($id, ['id_guru' => $id_guru]);

        // Simpan komponen baru ke tabel mapel_komponen (jika belum ada) dan relasikan ke enroll
        $this->EnrollMapel_model->save_komponen_baru($id, $komponen_baru);

        $this->set_flash('Detail mapel berhasil diperbarui.', 'success');

        $id_ta = $this->input->post('id_ta');
        $id_kelas = $this->input->post('id_kelas');
        redirect("admin/enrollmapel/filter?id_ta={$id_ta}&id_kelas={$id_kelas}");
    }

}
