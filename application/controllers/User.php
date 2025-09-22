<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends MY_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('User_model');
	}
	public function index()
	{
		$data = array(
        'users'      => $this->User_model->get_all(),
        'title'      => 'List User',
		);
		$this->template->load('template','user',$data);
	}

	public function add()
	{
		$this->only_post_allowed();
		$result = $this->User_model->add();
		if($result){
        	$this->set_flash('User berhasil ditambahkan', 'success');
		} else {
			$this->set_flash('Username sudah ada', 'error');
		}
		redirect($_SERVER['HTTP_REFERER']);
	}

	public function edit()
	{
		$this->only_post_allowed();
		$this->User_model->update();
		$this->set_flash('User berhasil diedit!', 'success');
		redirect($_SERVER['HTTP_REFERER']);
	}

	public function delete($id_user)
	{
		$this->User_model->delete($id_user);
        $this->set_flash('User berhasil dihapus!', 'success');
		redirect($_SERVER['HTTP_REFERER']);
	}
}
