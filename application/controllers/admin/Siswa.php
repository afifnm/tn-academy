<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Siswa extends MY_Controller {
    public function __construct() {
        parent::__construct();
        //$this->only_admin_allowed();
        $this->load->model('Siswa_model');
    }

    public function index()
    {
        $data = array(
            'siswa'      => $this->Siswa_model->get_all(),
            'title'      => 'List Siswa'
        );
        $this->template->load('template','master/siswa',$data);
    }
    
    public function add()
	{
		$this->only_post_allowed();
		$result = $this->Siswa_model->add();
		if($result){
        	$this->set_flash('Siswa berhasil ditambahkan', 'success');
		} else {
			$this->set_flash('Data siswa sudah ada', 'error');
		}
		redirect('admin/siswa');
	}

    public function edit()
    {
        $this->only_post_allowed();
        $this->Siswa_model->update();
        $this->set_flash('Siswa berhasil diedit!', 'success');
        redirect('admin/siswa');
    }

    public function delete($id_siswa)
    {
        $this->Siswa_model->delete($id_siswa);
        $this->set_flash('Siswa berhasil dihapus!', 'success');
        redirect('admin/siswa');
    }
}
