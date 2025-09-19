<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends MY_Controller {
	public function __construct() {
		parent::__construct();
	// 	if($this->session->userdata('role')!='admin')
	// 	{
	// 	$this->session->set_flashdata('alert','<div class="alert alert-primary alert-dismissible fade show" role="alert">
    //         kamu bukan admin
    //         <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    //         </div>'
	// 	);
	// 	redirect('portal');
	// 	}


		$this->load->model('User_model');
	}
	public function index()
	{
		$result = $this->paginate('users', 'name ASC');
		$data = array(
        'users'      => $result['data'],
        'pagination' => $result['pagination'],
        'title'      => 'List User',
        'offset'     => $result['offset'], 
		);
		$this->template->load('template','user',$data);
	}

	public function add()
	{
		$this->only_post_allowed();
		$this->User_model->add();
		$this->set_flash('success', 'User berhasil ditambahkan');
		redirect($_SERVER['HTTP_REFERER']);
	}

	public function edit()
	{
		$this->only_post_allowed();
		$this->User_model->update();
		$this->set_flash('success', 'User berhasil diedit!');
		redirect($_SERVER['HTTP_REFERER']);
	}

	public function delete($id_user)
	{
		$this->User_model->delete($id_user);
        $this->set_flash('success', 'User berhasil dihapus!');
		redirect($_SERVER['HTTP_REFERER']);
	}
}
