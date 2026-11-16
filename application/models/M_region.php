<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_region extends CI_Model {

	function get_City($idProv) {
		$this->db->select('id_city as id, city_name as name');
		$this->db->from('ms_cities');
		$this->db->where('prov_id', $idProv);
		$this->db->order_by('city_name', 'ASC');

		$query = $this->db->get();

		return $query;
	}

	function get_Dis($idCity) {
		$this->db->select('id_dis as id, dis_name as name');
		$this->db->from('ms_districts');
		$this->db->where('city_id', $idCity);
		$this->db->order_by('dis_name', 'ASC');

		$query = $this->db->get();

		return $query;
	}

	function get_Subdis($idDis) {
		$this->db->select('id_subdis as id, subdis_name as name');
		$this->db->from('ms_subdistricts');
		$this->db->where('dis_id', $idDis);
		$this->db->order_by('subdis_name', 'ASC');

		$query = $this->db->get();

		return $query;
	}	
}