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

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // HEADER Kolom
        $sheet->setCellValue('A1', 'Template Nilai Mata Pelajaran '.$mapel_terpilih->nama_mapel);
        $sheet->mergeCells('A1:C1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->setCellValue('A2', 'Kelas: '.$this->Kelas_model->get_nama($id_kelas));
        $sheet->mergeCells('A2:C2');
        $sheet->getStyle('A2')->getFont()->setBold(true)->setSize(12);
        $sheet->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->setCellValue('A3', 'No');
        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->setCellValue('B3', 'ID Enroll');
        $sheet->getColumnDimension('B')->setWidth(10);
        $sheet->setCellValue('C3', 'Nama');
        $sheet->getColumnDimension('C')->setWidth(50);
        $sheet->setCellValue('D2', 'ID Temp');
        $sheet->getColumnDimension('D')->setWidth(10);
        $sheet->setCellValue('E2', $kelas_mapel->id_kelas_mapel);
        $sheet->getColumnDimension('D')->setWidth(10);
        $col = 'D';
        foreach ($mapel_terpilih->komponen as $komponen) {
            $sheet->setCellValue($col.'3', $komponen['nama_komponen']);
            $col++;
        }

        // DATA siswa 
        $row = 4;
        $no =1;
        foreach ($siswa as $s) {
            $sheet->setCellValue('A'.$row, strval($no));
            $sheet->setCellValue('B'.$row, $s->id_enroll);
            $sheet->setCellValue('C'.$row, $s->nama);
            $row++;
            $no++;
        }
        
        // DOWNLOAD
        $namakelas = $this->Kelas_model->get_nama($id_kelas);
        $namamapel = $this->Mapel_model->get_nama($id_mapel);
        $filename = "Nilai_Kelas_{$namakelas}_Mapel_{$namamapel}.xlsx";
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment; filename={$filename}");
        header('Cache-Control: max-age=0');

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }
    public function importExcel()
{
    $this->load->library('upload');
    $this->load->library('PHPExcel');

    // Validasi guru / admin
    $role = $this->session->userdata('role');
    $id_guru = $this->session->userdata('id_guru');

    if (!$id_guru && $role !== 'admin') {
        echo json_encode(['status' => false, 'message' => 'Akses ditolak']);
        return;
    }

    // Upload file
    $config['upload_path'] = './uploads/excel/';
    $config['allowed_types'] = 'xls|xlsx';
    $config['encrypt_name'] = TRUE;

    if (!is_dir($config['upload_path'])) {
        mkdir($config['upload_path'], 0777, true);
    }

    $this->upload->initialize($config);

    if (!$this->upload->do_upload('file_excel')) {
        echo json_encode(['status' => false, 'message' => $this->upload->display_errors()]);
        return;
    }

    $file = $this->upload->data('full_path');

    // Load Excel
    $excel = PHPExcel_IOFactory::load($file);
    $sheet = $excel->getActiveSheet();
    $data = $sheet->toArray(null, true, true, true);

    /**
     * =========================================
     * TEMPLATE:
     * A1 = No
     * B1 = Nama
     * C1,D1,E1,... = Nama Komponen
     * =========================================
     */

    // Ambil ID dari GET (modal berada di halaman nilai)
    $id_kelas = $this->input->get('id_kelas');
    $id_ta    = $this->input->get('id_ta');
    $id_mapel = $this->input->get('id_mapel');

    // Pastikan kelas_mapel ada
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

    // Ambil komponen mapel
    $komponen = $this->db->get_where('komponen_mapel', [
        'id_kelas_mapel' => $id_kelas_mapel
    ])->result_array();

    if (!$komponen) {
        echo json_encode(['status' => false, 'message' => 'Tidak ada komponen mapel.']);
        return;
    }

    // Map kolom Excel ke id_komponen
    $colMap = [];
    $col = 'C';

    foreach ($komponen as $k) {
        $excelHeader = trim($data[1][$col]); // row 1
        if ($excelHeader == $k['nama_komponen']) {
            $colMap[$col] = $k['id_komponen'];
        }
        $col++;
    }

    // Ambil siswa kelas → untuk mapping nama => id_enroll
    $siswa = $this->db->select('enroll.id_enroll, siswa.nama')
                      ->from('enroll')
                      ->join('siswa', 'siswa.id_siswa=enroll.id_siswa')
                      ->where('enroll.id_kelas', $id_kelas)
                      ->get()->result();

    $mapNamaEnroll = [];
    foreach ($siswa as $s) {
        $mapNamaEnroll[trim(strtolower($s->nama))] = $s->id_enroll;
    }

    /**
     * =========================================
     * LOOP DATA EXCEL
     * =========================================
     */

    for ($row = 2; $row <= count($data); $row++) {
        $nama = trim(strtolower($data[$row]['B'])); 
        if ($nama == "") continue;

        if (!isset($mapNamaEnroll[$nama])) {
            continue; // abaikan siswa yg tidak cocok
        }

        $id_enroll = $mapNamaEnroll[$nama];

        // Loop kolom nilai
        foreach ($colMap as $col => $id_komponen) {
            $skor = floatval($data[$row][$col]);

            $this->Nilai_model->save_nilai([
                'id_enroll' => $id_enroll,
                'id_kelas_mapel' => $id_kelas_mapel,
                'id_komponen' => $id_komponen,
                'skor' => $skor,
                'id_guru' => $id_guru
            ]);
        }
    }

    echo json_encode(['status' => true, 'message' => 'Import berhasil']);
}


}

