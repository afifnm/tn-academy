<?php
class Enroll_model extends CI_Model {

    public function delete($id_enroll)
    {
        $this->db->delete('enroll', ['id_enroll' => $id_enroll]);
    }

    public function get_siswa()
    {
        return $this->db->get('siswa')->result_array();
    }

    public function get_kelas()
    {
        return $this->db->get('kelas')->result_array();
    }

    public function get_tahun_ajaran()
    {
        return $this->db->get('tahun_ajaran')->result_array();
    }

    public function get_enroll($id_ta = null, $id_kelas = null, $semester = null)
    {
        $this->db->select('enroll.id_enroll, enroll.id_siswa, enroll.id_kelas, enroll.id_ta, 
                        DATE(enroll.tanggal_enroll) AS tanggal_enroll,
                        siswa.nisn, siswa.nama, 
                        kelas.nama_kelas, 
                        tahun_ajaran.tahun, tahun_ajaran.semester');
        $this->db->from('enroll');
        $this->db->join('siswa', 'siswa.id_siswa = enroll.id_siswa');
        $this->db->join('kelas', 'kelas.id_kelas = enroll.id_kelas');
        $this->db->join('tahun_ajaran', 'tahun_ajaran.id_ta = enroll.id_ta');

        if ($id_ta) {
            $this->db->where('enroll.id_ta', $id_ta);
        }
        if ($id_kelas) {
            $this->db->where('enroll.id_kelas', $id_kelas);
        }
        if ($semester) {
            $this->db->where('tahun_ajaran.semester', $semester);
        }

        $this->db->order_by('enroll.id_enroll', 'DESC');
        return $this->db->get()->result_array();
    }

    public function get_siswa_not_enrolled($id_ta = null, $id_kelas = null, $semester = null)
    {
        $this->db->select('s.*');
        $this->db->from('siswa s');

        if ($id_ta && $id_kelas && $semester) {
            $this->db->where("s.id_siswa NOT IN (
                SELECT id_siswa FROM enroll 
                JOIN tahun_ajaran ta ON ta.id_ta = enroll.id_ta
                WHERE enroll.id_ta = ".$this->db->escape($id_ta)."
                AND enroll.id_kelas = ".$this->db->escape($id_kelas)."
                AND ta.semester = ".$this->db->escape($semester)."
            )", NULL, FALSE);
        }

        return $this->db->get()->result_array();
    }
}
