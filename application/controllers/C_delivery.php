<?php
defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . '/core/BaseController.php';

class C_delivery extends BaseController
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper('url_helper');
		$this->load->model('M_delivery');
		$this->load->model('M_simpan');
	}

	function index()
	{
		if ($this->secure_non_driver()) {
			$headerInfo['pageTitle'] = 'Daftar Pengiriman';

			$this->load_views('delivery/delivery_list', $headerInfo);
		}
	}

	function deliveryjson($date, $deltype, $driver = null)
	{
		if ($this->secure()) {
			if (!$this->is_valid_date($date)) {
				$date = date('Y-m-d');
			}
			if ($deltype !== 'semua' && !in_array((string) $deltype, array('0', '1', '2', '3'), TRUE)) {
				$deltype = 'semua';
			}

			$result = $this->M_delivery->getDeliveryList($date, $deltype, $driver);

			if ($result) {
				$json_data = array(
					"status"	=> 1,
					"data"		=> $result
				);
			} else {
				$json_data = array(
					"status"	=> 2,
					"data"		=> [],
				);
			}

			echo json_encode($json_data);
		}
	}

	function entry_delivery()
	{
		if ($this->secure_non_driver()) {
			$headerInfo['pageTitle'] = 'Tambah Pengiriman';
			$headerInfo['kurir'] = $this->M_delivery->getKurir();

			$this->load_views('delivery/entry_delivery', $headerInfo);
		}
	}

	function entry_delivery2()
	{
		if ($this->secure_non_driver()) {
			$headerInfo['pageTitle'] = 'Tambah Pengiriman';
			$headerInfo['kurir'] = $this->M_delivery->getKurir();

			$this->load_views('delivery/entry_delivery_v2', $headerInfo);
		}
	}

	function edit_delivery($delivery_id)
	{
		if ($this->secure_non_driver()) {
			$headerInfo['pageTitle'] = 'Edit Pengiriman';
			$headerInfo['kurir'] = $this->M_delivery->getKurir();

			$result = $this->M_delivery->getDelivery((int) $delivery_id);
			if (!$result) {
				show_404();
			}
			$headerInfo['data'] = $result;

			$this->load_views('delivery/edit_delivery', $headerInfo);
		}
	}

	function save_delivery()
	{
		if ($this->secure_non_driver() && $this->require_post()) {
			$typePost = (string) $this->input->post('typePost');
			if (!in_array($typePost, array('entry', 'edit'), TRUE)) {
				$this->error("Tipe aksi tidak valid!");
				return;
			}

			$delDate = trim((string) $this->input->post('delDate'));
			$delTime = trim((string) $this->input->post('delTime'));
			$delName = trim((string) $this->input->post('delName'));
			$delPhone = trim((string) $this->input->post('delPhone'));
			$delAddress = trim((string) $this->input->post('delAddress'));
			$delDetailAddress = trim((string) $this->input->post('delDetailAddress'));
			$delResep = trim((string) $this->input->post('delResep'));
			$idKurir = (int) $this->input->post('idKurir');
			$lat = $this->input->post('dellat');
			$lon = $this->input->post('dellon');
			$jarakInput = $this->input->post('delJarak');

			if (
				!$this->is_valid_date($delDate) ||
				$delTime === '' ||
				$delName === '' ||
				$delPhone === '' ||
				$delAddress === '' ||
				$delDetailAddress === '' ||
				$delResep === '' ||
				$idKurir <= 0 ||
				!is_numeric($lat) || !is_numeric($lon) || !is_numeric($jarakInput)
			) {
				$this->error("Data pengiriman tidak lengkap atau tidak valid!");
				return;
			}

			$latFloat = (float) $lat;
			$lonFloat = (float) $lon;
			$jarakFloat = (float) $jarakInput;

			if ($latFloat < -90 || $latFloat > 90 || $lonFloat < -180 || $lonFloat > 180 || $jarakFloat < 0) {
				$this->error("Koordinat atau jarak pengiriman tidak valid!");
				return;
			}

			$straightKm = $this->calculate_haversine_km(self::RSUD_LAT, self::RSUD_LON, $latFloat, $lonFloat);
			if ($jarakFloat + 1 < floor($straightKm)) {
				$this->error("Jarak pengiriman tidak sesuai dengan koordinat tujuan!");
				return;
			}

			$distance = max(0, (int) round($jarakFloat));
			$total = $this->calculate_shipping_fee($distance);

			$error = TRUE;
			$data = array(
				'user_entry'		=> (int) $this->session->userdata('s_usr_id'),
				'delivery_date'		=> $delDate,
				'delivery_time'		=> $delTime,
				'address'			=> $delAddress,
				'detail_address'	=> $delDetailAddress,
				'receiver_name'		=> $delName,
				'receiver_phone'	=> $delPhone,
				'distance'			=> $distance,
				'total'				=> $total,
				'resep'				=> $delResep,
				'kurir_id'			=> $idKurir,
				'lat'				=> $latFloat,
				'lon'				=> $lonFloat,
				'prov_id'			=> (int) $this->input->post('idProv'),
				'city_id'			=> (int) $this->input->post('idCity'),
				'dis_id'			=> (int) $this->input->post('idDis'),
				'subdis_id'			=> (int) $this->input->post('idSubdis'),
				'rt_address'		=> (int) $this->input->post('delRT'),
				'rw_address'		=> (int) $this->input->post('delRW')
			);

			if ($typePost === 'entry') {
				$data['delivery_type'] = 3;
				$data['invoice_num'] = date('ymdHis') . strtoupper(uniqid());
				$result_id = $this->M_simpan->tambahdata($data, 'delivery');

				if ($result_id) {
					$error = FALSE;
				}
			} else {
				$deliveryId = (int) $this->input->post('delivery_id');
				$existing = $this->M_delivery->getDelivery($deliveryId);
				if (!$existing || (int) $existing->status !== 1) {
					$this->error("Data pengiriman tidak ditemukan!");
					return;
				}

				$where['id_delivery'] = $deliveryId;
				$update = $this->db->where($where)->update('delivery', $data);

				if ($update) {
					$error = FALSE;
				}
			}

			if ($error) {
				$this->error("Gagal menyimpan data!");
			} else {
				$this->success('Berhasil disimpan!');
			}
		}
	}

	function resend_delivery($delivery_id)
	{
		if ($this->secure_non_driver()) {
			$result = $this->M_delivery->getDelivery((int) $delivery_id);

			if ($result) {
				$json_data = array(
					"status"	=> 1,
					"delivery_date"		=> $result->delivery_date,
					"delivery_time"		=> $result->delivery_time,
					"id_delivery"		=> $result->id_delivery,
					"resend"			=> $result->resend
				);

				echo json_encode($json_data);
			} else {
				$this->error("Gagal Proses!");
			}
		}
	}

	function save_resend()
	{
		if ($this->secure_non_driver() && $this->require_post()) {
			$delId = (int) $this->input->post('delId');
			$resendDate = trim((string) $this->input->post('resendDate', TRUE));
			$resendTime = trim((string) $this->input->post('resendTime', TRUE));

			if ($delId <= 0 || !$this->is_valid_date($resendDate) || $resendTime === '') {
				$this->error("Data kirim ulang tidak valid!");
				return;
			}

			$existing = $this->M_delivery->getDelivery($delId);
			if (!$existing || (int) $existing->status !== 1 || !in_array((int) $existing->delivery_type, array(2, 3), TRUE)) {
				$this->error("Pengiriman tidak ditemukan atau tidak dapat dikirim ulang!");
				return;
			}

			if ((int) $existing->resend >= 2) {
				$this->error("Batas maksimal kirim ulang telah tercapai!");
				return;
			}

			if ($resendDate !== $existing->delivery_date || strtotime($resendTime) > strtotime($existing->delivery_time)) {
				$where['id_delivery'] = $delId;
				$data['delivery_type'] = 3;
				$data['delivery_date'] = $resendDate;
				$data['delivery_time'] = $resendTime;
				$data['resend'] = (int) $existing->resend + 1;

				$result = $this->M_simpan->updatedata($where, $data, 'delivery');

				if ($result) {
					$this->success('Berhasil disimpan!');
				} else {
					$this->error("Gagal Proses!");
				}
			} else {
				$this->error("Tidak ada perubahan atau jam lebih kecil!");
			}
		}
	}

	function detail_delivery($delivery_id, $type = null)
	{
		if ($this->secure()) {
			$result = $this->M_delivery->getDelivery((int) $delivery_id);
			if (!$result) {
				$this->output->set_status_header(404);
				echo "<div class='alert alert-warning'>Data pengiriman tidak ditemukan.</div>";
				return;
			}

			if ((int) $this->session->userdata('s_usr_role') === self::ROLE_DRIVER && (int) $result->kurir_id !== (int) $this->session->userdata('s_usr_id')) {
				$this->denyAccess();
			}

			$alamat = html_escape($result->detail_address)
				. "<br>RT : " . html_escape($result->rt_address) . " / RW : " . html_escape($result->rw_address)
				. "<br>" . html_escape($result->address);
			$html = "<table style='border-bottom: 1px solid' width='100%'>";
			$html .= "<thead class='text-center'>";
			$html .= "<tr>";
			$html .= "<th colspan='3'>DELIVERY OBAT</th>";
			$html .= "</tr>";
			$html .= "<tr style='border-bottom: 5px double black;'>";
			$html .= "<th colspan='3'>RSUD R.A. Basoeni</th>";
			$html .= "</tr>";
			$html .= "</thead>";
			$html .= "<tbody style='vertical-align: top;'>";
			$html .= "<tr>";
			$html .= "<th class='ps-3'>Penerima : </th>";
			$html .= "</tr>";
			$html .= "<tr>";
			$html .= "<td class='ps-4' colspan='3'>" . html_escape(strtoupper($result->receiver_name)) . "</td>";
			$html .= "</tr>";
			$html .= "<tr>";
			$html .= "<th class='ps-3'>No Telepon : </th>";
			$html .= "</tr>";
			$html .= "<tr>";
			$html .= "<td class='ps-4' colspan='3'>" . html_escape($result->receiver_phone) . "</td>";
			$html .= "</tr>";
			$html .= "<tr>";
			$html .= "<th class='ps-3'>Tgl. Pengiriman : </th>";
			$html .= "</tr>";
			$html .= "<tr>";
			$html .= "<td class='ps-4' colspan='3'>" . html_escape($this->bln_indo($result->delivery_date)) . "&nbsp;&nbsp;&nbsp;&nbsp;" . html_escape(date('H : i', strtotime($result->delivery_time))) . "</td>";
			$html .= "</tr>";
			$html .= "<tr>";
			$html .= "<th class='ps-3'>Alamat : </th>";
			$html .= "</tr>";
			$html .= "<tr>";
			$html .= "<td class='ps-4' colspan='3'>" . $alamat . "</td>";
			$html .= "</tr>";
			$html .= "<tr>";
			$html .= "<th class='ps-3'>Rincian Resep : </th>";
			$html .= "</tr>";
			if ($type == "cetak2") {
				$html .= "<tr>";
				$html .= "<td class='ps-4' colspan='3' style='white-space: pre-wrap;'>" . html_escape($result->resep) . "</td>";
				$html .= "</tr>";
				$html .= "<tr>";
				$html .= "<th class='ps-3' height='50'>Jarak&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;" . html_escape($result->distance) . " Km</th>";
				$html .= "</tr>";
			} else {
				$html .= "<tr>";
				$html .= "<td class='ps-4' colspan='3' style='white-space: pre-wrap; border-bottom: 5px double black;'>" . html_escape($result->resep) . "</td>";
				$html .= "</tr>";
				$html .= "<tr>";
				$html .= "<th class='pe-3 text-end'>Jarak</th>";
				$html .= "<th class='text-end'>:</th>";
				$html .= "<td class='pe-5 text-end' width='50%'>" . html_escape($result->distance) . " Km</td>";
				$html .= "</tr>";
				$html .= "<tr>";
				$html .= "<th class='pe-3 text-end'>Ongkir</th>";
				$html .= "<th class='text-end'>:</th>";
				$html .= "<td class='pe-5 text-end'>Rp. " . number_format((float) $result->total, 0, ",", ".") . "</td>";
				$html .= "</tr>";
				$total = (float) $result->total;
				if ((int) $result->resend !== 0) {
					$ongkirresend = $total / 2; /* ditambah 50% dari ongkos kirim */
					$html .= "<tr>";
					$html .= "<th class='pe-3 text-end'>Kirim Ulang</th>";
					$html .= "<th class='text-end'>:</th>";
					$html .= "<td class='pe-5 text-end'>Rp. " . number_format($ongkirresend, 0, ",", ".") . "</td>";
					$html .= "</tr>";
					$total = $total + $ongkirresend;
				}
				$html .= "<tr>";
				$html .= "<th class='pe-3 text-end' height='50'>Total</th>";
				$html .= "<th class='text-end'>:</th>";
				$html .= "<td class='pe-5 text-end' style='border-top: solid;'>Rp. " . number_format($total, 0, ",", ".") . "</td>";
				$html .= "</tr>";
			}
			$html .= "</tbody>";
			$html .= "<tfoot class='text-center' style='vertical-align: top;'>";
			$html .= "<tr>";
			$html .= "<th colspan='3'>Terima Kasih</th>";
			$html .= "</tr>";
			$html .= "<tr>";
			$html .= "<th colspan='3'>Layanan Konsumen</th>";
			$html .= "</tr>";
			$html .= "<tr>";
			$html .= "<th colspan='3'><i class='bx bxl-whatsapp fs-3'></i>WA 082139202767</th>";
			$html .= "</tr>";
			$html .= "<tr>";
			$html .= "<td colspan='3' height='100' class='px-5 fw-light' style='font-size: 0.8rem !important;'>bila obat tidak diterima maka obat akan kembali ke rumah sakit dan akan dikenakan biaya tambahan untuk dikirimkan hari berikutnya</td>";
			$html .= "</tr>";

			$html .= "</tfoot>";
			$html .= "</table>";

			echo ($html);
		}
	}

	function driver_anterin()
	{
		if ($this->secure(array(self::ROLE_ADMIN, self::ROLE_DRIVER))) {
			$headerInfo['pageTitle'] = 'Driver';

			$this->load_views('delivery/driver_anterin', $headerInfo);
		}
	}

	function get_ordinary($delivery_id)
	{
		if ($this->secure(array(self::ROLE_ADMIN, self::ROLE_DRIVER))) {
			$deliveryId = (int) $delivery_id;
			$delivery = $this->M_delivery->getDelivery($deliveryId);
			if (!$delivery) {
				echo "<div class='alert alert-warning'>Data pengiriman tidak ditemukan.</div>";
				return;
			}
			if ((int) $this->session->userdata('s_usr_role') === self::ROLE_DRIVER && (int) $delivery->kurir_id !== (int) $this->session->userdata('s_usr_id')) {
				$this->denyAccess();
			}

			$urutan = (int) $this->M_delivery->getOrdinary()->urutan;

			$html = "<input type='hidden' id='delivery_id' value='" . $deliveryId . "'>";
			$html .= "<select id='ordinary' name='ordinary' class='select2 form-select form-select-lg mb-2'>";
			for ($i = $urutan + 1; $i <= $urutan + 10; $i++) {
				$html .= "<option value='" . $i . "'>" . $i . "</option>";
			}
			$html .= "</select>";
			$html .= "<div class='d-flex justify-content-end'>";
			$html .= "<button id='submitOrdinary' type='button' class='btn btn-sm btn-primary'>Simpan</button>";
			$html .= "</div>";

			echo ($html);
		}
	}

	function set_ordinary($delivery_id, $ordinary)
	{
		if ($this->secure(array(self::ROLE_ADMIN, self::ROLE_DRIVER)) && $this->require_post()) {
			$deliveryId = (int) $delivery_id;
			$ordinaryNum = (int) $ordinary;

			if ($deliveryId <= 0 || $ordinaryNum <= 0) {
				$this->error("Parameter urutan tidak valid!");
				return;
			}

			$delivery = $this->M_delivery->getDelivery($deliveryId);
			if (!$delivery || (int) $delivery->status !== 1 || (int) $delivery->delivery_type !== 3) {
				$this->error("Pengiriman tidak dapat diproses!");
				return;
			}

			if ((int) $this->session->userdata('s_usr_role') === self::ROLE_DRIVER && (int) $delivery->kurir_id !== (int) $this->session->userdata('s_usr_id')) {
				$this->denyAccess();
			}

			$where['id_delivery'] = $deliveryId;
			$data['delivery_type'] = 2;
			$data['ordinary'] = $ordinaryNum;
			$result = $this->M_simpan->updatedata($where, $data, 'delivery');

			if ($result) {
				$this->success('Berhasil disimpan!');
			} else {
				$this->error("Gagal Proses!");
			}
		}
	}

	function batal_delivery($delivery_id, $reason = null)
	{
		if ($this->secure_non_driver() && $this->require_post()) {
			$deliveryId = (int) $delivery_id;
			$postReason = $this->input->post('reason');
			$finalReason = ($postReason !== NULL && trim((string) $postReason) !== '')
				? trim((string) $postReason)
				: trim((string) rawurldecode((string) $reason));

			if ($deliveryId <= 0 || $finalReason === '') {
				$this->error("Alasan pembatalan harus diisi!");
				return;
			}

			if (function_exists('mb_substr')) {
				$finalReason = mb_substr($finalReason, 0, 500, 'UTF-8');
			} else {
				$finalReason = substr($finalReason, 0, 500);
			}

			$delivery = $this->M_delivery->getDelivery($deliveryId);
			if (!$delivery || (int) $delivery->status !== 1 || !in_array((int) $delivery->delivery_type, array(2, 3), TRUE)) {
				$this->error("Pengiriman tidak dapat dibatalkan!");
				return;
			}

			$where['id_delivery'] = $deliveryId;
			$data['cancel_reason'] = $finalReason;
			$data['delivery_type'] = 0;
			$data['ordinary'] = 0;
			$result = $this->M_simpan->updatedata($where, $data, 'delivery');

			if ($result) {
				$this->success('Berhasil diperbarui!');
			} else {
				$this->error("Gagal Proses!");
			}
		}
	}

	function selesai_delivery($delivery_id)
	{
		if ($this->secure(array(self::ROLE_ADMIN, self::ROLE_DRIVER)) && $this->require_post()) {
			$deliveryId = (int) $delivery_id;
			$delivery = $this->M_delivery->getDelivery($deliveryId);

			if (!$delivery || (int) $delivery->status !== 1 || (int) $delivery->delivery_type !== 2) {
				$this->error("Pengiriman tidak dalam status Delivery!");
				return;
			}

			if ((int) $this->session->userdata('s_usr_role') === self::ROLE_DRIVER && (int) $delivery->kurir_id !== (int) $this->session->userdata('s_usr_id')) {
				$this->denyAccess();
			}

			$where['id_delivery'] = $deliveryId;
			$data['delivery_type'] = 1;
			$data['received_time'] = date('Y-m-d H:i:s');
			$result = $this->M_simpan->updatedata($where, $data, 'delivery');

			if ($result) {
				$this->success('Berhasil diperbarui!');
			} else {
				$this->error("Gagal Proses!");
			}
		}
	}





	/* old */

	protected function detail_order($id_delivery, $user_id)
	{
		if ($this->secure()) {
			$headerInfo = array(
				'pageTitle' => 'Detail Pemeriksaan',
			);

			$result = $this->M_delivery->get_detail($id_delivery, $user_id);

			if ($result->num_rows() > 0) {
				$data = $result->row();
				$this->load->view('delivery/detail_delivery', $data);
			} else {
				redirect('dashboard');
			}
		}
	}

	protected function payment_delivery($id_delivery, $user_id)
	{
		if ($this->secure()) {
			$headerInfo = array(
				'pageTitle' => 'Pembayaran Rawat Luka',
			);

			$result = $this->M_delivery->get_detail($id_delivery, $user_id);

			if ($result->num_rows() > 0) {
				$data = $result->row();
				$this->load->view('delivery/payment_delivery', $data);
			} else {
				redirect('dashboard');
			}
		}
	}

	protected function save_payment($link)
	{
		if ($this->secure()) {
			if ($this->session->userdata('s_role') == 1) {
				$array = explode('471*#434', base64_decode(urldecode($link)));

				$px_id = $array[0];
				$id_delivery = $array[1];

				$dt = array(
					'ord_status' => 1,
				);

				$result = $this->M_delivery->edit_delivery($dt, $id_delivery);

				if ($result) {
					$datajson = array(
						'status' => TRUE,
						'message' => 'Pembayaran berhasil!',
					);
				} else {
					$datajson = array(
						'status' => FALSE,
						'message' => 'Pembayaran gagal, coba beberapa saat lagi!',
					);
				}

				$this->notif_delivery($id_delivery, $px_id, 1);

				echo json_encode($datajson);
			} else {
				echo "anda tidak memiliki akses ke halaman ini!";
			}
		}
	}

	protected function batal_deliverysdfsdfd($ord_id)
	{
		if ($this->secure()) {

			$dt = array(
				'ord_status' => 0,
			);

			$result = $this->M_delivery->edit_delivery($dt, $ord_id);

			if ($result) {
				$datajson = array(
					'status' => TRUE,
					'message' => 'Berhasil dihapus!',
				);
			} else {
				$datajson = array(
					'status' => FALSE,
					'message' => 'Gagal dihapus!',
				);
			}

			echo json_encode($datajson);
		}
	}

	protected function update_status($id_delivery, $status, $px_id, $user_id = 0)
	{
		if ($this->secure()) {

			$dt = array(
				'ord_status' => $status,
				'ord_usr_id' => $user_id
			);

			$result = $this->M_delivery->edit_delivery($dt, $id_delivery);

			if ($result) {

				if ($status == 1) {
					$ntf_text = 'Permintaan Rawat Luka anda telah selesai dilayani, mohon memberi penilaian pada pelayanan kami, Terima Kasih!';
				} else if ($status == 2) {
					$ntf_text = 'Permintaan Rawat Luka anda sedang dlayani atau petugas sedang menuju ke tempat anda!';
				} else if ($status == 3) {
					$ntf_text = 'Permintaan Rawat Luka anda berada pada antrian, harap sabar menunggu!';
				} else if ($status == 4) {
					$ntf_text = '';
				} else if ($status == 0) {
					$ntf_text = 'Permintaan Rawat Luka dibatalkan';
				}

				if ($ntf_text) {
					$ntf_detail = '{"id_delivery": ' . $id_delivery . '}';
					$notif = $this->add_notif($px_id, 'Permintaan Rawat Luka', $ntf_text, $ntf_detail, 1);
				}

				$datajson = array(
					'status' => TRUE,
					'message' => 'Status berhasil diperbarui!',
				);
			} else {
				$datajson = array(
					'status' => FALSE,
					'message' => 'Status gagal diperbarui!',
				);
			}

			echo json_encode($datajson);
		}
	}

	protected function update_nurse($user_id, $ord_id)
	{
		if ($this->secure()) {

			$dt = array(
				'ord_usr_id' => $user_id
			);

			$result = $this->M_delivery->edit_delivery($dt, $ord_id);

			if ($result) {
				$datajson = array(
					'status' => TRUE,
					'message' => 'Berhasil diperbarui!',
				);
			} else {
				$datajson = array(
					'status' => FALSE,
					'message' => 'Gagal diperbarui!',
				);
			}

			echo json_encode($datajson);
		}
	}

	protected function notif_delivery($id_delivery, $px_id, $status)
	{
		if ($status == 1) {
			$ntf_text = 'Permintaan Rawat Luka anda telah selesai dilayani, mohon memberi penilaian pada pelayanan kami, Terima Kasih! <a href="#" onclick="giveRate(' . $id_delivery . ')">beri penilaian</a>';
		} else if ($status == 2) {
			$ntf_text = 'Permintaan Rawat Luka anda sedang dlayani atau petugas sedang menuju ke tempat anda!';
		} else if ($status == 3) {
			$ntf_text = 'Permintaan Rawat Luka anda berada pada antrian, harap sabar menunggu!';
		} else if ($status == 4) {
			$ntf_text = '';
		} else if ($status == 0) {
			$ntf_text = 'Permintaan Rawat Luka dibatalkan';
		}

		if ($ntf_text) {
			$ntf_detail = '{"id_delivery": ' . $id_delivery . '}';
			$notif = $this->add_notif($px_id, 'Permintaan Rawat Luka', $ntf_text, $ntf_detail, 1);
		}
	}
}
