<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

    public function get_users($limit, $offset) {
        $query = $this->db->get('users', $limit, $offset);
        return $query->result_array(); 
    }

    public function count_users() {
        return $this->db->count_all('users');
    }

    public function add()
	{
		$this->db->from('users')->where('username',$this->input->post('username'));
		$cek = $this->db->get()->row();

		if($cek != null){
			$this->session->set_flashdata('alert','<div class="alert alert-primary alert-dismissible fade show" role="alert">
                            username alredy exist
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>');
			redirect('user');
		}
		$data = array(
            'name'	=>$this->input->post('name'),
			'username'	=>$this->input->post('username'),
			'password'	=> md5($this->input->post('password')),
			'role'	=>$this->input->post('role'),
		);

		$this->db->insert('users',$data);
	}

    public function update()
	{
		$data = array(
            'name'	=>$this->input->post('name'),
			'username'	=>$this->input->post('username'),
			'role'	=>$this->input->post('role'),
		);
		$this->db->where('id_user',$this->input->post('id_user'));
		$this->db->update('users',$data);
	}

    public function delete($id_user){
		$where = array('id_user'=>$id_user);
		$this->db->delete('users',$where);
	}
}
