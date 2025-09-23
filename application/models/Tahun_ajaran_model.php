<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tahun_ajaran_model extends CI_Model {
	public function get_all(){
		$this->db->from('tahun_ajaran');
		$this->db->order_by('tahun','ASC');
		return $this->db->get()->result_array();
	}
    
    public function add()
{
    $tahun    = $this->input->post('tahun');
    $semester = $this->input->post('semester');

    $this->db->where('tahun', $tahun);
    $this->db->where('semester', $semester);
    $exists = $this->db->get('tahun_ajaran')->row();

    if ($exists) {
        return false; 
    }

    return $this->db->insert('tahun_ajaran', [
        'tahun'    => $tahun,
        'semester' => $semester
    ]);
}


    public function update()
	{
		$data = array(
			'tahun'	=>$this->input->post('tahun'),
            'semester'	=>$this->input->post('semester')


		);
		$this->db->where('id_ta',$this->input->post('id_ta'));
		$this->db->update('tahun_ajaran',$data);
	}

    public function delete($id_ta){
		$where = array('id_ta'=>$id_ta);
		$this->db->delete('tahun_ajaran',$where);
	}
}