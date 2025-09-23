<?php
class Enroll_model extends CI_Model {

    public function add()
    {
        $this->db->from('enroll')
                 ->where('id_siswa', $this->input->post('id_siswa'))
                 ->where('id_kelas', $this->input->post('id_kelas'))
                 ->where('id_ta', $this->input->post('id_ta'));
        $cek = $this->db->get()->row();

        if($cek != null){
            return false;
        }

        $data = array(
            'id_siswa'       => $this->input->post('id_siswa'),
            'id_kelas'       => $this->input->post('id_kelas'),
            'id_ta'          => $this->input->post('id_ta'),
            'tanggal_enroll' => date('Y-m-d'),
            'status'         => $this->input->post('status') ?? 'aktif'
        );

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

    public function get_tahun_ajaran()
    {
        return $this->db->get('tahun_ajaran')->result_array();
    }

    public function get_enroll()
    {
        $this->db->select('enroll.*, DATE(enroll.tanggal_enroll) AS tanggal_enroll,
                        siswa.nama, kelas.nama_kelas, tahun_ajaran.tahun, tahun_ajaran.semester');
        $this->db->from('enroll');
        $this->db->join('siswa', 'siswa.id_siswa = enroll.id_siswa');
        $this->db->join('kelas', 'kelas.id_kelas = enroll.id_kelas');
        $this->db->join('tahun_ajaran', 'tahun_ajaran.id_ta = enroll.id_ta');
        $this->db->order_by('id_enroll', 'DESC');
        return $this->db->get()->result_array();
    }
}
