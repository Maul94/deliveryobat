<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/core/BaseController.php';
class C_dashboard extends BaseController {
	function __construct() {
		parent:: __construct();
		$this->load->helper('url_helper');
		$this->load->model('M_dashboard');
	}
	function index() {
		if ($this->secure()) {
			$headerInfo['pageTitle'] = 'dashboard';
			$headerInfo['numlist'] = $this->M_dashboard->numlist();
			$this->load_views('dashboard', $headerInfo);
		}
	}
	/* OLD */
	protected function get_notif() {
		if ($this->secure()) {
			if($this->session->userdata('s_role') == 2){
				$result = $this->M_dashboard->get_notif($this->session->userdata('s_id_px'));
				if ($result->num_rows() > 0) {
					$datajson = array(
						'status' => TRUE,
						'num_rows' => $result->num_rows(),
						'notifs' => $result->result_array()
					);
				}else{
					$datajson = array(
						'status' => FALSE,
					);
				}
				echo json_encode($datajson);
			}
		}
	}
	protected function give_rate($order_id) {
		if ($this->secure()) {
			$headerInfo = array(
				'pageTitle' => 'Beri Penilaian',
			);
			$data['order_id'] = $order_id;
			$this->load->view('give_rate', $data);
		}
	}
	protected function save_rate() {
		if ($this->secure()) {
			if ($_POST) {
				$dt = array(
					'order_id'		=> $_POST['order_id'],
					'rat_rating'	=> $_POST['rating'],
					'rat_comment'	=> $_POST['comment'],
				);
				$result = $this->M_dashboard->add_rating($dt);
				if ($result) {
					$datajson = array(
						'status' => TRUE,
						'message' => 'Terima Kasih!'
					);
				}else{
					$datajson = array(
						'status' => FALSE,
						'message' => 'Gagal simpan penilaian!'
					);
				}
				echo json_encode($datajson);
			}
		}
	}
}