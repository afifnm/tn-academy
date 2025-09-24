<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mapel_model extends CI_Model {
	public function get_all(){
		$this->db->from('mapel')->order_by('nama_mapel','ASC');
		return $this->db->get()->result_array();
	}

	public function get_mapel_by_kelas($id_kelas) {
        $this->db->select('km.id_kelas_mapel, m.id_mapel, m.nama_mapel');
        $this->db->from('kelas_mapel km');
        $this->db->join('mapel m', 'm.id_mapel = km.id_mapel');
        $this->db->where('km.id_kelas', $id_kelas);
        $this->db->order_by('m.nama_mapel', 'ASC');
        return $this->db->get()->result();
    }
	
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