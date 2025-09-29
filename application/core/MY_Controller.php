<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class MY_Controller extends CI_Controller {
    public function __construct() {
        parent::__construct();
        date_default_timezone_set("Asia/Jakarta");
    }
    public function set_flash($message, $icon = 'success') {
        $this->session->set_flashdata('notifikasi', $message);
        $this->session->set_flashdata('icon', $icon);
    }
    protected function only_post_allowed() {
        if (!$this->input->post()) {
            redirect($_SERVER['HTTP_REFERER'] ?? base_url());
        }
    }

    protected function only_admin_allowed()
    {
        if ($this->session->userdata('role') !== 'admin') {
            $this->set_flash('error', 'Kamu bukan admin');
            redirect('auth');
            exit;
        }
    }

    protected function only_principal_allowed()
    {
        if ($this->session->userdata('role') !== 'kepala sekolah') {
            $this->set_flash('error', 'Kamu bukan kepala sekolah ');
            redirect('auth');
            exit;
        }
    }

    // protected function only_teacher_allowed()
    // {
    //     if ($this->session->userdata('role') !== 'admin') {
    //         $this->set_flash('error', 'Kamu bukan admin');
    //         redirect('auth');
    //         exit;
    //     }
    // }
}