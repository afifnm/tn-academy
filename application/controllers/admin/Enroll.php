<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Enroll extends MY_Controller {
    public function __construct() {
        parent::__construct();
        //$this->only_admin_allowed();
        $this->load->model('Enroll_model');
    }

    public function index()
    {
        $siswa        = $this->db->get('siswa')->result();
        $kelas        = $this->db->get('kelas')->result();
        $this->db->order_by('tahun', 'DESC');
        $tahun_ajaran = $this->db->get('tahun_ajaran')->result();

        // ambil enroll dengan join
        $this->db->select('enroll.*, DATE(enroll.tanggal_enroll) AS tanggal_enroll,
                        siswa.nama, kelas.nama_kelas, tahun_ajaran.tahun, tahun_ajaran.semester');
        $this->db->from('enroll');
        $this->db->join('siswa', 'siswa.id_siswa = enroll.id_siswa');
        $this->db->join('kelas', 'kelas.id_kelas = enroll.id_kelas');
        $this->db->join('tahun_ajaran', 'tahun_ajaran.id_ta = enroll.id_ta');
        $this->db->order_by('id_enroll', 'DESC');
        $result = $this->db->get()->result();

        $data = array(
            'enroll'       => $result,
            'title'        => 'List Enroll',
            'siswa'        => $siswa,
            'kelas'        => $kelas,
            'tahun_ajaran' => $tahun_ajaran,
        );

        $this->template->load('template', 'master/enroll', $data);
    }


    public function add()
    {
        $siswa        = $this->db->get('siswa')->result();
        $kelas        = $this->db->get('kelas')->result();
        $tahun_ajaran = $this->db->get('tahun_ajaran')->result();

        $data = array(
            'title'        => 'Tambah Enroll',
            'siswa'        => $siswa,
            'kelas'        => $kelas,
            'tahun_ajaran' => $tahun_ajaran,
        );
        $this->template->load('template','enroll_add',$data);
    }
    
    public function save()
    {
        $this->only_post_allowed();
        $result = $this->Enroll_model->add();
        if($result){
            $this->set_flash('Enroll siswa berhasil ditambahkan', 'success');
        } else {
            $this->set_flash('Siswa sudah terdaftar di kelas/semester ini','error');
        }
		redirect('admin/enroll');
    }

    // public function edit($id_enroll)
    // {
    //     $data_enroll = $this->db->get_where('enroll', ['id_enroll' => $id_enroll])->row();
    //     if(!$data_enroll) show_404();

    //     $siswa        = $this->db->get('siswa')->result();
    //     $kelas        = $this->db->get('kelas')->result();
    //     $tahun_ajaran = $this->db->get('tahun_ajaran')->result();

    //     $data = array(
    //         'title'        => 'Edit Enroll',
    //         'enroll'       => $data_enroll,
    //         'siswa'        => $siswa,
    //         'kelas'        => $kelas,
    //         'tahun_ajaran' => $tahun_ajaran,
    //     );
    //     $this->template->load('template','enroll_edit',$data);
    // }

    public function update()
    {
        $this->only_post_allowed();
        $id_enroll = $this->input->post('id_enroll'); 

        $this->Enroll_model->update($id_enroll);

        $this->set_flash('success', 'Enroll berhasil diperbarui!');
        redirect('admin/enroll');
    }

    public function delete($id_enroll)
    {
        $this->Enroll_model->delete($id_enroll);
        $this->set_flash('success', 'Enroll berhasil dihapus!');
        redirect('admin/enroll');
    }
}
