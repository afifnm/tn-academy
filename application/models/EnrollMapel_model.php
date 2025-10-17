<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class EnrollMapel_model extends CI_Model {

    public function get_by_id($id) {
        $this->db->select('
            em.*,
            m.nama_mapel,
            k.nama_kelas,
            ta.tahun,
            ta.semester
        ');
        $this->db->from('enroll_mapel em');
        $this->db->join('mapel m', 'm.id_mapel = em.id_mapel');
        $this->db->join('kelas k', 'k.id_kelas = em.id_kelas');
        $this->db->join('tahun_ajaran ta', 'ta.id_ta = em.id_ta');
        $this->db->where('em.id_enroll_mapel', $id);
        return $this->db->get()->row_array();
    }

    public function get_kelas() {
        return $this->db->get('kelas')->result_array();
    }

    public function get_tahun_ajaran() {
        $this->db->order_by('tahun', 'DESC');
        $this->db->order_by('semester', 'DESC');
        return $this->db->get('tahun_ajaran')->result_array();
    }

    public function get_all_mapel() {
        return $this->db->get('mapel')->result_array();
    }

    public function get_enrolled($id_ta = null, $id_kelas = null) {
        $this->db->select('
            em.id_enroll_mapel,
            em.id_mapel,
            em.id_kelas,
            em.id_ta,
            em.id_guru,
            em.id_komponen,
            DATE(em.created_at) AS tanggal_enroll,
            m.nama_mapel,
            k.nama_kelas,
            ta.tahun,
            ta.semester,
            g.nama_guru AS nama_pengajar,
            mk.nama_komponen AS nama_komponen
        ');
        $this->db->from('enroll_mapel em');
        $this->db->join('mapel m', 'm.id_mapel = em.id_mapel');
        $this->db->join('kelas k', 'k.id_kelas = em.id_kelas');
        $this->db->join('tahun_ajaran ta', 'ta.id_ta = em.id_ta');
        $this->db->join('guru g', 'g.id_guru = em.id_guru', 'left');
        $this->db->join('mapel_komponen mk', 'mk.id_komponen = em.id_komponen', 'left');

        if ($id_ta) $this->db->where('em.id_ta', $id_ta);
        if ($id_kelas) $this->db->where('em.id_kelas', $id_kelas);

        $this->db->order_by('em.id_enroll_mapel', 'DESC');
        return $this->db->get()->result_array();
    }

    public function get_not_enrolled($id_ta = null, $id_kelas = null) {
        $this->db->select('m.*');
        $this->db->from('mapel m');

        if ($id_ta !== null && $id_kelas !== null) {
            $this->db->where("NOT EXISTS (
                SELECT 1 FROM enroll_mapel em
                WHERE em.id_mapel = m.id_mapel
                AND em.id_ta = " . $this->db->escape($id_ta) . "
                AND em.id_kelas = " . $this->db->escape($id_kelas) . "
            )", null, false);
        }

        return $this->db->get()->result_array();
    }

    public function add($data) {
        $this->db->where('id_mapel', $data['id_mapel']);
        $this->db->where('id_kelas', $data['id_kelas']);
        $this->db->where('id_ta', $data['id_ta']);
        if (isset($data['id_komponen'])) {
            $this->db->where('id_komponen', $data['id_komponen']);
        } else {
            $this->db->where('id_komponen IS NULL', null, false);
        }
        if ($this->db->get('enroll_mapel')->row()) {
            return false;
        }

        $this->db->insert('enroll_mapel', $data);
        return $this->db->insert_id();
        return true;
    }

    // Ambil semua komponen yang terkait dengan enroll_mapel ini
    public function get_komponen_by_enroll($id_enroll_mapel) {
        $this->db->select('ek.id_komponen');
        $this->db->from('enroll_mapel_komponen ek');
        $this->db->where('ek.id_enroll_mapel', $id_enroll_mapel);
        $query = $this->db->get();
        return array_column($query->result_array(), 'id_komponen');
    }

    // Simpan relasi banyak ke banyak
    public function save_komponen($id_enroll_mapel, $komponen_ids = []) {
        // Hapus dulu yang lama
        $this->db->delete('enroll_mapel_komponen', ['id_enroll_mapel' => $id_enroll_mapel]);

        // Simpan yang baru
        if (!empty($komponen_ids)) {
            $data = [];
            foreach ($komponen_ids as $id) {
                $data[] = [
                    'id_enroll_mapel' => $id_enroll_mapel,
                    'id_komponen'     => $id
                ];
            }
            $this->db->insert_batch('enroll_mapel_komponen', $data);
        }
    }
    
    public function update($id, $data) {
        $this->db->where('id_enroll_mapel', $id);
        return $this->db->update('enroll_mapel', $data);
    }

    public function delete($id) {
        $this->db->delete('enroll_mapel', ['id_enroll_mapel' => $id]);
    }
   
}
