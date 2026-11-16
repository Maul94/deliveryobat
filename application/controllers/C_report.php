<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/core/BaseController.php';

class C_report extends BaseController {
	function __construct() {
		parent:: __construct();
		$this->load->helper('url_helper');
		// $this->load->model('M_delivery');
		$this->load->model('M_simpan');
	}

	function index() {
		if ($this->secure()) {
			$headerInfo['pageTitle'] = 'Laporan';
			
			$this->load_views('report/report_index', $headerInfo);
		}
	}

	function print_report() {
		if ($this->secure()) {
			$query = "SELECT (@row:=@row+1) AS `nomor`, d.*, d.`total` as ongkir,
				CASE
					WHEN d.`delivery_type` = 1 THEN 'Selesai'
					WHEN d.`delivery_type` = 2 THEN 'Delivery'
					WHEN d.`delivery_type` = 3 THEN 'Proses'
					WHEN d.`delivery_type` = 0 THEN 'Batal'
				END status,
				CASE
					WHEN d.`delivery_type` = 1 THEN d.`total`
					WHEN d.`delivery_type` = 2 THEN 0
					WHEN d.`delivery_type` = 3 THEN 0
					WHEN d.`delivery_type` = 0 THEN 0
				END total
				FROM (SELECT @row :=0) AS no, delivery as d 
				WHERE d.`status` = 1
				AND d.`delivery_date` = '".$_POST['reportDate']."'
				ORDER BY FIELD(d.`delivery_type`, 1, 2, 3, 0)
				";
			$data['resultReport'] = $this->M_simpan->queryselect($query)->result();
			$data['dateReport'] = $this->bln_indo($_POST['reportDate']);
			$this->load->view('report/print_report', $data);
		}
	}
}