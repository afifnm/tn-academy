<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Siswa_model extends CI_Model {

	public function get_all()
	{
		return $this->db->get('siswa')->result_array();
	}

    public function add()
	{
		$this->db->from('siswa')->where('nisn',$this->input->post('nisn'));
		$cek = $this->db->get()->row();

		if($cek != null){
        	return false;
		}
		$data = array(
            'nisn'	=>$this->input->post('nisn'),
			'nama'	=>$this->input->post('nama'),
            'tgl_lahir' => date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('tgl_lahir')))),
			'thn_masuk'	=>$this->input->post('thn_masuk'),
            'status'	=>$this->input->post('status'),
		);

		$this->db->insert('siswa',$data);
        return true;
	}

    public function update()
	{
		$data = array(
            'nisn'	=>$this->input->post('nisn'),
			'nama'	=>$this->input->post('nama'),
            'tgl_lahir' => date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('tgl_lahir')))),
			'thn_masuk'	=>$this->input->post('thn_masuk'),
            'status'	=>$this->input->post('status'),
		);
		$this->db->where('id_siswa',$this->input->post('id_siswa'));
		$this->db->update('siswa',$data);
	}

    public function delete($id_siswa){
		$where = array('id_siswa'=>$id_siswa);
		$this->db->delete('siswa',$where);
	}
}