<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_dashboard extends CI_Model {

	public function numlist() {
		$this->db->where('delivery_type !=', 1);
		$this->db->where('status', 1);
		$this->db->where('delivery_date', date('Y-m-d'));
		$query = $this->db->get('delivery');

		return $query->num_rows();
	}


	function add_rating($dt) {

		$this->db->insert('tb_rating', $dt);

		if($this->db->affected_rows() > 0) {
			return $this->db->insert_id();
		}else{
		    return FALSE;
		}
	}

	function add_notif($ntf_for_patient, $ntf_title, $ntf_text, $ntf_detail, $ntf_status) {
		$dt = array(
			'ntf_for_patient' 	=> $ntf_for_patient,
			'ntf_title' 	=> $ntf_title,
			'ntf_text'		=> $ntf_text,
			'ntf_detail'	=> $ntf_detail,
			'ntf_status'	=> $ntf_status
		);

		$this->db->insert('tb_notif', $dt);

		if($this->db->affected_rows() > 0) {
			return $this->db->insert_id();
		}else{
		    return FALSE;
		}
	}

	function get_notif($px_id) {
		$this->db->select('*');
		$this->db->from('tb_notif');
		$this->db->where('ntf_for_patient', $px_id);
		$this->db->where('ntf_status', 1);
		$this->db->where('ntf_active', 1);
		$this->db->order_by('entrydate', 'DESC');

		$query = $this->db->get();

		return $query;
	}	
}