<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mapel_model extends CI_Model {
	public function get_all(){
		$this->db->from('mapel')->order_by('nama_mapel','ASC');
		return $this->db->get()->result_array();
	}
	public function get_nama($id) {
		$row = $this->db->get_where('mapel', ['id_mapel' => $id])->row();
		return $row ? $row->nama_mapel : '—';
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

	public function get_mapel_enrolled_by_kelas_ta($id_kelas, $id_ta) {
		$query = $this->db
			->select('
				em.id_enroll_mapel,
				em.id_mapel,
				em.id_guru,
				ek.id_komponen,  
				m.nama_mapel,
				mk.nama_komponen,
				mk.bobot
			')
			->from('enroll_mapel em')
			->join('mapel m', 'm.id_mapel = em.id_mapel', 'left')
			->join('enroll_mapel_komponen ek', 'ek.id_enroll_mapel = em.id_enroll_mapel', 'left') 
			->join('mapel_komponen mk', 'mk.id_komponen = ek.id_komponen', 'left')  
			->where('em.id_kelas', $id_kelas)
			->where('em.id_ta', $id_ta)
			->get();

		$raw = $query->result();

		// Kelompokkan per mapel
		$grouped = [];
		foreach ($raw as $row) {
			if (!isset($grouped[$row->id_mapel])) {
				$grouped[$row->id_mapel] = [
					'id_mapel' => $row->id_mapel,
					'nama_mapel' => $row->nama_mapel,
					'id_guru' => $row->id_guru,
					'komponen' => []
				];
			}
			if ($row->id_komponen) {
				$grouped[$row->id_mapel]['komponen'][] = [
					'id_komponen' => $row->id_komponen,
					'nama_komponen' => $row->nama_komponen,
					'bobot' => $row->bobot
				];
			}
		}

		return array_values($grouped);
	}

	public function get_mapel_enrolled_by_kelas_ta_guru($id_kelas, $id_ta, $id_guru) {
		$query = $this->db
			->select('
				em.id_enroll_mapel,
				em.id_mapel,
				em.id_guru,
				ek.id_komponen,
				m.nama_mapel,
				mk.nama_komponen,
				mk.bobot
			')
			->from('enroll_mapel em')
			->join('mapel m', 'm.id_mapel = em.id_mapel', 'left')
			->join('enroll_mapel_komponen ek', 'ek.id_enroll_mapel = em.id_enroll_mapel', 'left')
			->join('mapel_komponen mk', 'mk.id_komponen = ek.id_komponen', 'left')
			->where('em.id_kelas', $id_kelas)
			->where('em.id_ta', $id_ta)
			->where('em.id_guru', $id_guru) 
			->get();

		$raw = $query->result();

		$grouped = [];
		foreach ($raw as $row) {
			if (!isset($grouped[$row->id_mapel])) {
				$grouped[$row->id_mapel] = [
					'id_mapel' => $row->id_mapel,
					'nama_mapel' => $row->nama_mapel,
					'id_guru' => $row->id_guru,
					'komponen' => []
				];
			}
			if ($row->id_komponen) {
				$grouped[$row->id_mapel]['komponen'][] = [
					'id_komponen' => $row->id_komponen,
					'nama_komponen' => $row->nama_komponen,
					'bobot' => $row->bobot
				];
			}
		}

		return array_values($grouped);
	}
}