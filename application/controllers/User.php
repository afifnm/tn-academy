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
		$limit = $this->input->get('limit') ?? 10;
		$offset = $this->uri->segment(3, 0);

		$data['all_users'] = $this->User_model->get_users($limit, $offset);
		$total_users   = $this->User_model->count_users();

		$data['pagination'] = pagination(base_url('user/index'), $total_users, $limit, 3);

		$this->db->from('users')->order_by('name','ASC');
		$data['users'] = $this->db->get()->result_array();

		$data['title'] = 'List User';

		$this->template->load('template','user',$data);
	}

	public function add()
	{
		$this->User_model->add();
		$this->set_flash('success', 'User berhasil ditambahkan');
		redirect('user');
	}

	public function edit()
	{
		$this->User_model->update();
		$this->set_flash('success', 'User berhasil diedit!');
		redirect('user');
	}

	public function delete($id_user)
	{
		$this->User_model->delete($id_user);
        $this->set_flash('success', 'User berhasil dihapus!');
       
            redirect('user');
	}
}
