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
            'not_enrolled' => []  ,
            'filter'       => [] 
        );

        $this->template->load('template', 'enroll/siswa', $data);
    }

    public function filter() {
        $id_ta    = $this->input->get('id_ta');
        $id_kelas = $this->input->get('id_kelas');
        $semester = $this->input->get('semester');

        $data = array(
            'title'        => 'Penempatan Siswa (Enroll)',
            'kelas'        => $this->Enroll_model->get_kelas(),
            'tahun_ajaran' => $this->Enroll_model->get_tahun_ajaran(),
            'enrolled'     => $this->Enroll_model->get_enroll($id_ta, $id_kelas, $semester),
            'not_enrolled' => $this->Enroll_model->get_siswa_not_enrolled($id_ta, $id_kelas, $semester),
            'filter'       => [ 
            'id_ta'    => $id_ta,
            'id_kelas' => $id_kelas,
            'semester' => $semester
        ]
        );

        $this->template->load('template', 'enroll/siswa', $data);
    } 

    public function enroll_bulk() {
        $siswa_ids = $this->input->post('siswa_ids'); // array siswa yang dicentang
        $id_ta     = $this->input->post('id_ta');
        $id_kelas  = $this->input->post('id_kelas');

        if (!empty($siswa_ids) && $id_ta && $id_kelas) {
            foreach ($siswa_ids as $id_siswa) {
                $this->Enroll_model->add([
                    'id_siswa'   => $id_siswa,
                    'id_kelas'   => $id_kelas,
                    'id_ta'      => $id_ta,
                    'tanggal_enroll' => date('Y-m-d H:i:s')
                ]);
            }
            $this->set_flash( 'Siswa berhasil di-enroll.', 'success');
        } else {
            $this->set_flash( 'Pilih siswa dan pastikan filter terisi.','error');
        }

        redirect('admin/enrollsiswa/filter?id_ta='.$id_ta.'&id_kelas='.$id_kelas);
    }

    public function delete($id_enroll) {
        $this->Enroll_model->delete($id_enroll);
        $this->set_flash('Data enroll berhasil dihapus.','success' );
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function clone() {
        $source_ta = $this->input->post('source_ta');
        $target_ta = $this->input->post('target_ta');
        $source_kelas = $this->input->post('source_kelas');
        $target_kelas = $this->input->post('target_kelas');

        $data_enroll = $this->Enroll_model->get_enroll($source_ta, $source_kelas, null);
        if (!empty($data_enroll)) {        
            foreach ($data_enroll as $enroll) {
                // cek duplikasi
                $this->db->from('enroll')
                        ->where('id_siswa', $enroll['id_siswa'])
                        ->where('id_ta', $target_ta);
                $cek = $this->db->get()->row();
                if ($cek != null) {
                    $this->set_flash('Data enroll sudah ada pada tahun ajaran dan kelas tujuan.','error' );
                    redirect('admin/enrollsiswa/'.'filter?id_ta='.$source_ta.'&id_kelas='.$source_kelas);
                }
                $this->Enroll_model->add([
                    'id_siswa'      => $enroll['id_siswa'],
                    'id_kelas'      => $target_kelas,
                    'id_ta'         => $target_ta,
                    'tanggal_enroll'=> date('Y-m-d H:i:s')
                ]);
            }
            $this->set_flash('Data enroll berhasil di-clone.','success' );
        } else {
            $this->set_flash('Tidak ada data enroll pada tahun ajaran dan kelas sumber.','error' );
        }
        redirect('admin/enrollsiswa/'.'filter?id_ta='.$source_ta.'&id_kelas='.$source_kelas);
    }
}
