<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Guru extends MY_Controller {
    public function __construct() {
        parent::__construct();
        //$this->only_admin_allowed();
        $this->load->model('Guru_model');
    }

    public function index()
    {
        $data = array(
            'guru'      => $this->Guru_model->get_all(),
            'title'      => 'List Guru',
        );
        $this->template->load('template','master/guru',$data);
    }
    
    public function add()
	{
		$this->only_post_allowed();
		$result = $this->Guru_model->add();
		if($result){
        	$this->set_flash('Data guru berhasil ditambahkan', 'success');
		} else {
			$this->set_flash('Data guru sudah ada', 'error');
		}
		redirect('admin/guru');
	}

    public function edit()
    {
        $this->only_post_allowed();
        $this->Guru_model->update();
        $this->set_flash('Data guru berhasil diedit!', 'success');
        redirect('admin/guru');
    }

    public function delete($id_guru)
    {
        $this->Guru_model->delete($id_guru);
        $this->set_flash('Data guru berhasil dihapus!', 'success');
        redirect('admin/guru');
    }
}
