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

    protected function paginate($table, $order_by = null, $where = [], $limit_param = 'limit', $uri_segment = 3)
    {
        $limit = $this->input->get($limit_param) ?? 10;
        $offset = $this->uri->segment($uri_segment, 0);

        // Hitung total data
        $this->db->from($table);
        if (!empty($where)) $this->db->where($where);
        $total = $this->db->count_all_results();

        // Ambil data paged
        $this->db->from($table);
        if (!empty($where)) $this->db->where($where);
        if ($order_by) $this->db->order_by($order_by);
        $this->db->limit($limit, $offset);
        $data = $this->db->get()->result_array();

        // Pagination links
        $pagination = pagination(base_url($this->router->fetch_class().'/'.$this->router->fetch_method()), $total, $limit, $uri_segment);

        return [
            'data' => $data,
            'pagination' => $pagination,
            'limit' => $limit,
            'total' => $total,
            'offset' => $offset, 

        ];
    }
}