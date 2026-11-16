<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '/core/BaseController.php';
class C_user extends BaseController
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper('url_helper');
		$this->load->model('M_user');
		$this->load->model('M_simpan');
	}

	function index()
	{
		if ($this->secure()) {
			$headerInfo['pageTitle'] = 'Master User';
			// $data['role_list'] = $this->M_user->getRoleList();
			$headerInfo['role_list'] = $this->M_user->getRoleList();
			$this->load_views('user/user_index', $headerInfo);
		}
	}

	function userjson()
	{
		if ($this->secure()) {
			$result = $this->M_user->getUser();

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

	function getuser($id_user)
	{
		if ($this->secure()) {
			$result = $this->M_user->getUser($id_user);

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

	function adduser()
	{
		if ($this->secure()) {
			if ($_POST) {
				$error = TRUE;

				$this->form_validation->set_rules('nama', 'Nama', 'trim|required|min_length[5]|callback_exist_name[username]');
				$this->form_validation->set_rules('username', 'Username', 'trim|alpha_numeric|required|callback_exist_Username[username]');
				$this->form_validation->set_rules('password', 'password', 'trim|required|min_length[6]');
				$this->form_validation->set_rules('access', 'Hak Akses', 'trim|required');

				$this->form_validation->set_message('required', '%s Harus Diisi !');
				$this->form_validation->set_message('min_length', '%s minimal %s karakter !');
				$this->form_validation->set_message('alpha_numeric', '%s hanya huruf dan angka !');
				$this->form_validation->set_message('exist_Username', '%s sudah digunakan!');
				$this->form_validation->set_message('exist_name', '%s sudah digunakan!');
				if ($this->form_validation->run() == true) {

					if (!empty($_POST['status'])) {
						$status = 1;
					}else{
						$status = 0;
					}

					$pswhash = password_hash($_POST['password'], PASSWORD_DEFAULT);

					$data = array(
						'usr_name'		=> $_POST['username'],
						'usr_fullname'	=> $_POST['nama'],
						'usr_password'	=> $pswhash,
						'usr_role'		=> $_POST['access'],
						'status'		=> $status
					);

					$result_id = $this->M_simpan->tambahdata($data, 'ms_user');

					if ($result_id) {
						$error = FALSE;
					}

					if ($error) {
						$this->error("Gagal menyimpan data!");
					} else {
						$this->success('Berhasil disimpan!');
					}
				} else {
					$this->input_error();
				}
			} else {
				$this->error("Gagal menyimpan data!");
			}
		}
	}

	function exist_Username($username)
	{
		if ($this->secure()) {
			$result = $this->db
				->select('usr_name')
				->where('usr_name', $username)
				// ->where('status', 1)
				->limit(1)
				->get('ms_user');

			if ($result->num_rows() > 0) {
				return FALSE;
			}
			return TRUE;
		}
	}

	function exist_name($nama)
	{
		if ($this->secure()) {
			$result = $this->db
				->select('usr_fullname')
				->where('usr_fullname', $nama)
				// ->where('status', 1)
				->limit(1)
				->get('ms_user');

			if ($result->num_rows() > 0) {
				return FALSE;
			}
			return TRUE;
		}
	}
}
