<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/core/BaseController.php';

class C_region extends BaseController {
	function __construct() {
		parent:: __construct();
		$this->load->helper('url_helper');
		$this->load->model('M_region');
	}

	function getCity($idProv) {
		if ($this->secure()) {
			$result = $this->M_region->get_City((int) $idProv);

			if ($result->num_rows() > 0) {
				$datajson = array(
					'status' => TRUE,
					'data' => $result->result_array()
				);
			}else{
				$datajson = array(
					'status' => FALSE,
				);
			}

			echo json_encode($datajson);
		}
	}

	function getDis($idCity) {
		if ($this->secure()) {
			$result = $this->M_region->get_Dis((int) $idCity);

			if ($result->num_rows() > 0) {
				$datajson = array(
					'status' => TRUE,
					'data' => $result->result_array()
				);
			}else{
				$datajson = array(
					'status' => FALSE,
				);
			}

			echo json_encode($datajson);
		}
	}

	function getSubdis($idDis) {
		if ($this->secure()) {
			$result = $this->M_region->get_Subdis((int) $idDis);

			if ($result->num_rows() > 0) {
				$datajson = array(
					'status' => TRUE,
					'data' => $result->result_array()
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