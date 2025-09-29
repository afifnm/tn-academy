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
        $result = $this->db->get('siswa')->result();

        $output = [];
        foreach ($result as $row) {
            $output[] = [
                "nama" => $row->nama,
                "nisn" => $row->nisn
            ];
        }
        echo json_encode($output);
    }


}
