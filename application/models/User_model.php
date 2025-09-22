<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

    public function get_users($limit, $offset) {
        $query = $this->db->get('users', $limit, $offset);
        return $query->result_array(); 
    }
	public function get_all() {
		$query = $this->db->get('users');
		return $query->result_array(); 
	}

    public function count_users() {
        return $this->db->count_all('users');
    }

    public function add()
	{
		$this->db->from('users')->where('username',$this->input->post('username'));
		$cek = $this->db->get()->row();
		if($cek){
        	return false; 
		} else {
			$data = array(
				'nama'	=>$this->input->post('nama'),
				'username'	=>$this->input->post('username'),
				'password'	=> md5($this->input->post('password')),
				'role'	=>$this->input->post('role'),
			);
			$this->db->insert('users',$data);
			return true; 
		}
	}

    public function update()
	{
		$data = array(
            'nama'	=>$this->input->post('nama'),
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
