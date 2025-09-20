<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Guru extends MY_Controller {
    public function __construct() {
        parent::__construct();
        $this->only_admin_allowed();
        $this->load->model('Guru_model');
    }

    public function index()
    {
        $result = $this->paginate('guru', 'nama_guru ASC');
        $data = array(
            'guru'      => $result['data'],
            'pagination' => $result['pagination'],
            'title'      => 'List Guru',
            'offset'     => $result['offset'], 
        );
        $this->template->load('template','guru',$data);
    }
    
    public function add()
	{
		$this->only_post_allowed();
		$result = $this->Guru_model->add();
		if($result){
        	$this->set_flash('success', 'Data guru berhasil ditambahkan');
		} else {
			$this->set_flash('error', 'Data guru sudah ada');
		}
		redirect('admin/guru');
	}

    public function edit()
    {
        $this->only_post_allowed();
        $this->Guru_model->update();
        $this->set_flash('success', 'Data guru berhasil diedit!');
        redirect('admin/guru');
    }

    public function delete($id_guru)
    {
        $this->Guru_model->delete($id_guru);
        $this->set_flash('success', 'Data guru berhasil dihapus!');
        redirect('admin/guru');
    }
}
