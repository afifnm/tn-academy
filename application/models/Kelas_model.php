<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kelas_model extends CI_Model {
	public function get_all(){
		$this->db->from('kelas');
		$this->db->order_by('nama_kelas','ASC');
		return $this->db->get()->result_array();
	}
    
    public function add()
	{
		$this->db->from('kelas')->where('nama_kelas',$this->input->post('nama_kelas'));
		$cek = $this->db->get()->row();

		if($cek != null){
        	return false;
		}
		$data = array(
			'nama_kelas'	=>$this->input->post('nama_kelas'),
            'tingkat'	=>$this->input->post('tingkat'),
            'jurusan'	=>$this->input->post('jurusan')
		);

		$this->db->insert('kelas',$data);
        return true;
	}

    public function update()
	{
		$data = array(
			'nama_kelas'	=>$this->input->post('nama_kelas'),
            'tingkat'	=>$this->input->post('tingkat'),
            'jurusan'	=>$this->input->post('jurusan'),


		);
		$this->db->where('id_kelas',$this->input->post('id_kelas'));
		$this->db->update('kelas',$data);
	}

    public function delete($id_kelas){
		$where = array('id_kelas'=>$id_kelas);
		$this->db->delete('kelas',$where);
	}
}