<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\Xls;

class Siswa extends MY_Controller {
    public function __construct() {
        parent::__construct();
        $this->only_admin_allowed();

        $this->load->model('Siswa_model');
    }

    public function index()
    {
        $data = array(
            'siswa'      => $this->Siswa_model->get_all(),
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
		$result = $this->Siswa_model->add();
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

    public function delete($id_siswa)
    {
        $this->Siswa_model->delete($id_siswa);
        $this->set_flash('Siswa berhasil dihapus!', 'success');
        redirect('admin/siswa');
    }

    public function importExcel()
    {
        $this->load->library('Spreadsheet_loader');

        // ambil file upload
        $file_tmp = $_FILES['file_excel']['tmp_name'];
        $ext = pathinfo($_FILES['file_excel']['name'], PATHINFO_EXTENSION);

        if ($ext == 'xlsx') {
            $spreadsheet = $this->spreadsheet_loader->loadXlsx($file_tmp);
        } else {
            $spreadsheet = $this->spreadsheet_loader->loadXls($file_tmp);
        }

        // ambil data excel jadi array
        $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

        $countInsert = 0;
        $countUpdate = 0;

        foreach ($sheetData as $key => $row) {
            if ($key == 1) continue; // skip header

            $nisn   = trim($row['A']); // pastikan tidak ada spasi
            $nama   = trim($row['B']);
            $tgl_lahir  = trim($row['C']);
            $thn_masuk = trim($row['D']);
            $status = trim($row['E']);

            if ($nisn == '') continue; // skip baris kosong

            $data = [
                'nama'   => $nama,
                'tgl_lahir' => $tgl_lahir,
                'thn_masuk' => $thn_masuk,
                'status' => $status,
            ];

            // cek apakah nisn sudah ada
            $cek = $this->db->get_where('siswa', ['nisn' => $nisn])->row();

            if ($cek) {
                // update
                $this->db->where('nisn', $nisn);
                $this->db->update('siswa', $data);
                $countUpdate++;
            } else {
                // insert
                $data['nisn'] = $nisn;
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
