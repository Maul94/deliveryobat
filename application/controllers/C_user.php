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
		if ($this->secure(array(self::ROLE_ADMIN))) {
			$headerInfo['pageTitle'] = 'Master User';
			// $data['role_list'] = $this->M_user->getRoleList();
			$headerInfo['role_list'] = $this->M_user->getRoleList();
			$this->load_views('user/user_index', $headerInfo);
		}
	}

	function userjson()
	{
		if ($this->secure(array(self::ROLE_ADMIN))) {
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
		if ($this->secure(array(self::ROLE_ADMIN))) {
			$result = $this->M_user->getUser((int) $id_user);

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
		if ($this->secure(array(self::ROLE_ADMIN)) && $this->require_post()) {
			if ($_POST) {
				$error = TRUE;

				$this->form_validation->set_rules('nama', 'Nama', 'trim|required|min_length[5]|max_length[50]|callback_exist_name[username]');
				$this->form_validation->set_rules('username', 'Username', 'trim|alpha_numeric|required|min_length[6]|max_length[10]|callback_exist_Username[username]');
				$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]');
				$this->form_validation->set_rules('access', 'Hak Akses', 'trim|required|integer|greater_than[0]');

				$this->form_validation->set_message('required', '%s Harus Diisi !');
				$this->form_validation->set_message('min_length', '%s minimal %s karakter !');
				$this->form_validation->set_message('max_length', '%s maksimal %s karakter !');
				$this->form_validation->set_message('alpha_numeric', '%s hanya huruf dan angka !');
				$this->form_validation->set_message('integer', '%s tidak valid !');
				$this->form_validation->set_message('greater_than', '%s tidak valid !');
				$this->form_validation->set_message('exist_Username', '%s sudah digunakan!');
				$this->form_validation->set_message('exist_name', '%s sudah digunakan!');
				if ($this->form_validation->run() == true) {

					if (!empty($_POST['status'])) {
						$status = 1;
					}else{
						$status = 0;
					}

					$pswhash = password_hash($this->input->post('password'), PASSWORD_DEFAULT);

					$data = array(
						'usr_name'		=> trim((string) $this->input->post('username')),
						'usr_fullname'	=> trim((string) $this->input->post('nama')),
						'usr_password'	=> $pswhash,
						'usr_role'		=> (int) $this->input->post('access'),
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

	function updateuser()
	{
		if ($this->secure(array(self::ROLE_ADMIN)) && $this->require_post()) {
			$idUser = (int) $this->input->post('id_user');
			if ($idUser <= 0) {
				$this->error("User tidak valid!");
				return;
			}

			$existing = $this->M_user->getUser($idUser);
			if (!$existing) {
				$this->error("Data user tidak ditemukan!");
				return;
			}

			$this->form_validation->set_rules('nama', 'Nama', 'trim|required|min_length[5]|max_length[50]|callback_exist_name_edit[' . $idUser . ']');
			$this->form_validation->set_rules('username', 'Username', 'trim|alpha_numeric|required|min_length[6]|max_length[10]|callback_exist_Username_edit[' . $idUser . ']');
			$this->form_validation->set_rules('access', 'Hak Akses', 'trim|required|integer|greater_than[0]');

			$changePass = !empty($_POST['change_pass']) || (string) $this->input->post('password') !== '';
			if ($changePass) {
				$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]');
				$this->form_validation->set_rules('rptpassword', 'Ulangi Password', 'trim|required|matches[password]');
			}

			$this->form_validation->set_message('required', '%s Harus Diisi !');
			$this->form_validation->set_message('min_length', '%s minimal %s karakter !');
			$this->form_validation->set_message('max_length', '%s maksimal %s karakter !');
			$this->form_validation->set_message('alpha_numeric', '%s hanya huruf dan angka !');
			$this->form_validation->set_message('integer', '%s tidak valid !');
			$this->form_validation->set_message('greater_than', '%s tidak valid !');
			$this->form_validation->set_message('matches', 'Verifikasi password tidak sama !');
			$this->form_validation->set_message('exist_Username_edit', '%s sudah digunakan!');
			$this->form_validation->set_message('exist_name_edit', '%s sudah digunakan!');

			if ($this->form_validation->run() == TRUE) {
				$status = !empty($_POST['status']) ? 1 : 0;

				$data = array(
					'usr_name'     => trim((string) $this->input->post('username')),
					'usr_fullname' => trim((string) $this->input->post('nama')),
					'usr_role'     => (int) $this->input->post('access'),
					'status'       => $status
				);

				if ($changePass) {
					$data['usr_password'] = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
				}

				$updated = $this->db->where('id_user', $idUser)->update('ms_user', $data);
				if ($updated) {
					$this->success('Data user berhasil diperbarui!');
				} else {
					$this->error('Gagal memperbarui data user!');
				}
			} else {
				$this->input_error();
			}
		}
	}

	function change_password()
	{
		if ($this->secure() && $this->require_post()) {
			$this->form_validation->set_rules('oldPass', 'Password Lama', 'trim|required');
			$this->form_validation->set_rules('inptPass', 'Password Baru', 'trim|required|min_length[6]');
			$this->form_validation->set_rules('repeatinptPass', 'Ulangi Password', 'trim|required|matches[inptPass]');

			$this->form_validation->set_message('required', '%s Harus Diisi !');
			$this->form_validation->set_message('min_length', '%s minimal %s karakter !');
			$this->form_validation->set_message('matches', 'Verifikasi password tidak sama !');

			if ($this->form_validation->run() == TRUE) {
				$userId = (int) $this->session->userdata('s_usr_id');
				$userRow = $this->db->select('id_user, usr_password')
					->where('id_user', $userId)
					->where('status', 1)
					->limit(1)
					->get('ms_user')
					->row();

				if (!$userRow || !password_verify((string) $this->input->post('oldPass'), $userRow->usr_password)) {
					$this->error('Password lama tidak sesuai!');
					return;
				}

				$newHash = password_hash((string) $this->input->post('inptPass'), PASSWORD_DEFAULT);
				$updated = $this->db->where('id_user', $userId)->update('ms_user', array('usr_password' => $newHash));
				if ($updated) {
					$this->success('Password berhasil diubah!');
				} else {
					$this->error('Gagal mengubah password!');
				}
			} else {
				$this->input_error();
			}
		}
	}

	function exist_Username($username)
	{
		if ($this->secure(array(self::ROLE_ADMIN))) {
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
		if ($this->secure(array(self::ROLE_ADMIN))) {
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

	function exist_Username_edit($username, $idUser)
	{
		if ($this->secure(array(self::ROLE_ADMIN))) {
			$result = $this->db
				->select('usr_name')
				->where('usr_name', $username)
				->where('id_user !=', (int) $idUser)
				->limit(1)
				->get('ms_user');

			return $result->num_rows() === 0;
		}
	}

	function exist_name_edit($nama, $idUser)
	{
		if ($this->secure(array(self::ROLE_ADMIN))) {
			$result = $this->db
				->select('usr_fullname')
				->where('usr_fullname', $nama)
				->where('id_user !=', (int) $idUser)
				->limit(1)
				->get('ms_user');

			return $result->num_rows() === 0;
		}
	}
}
