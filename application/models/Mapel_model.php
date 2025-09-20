<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mapel_model extends CI_Model {
    
    public function add()
	{
		$this->db->from('mapel')->where('nama_mapel',$this->input->post('nama_mapel'));
		$cek = $this->db->get()->row();

		if($cek != null){
        	return false;
		}
		$data = array(
			'nama_mapel'	=>$this->input->post('nama_mapel'),
		);

		$this->db->insert('mapel',$data);
        return true;
	}

    public function update()
	{
		$data = array(
			'nama_mapel'	=>$this->input->post('nama_mapel'),
		);
		$this->db->where('id_mapel',$this->input->post('id_mapel'));
		$this->db->update('mapel',$data);
	}

    public function delete($id_mapel){
		$where = array('id_mapel'=>$id_mapel);
		$this->db->delete('mapel',$where);
	}
}