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
        $tahun_ajaran = $this->db->get('tahun_ajaran')->result();
        
        $result = $this->paginate('enroll', 'id_enroll DESC', [
            'join' => [
                ['siswa', 'siswa.id_siswa = enroll.id_siswa'],
                ['kelas', 'kelas.id_kelas = enroll.id_kelas'],
                ['tahun_ajaran', 'tahun_ajaran.id_ta = enroll.id_ta'],
            ],
            'select' => 'enroll.*,  DATE(enroll.tanggal_enroll) AS tanggal_enroll,siswa.nama, kelas.nama_kelas, tahun_ajaran.tahun, tahun_ajaran.semester'
        ]);

        $data = array(
            'enroll'     => $result['data'],
            'pagination' => $result['pagination'],
            'title'      => 'List Enroll',
            'offset'     => $result['offset'], 
            'siswa'        => $siswa,
            'kelas'        => $kelas,
            'tahun_ajaran' => $tahun_ajaran,
        );
        $this->template->load('template','enroll',$data);
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
            $this->set_flash('success', 'Enroll siswa berhasil ditambahkan');
        } else {
            $this->set_flash('error', 'Siswa sudah terdaftar di kelas/semester ini');
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
