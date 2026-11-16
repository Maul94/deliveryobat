<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_login extends CI_Model {

	/* Models Patient */
	function get_px($where) {
		$this->db->select("*");
		$this->db->from("tb_patient");
		$this->db->where($where);
		$this->db->where('px_active', 1);
		$this->db->limit(1);

		$query = $this->db->get();

		return $query;
	}

	function add_px($data) {
		return $this->db->insert('tb_patient', $data);
	}

	/* Models User */
	function get_usr($where) {
		$this->db->select("*");
		$this->db->from("ms_user");
		$this->db->where($where);
		$this->db->where('status', 1);
		$this->db->limit(1);

		$query = $this->db->get();

		return $query;
	}
	
	
	function get_module($where) { 
	    
	    $this->db->select("module.`module_name`, module.`link`, module.`icon`");
	    $this->db->from("ms_user");
	    $this->db->join('role_module', 'role_module.role_id = ms_user.usr_role', 'left');
	    $this->db->join('module', 'module.id_module = role_module.module_id', 'left');
	    $this->db->where($where);
		$this->db->where('module.status', 1);
		$this->db->order_by('module.ordinal', 'ASC');

        // $this->db->query("SELECT m.`module_name`, m.`link`, m.`icon` FROM `ms_user` u 
        //     LEFT JOIN `role_module`rm ON u.`usr_role` = rm.`role_id`
        //     LEFT JOIN `module` m ON m.`id_module` = rm.`module_id`
        //     WHERE u.`usr_name` = 'admin1'
        //     ORDER BY m.`ordinal` ASC");

		$query = $this->db->get();

		return $query;
	}
}