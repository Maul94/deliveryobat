<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/core/BaseController.php';
class C_login extends BaseController {
	function __construct() {
		parent:: __construct();
		$this->load->helper('url_helper');
		$this->load->model('M_login');
	}
	function index() {
		if ($this->session->userdata('s_login') == FALSE) {
			$this->load->view('auth/usrlogin');
		}else{
			redirect('dashboard');
		}
	}
	function usrlogin() {
		$this->load->view('auth/usrlogin');
	}
	function do_usrlogin() {
		if ($this->require_post()) {
			$gagalLogin = TRUE;
			$usrName = trim((string) $this->input->post('usrName', TRUE));
			$usrPassword = (string) $this->input->post('usrPassword');
			$clientIp = $this->input->ip_address();

			if ($usrName === '' || $usrPassword === '') {
				$this->error("Username dan Password harus diisi!");
				return;
			}

			if ($this->is_login_rate_limited($clientIp, $usrName)) {
				$this->error("Terlalu banyak percobaan login gagal. Silakan coba lagi beberapa menit lagi.");
				return;
			}

			$where = array(
	            'usr_name' => $usrName
	        );
		    $usrLogin = $this->M_login->get_usr($where);
		    if ($usrLogin->num_rows() > 0) {
				if (password_verify($usrPassword, $usrLogin->row()->usr_password)) {
					$this->clear_login_attempts($clientIp, $usrName);
					$this->session->sess_regenerate(TRUE);

					/* create session */
					$usrModule = $this->M_login->get_module($where);
					$this->session->set_userdata(array(
						's_login'		=> TRUE,
						's_usr_id' 		=> $usrLogin->row()->id_user,
						's_name'		=> $usrLogin->row()->usr_fullname,
						's_usr_role'	=> $usrLogin->row()->usr_role,
						's_usr_module'  => $usrModule
					));
					// var_dump($pxLogin->row()->px_norm);
					$gagalLogin = FALSE;
					// $datajson = array(
					// 	'status' => TRUE,
					// 	'message' => 'Login Berhasil!'
					// );
					$this->success('Login Berhasil!');
				}
			}
			if($gagalLogin) {
				$this->record_failed_login($clientIp, $usrName);
				// $datajson = array(
				// 	'status' => FALSE,
				// 	'message' => 'Username atau Password Salah!'
				// );
				$this->error("Username atau Password Salah!");
			}
			// echo json_encode($datajson);
		}
	}

	protected function get_rate_limit_dir() {
		$dir = APPPATH . 'cache/login_attempts/';
		if (!is_dir($dir)) {
			@mkdir($dir, 0750, TRUE);
		}
		return $dir;
	}

	protected function get_rate_limit_keys($ip, $username) {
		return array(
			'user' => array('file' => $this->get_rate_limit_dir() . hash('sha256', 'u|' . $ip . '|' . strtolower($username)) . '.json', 'max' => 5, 'window' => 900),
			'ip'   => array('file' => $this->get_rate_limit_dir() . hash('sha256', 'ip|' . $ip) . '.json', 'max' => 20, 'window' => 900),
		);
	}

	protected function read_attempt_record($file, $window) {
		if (!file_exists($file)) {
			return array('count' => 0, 'first_at' => time());
		}
		$raw = @file_get_contents($file);
		$data = json_decode((string) $raw, TRUE);
		if (!is_array($data) || !isset($data['count'], $data['first_at']) || (time() - (int) $data['first_at']) > $window) {
			return array('count' => 0, 'first_at' => time());
		}
		return array('count' => (int) $data['count'], 'first_at' => (int) $data['first_at']);
	}

	protected function is_login_rate_limited($ip, $username) {
		foreach ($this->get_rate_limit_keys($ip, $username) as $cfg) {
			$rec = $this->read_attempt_record($cfg['file'], $cfg['window']);
			if ($rec['count'] >= $cfg['max']) {
				return TRUE;
			}
		}
		return FALSE;
	}

	protected function record_failed_login($ip, $username) {
		foreach ($this->get_rate_limit_keys($ip, $username) as $cfg) {
			$rec = $this->read_attempt_record($cfg['file'], $cfg['window']);
			$rec['count'] += 1;
			@file_put_contents($cfg['file'], json_encode($rec), LOCK_EX);
		}
	}

	protected function clear_login_attempts($ip, $username) {
		$keys = $this->get_rate_limit_keys($ip, $username);
		if (file_exists($keys['user']['file'])) {
			@unlink($keys['user']['file']);
		}
	}
	function logout() {
		if ($this->session->userdata('s_login') == FALSE) {
			redirect('usrlogin');
		}else{
			$this->session->set_userdata('s_login');
			$this->session->set_userdata('s_id_user');
			$this->session->set_userdata('s_id_px');
			$this->session->set_userdata('s_px_norm');
			$this->session->set_userdata('s_px_name');
			$this->session->sess_destroy();
			redirect('usrlogin');
		}
	}
	/* OLD */
	protected function do_login() {
		if ($this->session->userdata('s_login') == FALSE) {
			if($_POST){
				$gagalLogin = TRUE;
				$pxNoRm = $_POST['pxNoRm'];
				$pxPassword = $_POST['pxPassword'];
				$where = array(
		            'px_norm' => $pxNoRm
		        );
			    $pxLogin = $this->M_login->get_px($where);
			    if ($pxLogin->num_rows() > 0) {
					if (password_verify($pxPassword, $pxLogin->row()->px_password)) {
						/* create session */
						$this->session->set_userdata(array(
							's_login'	=> TRUE,
							's_id_px' 	=> $pxLogin->row()->id_px,
							's_px_norm'	=> $pxLogin->row()->px_norm,
							's_name'	=> $pxLogin->row()->px_name,
							's_role'	=> 2,
						));
						// var_dump($pxLogin->row()->px_norm);
						$gagalLogin = FALSE;
						$datajson = array(
							'status' => TRUE,
							'message' => 'Login Berhasil!'
						);					
					}
				}
				if($gagalLogin) {
					$datajson = array(
						'status' => FALSE,
						'message' => 'No. RM atau Password Salah!'
					);
				}
				echo json_encode($datajson);
			}else{
				$this->index();
			}
		}else{
			redirect('dashboard');
		}
	}
	protected function register() {
		if ($this->session->userdata('s_login') == FALSE) {
			$this->load->view('auth/register');
		}else{
			redirect('dashboard');
		}
	}
	protected function get_px() {
		if ($this->session->userdata('s_login') == FALSE) {
			$pxNoRm = $_POST['pxNoRm'];
			$pxBirthDate = $_POST['pxBirthDate'];
			if (!empty($pxNoRm) && !empty($pxBirthDate)) {
			    $where = array(
		            'px_norm' => $pxNoRm,
		            'px_birthdate' => $pxBirthDate
		        );
			    /* cek di database local */
			    if ($this->M_login->get_px($where)->num_rows() > 0) {
			    	$datajson = array(
						'status' => FALSE,
						'message' => 'Data pasien telah terdaftar!'
					);
			    }else{
					$data = $this->M_login->get_px_postgre($where);
					if ($data->num_rows() > 0) {
						$datajson = array(
							'status' => TRUE,
							'px' => $data->row()
						);
					}else{
						$datajson = array(
							'status' => FALSE,
							'message' => 'Data pasien tidak ditemukan!'
						);
					}
			    }
			} else {
				$datajson = array(
					'status' => FALSE,
					'message' => 'Data tidak boleh kosong'
				);
			}
			echo json_encode($datajson);
		}else{
			redirect('dashboard');
		}
	}
	protected function simpan_register() {
		if ($this->session->userdata('s_login') == FALSE) {
			if($_POST){
				$pxPhone = $_POST['pxPhone'];
				/* cek angka 0 didepan pada pxPhone */
				if(substr($pxPhone, 0, 1) != '0') {
					$pxPhone = '0'.$pxPhone;
				}
	 			$hash = password_hash($_POST['pxPassword'], PASSWORD_DEFAULT);
				$data = array(
					'px_norm' 		=> $_POST['pxNoRm'],
					'px_noktp' 		=> $_POST['pxNoKtp'],
					'px_name' 		=> $_POST['pxName'],
					'px_birthdate' 	=> $_POST['pxBirthDate'],
					'px_phone' 		=> $pxPhone,
					'px_email' 		=> $_POST['pxEmail'],
					'px_address' 	=> $_POST['pxAddress'],
					'px_password' 	=> $hash,
					// 'px_norm' 		=> '000001',
					// 'px_noktp' 		=> '1234567890',
					// 'px_name' 		=> 'User Administrator',
					// 'px_birthdate' 	=> '9999-99-99',
					// 'px_phone' 		=> '0123456789',
					// 'px_email' 		=> '-',
					// 'px_address' 	=> '- - -',
					// 'px_password' 	=> '$2y$10$0zVPGeC6QUPo5g0n7CMbrODNbtlpw6w.4rWX9bQQA.fwsAcZiTp3m',
				);
				$result = $this->M_login->add_px($data);
				if ($result) {
					$datajson = array(
						'status' => TRUE,
						'message' => 'Data berhasil disimpan!'
					);
				}else{
					$datajson = array(
						'status' => FALSE,
						'message' => 'Data gagal disimpan, coba beberapa saat lagi!'
					);
				}
				echo json_encode($datajson);
			}else{
				$this->register();
			}
		}else{
			redirect('dashboard');
		}
	}
}
