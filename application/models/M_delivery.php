<?php
defined('BASEPATH') or exit('No direct script access allowed');
class M_delivery extends CI_Model
{
	function getKurir()
	{
		$sql = "SELECT id_user as kurir_id, usr_fullname as kurir_name FROM ms_user where usr_role = 3 AND status = 1";
		return $this->db->query($sql)->result();
	}
	function getDeliveryList($date = null, $deltype, $driver = null)
	{
		$and = "";
		if ($date == null) {
			$and .= " AND d.`delivery_date` = '" . date('Y-m-d') . "'";
		} else {
			$and .= " AND d.`delivery_date` = '" . $date . "'";
		}
		if ($deltype == 'semua') {
			$and .= "";
		} else {
			$and .= " AND d.`delivery_type` = '" . $deltype . "'";
		}
		if ($driver != null && $this->session->userdata('s_usr_role') != 1) {
			$and .= " AND d.kurir_id = $driver";
		}
		$sql = "SELECT (@row:=@row+1) AS `nomor`, d.*, mu.`id_user`, mu.`usr_fullname` 
				FROM (SELECT @row :=0) AS no, delivery d
				LEFT JOIN ms_user mu ON mu.`id_user` = d.`kurir_id` AND mu.`status` = 1
				WHERE d.`status` = 1 $and ORDER BY FIELD(d.`delivery_type`,2,3,1,0), d.`ordinary` = 0, d.`ordinary`";
		// $and ORDER BY FIELD(d.`delivery_type`,2,3,1,0), field(d.`ordinary`,1,2,3,4,5,6,7,8,9,10), FIELD(d.`status`,1,0)";
		return $this->db->query($sql)->result();
	}
	function getDelivery($delivery_id)
	{
		$sql = "SELECT d.*, mu.`id_user` as kurir_id, mu.`usr_fullname` as kurir_name, mp.`prov_name`, mc.`city_name`, md.`dis_name`, ms.`subdis_name`
			FROM delivery d
			LEFT JOIN ms_user mu ON mu.`id_user` = d.`kurir_id` AND mu.`status` = 1
			LEFT JOIN ms_provinces mp ON mp.`id_prov` = d.`prov_id` AND mp.`status` = 1
			LEFT JOIN ms_cities mc ON mc.`id_city` = d.`city_id`
			LEFT JOIN ms_districts md ON md.`id_dis` = d.`dis_id`
			LEFT JOIN ms_subdistricts ms ON ms.`id_subdis` = d.`subdis_id`
			where d.`id_delivery` = $delivery_id";
		return $this->db->query($sql)->row();
	}
	function getOrdinary()
	{
		$sql = "SELECT count(ordinary) as urutan FROM delivery where delivery_type = 2 AND status = 1 AND delivery_date = '" . date('Y-m-d') . "'";
		return $this->db->query($sql)->row();
	}
	/* old */
	function add_detail_delivery($dataDetail)
	{
		$this->db->insert('tb_detail_delivery', $dataDetail);
		if ($this->db->affected_rows() > 0) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	function get_delivery_list($id_px = NULL)
	{
		if ($id_px) {
			$this->db->where('o.ord_px_id', $id_px);
		} else {
			$this->db->select('p.px_norm');
			$this->db->join('tb_patient p', 'p.id_px = o.ord_px_id');
		}
		$this->db->select('o.id_order, o.ord_date, o.ord_px_id, o.ord_invoice, o.ord_status, CASE WHEN o.ord_usr_id is NULL THEN 0 ELSE o.ord_usr_id END AS user_id, u.usr_fullname, i.item_name, d.item_total', FALSE);
		$this->db->from('tb_delivery o, tb_detail_delivery d, tb_item i');
		$this->db->join('tb_user u', 'o.ord_usr_id = u.id_user', 'left');
		$this->db->where('d.order_id = o.id_order');
		$this->db->where('d.item_id = i.id_item');
		// $this->db->where('o.ord_usr_id = u.id_user');
		$this->db->where('o.ord_active', 1);
		$this->db->order_by('FIELD(o.ord_status, 2, 3, 4, 1, 0)');
		$this->db->order_by('o.ord_date', 'DESC');
		$query = $this->db->get();
		return $query;
	}
	function get_detail($id_order, $user_id)
	{
		if ($user_id) {
			$this->db->select('u.usr_fullname');
			$this->db->join('tb_user u', 'o.ord_usr_id = u.id_user');
		}
		$this->db->select('o.*, d.*, i.*, p.*');
		$this->db->from('tb_delivery o, tb_detail_delivery d, tb_item i, tb_patient p');
		$this->db->where('d.order_id = o.id_order');
		$this->db->where('p.id_px = o.ord_px_id');
		$this->db->where('d.item_id = i.id_item');
		// $this->db->where('o.ord_px_id', $id_px);
		$this->db->where('o.id_order', $id_order);
		$this->db->where('o.ord_active', 1);
		// if ($user_id) {
		// 	$this->db->where('o.ord_usr_id = u.id_user');
		// }
		$this->db->limit(1);
		$query = $this->db->get();
		return $query;
	}
	function edit_order($data, $order_id)
	{
		return $this->db
			->where('id_order', $order_id)
			->update('tb_delivery', $data);
	}
	function edit_detail_delivery($data, $order_id)
	{
		return $this->db
			->where('order_id', $order_id)
			->update('tb_detail_delivery', $data);
	}
}
