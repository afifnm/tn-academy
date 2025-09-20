<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Guru_model extends CI_Model {
    
    public function add()
	{
		$this->db->from('guru')->where('nama_guru',$this->input->post('nama_guru'));
		$cek = $this->db->get()->row();

		if($cek != null){
        	return false;
		}
		$data = array(
			'nama_guru'	=>$this->input->post('nama_guru'),
		);

		$this->db->insert('guru',$data);
        return true;
	}

    public function update()
	{
		$data = array(
			'nama_guru'	=>$this->input->post('nama_guru'),
		);
		$this->db->where('id_guru',$this->input->post('id_guru'));
		$this->db->update('guru',$data);
	}

    public function delete($id_guru){
		$where = array('id_guru'=>$id_guru);
		$this->db->delete('guru',$where);
	}
}