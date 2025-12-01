<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
	public function index()
	{
		$data = array (
			'title' => 'Dashboard'
		);
		$this->template->load('template','home',$data); 
	}

	
   public function search() {
        $q = $this->input->get('q');
        $this->db->like('nama', $q);
        $this->db->or_like('nisn', $q);
        $this->db->or_like('nis', $q);
        $result = $this->db->get('siswa')->result();

        $output = [];
        foreach ($result as $row) {
            $output[] = [
                "id_siswa" => $row->id_siswa, 
                "nama" => $row->nama,
                "nisn" => $row->nisn,
                "nis" => $row->nis
            ];
        }
        echo json_encode($output);
    }



}
