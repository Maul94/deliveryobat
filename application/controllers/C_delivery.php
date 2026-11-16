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
		if ($this->secure()) {
			$headerInfo['pageTitle'] = 'Daftar Pengiriman';

			$this->load_views('delivery/delivery_list', $headerInfo);
		}
	}

	function deliveryjson($date, $deltype, $driver = null)
	{
		if ($this->secure()) {
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
		if ($this->secure()) {
			$headerInfo['pageTitle'] = 'Tambah Pengiriman';
			$headerInfo['kurir'] = $this->M_delivery->getKurir();

			$this->load_views('delivery/entry_delivery', $headerInfo);
		}
	}

	function entry_delivery2()
	{
		if ($this->secure()) {
			$headerInfo['pageTitle'] = 'Tambah Pengiriman';
			$headerInfo['kurir'] = $this->M_delivery->getKurir();

			$this->load_views('delivery/entry_delivery_v2', $headerInfo);
		}
	}

	function edit_delivery($delivery_id)
	{
		if ($this->secure()) {
			$headerInfo['pageTitle'] = 'Edit Pengiriman';
			$headerInfo['kurir'] = $this->M_delivery->getKurir();

			$result = $this->M_delivery->getDelivery($delivery_id);
			$headerInfo['data'] = $result;

			$this->load_views('delivery/edit_delivery', $headerInfo);
		}
	}

	function save_delivery()
	{
		if ($this->secure()) {
			if ($_POST) {
				$error = TRUE;
				if ($_POST['typePost'] == 'entry') {
					$data = array(
						'user_entry'		=> $this->session->userdata('s_usr_id'),
						'delivery_date'		=> $_POST['delDate'],
						'delivery_time'		=> $_POST['delTime'],
						'delivery_type'		=> 3,
						'invoice_num'		=> date('ymdHis') . strtoupper(uniqid()),
						'address'			=> $_POST['delAddress'],
						'detail_address'	=> $_POST['delDetailAddress'],
						'receiver_name'		=> $_POST['delName'],
						'receiver_phone'	=> $_POST['delPhone'],
						'distance'			=> $_POST['delJarak'],
						'total'				=> $_POST['delTotal'],
						'resep'				=> $_POST['delResep'],
						'kurir_id'			=> $_POST['idKurir'],
						'lat'				=> $_POST['dellat'],
						'lon'				=> $_POST['dellon'],
						'prov_id'			=> $_POST['idProv'],
						'city_id'			=> $_POST['idCity'],
						'dis_id'			=> $_POST['idDis'],
						'subdis_id'			=> $_POST['idSubdis'],
						'rt_address'		=> $_POST['delRT'],
						'rw_address'		=> $_POST['delRW']
					);
					$result_id = $this->M_simpan->tambahdata($data, 'delivery');

					if ($result_id) {
						$error = FALSE;
					}
				} else if ($_POST['typePost'] == 'edit') {
					$where['id_delivery'] = $_POST['delivery_id'];

					$data = array(
						'user_entry'		=> $this->session->userdata('s_usr_id'),
						'delivery_date'		=> $_POST['delDate'],
						'delivery_time'		=> $_POST['delTime'],
						'delivery_type'		=> 3,
						'invoice_num'		=> date('ymdHis') . strtoupper(uniqid()),
						'address'			=> $_POST['delAddress'],
						'detail_address'	=> $_POST['delDetailAddress'],
						'receiver_name'		=> $_POST['delName'],
						'receiver_phone'	=> $_POST['delPhone'],
						'distance'			=> $_POST['delJarak'],
						'total'				=> $_POST['delTotal'],
						'resep'				=> $_POST['delResep'],
						'kurir_id'			=> $_POST['idKurir'],
						'lat'				=> $_POST['dellat'],
						'lon'				=> $_POST['dellon'],
						'prov_id'			=> $_POST['idProv'],
						'city_id'			=> $_POST['idCity'],
						'dis_id'			=> $_POST['idDis'],
						'subdis_id'			=> $_POST['idSubdis'],
						'rt_address'		=> $_POST['delRT'],
						'rw_address'		=> $_POST['delRW']
					);

					$update = $this->M_simpan->updatedata($where, $data, 'delivery');

					if ($update) {
						$error = FALSE;
					}
				}

				if ($error) {
					$this->error("Gagal menyimpan data!");
				} else {
					$this->success('Berhasil disimpan!');
				}
			} else {
				redirect('dashboard');
			}
		}
	}

	function resend_delivery($delivery_id)
	{
		if ($this->secure()) {
			$result = $this->M_delivery->getDelivery($delivery_id);

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
		if ($this->secure()) {
			if ($_POST) {
				if ($_POST['resendDate'] != $_POST['resendDate2'] || $_POST['resendTime'] > $_POST['resendTime2']) {
					$where['id_delivery'] = $_POST['delId'];
					$data['delivery_type'] = 3;
					$data['delivery_date'] = $_POST['resendDate'];
					$data['delivery_time'] = $_POST['resendTime'];
					$data['resend'] = $_POST['delResend'] + 1;

					$result = $this->M_simpan->updatedata($where, $data, 'delivery');

					if ($result) {
						$this->success('Berhasil disimpan!');
					} else {
						$this->error("Gagal Proses!");
					}
				} else {
					$this->error("Tidak ada perubahan atau jam lebih kecil!");
				}
			} else {
				$this->error("Gagal Proses!");
			}
		}
	}

	function detail_delivery($delivery_id, $type = null)
	{
		$result = $this->M_delivery->getDelivery($delivery_id);

		// $html = "<input type='hidden' id='delivery_id' value='".$delivery_id."'>";
		// $html .= "<select id='ordinary' name='ordinary' class='select2 form-select form-select-lg mb-2'>";
		// for ($i = $urutan+1; $i <= 10; $i++) { 
		// 	$html .= "<option value='".$i."'>".$i."</option>";
		// }
		// $html .= "</select>";
		// $html .= "<div class='d-flex justify-content-end'>";
		// $html .= "<button id='submitOrdinary' type='button' class='btn btn-sm btn-primary'>Simpan</button>";
		// $html .= "</div>";

		$alamat = $result->detail_address . "<br>RT : " . $result->rt_address . " / RW : " . $result->rw_address . "<br>" . $result->address;
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
		$html .= "<td class='ps-4' colspan='3'>" . strtoupper($result->receiver_name) . "</td>";
		$html .= "</tr>";
		$html .= "<tr>";
		$html .= "<th class='ps-3'>No Telepon : </th>";
		$html .= "</tr>";
		$html .= "<tr>";
		$html .= "<td class='ps-4' colspan='3'>" . $result->receiver_phone . "</td>";
		$html .= "</tr>";
		$html .= "<tr>";
		$html .= "<th class='ps-3'>Tgl. Pengiriman : </th>";
		$html .= "</tr>";
		$html .= "<tr>";
		$html .= "<td class='ps-4' colspan='3'>" . $this->bln_indo($result->delivery_date) . "&nbsp;&nbsp;&nbsp;&nbsp;" . date('H : i', strtotime($result->delivery_time)) . "</td>";
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
			$html .= "<td class='ps-4' colspan='3' style='white-space: pre-wrap;'>" . $result->resep . "</td>";
			$html .= "</tr>";
			$html .= "<tr>";
			$html .= "<th class='ps-3' height='50'>Jarak&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;" . $result->distance . " Km</th>";
			$html .= "</tr>";
		} else {
			$html .= "<tr>";
			$html .= "<td class='ps-4' colspan='3' style='white-space: pre-wrap; border-bottom: 5px double black;'>" . $result->resep . "</td>";
			$html .= "</tr>";
			$html .= "<tr>";
			$html .= "<th class='pe-3 text-end'>Jarak</th>";
			$html .= "<th class='text-end'>:</th>";
			$html .= "<td class='pe-5 text-end' width='50%'>" . $result->distance . " Km</td>";
			$html .= "</tr>";
			$html .= "<tr>";
			$html .= "<th class='pe-3 text-end'>Ongkir</th>";
			$html .= "<th class='text-end'>:</th>";
			$html .= "<td class='pe-5 text-end'>Rp. " . number_format($result->total, 0, ",", ".") . "</td>";
			$html .= "</tr>";
			$total = $result->total;
			if ($result->resend != 0) {
				$ongkirresend = $result->total / 2; /* ditambah 50% dari ongkos kirim */
				$html .= "<tr>";
				$html .= "<th class='pe-3 text-end'>Kirim Ulang</th>";
				$html .= "<th class='text-end'>:</th>";
				$html .= "<td class='pe-5 text-end'>Rp. " . number_format($ongkirresend, 0, ",", ".") . "</td>";
				$html .= "</tr>";
				$total = $result->total + $ongkirresend;
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

		// $html = "<dt class='text-center'>DELIVERY OBAT</dt>";
		// $html .= "<dt class='text-center'>RSUD R.A. Basoeni</dt>";
		// $html .= "<hr style='border-top: solid 2px black'>";
		// $html .= "<dt class='col-sm-4'>Penerima</dt>";
		// $html .= "<dd class='col-sm-8' id='mdName'>".$result->receiver_name."</dd>";
		// $html .= "<dt class='col-sm-4'>No Telepon</dt>";
		// $html .= "<dd class='col-sm-8' id='mdPhone'>".$result->receiver_phone."</dd>";
		// $html .= "<dt class='col-sm-4'>Tgl. Pengiriman</dt>";
		// $html .= "<dd class='col-sm-8' id='mdDate'>".$result->delivery_date."</dd>";
		// $html .= "<dt class='col-sm-4'>Alamat</dt>";
		// $html .= "<dd class='col-sm-8' id='mdAddress'>".$alamat."</dd>";
		// $html .= "<dt class='col-sm-4'>Rincian Resep</dt>";
		// $html .= "<dd class='col-sm-8' id='mdResep' style='white-space: pre-wrap;'>".$result->resep."</dd>";
		// $html .= "<dt class='col-sm-4'>Jarak</dt>";
		// $html .= "<dd class='col-sm-8' id='mdJarak'>".$result->distance."</dd>";
		// $html .= "<dt class='col-sm-4'>Total Ongkir</dt>";
		// $html .= "<dd class='col-sm-8' id='mdTotal'>Rp. ".number_format($result->total, 0, ",", ".")."</dd>";
		echo ($html);
	}

	function driver_anterin()
	{
		if ($this->secure()) {
			$headerInfo['pageTitle'] = 'Driver';

			$this->load_views('delivery/driver_anterin', $headerInfo);
		}
	}

	function get_ordinary($delivery_id)
	{
		$urutan = $this->M_delivery->getOrdinary()->urutan;

		$html = "<input type='hidden' id='delivery_id' value='" . $delivery_id . "'>";
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

	function set_ordinary($delivery_id, $ordinary)
	{
		if ($this->secure()) {
			$where['id_delivery'] = $delivery_id;
			$data['delivery_type'] = 2;
			$data['ordinary'] = $ordinary;
			$result = $this->M_simpan->updatedata($where, $data, 'delivery');

			if ($result) {
				$this->success('Berhasil disimpan!');
			} else {
				$this->error("Gagal Proses!");
			}
		}
	}

	function batal_delivery($delivery_id, $reason)
	{
		if ($this->secure()) {
			$where['id_delivery'] = $delivery_id;
			// $data['status'] = 0;
			$data['cancel_reason'] = $reason;
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
		if ($this->secure()) {
			$where['id_delivery'] = $delivery_id;
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

	function detail_order($id_delivery, $user_id)
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

	function payment_delivery($id_delivery, $user_id)
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

	function save_payment($link)
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

	function batal_deliverysdfsdfd($ord_id)
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

	function update_status($id_delivery, $status, $px_id, $user_id = 0)
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

	function update_nurse($user_id, $ord_id)
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

	function notif_delivery($id_delivery, $px_id, $status)
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
