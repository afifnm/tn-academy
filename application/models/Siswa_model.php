<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Siswa_model extends CI_Model {

	public function get_all($thn_masuk = null)
	{
		if ($thn_masuk) {
			$this->db->where('thn_masuk', $thn_masuk);
		}
		$this->db->order_by('nama', 'ASC');
		return $this->db->get('siswa')->result_array();
	}


	public function get_by_id($id_siswa)
	{
	    return $this->db->get_where('siswa', ['id_siswa' => $id_siswa])->row_array();
		
	}

	public function get_by_thn_masuk($thn_masuk = null)
	{
		if ($thn_masuk) {
			$this->db->where('thn_masuk', $thn_masuk);
		}
		return $this->db->get('siswa')->result_array();
	}

	public function get_all_tahun_masuk()
	{
		$this->db->select('DISTINCT (thn_masuk) as thn_masuk', false);
		$this->db->order_by('thn_masuk', 'DESC');
		return $this->db->get('siswa')->result_array();
	}

	public function search($keyword) {
        $this->db->like('nama', $keyword);
        $this->db->or_like('nisn', $keyword);
        $query = $this->db->get('siswa');
        return $query->result();
    }

    public function add($foto = null)
	{
		$this->db->from('siswa')->where('nisn',$this->input->post('nisn'));
		$cek = $this->db->get()->row();
		$pekerjaan_ayah = $this->input->post('pekerjaan_ayah');
		if ($pekerjaan_ayah === 'Lainnya') {
			$pekerjaan_ayah = $this->input->post('pekerjaan_ayah_lain');
		}

		$pekerjaan_ibu = $this->input->post('pekerjaan_ibu');
		if ($pekerjaan_ibu === 'Lainnya') {
			$pekerjaan_ibu = $this->input->post('pekerjaan_ibu_lain');
		}

		if($cek != null){
        	return false;
		}
		$data = array(
			'nisn'          => $this->input->post('nisn'),
			'nis'           => $this->input->post('nis'),
			'nama'          => $this->input->post('nama'),
			'email'         => $this->input->post('email'),
			'jenis_kelamin' => $this->input->post('jenis_kelamin'),
			'agama'         => $this->input->post('agama'),
			'jalur_pendidikan' => $this->input->post('jalur_pendidikan'),
			'tempat_lahir'     => $this->input->post('tempat_lahir'),
			'tgl_lahir'     => date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('tgl_lahir')))),
			'thn_masuk'     => $this->input->post('thn_masuk'),
			'status'        => $this->input->post('status'),
			'nama_ayah'     => $this->input->post('nama_ayah'),
			'pekerjaan_ayah'=> $pekerjaan_ayah,
			'penghasilan_ayah' => $this->input->post('penghasilan_ayah'),
			'nama_ibu'      => $this->input->post('nama_ibu'),
			'pekerjaan_ibu' => $pekerjaan_ibu,
			'penghasilan_ibu' => $this->input->post('penghasilan_ibu'),
			'cita_cita'     => $this->input->post('cita_cita'),
			'nama_smp'      => $this->input->post('nama_smp'),
			'tinggi'        => $this->input->post('tinggi'),
			'berat_badan'         => $this->input->post('berat_badan'),
			'hobi'          => $this->input->post('hobi'),
			'nama_provinsi'      => $this->input->post('provinsi')
		);

		if ($foto!=null) {
			$data['foto'] = $foto;
		}

		$this->db->insert('siswa',$data);
        return true;
	}

    public function update()
	{
		$data = array(
            'nisn'	=>$this->input->post('nisn'),
			'nama'	=>$this->input->post('nama'),
            'tgl_lahir' => date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('tgl_lahir')))),
			'thn_masuk'	=>$this->input->post('thn_masuk'),
            'status'	=>$this->input->post('status'),
		);
		$this->db->where('id_siswa',$this->input->post('id_siswa'));
		$this->db->update('siswa',$data);
	}

	public function update_siswa($id_siswa)
	{
		$data = [
			'nisn' => $this->input->post('nisn'),
			'nis' => $this->input->post('nis'),
			'nama' => $this->input->post('nama'),
			'email' => $this->input->post('email'),
			'jenis_kelamin' => $this->input->post('jenis_kelamin'),
			'agama' => $this->input->post('agama'),
			'jalur_pendidikan' => $this->input->post('jalur_pendidikan'),
			'tempat_lahir' => $this->input->post('tempat_lahir'),
			'tgl_lahir' => $this->input->post('tgl_lahir'),
			'thn_masuk' => $this->input->post('thn_masuk'),
			'status' => $this->input->post('status'),
			'graha' => $this->input->post('graha'),
			'nama_provinsi' => $this->input->post('nama_provinsi'),
		];
		$this->db->where('id_siswa', $id_siswa);
		$this->db->update('siswa', $data);
	}

	public function update_ortu($id_siswa)
	{
		$data = [
			'nama_ayah' => $this->input->post('nama_ayah'),
			'pekerjaan_ayah' => $this->input->post('pekerjaan_ayah'),
			'penghasilan_ayah' => $this->input->post('penghasilan_ayah'),
			'nama_ibu' => $this->input->post('nama_ibu'),
			'pekerjaan_ibu' => $this->input->post('pekerjaan_ibu'),
			'penghasilan_ibu' => $this->input->post('penghasilan_ibu'),
		];
		$this->db->where('id_siswa', $id_siswa);
		$this->db->update('siswa', $data);
	}

	public function update_lain($id_siswa)
	{
		$data = [
			'cita_cita' => $this->input->post('cita_cita'),
			'nama_smp' => $this->input->post('nama_smp'),
			'tinggi' => $this->input->post('tinggi'),
			'berat_badan' => $this->input->post('berat_badan'),
			'hobi' => $this->input->post('hobi'),
		];

		// Handle upload foto
		if (!empty($_FILES['foto']['name'])) {
			$namafoto = date('YmdHis') . '.jpg';

			$config['upload_path']   = './assets/upload/foto_siswa/';
			$config['allowed_types'] = 'jpg|jpeg|png';
			$config['max_size']      = 500 * 1024; // 500KB
			$config['file_name']     = $namafoto;

			$CI =& get_instance();
			$CI->load->library('upload', $config);

			if ($_FILES['foto']['size'] >= 500 * 1024) {
				$CI->session->set_flashdata('error', 'Ukuran foto terlalu besar, maksimal 500 KB.');
				redirect('admin/siswa/detail/'.$id_siswa.'?tab=lain');
			} elseif (!$CI->upload->do_upload('foto')) {
				$CI->session->set_flashdata('error', 'Upload gagal: ' . $CI->upload->display_errors());
				redirect('admin/siswa/detail/'.$id_siswa.'?tab=lain');
			} else {
				$uploadData = $CI->upload->data();
				$data['foto'] = $uploadData['file_name'];
			}
		}

		$this->db->where('id_siswa', $id_siswa);
		$this->db->update('siswa', $data);
	}

    public function delete($id_siswa){
		$where = array('id_siswa'=>$id_siswa);
		$this->db->delete('siswa',$where);
	}
}