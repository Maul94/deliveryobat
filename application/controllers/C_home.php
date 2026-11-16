<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/core/BaseController.php';

class C_home extends BaseController {
	function __construct() {
		parent:: __construct();
		$this->load->helper('url_helper');
		// $this->load->model('M_user');
	}

	function index() {
        $this->load->view('under_construction');
	}

	function gotonewdomain() {
        $this->load->view('redirect_page');
	}
}