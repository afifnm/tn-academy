<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tahun_ajaran extends MY_Controller {
    public function __construct() {
        parent::__construct();
        //$this->only_admin_allowed();
        $this->load->model('Tahun_ajaran_model');
    }

    public function index()
    {
        $data = array(
            'tahun_ajaran'  => $this->Tahun_ajaran_model->get_all(),
            'title'      => 'List Tahun Ajaran & Semester',
        );
        $this->template->load('template','master/tahun_ajaran',$data);
    }
    
    public function add()
	{
		$this->only_post_allowed();
		$result = $this->Tahun_ajaran_model->add();
		if($result){
        	$this->set_flash('Data Tahun ajaran dan semsester berhasil ditambahkan', 'success');
		} else {
			$this->set_flash('Data Tahun ajaran dan semsester sudah ada', 'error');
		}
		redirect('admin/tahun_ajaran');
	}

    public function edit()
    {
        $this->only_post_allowed();
        $this->Tahun_ajaran_model->update();
        $this->set_flash('Data Tahun ajaran dan semsester berhasil diedit!', 'success');
        redirect('admin/tahun_ajaran');
    }

    public function delete($id_ta)
    {
        $this->Tahun_ajaran_model->delete($id_ta);
        $this->set_flash('Data Tahun ajaran dan semsester berhasil dihapus!', 'success');
        redirect('admin/tahun_ajaran');
    }
}
