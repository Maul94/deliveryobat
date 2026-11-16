<?php
defined('BASEPATH') or 	exit('No direct script access allowed');
class M_simpan extends CI_Model
{
	function tambahdata($data, $tabel)
	{
		$this->db->insert($tabel, $data);
		if ($this->db->affected_rows() > 0) {
			return $this->db->insert_id();;
		} else {
			return false;
		}
	}
	function updatedata($where, $data, $table)
	{
		$this->db->set($data);
		$this->db->where($where);
		$this->db->update($table);
		if ($this->db->affected_rows() > 0) {
			return TRUE;
		} else {
			return false;
		}
	}
	function deletedata($where, $table)
	{
		$this->db->where($where);
		$this->db->delete($table);
		if ($this->db->affected_rows() > 0) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	function queryselect($select)
	{
		return $this->db->query($select);
	}
}
