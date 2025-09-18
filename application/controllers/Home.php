<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
	public function index()
	{
		$data = array (
			'title' => 'Dashboard'
		);
		$this->template->load('template','home',$data);
	}
}
