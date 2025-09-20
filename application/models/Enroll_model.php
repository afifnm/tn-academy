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
}
