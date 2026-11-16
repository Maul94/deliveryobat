<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_user extends CI_Model
{
	function getUser($id_user = null)
	{
		$where = '';
		$params = array();
		if ($id_user !== null) {
			$where = " where mu.id_user = ?";
			$params[] = (int) $id_user;
		}
		$sql = "SELECT mu.id_user, mu.usr_fullname, mu.usr_name, mu.usr_role, mu.status, ra.role_name, ra.id_role
		FROM ms_user mu
		left join role_access ra on ra.id_role = mu.usr_role
		$where
		order by mu.status desc, mu.usr_fullname asc";

		if ($id_user !== null) {
			return $this->db->query($sql, $params)->row();
		} else {
			return $this->db->query($sql)->result();
		}
	}

	function getRoleList()
	{
		$sql = "SELECT * FROM role_access where status = 1";
		return $this->db->query($sql)->result();
	}
}
