<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Nilai_model extends CI_Model {

    public function get_komponen_by_mapel($id_mapel) {
        return $this->db
            ->where('id_mapel', $id_mapel)
            ->get('mapel_komponen')
            ->result();
    }

    public function save_nilai($data) {
        $exists = $this->db->get_where('nilai', [
            'id_enroll' => $data['id_enroll'],
            'id_kelas_mapel' => $data['id_kelas_mapel'],
            'id_komponen' => $data['id_komponen']
        ])->row();

        if($exists) {
            $this->db->where('id_nilai', $exists->id_nilai);
            $this->db->update('nilai', [
                'skor' => $data['skor'],
                'id_guru' => $data['id_guru'],
                'tanggal_input' => date('Y-m-d H:i:s')
            ]);
        } else {
            $this->db->insert('nilai', [
                'id_enroll' => $data['id_enroll'],
                'id_kelas_mapel' => $data['id_kelas_mapel'],
                'id_komponen' => $data['id_komponen'],
                'skor' => $data['skor'],
                'id_guru' => $data['id_guru']
            ]);
        }
    }

    public function get_nilai_siswa($id_enroll, $id_kelas_mapel) {
        return $this->db
            ->select('n.*, mk.nama_komponen, mk.bobot')
            ->from('nilai n')
            ->join('mapel_komponen mk', 'mk.id_komponen = n.id_komponen')
            ->where('n.id_enroll', $id_enroll)
            ->where('n.id_kelas_mapel', $id_kelas_mapel)
            ->get()
            ->result();
    }

    public function get_nilai_by_kelas_ta($id_kelas, $id_ta) {
        $this->db->select('n.id_nilai, s.nama, m.nama_mapel, mk.nama_komponen, n.skor');
        $this->db->from('nilai n');
        $this->db->join('enroll e', 'e.id_enroll = n.id_enroll');
        $this->db->join('siswa s', 's.id_siswa = e.id_siswa');
        $this->db->join('kelas_mapel km', 'km.id_kelas_mapel = n.id_kelas_mapel');
        $this->db->join('mapel m', 'm.id_mapel = km.id_mapel');
        $this->db->join('mapel_komponen mk', 'mk.id_komponen = n.id_komponen');
        $this->db->where('e.id_kelas', $id_kelas);
        $this->db->where('e.id_ta', $id_ta);
        $this->db->order_by('s.nama','ASC');
        return $this->db->get()->result();
    }

    public function get_raport_by_siswa($id_siswa)
    {
        $sql = "
            SELECT 
                ta.tahun AS tahun_ajaran,
                ta.semester AS jenis_semester,
                m.nama_mapel,
                mk.nama_komponen,
                n.skor
            FROM nilai n
            JOIN enroll e ON n.id_enroll = e.id_enroll
            JOIN tahun_ajaran ta ON e.id_ta = ta.id_ta
            JOIN kelas_mapel km ON n.id_kelas_mapel = km.id_kelas_mapel
            JOIN mapel m ON km.id_mapel = m.id_mapel
            JOIN mapel_komponen mk ON n.id_komponen = mk.id_komponen
            WHERE e.id_siswa = ?
            ORDER BY ta.tahun, ta.semester, m.nama_mapel, mk.id_komponen
        ";

        return $this->db->query($sql, [$id_siswa])->result_array();
    }
}