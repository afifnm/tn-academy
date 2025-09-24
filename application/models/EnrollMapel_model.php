<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class EnrollMapel_model extends CI_Model {

    
    public function get_kelas() {
        return $this->db->get('kelas')->result_array();
    }

    public function get_tahun_ajaran() {
        return $this->db->get('tahun_ajaran')->result_array();
    }

    public function get_all_mapel() {
        return $this->db->get('mapel')->result_array();
    }

    public function get_enrolled($id_ta = null, $id_kelas = null) {
        $this->db->select('
            em.id_enroll_mapel,
            em.id_mapel,
            em.id_kelas,
            em.id_ta,
            DATE(em.created_at) AS tanggal_enroll,
            m.nama_mapel,
            k.nama_kelas,
            ta.tahun,
            ta.semester
        ');
        $this->db->from('enroll_mapel em');
        $this->db->join('mapel m', 'm.id_mapel = em.id_mapel');
        $this->db->join('kelas k', 'k.id_kelas = em.id_kelas');
        $this->db->join('tahun_ajaran ta', 'ta.id_ta = em.id_ta');

        if ($id_ta) $this->db->where('em.id_ta', $id_ta);
        if ($id_kelas) $this->db->where('em.id_kelas', $id_kelas);

        $this->db->order_by('em.id_enroll_mapel', 'DESC');
        return $this->db->get()->result_array();
    }

    public function get_not_enrolled($id_ta = null, $id_kelas = null) {
        $this->db->select('m.*');
        $this->db->from('mapel m');

        if ($id_ta && $id_kelas) {
            $this->db->where("m.id_mapel NOT IN (
                SELECT id_mapel FROM enroll_mapel 
                WHERE id_ta = ".$this->db->escape($id_ta)." 
                AND id_kelas = ".$this->db->escape($id_kelas)."
            )", NULL, FALSE);
        }

        return $this->db->get()->result_array();
    }

    public function add($data = null) {
        if ($data === null) {
            $data = [
                'id_mapel'  => $this->input->post('id_mapel'),
                'id_kelas'  => $this->input->post('id_kelas'),
                'id_ta'     => $this->input->post('id_ta'),
                'created_at'=> date('Y-m-d')
            ];
        } else {
            if (!isset($data['created_at'])) $data['created_at'] = date('Y-m-d');
        }

        $this->db->from('enroll_mapel')
            ->where('id_mapel', $data['id_mapel'])
            ->where('id_kelas', $data['id_kelas'])
            ->where('id_ta', $data['id_ta']);
        $cek = $this->db->get()->row();

        if ($cek != null) return false;

        $this->db->insert('enroll_mapel', $data);
        $id_enroll_mapel = $this->db->insert_id();

        $komponen = $this->db->get_where('mapel_komponen', ['id_mapel' => $data['id_mapel']])->result_array();
        foreach ($komponen as $k) {
            $this->db->insert('enroll_mapel_komponen', [
                'id_enroll_mapel' => $id_enroll_mapel,
                'id_komponen'     => $k['id_komponen'],
                'bobot'           => $k['bobot']
            ]);
        }

        return true;
    }

    public function delete($id_enroll_mapel) {
        $this->db->delete('enroll_mapel', ['id_enroll_mapel' => $id_enroll_mapel]);
    }

    public function get_komponen($id_enroll_mapel) {
        
        $enroll = $this->db->get_where('enroll_mapel', ['id_enroll_mapel' => $id_enroll_mapel])->row_array();
        if (!$enroll) return [];
        
        $this->db->select('ek.*, mk.nama_komponen');
        $this->db->from('enroll_mapel_komponen ek');
        $this->db->join('mapel_komponen mk', 'mk.id_komponen = ek.id_komponen');
        $this->db->where('ek.id_enroll_mapel', $id_enroll_mapel);
        return $this->db->get()->result_array();
    }
}
