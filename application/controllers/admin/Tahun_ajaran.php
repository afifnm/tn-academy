<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tahun_ajaran extends MY_Controller {
    public function __construct() {
        parent::__construct();
        $this->only_admin_allowed();
        $this->load->model('Tahun_ajaran_model');
    }

    public function index()
    {
        $result = $this->paginate('tahun_ajaran', 'tahun ASC');
        $data = array(
            'tahun_ajaran'  => $result['data'],
            'pagination' => $result['pagination'],
            'title'      => 'List Tahun Ajaran & Semester',
            'offset'     => $result['offset'], 
        );
        $this->template->load('template','tahun_ajaran',$data);
    }
    
    public function add()
	{
		$this->only_post_allowed();
		$result = $this->Tahun_ajaran_model->add();
		if($result){
        	$this->set_flash('success', 'Data Tahun ajaran dan semsester berhasil ditambahkan');
		} else {
			$this->set_flash('error', 'Data Tahun ajaran dan semsester sudah ada');
		}
		redirect('admin/tahun_ajaran');
	}

    public function edit()
    {
        $this->only_post_allowed();
        $this->Tahun_ajaran_model->update();
        $this->set_flash('success', 'Data Tahun ajaran dan semsester berhasil diedit!');
        redirect('admin/tahun_ajaran');
    }

    public function delete($id_ta)
    {
        $this->Tahun_ajaran_model->delete($id_ta);
        $this->set_flash('success', 'Data Tahun ajaran dan semsester berhasil dihapus!');
        redirect('admin/tahun_ajaran');
    }
}
