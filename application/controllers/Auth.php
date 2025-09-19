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
            $this->set_flash('error','Username tidak ditemukan');
            redirect('auth');
        } else if ($user->password==$password){
            $data = array (
                'id_user'       =>$user->id_user,
                'username'      =>$user->username,
                'name'          =>$user->name,
                'role'         =>$user->role,               
            );
            $this -> session->set_userdata($data);
            redirect('home');
        }else {
            $this->set_flash('error','Password salah');
            redirect('auth');
        }

    }

    public function regist(){
        $this->load->view('regist');
    }

    public function signup()
	{
        $this->only_post_allowed();
		$this->db->from('users')->where('username',$this->input->post('username'));
		$cek = $this->db->get()->result_array();

		if($cek != null){
			$this->set_flash('error','Username sudah digunakan');
			redirect('auth/regist');
		}
		$data = array(
			'username'	=>$this->input->post('username'),
			'password'	=> md5($this->input->post('password')),
			'name'	=>$this->input->post('name'),
			'role'	=>'guru',
		);

		$this->db->insert('users',$data);
		$this->set_flash('success','Akun berhasil dibuat, silahkan login');
		redirect('auth/login');

	}

    public function logout(){
        $this->session->sess_destroy();
        redirect('auth');
    }
}