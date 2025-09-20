<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mapel extends MY_Controller {
    public function __construct() {
        parent::__construct();
        $this->only_admin_allowed();
        $this->load->model('Mapel_model');
    }

    public function index()
    {
        $result = $this->paginate('mapel', 'nama_mapel ASC');
        $data = array(
            'mapel'      => $result['data'],
            'pagination' => $result['pagination'],
            'title'      => 'List Mata Pelajaran',
            'offset'     => $result['offset'], 
        );
        $this->template->load('template','mapel',$data);
    }
    
    public function add()
	{
		$this->only_post_allowed();
		$result = $this->Mapel_model->add();
		if($result){
        	$this->set_flash('success', 'Data Mata Pelajaran berhasil ditambahkan');
		} else {
			$this->set_flash('error', 'Data Mata Pelajaran sudah ada');
		}
		redirect('admin/mapel');
	}

    public function edit()
    {
        $this->only_post_allowed();
        $this->Mapel_model->update();
        $this->set_flash('success', 'Data Mata Pelajaran berhasil diedit!');
        redirect('admin/mapel');
    }

    public function delete($id_guru)
    {
        $this->Mapel_model->delete($id_guru);
        $this->set_flash('success', 'Data Mata Pelajaran berhasil dihapus!');
        redirect('admin/mapel');
    }
}
