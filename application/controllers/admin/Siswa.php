<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\Xls;

class Siswa extends MY_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Siswa_model');
        $this->load->model('Nilai_model');
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
        $siswa = $this->Siswa_model->get_by_id($id_siswa);
        $tahun_masuk = (int)$siswa['thn_masuk']; 

        $nilai_raw = $this->Nilai_model->get_raport_by_siswa($id_siswa);

        // echo "<pre>";
        // print_r($nilai_raw);
        // echo "</pre>";
        // exit; // hentikan sementara


        $semesterData = [];
        foreach ($nilai_raw as $row) {
            $tahun_awal = (int)substr($row['tahun_ajaran'], 0, 4); 
            $semester_nomor = ($tahun_awal - $tahun_masuk) * 2 + 
                            ($row['jenis_semester'] == 'Ganjil' ? 1 : 2);

            // Batasi hanya semester 1-5
            if ($semester_nomor < 1 || $semester_nomor > 5) continue;

            $mapel = $row['nama_mapel'];
            
            if (!isset($semesterData[$semester_nomor])) {
                $semesterData[$semester_nomor] = [
                    'semester' => $semester_nomor,
                    'tahun' => $row['tahun_ajaran'] . ' (' . $row['jenis_semester'] . ')',
                    'mapel' => []
                ];
            }
            
            if (!isset($semesterData[$semester_nomor]['mapel'][$mapel])) {
                $semesterData[$semester_nomor]['mapel'][$mapel] = [
                    'nama' => $mapel,
                    'komponen' => []
                ];
            }
            
            $semesterData[$semester_nomor]['mapel'][$mapel]['komponen'][] = [
                'nama' => $row['nama_komponen'],
                'nilai' => (float)$row['skor']
            ];
        }

        foreach ($semesterData as $sem => $data) {
            $semesterData[$sem]['mapel'] = array_values($data['mapel']);
        }

        $final = [];
        for ($i = 1; $i <= 5; $i++) {
            $final[$i] = $semesterData[$i] ?? [
                'semester' => $i,
                'tahun' => $this->format_tahun_semester($tahun_masuk, $i),
                'mapel' => []
            ];
        }

        $data = [
            'siswa' => $siswa,
            'semesterData' => $final,
            'title' => 'Raport Siswa'
        ];

        // echo "<pre>";
        // print_r($semesterData);
        // echo "</pre>";
        // exit;

        $this->template->load('template', 'master/siswa/raport', $data);
    }

    private function format_tahun_semester($tahun_masuk, $semester)
    {
        $kelas = ceil($semester / 2);
        $tahun_awal = $tahun_masuk + $kelas - 1;
        $tahun_ajaran = $tahun_awal . '/' . ($tahun_awal + 1);
        $jenis = ($semester % 2 == 1) ? 'Ganjil' : 'Genap';
        return $tahun_ajaran . ' (' . $jenis . ')';
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
        if (empty($_FILES['file_excel']['tmp_name'])) {
            $this->set_flash('Silakan pilih file Excel terlebih dahulu.', 'error');
            redirect('admin/siswa');
        }

        $this->load->library('Spreadsheet_loader');

        $file_tmp = $_FILES['file_excel']['tmp_name'];
        $ext = pathinfo($_FILES['file_excel']['name'], PATHINFO_EXTENSION);

        if (!in_array(strtolower($ext), ['xlsx', 'xls'])) {
            $this->set_flash('Format file tidak didukung. Gunakan .xlsx atau .xls', 'error');
            redirect('admin/siswa');
        }

        try {
            if ($ext == 'xlsx') {
                $spreadsheet = $this->spreadsheet_loader->loadXlsx($file_tmp);
            } else {
                $spreadsheet = $this->spreadsheet_loader->loadXls($file_tmp);
            }
        } catch (Exception $e) {
            $this->set_flash('File Excel rusak atau tidak valid.', 'error');
            redirect('admin/siswa');
        }

        $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

        $countInsert = 0;
        $countUpdate = 0;

        foreach ($sheetData as $key => $row) {
            // Skip baris 1-4 (1: judul, 2-3: kosong, 4: header)
            if ($key <= 4) continue;

            $nis          = trim($row['B'] ?? '');
            if ($nis == '') continue;

            $nisn         = trim($row['C'] ?? '');
            $nama         = trim($row['D'] ?? '');
            $email        = trim($row['E'] ?? '');
            $jk           = trim($row['F'] ?? '');
            $jalur        = trim($row['G'] ?? '');
            $tmp_lahir    = trim($row['H'] ?? '');
            $tgl_lahir    = trim($row['I'] ?? '');
            $graha        = trim($row['J'] ?? '');
            $agama        = trim($row['K'] ?? '');
            $cita_cita    = trim($row['L'] ?? '');
            $nama_smp     = trim($row['M'] ?? '');
            $tinggi       = trim($row['N'] ?? '');
            $berat        = trim($row['O'] ?? '');
            $hobi         = trim($row['P'] ?? '');
            $nama_ayah    = trim($row['Q'] ?? '');
            $nama_ibu     = trim($row['R'] ?? '');
            $pekerjaan_ayah = trim($row['S'] ?? '');
            $pekerjaan_ibu  = trim($row['T'] ?? '');
            $penghasilan_ayah = trim($row['U'] ?? '');
            $penghasilan_ibu  = trim($row['V'] ?? '');
            $provinsi     = trim($row['W'] ?? '');
            $tahun_masuk  = trim($row['X'] ?? '');

            // Validasi tanggal
            $tgl_lahir_db = null;
            if (!empty($tgl_lahir)) {
                $formats = ['Y-m-d', 'd/m/Y', 'd-m-Y'];
                foreach ($formats as $format) {
                    $date = \DateTime::createFromFormat($format, $tgl_lahir);
                    if ($date) {
                        $tgl_lahir_db = $date->format('Y-m-d');
                        break;
                    }
                }
            }

            $data = [
                'nis'               => $nis,
                'nisn'              => $nisn,
                'nama'              => $nama,
                'email'             => $email,
                'jenis_kelamin'     => $jk,
                'agama'             => $agama,
                'jalur_pendidikan'  => $jalur,
                'tempat_lahir'      => $tmp_lahir,
                'tgl_lahir'         => $tgl_lahir_db,
                'status'            => 'Aktif',
                'nama_ayah'         => $nama_ayah,
                'pekerjaan_ayah'    => $pekerjaan_ayah,
                'penghasilan_ayah'  => $penghasilan_ayah,
                'nama_ibu'          => $nama_ibu,
                'pekerjaan_ibu'     => $pekerjaan_ibu,
                'penghasilan_ibu'   => $penghasilan_ibu,
                'cita_cita'         => $cita_cita,
                'nama_smp'          => $nama_smp,
                'tinggi'            => $tinggi,
                'berat_badan'       => $berat,
                'hobi'              => $hobi,
                'nama_provinsi'     => $provinsi,
                'thn_masuk'         => !empty($tahun_masuk) ? (int)$tahun_masuk : null
            ];

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

       $this->set_flash(
            "Import selesai. Berhasil menambahkan data.",'success'
        );

        // kirim JSON agar Dropzone tahu hasilnya
        echo json_encode(['status' => 'success']);
        exit;

    }

    public function download_template()
    {
        // Path ke file template
        $filePath = FCPATH . 'assets/templates/format_import_siswa.xlsx';

        if (!file_exists($filePath)) {
            $this->set_flash('File template tidak ditemukan. Silakan hubungi administrator.', 'error');
            redirect('admin/siswa');
        }

        // Set header untuk download
        header('Content-Description: File Transfer');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . basename($filePath) . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($filePath));

        // Baca file dan kirim ke output
        readfile($filePath);
        exit();
    }


}

