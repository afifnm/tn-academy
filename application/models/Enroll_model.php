<?php
class Enroll_model extends CI_Model {

    public function add($data = null)
    {        if ($data === null) {
            $data = array(
                'id_siswa'       => $this->input->post('id_siswa'),
                'id_kelas'       => $this->input->post('id_kelas'),
                'id_ta'          => $this->input->post('id_ta'),
                'tanggal_enroll' => date('Y-m-d'),
                'status'         => $this->input->post('status') ?? 'aktif'
            );
        }

        // cek duplikasi
        $this->db->from('enroll')
                ->where('id_siswa', $data['id_siswa'])
                ->where('id_kelas', $data['id_kelas'])
                ->where('id_ta', $data['id_ta']);
        $cek = $this->db->get()->row();

        if ($cek != null) {
            return false;
        }

        $this->db->insert('enroll', $data);
        return true;
    }


    public function update($id_enroll)
    {
        $data = array(
            'id_siswa' => $this->input->post('id_siswa'),
            'id_kelas' => $this->input->post('id_kelas'),
            'id_ta'    => $this->input->post('id_ta'),
            'status'   => $this->input->post('status')
        );
        $this->db->where('id_enroll', $id_enroll)->update('enroll', $data);
    }

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

    public function get_tahun_ajaran(){
        $this->db->order_by('tahun', 'DESC');
        $this->db->order_by('semester', 'DESC');
        return $this->db->get('tahun_ajaran')->result_array();
    }

    public function get_siswa_by_kelas($id_kelas, $id_ta) {
        $this->db->select('e.id_enroll, s.nama');
        $this->db->from('enroll e');
        $this->db->join('siswa s', 's.id_siswa = e.id_siswa');
        $this->db->where('e.id_kelas', $id_kelas);
        $this->db->where('e.id_ta', $id_ta);
        $this->db->order_by('s.nama', 'ASC');
        return $this->db->get()->result();
    }

    public function get_enroll($id_ta = null, $id_kelas = null, $semester = null)
    {
        $this->db->select('enroll.id_enroll, enroll.id_siswa, enroll.id_kelas, enroll.id_ta, 
                        DATE(enroll.tanggal_enroll) AS tanggal_enroll,
                        siswa.nis, siswa.nama, 
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
        $this->db->select('s.id_siswa, s.nis,s.nisn, s.nama, s.thn_masuk');
        $this->db->from('siswa s');

        if ($id_ta) {
            if ($semester) {
                $this->db->where("s.id_siswa NOT IN (
                    SELECT id_siswa FROM enroll 
                    JOIN tahun_ajaran ta ON ta.id_ta = enroll.id_ta
                    WHERE enroll.id_ta = ".$this->db->escape($id_ta)."
                    AND ta.semester = ".$this->db->escape($semester)."
                )", NULL, FALSE);
            } else {

                $this->db->where("s.id_siswa NOT IN (
                    SELECT id_siswa FROM enroll
                    WHERE enroll.id_ta = ".$this->db->escape($id_ta)."
                )", NULL, FALSE);
            }
        }

        return $this->db->get()->result_array();
    }

}