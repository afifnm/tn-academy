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
            $this->db->from('guru')->where('nip',$username);
            $guru = $this->db->get()->row();
            if($guru==NULL){
                $this->set_flash('Username tidak ditemukan','error');
                redirect('auth');
            } else if ($guru->password==$this->input->post('password')){
                $data = array (
                    'id_user'       => $guru->id_guru,
                    'username'      => $guru->nip,
                    'nama'          => $guru->nama_guru,
                    'role'          => 'guru'
                );
                $this->session->set_userdata($data);
                redirect('home');
            } else {
                $this->set_flash('Password Salah','error');
                redirect('auth');
            }
        } else if ($user->password==$password){
            $data = array (
                'id_user'       => $user->id_user,
                'username'      => $user->username,
                'nama'          => $user->nama,
                'role'          => $user->role
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