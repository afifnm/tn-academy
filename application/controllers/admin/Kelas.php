<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kelas extends MY_Controller {
    public function __construct() {
        parent::__construct();
        //$this->only_admin_allowed();
        $this->load->model('Kelas_model');
    }

    public function index()
    {
        $data = array(
            'kelas'      => $this->Kelas_model->get_all(),
            'title'      => 'List Data Kelas',
        );
        $this->template->load('template','master/kelas',$data);
    }
    
    public function add()
	{
		$this->only_post_allowed();
		$result = $this->Kelas_model->add();
		if($result){
        	$this->set_flash('Data Kelas berhasil ditambahkan', 'success');
		} else {
			$this->set_flash('Data Kelas sudah ada', 'error');
		}
		redirect('admin/kelas');
	}

    public function edit()
    {
        $this->only_post_allowed();
        $this->Kelas_model->update();
        $this->set_flash('Data Kelas berhasil diedit!', 'success');
        redirect('admin/kelas');
    }

    public function delete($id_Kelas)
    {
        $this->Kelas_model->delete($id_Kelas);
        $this->set_flash('Data Kelas berhasil dihapus!', 'success');
        redirect('admin/kelas');
    }
}
