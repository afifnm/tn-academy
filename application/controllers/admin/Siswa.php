<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Siswa extends MY_Controller {
    public function __construct() {
        parent::__construct();
        $this->only_admin_allowed();
        $this->load->model('Siswa_model');
    }

    public function index()
    {
        $result = $this->paginate('siswa', 'nama ASC');
        $data = array(
            'siswa'      => $result['data'],
            'pagination' => $result['pagination'],
            'title'      => 'List Siswa',
            'offset'     => $result['offset'], 
        );
        $this->template->load('template','siswa',$data);
    }
    
    public function add()
	{
		$this->only_post_allowed();
		$result = $this->Siswa_model->add();
		if($result){
        	$this->set_flash('success', 'User berhasil ditambahkan');
		} else {
			$this->set_flash('error', 'Data siswa sudah ada');
		}
		redirect('admin/siswa');
	}

    public function edit()
    {
        $this->only_post_allowed();
        $this->Siswa_model->update();
        $this->set_flash('success', 'Siswa berhasil diedit!');
        redirect('admin/siswa');
    }

    public function delete($id_siswa)
    {
        $this->Siswa_model->delete($id_siswa);
        $this->set_flash('success', 'Siswa berhasil dihapus!');
        redirect('admin/siswa');
    }
}
