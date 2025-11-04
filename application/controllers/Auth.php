<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends MY_Controller {

    public function index(){
        $this->load->view('login');
    }

    public function login(){
        $username = $this->input->post('username');
        $password = md5($this->input->post('password'));

        $this->db->from('users')->where('username',$username);
        $user = $this->db->get()->row();

        if ($user == NULL){
            $this->set_flash('Username tidak ditemukan','error');
            redirect('auth');
        } else if ($user->password==$password){
            // Ambil id_guru jika role = guru
            $id_guru = null;
            if ($user->role === 'guru') {
                // Ambil id_guru dari tabel guru berdasarkan id_user
                $guru = $this->db->get_where('guru', ['id_user' => $user->id_user])->row();
                if ($guru) {
                    $id_guru = $guru->id_guru;
                }
            }

            $data = array (
                'id_user'       => $user->id_user,
                'username'      => $user->username,
                'nama'          => $user->nama,
                'role'          => $user->role,
                'id_guru'       => $id_guru
            );
            $this->session->set_userdata($data);
            redirect('home');
        } else {
            $this->set_flash('Password Salah','error');
            redirect('auth');
        }
    }

    public function logout(){
        $this->session->sess_destroy();
        redirect('auth');
    }
}