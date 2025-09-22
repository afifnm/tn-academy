<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mapel extends MY_Controller {
    public function __construct() {
        parent::__construct();
        //$this->only_admin_allowed();
        $this->load->model('Mapel_model');
    }

    public function index()
    {
        $data = array(
            'mapel'      => $this->Mapel_model->get_all(),
            'title'      => 'List Mata Pelajaran',
        );
        $this->template->load('template','master/mapel',$data);
    }
    
    public function add()
	{
		$this->only_post_allowed();
		$result = $this->Mapel_model->add();
		if($result){
        	$this->set_flash('Data Mata Pelajaran berhasil ditambahkan', 'success');
		} else {
			$this->set_flash('Data Mata Pelajaran sudah ada', 'error');
		}
		redirect('admin/mapel');
	}

    public function edit()
    {
        $this->only_post_allowed();
        $this->Mapel_model->update();
        $this->set_flash('Data Mata Pelajaran berhasil diedit!', 'success');
        redirect('admin/mapel');
    }

    public function delete($id_mapel)
    {
        $this->Mapel_model->delete($id_mapel);
        $this->set_flash('Data Mata Pelajaran berhasil dihapus!', 'success');
        redirect('admin/mapel');
    }
}
