<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class MY_Controller extends CI_Controller {
    public function __construct() {
        parent::__construct();
        // $this->load->model('Func_model');
        // $this->load->helper('cookie');
        // $this->load->library('encryption');
        date_default_timezone_set("Asia/Jakarta");
        // $this->load->vars([
        //     'role' => $this->session->userdata('level'),
        // ]);
        // if ($this->session->userdata('login') !== "Backend") {
        //     redirect('auth');
        // }
    }
    public function set_flash($type, $message) {
        $this->session->set_flashdata($type, $message);
    }

    
    protected function only_post_allowed() {
        if (!$this->input->post()) {
            redirect($_SERVER['HTTP_REFERER'] ?? base_url());
        }
    }
}