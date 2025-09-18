<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('pagination')) {
    function pagination($base_url, $total_rows, $per_page = 10, $uri_segment = 3)
    {
        $CI =& get_instance();
        $CI->load->library('pagination');

        $config['base_url'] = $base_url;
        $config['total_rows'] = $total_rows;
        $config['per_page'] = $per_page;
        $config['uri_segment'] = $uri_segment;

        // Midone/Tailwind style
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';

        $config['first_link'] = '<i class="w-4 h-4" data-lucide="chevrons-left"></i>';
        $config['first_tag_open'] = '<li class="page-item"><a class="page-link" href="#">';
        $config['first_tag_close'] = '</a></li>';

        $config['last_link'] = '<i class="w-4 h-4" data-lucide="chevrons-right"></i>';
        $config['last_tag_open'] = '<li class="page-item"><a class="page-link" href="#">';
        $config['last_tag_close'] = '</a></li>';

        $config['next_link'] = '<i class="w-4 h-4" data-lucide="chevron-right"></i>';
        $config['next_tag_open'] = '<li class="page-item"><a class="page-link" href="#">';
        $config['next_tag_close'] = '</a></li>';

        $config['prev_link'] = '<i class="w-4 h-4" data-lucide="chevron-left"></i>';
        $config['prev_tag_open'] = '<li class="page-item"><a class="page-link" href="#">';
        $config['prev_tag_close'] = '</a></li>';

        $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="#">';
        $config['cur_tag_close'] = '</a></li>';

        $config['num_tag_open'] = '<li class="page-item"><a class="page-link" href="#">';
        $config['num_tag_close'] = '</a></li>';

        $CI->pagination->initialize($config);

        return $CI->pagination->create_links();
    }
}
