<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\Xls;

class Siswa extends MY_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Siswa_model');
    }

    public function index()
    {
        $thn_masuk = $this->input->get('thn_masuk') ?? date('Y');
        $data = array(
            'thn_masuk' => $thn_masuk,
            'daftar_thn'=> $this->Siswa_model->get_all_tahun_masuk(),
            'siswa'      => $thn_masuk ? $this->Siswa_model->get_by_thn_masuk($thn_masuk) : [],
            'title'      => 'List Siswa'
        );
        $this->template->load('template','master/siswa/index',$data);
    }
    
    public function add()
	{
		 $data = array(
            // 'siswa'      => $this->Siswa_model->get_all(),
            'title'      => 'Tambah Data Siswa'
        );
        $this->template->load('template','master/siswa/siswa_add',$data);
	}

    

    public function save()
	{
		$this->only_post_allowed();
        $foto = null; // default null

        // cek kalau ada file foto yang diupload
        if (!empty($_FILES['foto']['name'])) {
            $namafoto = date('YmdHis') . '.jpg';

            $config['upload_path']   = './assets/upload/foto_siswa/';
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['max_size']      = 300 * 1024; // 500KB
            $config['file_name']     = $namafoto;

            $this->load->library('upload', $config);

            if ($_FILES['foto']['size'] >= 500 * 1024) {
                $this->set_flash('Ukuran foto terlalu besar, maksimal 500 KB.', 'error');
                redirect('admin/siswa');
            } elseif (!$this->upload->do_upload('foto')) {
                $this->set_flash('Upload gagal: ' . $this->upload->display_errors(), 'error');
                redirect('admin/siswa');
            } else {
                $uploadData = $this->upload->data();
                $foto = $uploadData['file_name'];
            }
        }

		$result = $this->Siswa_model->add($foto);
		if($result){
        	$this->set_flash('Siswa berhasil ditambahkan', 'success');
		} else {
			$this->set_flash('Data siswa sudah ada', 'error');
		}
		redirect('admin/siswa');
	}

    public function edit()
    {
        $this->only_post_allowed();
        $this->Siswa_model->update();
        $this->set_flash('Siswa berhasil diedit!', 'success');
        redirect('admin/siswa');
    }

    public function detail($id_siswa)
    {
        $data = array(
            'siswa'      => $this->Siswa_model->get_by_id($id_siswa),
            'title'      => 'Detail Siswa',
            'id_siswa'   => $id_siswa
        );
        $this->template->load('template','master/siswa/siswa_detail',$data);
    }
    public function raport($id_siswa)
    {
        $data = array(
            'siswa'      => $this->Siswa_model->get_by_id($id_siswa),
            'title'      => 'Raport Siswa'
        );
        $this->template->load('template','master/siswa/raport',$data);
    }

    public function update_siswa($id_siswa)
    {
        $this->Siswa_model->update_siswa($id_siswa);
        $this->set_flash('Informasi siswa berhasil diperbarui!', 'success');
        redirect('admin/siswa/detail/'.$id_siswa);
    }

    public function update_ortu($id_siswa)
    {
        $this->Siswa_model->update_ortu($id_siswa);
        $this->set_flash('Informasi Orang Tua berhasil diperbarui!', 'success');
        redirect('admin/siswa/detail/'.$id_siswa.'?tab=ortu');
    }

    public function update_lain($id_siswa)
    {
        $this->Siswa_model->update_lain($id_siswa);
        $this->set_flash('Informasi berhasil diperbarui!', 'success');
        redirect('admin/siswa/detail/'.$id_siswa.'?tab=lain');
    }

        public function delete($id_siswa)
    {
        $this->Siswa_model->delete($id_siswa);
        $this->set_flash('Siswa berhasil dihapus!', 'success');
        redirect('admin/siswa');
    }

    public function importExcel()
    {
        $this->load->library('Spreadsheet_loader');

        $file_tmp = $_FILES['file_excel']['tmp_name'];
        $ext = pathinfo($_FILES['file_excel']['name'], PATHINFO_EXTENSION);

        if ($ext == 'xlsx') {
            $spreadsheet = $this->spreadsheet_loader->loadXlsx($file_tmp);
        } else {
            $spreadsheet = $this->spreadsheet_loader->loadXls($file_tmp);
        }

        $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

        $countInsert = 0;
        $countUpdate = 0;

        foreach ($sheetData as $key => $row) {
            if ($key == 1) continue; // skip header

            $nis          = trim($row['B']);
            $nama         = trim($row['C']);
            $jk           = trim($row['D']);
            $jalur        = trim($row['E']);
            $kelas        = trim($row['F']);
            $nisn         = trim($row['G']);
            $tmp_lahir    = trim($row['H']);
            $tgl_lahir    = trim($row['I']);
            $graha        = trim($row['J']);
            $email        = trim($row['K']);
            $agama        = trim($row['L']);
            $cita_cita    = trim($row['M']);
            $nama_smp     = trim($row['N']);
            $tinggi       = trim($row['O']);
            $berat        = trim($row['P']);
            $hobi         = trim($row['Q']);
            $nama_ayah    = trim($row['R']);
            $nama_ibu     = trim($row['S']);
            $pekerjaan_ayah = trim($row['T']);
            $pekerjaan_ibu  = trim($row['U']);
            $penghasilan_ayah = trim($row['V']);
            $penghasilan_ibu  = trim($row['W']);
            $provinsi     = trim($row['X']);

            if ($nis == '') continue;

            $data = [
                'nis'            => $nis,
                'nisn'           => $nisn,
                'nama'           => $nama,
                'email'          => $email,
                'jenis_kelamin'  => $jk,
                'agama'          => $agama,
                'jalur_pendidikan' => $jalur,
                'tempat_lahir'   => $tmp_lahir,
                'tgl_lahir'      => date('Y-m-d', strtotime($tgl_lahir)),
                'status'         => 'Aktif', // default kalau tidak ada di excel
                'nama_ayah'      => $nama_ayah,
                'pekerjaan_ayah' => $pekerjaan_ayah,
                'penghasilan_ayah' => $penghasilan_ayah,
                'nama_ibu'       => $nama_ibu,
                'pekerjaan_ibu'  => $pekerjaan_ibu,
                'penghasilan_ibu'=> $penghasilan_ibu,
                'cita_cita'      => $cita_cita,
                'nama_smp'       => $nama_smp,
                'tinggi'         => $tinggi,
                'berat_badan'    => $berat,
                'hobi'           => $hobi,
                'nama_provinsi'  => $provinsi
            ];

            // cek apakah nis sudah ada
            $cek = $this->db->get_where('siswa', ['nis' => $nis])->row();

            if ($cek) {
                $this->db->where('nis', $nis);
                $this->db->update('siswa', $data);
                $countUpdate++;
            } else {
                $this->db->insert('siswa', $data);
                $countInsert++;
            }
        }

        $this->session->set_flashdata('success',
            "Import selesai. Tambah: {$countInsert}, Update: {$countUpdate}"
        );
        redirect('admin/siswa');
    }


}
