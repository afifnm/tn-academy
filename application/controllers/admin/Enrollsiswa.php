<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Enrollsiswa extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Enroll_model');
    }

    public function index() {
        $data = array(
            'title'        => 'Penempatan Siswa (Enroll)',
            'siswa'        => $this->Enroll_model->get_siswa(),
            'kelas'        => $this->Enroll_model->get_kelas(),
            'tahun_ajaran' => $this->Enroll_model->get_tahun_ajaran(),
            'enrolled'     => [], 
            'not_enrolled' => []  
        );

        $this->template->load('template', 'enroll/siswa', $data);
    }

   public function filter()
    {
        $data['title'] = 'Penempatan Siswa';
        $id_ta    = $this->input->get('id_ta');
        $id_kelas = $this->input->get('id_kelas');

        $data['filter'] = [
            'id_ta'    => $id_ta,
            'id_kelas' => $id_kelas
        ];

        $data['tahun_ajaran'] = $this->db->get('tahun_ajaran')->result_array();
        $data['kelas'] = $this->db->get('kelas')->result_array();

        $data['enrolled'] = $this->Enroll_model->get_enroll($id_ta, $id_kelas);
        $data['not_enrolled'] = $this->Enroll_model->get_siswa_not_enrolled($id_ta, $id_kelas);

        $this->template->load('template','enroll/siswa',$data);
    }


   public function enroll_bulk() {
    $siswa_ids = $this->input->post('siswa_ids'); 
    $id_ta     = $this->input->post('id_ta');
    $id_kelas  = $this->input->post('id_kelas');

    if (!empty($siswa_ids) && $id_ta && $id_kelas) {
        $success = 0;
        $duplicate = 0;

        foreach ($siswa_ids as $id_siswa) {
            $result = $this->Enroll_model->add([
                'id_siswa'       => $id_siswa,
                'id_kelas'       => $id_kelas,
                'id_ta'          => $id_ta,
                'tanggal_enroll' => date('Y-m-d H:i:s'),
                'status'         => 'aktif'
            ]);

            if ($result) {
                $success++;
            } else {
                $duplicate++;
            }
        }

        if ($success > 0) {
            $this->session->set_flashdata('success', "$success siswa berhasil di-enroll.");
        }
        if ($duplicate > 0) {
            $this->session->set_flashdata('error', "$duplicate siswa gagal di-enroll karena sudah ada.");
        }
    } else {
        $this->session->set_flashdata('error', 'Pilih siswa dan pastikan filter terisi.');
    }

    redirect('admin/enrollsiswa/filter?id_ta='.$id_ta.'&id_kelas='.$id_kelas);
    }


    public function delete($id_enroll) {
        $this->Enroll_model->delete($id_enroll);
        $this->session->set_flashdata('success', 'Data enroll berhasil dihapus.');
        redirect($_SERVER['HTTP_REFERER']);}
}
