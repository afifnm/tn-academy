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

    public function guru(){ //untuk guru mengarah ke index kirim id kelas, id ta dan id mapel
        $id_kelas = $this->input->get('id_kelas');
        $id_ta = $this->input->get('id_ta');
        $this->db->where('id_kelas',$id_kelas);
        $this->db->where('id_ta',$id_ta);
        $this->db->where('id_guru',$this->session->userdata('id_guru'));
        $id_mapel = $this->db->get('enroll_mapel')->row()->id_mapel;
        redirect('nilai?id_kelas='.$id_kelas.'&id_ta='.$id_ta.'&id_mapel='.$id_mapel);

    }
    public function index() {
        $data['title'] = 'Input Nilai Siswa';
        $data['kelas'] = $this->Kelas_model->get_all();
        $data['tahun_ajaran'] = $this->db->order_by('tahun', 'DESC')->get('tahun_ajaran')->result();

        $role = $this->session->userdata('role');
        $id_guru = $this->session->userdata('id_guru');


        $id_kelas = $this->input->get('id_kelas');
        $id_ta = $this->input->get('id_ta');
        $id_mapel = $this->input->get('id_mapel');

        $data['id_kelas'] = $id_kelas;
        $data['id_ta'] = $id_ta;
        $data['id_mapel'] = $id_mapel;

        if ($id_kelas && $id_ta) {
            if ($role === 'admin') {
                $data['mapel_list'] = $this->Mapel_model->get_mapel_enrolled_by_kelas_ta($id_kelas, $id_ta);
            } else {
                $data['mapel_list'] = $this->Mapel_model->get_mapel_enrolled_by_kelas_ta_guru($id_kelas, $id_ta, $id_guru);
            }
        } else {
            $data['mapel_list'] = [];
        }

        if ($id_kelas && $id_ta && $id_mapel) {
            if ($role === 'admin') {
                $is_valid = $this->db->get_where('enroll_mapel', [
                    'id_kelas' => $id_kelas,
                    'id_ta' => $id_ta,
                    'id_mapel' => $id_mapel
                ])->row();
            } else {
                $is_valid = $this->db->get_where('enroll_mapel', [
                    'id_kelas' => $id_kelas,
                    'id_ta' => $id_ta,
                    'id_mapel' => $id_mapel,
                    'id_guru' => $id_guru
                ])->row();
            }

            if (!$is_valid) {
                $this->session->set_flashdata('error', 'Anda tidak diizinkan mengajar mapel ini.');
                redirect('nilai');
            }

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
                    } else {
                        $this->db->insert('kelas_mapel', [
                            'id_kelas' => $id_kelas,
                            'id_mapel' => $id_mapel
                        ]);
                        $mapel_terpilih->id_kelas_mapel = $this->db->insert_id();
                    }
                    break;
                }
            }

            if (!$mapel_terpilih || empty($mapel_terpilih->komponen)) {
                $this->session->set_flashdata('error', 'Tidak ada komponen nilai untuk mapel ini.');
                redirect('nilai?id_kelas=' . $id_kelas . '&id_ta=' . $id_ta);
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
        $id_kelas = $post['id_kelas'];
        $id_mapel = $post['id_mapel'];
        $role = $this->session->userdata('role');
        $id_guru = $this->session->userdata('id_guru');

        if (!$id_guru && $role !== 'admin') {
            $this->session->set_flashdata('error', 'Akses ditolak.');
            redirect('nilai');
        }

        if ($role === 'guru') {
            $is_valid = $this->db->get_where('enroll_mapel', [
                'id_kelas' => $id_kelas,
                'id_mapel' => $id_mapel,
                'id_guru' => $id_guru
            ])->row();

            if (!$is_valid) {
                $this->session->set_flashdata('error', 'Anda tidak diizinkan menyimpan nilai untuk mapel ini.');
                redirect('nilai');
            }
        }

        foreach($post['nilai'] as $id_enroll => $mapel_nilai) {
            foreach($mapel_nilai as $id_kelas_mapel => $komponen_nilai) {
                foreach($komponen_nilai as $id_komponen => $skor) {
                    // Pastikan id_kelas_mapel valid
                    if ($id_kelas_mapel == 0) {
                        $kelas_mapel = $this->db->get_where('kelas_mapel', [
                            'id_kelas' => $id_kelas,
                            'id_mapel' => $id_mapel
                        ])->row();

                        if ($kelas_mapel) {
                            $id_kelas_mapel = $kelas_mapel->id_kelas_mapel;
                        } else {
                            $this->db->insert('kelas_mapel', [
                                'id_kelas' => $id_kelas,
                                'id_mapel' => $id_mapel
                            ]);
                            $id_kelas_mapel = $this->db->insert_id();
                        }
                    }

                    $this->Nilai_model->save_nilai([
                        'id_enroll' => $id_enroll,
                        'id_kelas_mapel' => $id_kelas_mapel,
                        'id_komponen' => $id_komponen,
                        'skor' => $skor,
                        'id_guru' => $id_guru 
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
        $data['tahun_ajaran'] = $this->db->order_by('tahun', 'DESC')->get('tahun_ajaran')->result();

        $data['id_kelas'] = $id_kelas;
        $data['id_ta'] = $id_ta;
        $data['id_mapel'] = $id_mapel;

        $mapel_list = $this->Mapel_model->get_mapel_enrolled_by_kelas_ta($id_kelas, $id_ta);
        $mapel_terpilih = null;
        foreach ($mapel_list as $m) {
            if ($m['id_mapel'] == $id_mapel) {
                $mapel_terpilih = new stdClass();
                $mapel_terpilih->id_mapel = $m['id_mapel'];
                $mapel_terpilih->nama_mapel = $m['nama_mapel'];
                $mapel_terpilih->komponen = $m['komponen'];
                
                $kelas_mapel = $this->db->get_where('kelas_mapel', [
                    'id_kelas' => $id_kelas,
                    'id_mapel' => $id_mapel
                ])->row();

                if ($kelas_mapel) {
                    $mapel_terpilih->id_kelas_mapel = $kelas_mapel->id_kelas_mapel;
                } else {
                    $this->db->insert('kelas_mapel', [
                        'id_kelas' => $id_kelas,
                        'id_mapel' => $id_mapel
                    ]);
                    $mapel_terpilih->id_kelas_mapel = $this->db->insert_id();
                }

                break;
            }
        }

        $data['mapel_terpilih'] = $mapel_terpilih;

         $data['nilai_terisi'] = $this->Nilai_model->get_nilai_by_kelas_ta_mapel($id_kelas, $id_ta, $id_mapel);

        $this->template->load('template', 'nilai/daftar', $data);
    }

    public function update(){
        $post = $this->input->post();
        $id_nilai = $post['id_nilai'];
        $skor = $post['skor'];
        $id_guru = $this->session->userdata('id_guru');

        if (!$id_guru && $this->session->userdata('role') !== 'admin') {
            $this->set_flash('Akses ditolak.', 'error');
            redirect('nilai');
            
        }
        $result = $this->Nilai_model->update_nilai($id_nilai, $skor, $id_guru);
    }
    public function update_multiple() {
        $id_enroll = $this->input->post('id_enroll');
        $id_kelas_mapel = $this->input->post('id_kelas_mapel');
        $nilai = $this->input->post('nilai');
        $id_guru = $this->session->userdata('id_guru');

        if (!$id_guru && $this->session->userdata('role') !== 'admin') {
            $this->session->set_flashdata('error', 'Akses ditolak');
            redirect('nilai');
        }

        $result = $this->Nilai_model->update_multiple_nilai($id_enroll, $id_kelas_mapel, $nilai, $id_guru);

        if ($result['success']) {
            $this->session->set_flashdata('success', 'Nilai berhasil diperbarui');
        } else {
            $this->session->set_flashdata('error', $result['error']);
        }
        
        // Redirect ke halaman sebelumnya (daftar nilai)
        $kelas_mapel = $this->db->get_where('kelas_mapel', ['id_kelas_mapel' => $id_kelas_mapel])->row();
        $enroll = $this->db->get_where('enroll', ['id_enroll' => $id_enroll])->row();

        redirect('nilai/daftar/'.$enroll->id_kelas.'/'.$enroll->id_ta.'/'.$kelas_mapel->id_mapel);
    }

}

