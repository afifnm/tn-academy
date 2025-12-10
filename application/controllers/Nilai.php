<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Font;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
class Nilai extends MY_Controller {

    public function __construct() {
        parent::__construct(); 
        $this->load->model('Nilai_model');
        $this->load->model('Enroll_model');
        $this->load->model('Kelas_model');
        $this->load->model('Mapel_model');
    }

    public function guru(){ //untuk guru mengarah ke index kirim id kelas, id ta dan id mapel
        $id_kelas = $this->input->get('id_kelas');
        $id_ta = $this->input->get('id_ta');
        $this->db->where('id_kelas',$id_kelas);
        $this->db->where('id_ta',$id_ta);
        $this->db->where('id_guru',$this->session->userdata('id_guru'));
        $id_mapel = $this->db->get('enroll_mapel')->row()->id_mapel;
        redirect('nilai?id_kelas='.$id_kelas.'&id_ta='.$id_ta.'&id_mapel='.$id_mapel);

    }
    public function index() {
        $data['title'] = 'Input Nilai Siswa';
        $data['kelas'] = $this->Kelas_model->get_all();
        $data['tahun_ajaran'] = $this->db->order_by('tahun', 'DESC')->get('tahun_ajaran')->result();

        $role = $this->session->userdata('role');
        $id_guru = $this->session->userdata('id_guru');


        $id_kelas = $this->input->get('id_kelas');
        $id_ta = $this->input->get('id_ta');
        $id_mapel = $this->input->get('id_mapel');

        $data['id_kelas'] = $id_kelas;
        $data['id_ta'] = $id_ta;
        $data['id_mapel'] = $id_mapel;

        if ($id_kelas && $id_ta) {
            if ($role === 'admin') {
                $data['mapel_list'] = $this->Mapel_model->get_mapel_enrolled_by_kelas_ta($id_kelas, $id_ta);
            } else {
                $data['mapel_list'] = $this->Mapel_model->get_mapel_enrolled_by_kelas_ta_guru($id_kelas, $id_ta, $id_guru);
            }
        } else {
            $data['mapel_list'] = [];
        }

        if ($id_kelas && $id_ta && $id_mapel) {
            if ($role === 'admin') {
                $is_valid = $this->db->get_where('enroll_mapel', [
                    'id_kelas' => $id_kelas,
                    'id_ta' => $id_ta,
                    'id_mapel' => $id_mapel
                ])->row();
            } else {
                $is_valid = $this->db->get_where('enroll_mapel', [
                    'id_kelas' => $id_kelas,
                    'id_ta' => $id_ta,
                    'id_mapel' => $id_mapel,
                    'id_guru' => $id_guru
                ])->row();
            }

            if (!$is_valid) {
                $this->session->set_flashdata('error', 'Anda tidak diizinkan mengajar mapel ini.');
                redirect('nilai');
            }

            $data['siswa'] = $this->Enroll_model->get_siswa_by_kelas($id_kelas, $id_ta);

            $mapel_terpilih = null;
            foreach ($data['mapel_list'] ?? [] as $m) {
                if ($m['id_mapel'] == $id_mapel) {
                    $mapel_terpilih = new stdClass();
                    $mapel_terpilih->id_mapel = $m['id_mapel'];
                    $mapel_terpilih->nama_mapel = $m['nama_mapel'];
                    $mapel_terpilih->id_guru = $m['id_guru'];
                    $mapel_terpilih->komponen = $m['komponen'];

                    $kelas_mapel = $this->db->get_where('kelas_mapel', [
                        'id_kelas' => $id_kelas,
                        'id_mapel' => $id_mapel
                    ])->row();

                    if ($kelas_mapel) {
                        $mapel_terpilih->id_kelas_mapel = $kelas_mapel->id_kelas_mapel;
                    } else {
                        $this->db->insert('kelas_mapel', [
                            'id_kelas' => $id_kelas,
                            'id_mapel' => $id_mapel
                        ]);
                        $mapel_terpilih->id_kelas_mapel = $this->db->insert_id();
                    }
                    break;
                }
            }

            if (!$mapel_terpilih || empty($mapel_terpilih->komponen)) {
                $this->session->set_flashdata('error', 'Tidak ada komponen nilai untuk mapel ini.');
                redirect('nilai?id_kelas=' . $id_kelas . '&id_ta=' . $id_ta);
            }

            $data['mapel_terpilih'] = $mapel_terpilih;
            $data['nilai_terisi'] = $this->Nilai_model->get_nilai_by_kelas_ta($id_kelas, $id_ta);
        } else {
            $data['siswa'] = [];
            $data['mapel_terpilih'] = null;
            $data['nilai_terisi'] = [];
        }

        $this->template->load('template', 'nilai/index', $data);
    }


    public function save() {
        $post = $this->input->post();
        $id_kelas = $post['id_kelas'];
        $id_mapel = $post['id_mapel'];
        $role = $this->session->userdata('role');
        $id_guru = $this->session->userdata('id_guru');

        if (!$id_guru && $role !== 'admin') {
            $this->session->set_flashdata('error', 'Akses ditolak.');
            redirect('nilai');
        }

        if ($role === 'guru') {
            $is_valid = $this->db->get_where('enroll_mapel', [
                'id_kelas' => $id_kelas,
                'id_mapel' => $id_mapel,
                'id_guru' => $id_guru
            ])->row();

            if (!$is_valid) {
                $this->session->set_flashdata('error', 'Anda tidak diizinkan menyimpan nilai untuk mapel ini.');
                redirect('nilai');
            }
        }

        foreach($post['nilai'] as $id_enroll => $mapel_nilai) {
            foreach($mapel_nilai as $id_kelas_mapel => $komponen_nilai) {
                foreach($komponen_nilai as $id_komponen => $skor) {
                    //Pastikan id_kelas_mapel valid
                    if ($id_kelas_mapel == 0) {
                        $kelas_mapel = $this->db->get_where('kelas_mapel', [
                            'id_kelas' => $id_kelas,
                            'id_mapel' => $id_mapel
                        ])->row();

                        if ($kelas_mapel) {
                            $id_kelas_mapel = $kelas_mapel->id_kelas_mapel;
                        } else {
                            $this->db->insert('kelas_mapel', [
                                'id_kelas' => $id_kelas,
                                'id_mapel' => $id_mapel
                            ]);
                            $id_kelas_mapel = $this->db->insert_id();
                        }
                    }

                    $this->Nilai_model->save_nilai([
                        'id_enroll' => $id_enroll,
                        'id_kelas_mapel' => $id_kelas_mapel,
                        'id_komponen' => $id_komponen,
                        'skor' => $skor,
                        'id_guru' => $id_guru 
                    ]);
                }
            }
        }

        $this->session->set_flashdata('success', 'Nilai berhasil disimpan!');

        $url = 'nilai?';
        $url .= 'id_kelas=' . $post['id_kelas'];
        $url .= '&id_ta=' . $post['id_ta'];
        $url .= '&id_mapel=' . $post['id_mapel'];

        redirect($url);
    }

    public function daftar($id_kelas, $id_ta, $id_mapel) {
        $data['title'] = 'Daftar Nilai';
        $data['kelas'] = $this->Kelas_model->get_all();
        $data['tahun_ajaran'] = $this->db->order_by('tahun', 'DESC')->get('tahun_ajaran')->result();

        $data['id_kelas'] = $id_kelas;
        $data['id_ta'] = $id_ta;
        $data['id_mapel'] = $id_mapel;

        $mapel_list = $this->Mapel_model->get_mapel_enrolled_by_kelas_ta($id_kelas, $id_ta);
        $mapel_terpilih = null;
        foreach ($mapel_list as $m) {
            if ($m['id_mapel'] == $id_mapel) {
                $mapel_terpilih = new stdClass();
                $mapel_terpilih->id_mapel = $m['id_mapel'];
                $mapel_terpilih->nama_mapel = $m['nama_mapel'];
                $mapel_terpilih->komponen = $m['komponen'];
                
                $kelas_mapel = $this->db->get_where('kelas_mapel', [
                    'id_kelas' => $id_kelas,
                    'id_mapel' => $id_mapel
                ])->row();

                if ($kelas_mapel) {
                    $mapel_terpilih->id_kelas_mapel = $kelas_mapel->id_kelas_mapel;
                } else {
                    $this->db->insert('kelas_mapel', [
                        'id_kelas' => $id_kelas,
                        'id_mapel' => $id_mapel
                    ]);
                    $mapel_terpilih->id_kelas_mapel = $this->db->insert_id();
                }

                break;
            }
        }

        $data['mapel_terpilih'] = $mapel_terpilih;

         $data['nilai_terisi'] = $this->Nilai_model->get_nilai_by_kelas_ta_mapel($id_kelas, $id_ta, $id_mapel);

        $this->template->load('template', 'nilai/daftar', $data);
    }

    public function update(){
        $post = $this->input->post();
        $id_nilai = $post['id_nilai'];
        $skor = $post['skor'];
        $id_guru = $this->session->userdata('id_guru');

        if (!$id_guru && $this->session->userdata('role') !== 'admin') {
            $this->set_flash('Akses ditolak.', 'error');
            redirect('nilai');
            
        }
        $result = $this->Nilai_model->update_nilai($id_nilai, $skor, $id_guru);
    }
    public function update_multiple() {
        $id_enroll = $this->input->post('id_enroll');
        $id_kelas_mapel = $this->input->post('id_kelas_mapel');
        $nilai = $this->input->post('nilai');
        $id_guru = $this->session->userdata('id_guru');

        if (!$id_guru && $this->session->userdata('role') !== 'admin') {
            $this->session->set_flashdata('error', 'Akses ditolak');
            redirect('nilai');
        }

        $result = $this->Nilai_model->update_multiple_nilai($id_enroll, $id_kelas_mapel, $nilai, $id_guru);

        if ($result['success']) {
            $this->session->set_flashdata('success', 'Nilai berhasil diperbarui');
        } else {
            $this->session->set_flashdata('error', $result['error']);
        }
        
        // Redirect ke halaman sebelumnya (daftar nilai)
        $kelas_mapel = $this->db->get_where('kelas_mapel', ['id_kelas_mapel' => $id_kelas_mapel])->row();
        $enroll = $this->db->get_where('enroll', ['id_enroll' => $id_enroll])->row();

        redirect('nilai/daftar/'.$enroll->id_kelas.'/'.$enroll->id_ta.'/'.$kelas_mapel->id_mapel);
    }
    public function exportExcel($id_kelas, $id_ta, $id_mapel){
        // Nonaktifkan error reporting dan semua output
        error_reporting(0);
        @ini_set('display_errors', 0);
        
        // Start output buffering dengan level maksimal
        while (ob_get_level()) {
            ob_end_clean();
        }
        ob_start();
        
        $siswa = $this->Enroll_model->get_siswa_by_kelas($id_kelas, $id_ta);
        $mapel_list = $this->Mapel_model->get_mapel_enrolled_by_kelas_ta($id_kelas, $id_ta);
        $mapel_terpilih = null;
        foreach ($mapel_list ?? [] as $m) {
            if ($m['id_mapel'] == $id_mapel) {
                $mapel_terpilih = new stdClass();
                $mapel_terpilih->id_mapel = $m['id_mapel'];
                $mapel_terpilih->nama_mapel = $m['nama_mapel'];
                $mapel_terpilih->id_guru = $m['id_guru'];
                $mapel_terpilih->komponen = $m['komponen'];

                $kelas_mapel = $this->db->get_where('kelas_mapel', [
                    'id_kelas' => $id_kelas,
                    'id_mapel' => $id_mapel
                ])->row();

                if ($kelas_mapel) {
                    $mapel_terpilih->id_kelas_mapel = $kelas_mapel->id_kelas_mapel;
                } else {
                    $this->db->insert('kelas_mapel', [
                        'id_kelas' => $id_kelas,
                        'id_mapel' => $id_mapel
                    ]);
                    $mapel_terpilih->id_kelas_mapel = $this->db->insert_id();
                }
                break;
            }
        }

        // Validasi data
        if (!$mapel_terpilih || empty($mapel_terpilih->komponen)) {
            ob_end_clean();
            $this->session->set_flashdata('error', 'Data mapel tidak ditemukan atau tidak memiliki komponen.');
            redirect('nilai');
        }

        // Ambil semua nilai dari database
        $nilai_db = $this->Nilai_model->get_nilai_by_kelas_ta_mapel($id_kelas, $id_ta, $id_mapel);
        $nilai_map = [];
        foreach ($nilai_db as $n) {
            $nilai_map[$n->id_enroll][$n->id_komponen] = $n->skor;
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // HEADER Kolom
        $sheet->setCellValue('A1', 'Template Nilai Mata Pelajaran '.$mapel_terpilih->nama_mapel);
        $sheet->mergeCells('A1:C1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle('A1')->getFill()->setFillType(Fill::FILL_SOLID);
        $sheet->getStyle('A1')->getFill()->getStartColor()->setARGB('FF4472C4');
        $sheet->getStyle('A1')->getFont()->getColor()->setARGB('FFFFFFFF');
        $sheet->getRowDimension(1)->setRowHeight(25);

        $sheet->setCellValue('A2', 'Kelas: '.$this->Kelas_model->get_nama($id_kelas));
        $sheet->mergeCells('A2:C2');
        $sheet->getStyle('A2')->getFont()->setBold(true)->setSize(12);
        $sheet->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A2')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle('A2')->getFill()->setFillType(Fill::FILL_SOLID);
        $sheet->getStyle('A2')->getFill()->getStartColor()->setARGB('FFD9E1F2');
        $sheet->getRowDimension(2)->setRowHeight(20);

        // Header baris 3
        $sheet->setCellValue('A3', 'No');
        $sheet->getColumnDimension('A')->setWidth(8);
        $sheet->setCellValue('B3', 'ID Enroll');
        $sheet->getColumnDimension('B')->setWidth(12);
        $sheet->setCellValue('C3', 'Nama Siswa');
        $sheet->getColumnDimension('C')->setWidth(40);
        
        // ID Temp di D2 dan E2
        $sheet->setCellValue('D2', 'ID Temp');
        $sheet->setCellValue('E2', $mapel_terpilih->id_kelas_mapel);
        $sheet->getStyle('D2')->getFont()->setBold(true);
        $sheet->getStyle('E2')->getFont()->setBold(true);
        $sheet->getStyle('D2:E2')->getFill()->setFillType(Fill::FILL_SOLID);
        $sheet->getStyle('D2:E2')->getFill()->getStartColor()->setARGB('FFFFC000');
        $sheet->getStyle('D2:E2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Header komponen mulai dari D3
        $col = 'D';
        $komponenCols = [];
        foreach ($mapel_terpilih->komponen as $komponen) {
            $sheet->setCellValue($col.'3', $komponen['nama_komponen']);
            $sheet->getColumnDimension($col)->setWidth(15);
            $komponenCols[$col] = $komponen['id_komponen'];
            $lastHeaderCol = $col; // Simpan kolom terakhir
            $col++;
        }

        // Styling header baris 3
        $headerRange = 'A3:' . $lastHeaderCol . '3';
        $sheet->getStyle($headerRange)->getFont()->setBold(true);
        $sheet->getStyle($headerRange)->getFill()->setFillType(Fill::FILL_SOLID);
        $sheet->getStyle($headerRange)->getFill()->getStartColor()->setARGB('FF4472C4');
        $sheet->getStyle($headerRange)->getFont()->getColor()->setARGB('FFFFFFFF');
        $sheet->getStyle($headerRange)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle($headerRange)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getRowDimension(3)->setRowHeight(20);

        // Border untuk header
        $borderStyle = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ];
        $sheet->getStyle($headerRange)->applyFromArray($borderStyle);
        $sheet->getStyle('A1:C2')->applyFromArray($borderStyle);
        $sheet->getStyle('D2:E2')->applyFromArray($borderStyle);

        // DATA siswa 
        $row = 4;
        $no = 1;
        foreach ($siswa as $s) {
            $sheet->setCellValue('A'.$row, strval($no));
            $sheet->setCellValue('B'.$row, $s->id_enroll);
            $sheet->setCellValue('C'.$row, $s->nama);
            
            // Isi nilai dari database jika ada
            foreach ($komponenCols as $col => $id_komponen) {
                if (isset($nilai_map[$s->id_enroll][$id_komponen])) {
                    $sheet->setCellValue($col.$row, $nilai_map[$s->id_enroll][$id_komponen]);
                }
            }
            
            // Border untuk setiap baris data (termasuk kolom nilai yang kosong)
            $dataRowRange = 'A'.$row.':' . $lastHeaderCol . $row;
            $sheet->getStyle($dataRowRange)->applyFromArray($borderStyle);
            
            // Alternating row colors
            if ($no % 2 == 0) {
                $sheet->getStyle($dataRowRange)->getFill()->setFillType(Fill::FILL_SOLID);
                $sheet->getStyle($dataRowRange)->getFill()->getStartColor()->setARGB('FFF2F2F2');
            }
            
            // Alignment
            $sheet->getStyle('A'.$row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('B'.$row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('C'.$row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            
            // Alignment untuk kolom nilai
            foreach ($komponenCols as $col => $id_komponen) {
                $sheet->getStyle($col.$row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            }
            
            $row++;
            $no++;
        }

        // Freeze panes untuk memudahkan scroll
        $sheet->freezePane('D4');
        
        // DOWNLOAD - Simpan ke temporary file dulu, lalu baca dan kirim
        // Bersihkan semua output buffer dengan agresif
        @ob_end_clean();
        @ob_end_flush();
        while (@ob_get_level()) {
            @ob_end_clean();
        }
        flush();
        
        $namakelas = $this->Kelas_model->get_nama($id_kelas);
        $namamapel = $this->Mapel_model->get_nama($id_mapel);
        
        // Sanitize filename untuk menghindari karakter khusus
        $namakelas = preg_replace('/[^a-zA-Z0-9_-]/', '_', $namakelas);
        $namamapel = preg_replace('/[^a-zA-Z0-9_-]/', '_', $namamapel);
        $filename = "Nilai_Kelas_{$namakelas}_Mapel_{$namamapel}.xlsx";
        
        // Check jika headers sudah terkirim - ini bisa jadi masalah di hosting
        if (headers_sent($file, $line)) {
            // Jika headers sudah terkirim, output error dan exit
            die("Cannot send file: headers already sent in {$file} on line {$line}. Please check for whitespace or output before this line.");
        }
        
        $temp_file = null;
        try {
            // Set headers dengan encoding yang benar SEBELUM membuat file
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header("Content-Disposition: attachment; filename=\"{$filename}\"");
            header('Content-Transfer-Encoding: binary');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');
            header('Expires: 0');
            
            // Coba simpan ke temporary file dulu
            $writable_path = defined('WRITEPATH') ? WRITEPATH . 'cache/' : sys_get_temp_dir() . '/';
            if (!is_writable($writable_path)) {
                $writable_path = sys_get_temp_dir() . '/';
            }
            
            $use_temp_file = is_writable($writable_path);
            
            if ($use_temp_file) {
                // Metode 1: Simpan ke temporary file, lalu baca
                $temp_file = $writable_path . uniqid('excel_') . '.xlsx';
                $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
                $writer->save($temp_file);
                
                header('Content-Length: ' . filesize($temp_file));
                readfile($temp_file);
                
                // Hapus temporary file
                @unlink($temp_file);
            } else {
                // Metode 2: Langsung output (fallback jika tidak bisa write file)
                $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
                $writer->save('php://output');
            }
            
            exit;
            
        } catch (Exception $e) {
            // Jika error, bersihkan dan redirect
            if ($temp_file && file_exists($temp_file)) {
                @unlink($temp_file);
            }
            $this->session->set_flashdata('error', 'Gagal membuat file Excel: ' . $e->getMessage());
            redirect('nilai');
        }
    }
    public function importExcel(){
        // Start output buffering untuk mencegah header sudah terkirim
        ob_start();
        
        if (empty($_FILES['file_excel']['tmp_name'])) {
            ob_end_clean();
            $this->set_flash('Silakan pilih file Excel terlebih dahulu.', 'error');
            redirect($_SERVER['HTTP_REFERER']);
        }

        $this->load->library('Spreadsheet_loader');

        $file_tmp = $_FILES['file_excel']['tmp_name'];
        $ext = pathinfo($_FILES['file_excel']['name'], PATHINFO_EXTENSION);

        if (!in_array(strtolower($ext), ['xlsx', 'xls'])) {
            ob_end_clean();
            $this->set_flash('Format file tidak didukung. Gunakan .xlsx atau .xls', 'error');
            redirect($_SERVER['HTTP_REFERER']);
        }

        // Set error handler untuk menekan warning dari PhpSpreadsheet
        set_error_handler(function($errno, $errstr, $errfile, $errline) {
            // Hanya suppress warning terkait DefaultValueBinder
            if (strpos($errfile, 'DefaultValueBinder.php') !== false && 
                strpos($errstr, 'Trying to access array offset') !== false) {
                return true; // Suppress error ini
            }
            return false; // Biarkan error lain tetap ditampilkan
        }, E_WARNING);
        
        try {
            if ($ext == 'xlsx') {
                $spreadsheet = $this->spreadsheet_loader->loadXlsx($file_tmp);
            } else {
                $spreadsheet = $this->spreadsheet_loader->loadXls($file_tmp);
            }
        } catch (Exception $e) {
            restore_error_handler();
            ob_end_clean();
            $this->set_flash('File Excel rusak atau tidak valid.', 'error');
            redirect($_SERVER['HTTP_REFERER']);
        }
        
        // Restore error handler setelah load berhasil
        restore_error_handler();
        
        try {
            $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
            
            // Ambil ID kelas mapel dari E2
            $id_kelas_mapel = isset($sheetData[2]['E']) ? trim($sheetData[2]['E']) : null;
            if (empty($id_kelas_mapel) || !is_numeric($id_kelas_mapel)) {
                ob_end_clean();
                $this->set_flash('File Excel tidak valid. Pastikan kolom E2 berisi ID kelas mapel.', 'error');
                redirect($_SERVER['HTTP_REFERER']);
            }
            $id_kelas_mapel = (int) $id_kelas_mapel;
            
            // Hapus data lama berdasarkan id_kelas_mapel
            $this->db->where('id_kelas_mapel', $id_kelas_mapel);
            $this->db->delete('nilai');
            
            // Ambil header komponen dari baris 3
            $headerRow = isset($sheetData[3]) ? $sheetData[3] : [];
            $komponenCols = [];
            $colIndex = 'D';
            while (isset($headerRow[$colIndex]) && !empty(trim($headerRow[$colIndex]))) {
                $komponenName = trim($headerRow[$colIndex]);
                // Cari ID komponen berdasarkan nama
                $komponen = $this->db->get_where('mapel_komponen', ['nama_komponen' => $komponenName])->row();
                if ($komponen) {
                    $komponenCols[$colIndex] = $komponen->id_komponen;
                }
                $colIndex++;
            }
            
            // Import data mulai dari baris 4
            $countSuccess = 0;
            $countFailed = 0;
            $id_guru = $this->session->userdata('id_guru');
            if (!$id_guru && $this->session->userdata('role') === 'admin') {
                $id_guru = null;
            }
            
            foreach ($sheetData as $rowNum => $row) {
                // Skip header rows (1, 2, 3)
                if ($rowNum <= 3) continue;
                
                // Ambil ID enroll dari kolom B
                $id_enroll = isset($row['B']) ? trim($row['B']) : null;
                if (empty($id_enroll) || !is_numeric($id_enroll)) {
                    continue; // Skip baris tanpa ID enroll valid
                }
                $id_enroll = (int) $id_enroll;
                
                // Verifikasi ID enroll ada di database
                $enroll = $this->db->get_where('enroll', ['id_enroll' => $id_enroll])->row();
                if (!$enroll) {
                    $countFailed++;
                    continue;
                }
                
                // Import nilai untuk setiap komponen
                foreach ($komponenCols as $col => $id_komponen) {
                    $nilai = isset($row[$col]) ? trim($row[$col]) : '';
                    if ($nilai !== '' && is_numeric($nilai)) {
                        $nilai = (float) $nilai;
                        
                        // Simpan atau update nilai
                        $this->Nilai_model->save_nilai([
                            'id_enroll' => $id_enroll,
                            'id_kelas_mapel' => $id_kelas_mapel,
                            'id_komponen' => $id_komponen,
                            'skor' => $nilai,
                            'id_guru' => $id_guru
                        ]);
                        $countSuccess++;
                    }
                }
            }
            
            // Clean output buffer sebelum redirect
            ob_end_clean();
            
            $message = "Import selesai. Berhasil mengimpor {$countSuccess} nilai.";
            if ($countFailed > 0) {
                $message .= " {$countFailed} baris gagal.";
            }
            $this->set_flash($message, 'success');
            
        } catch (Exception $e) {
            ob_end_clean();
            $this->set_flash('Gagal membaca data Excel: ' . $e->getMessage(), 'error');
        }
        
        redirect($_SERVER['HTTP_REFERER']);

    }
}

