<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kelas extends MY_Controller {
    public function __construct() {
        parent::__construct();
        $this->only_admin_allowed();
        $this->load->model('Kelas_model');
    }

    public function index()
    {
        $result = $this->paginate('kelas', 'nama_kelas ASC');
        $data = array(
            'kelas'      => $result['data'],
            'pagination' => $result['pagination'],
            'title'      => 'List Data Kelas',
            'offset'     => $result['offset'], 
        );
        $this->template->load('template','kelas',$data);
    }
    
    public function add()
	{
		$this->only_post_allowed();
		$result = $this->Kelas_model->add();
		if($result){
        	$this->set_flash('success', 'Data Kelas berhasil ditambahkan');
		} else {
			$this->set_flash('error', 'Data Kelas sudah ada');
		}
		redirect('admin/kelas');
	}

    public function edit()
    {
        $this->only_post_allowed();
        $this->Kelas_model->update();
        $this->set_flash('success', 'Data Kelas berhasil diedit!');
        redirect('admin/kelas');
    }

    public function delete($id_Kelas)
    {
        $this->Kelas_model->delete($id_Kelas);
        $this->set_flash('success', 'Data Kelas berhasil dihapus!');
        redirect('admin/kelas');
    }
}
