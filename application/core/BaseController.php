<?php defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' ); 

date_default_timezone_set('Asia/Jakarta'); /* Fungsi merubah jam */

/**
 * Class : BaseController
 * Base Class to control over all the classes
 * @author : Maulana Akhmady Arief
 * @version : 1.0
 * @since : 22 Desember 2018
 */
class BaseController extends CI_Controller {
    const ROLE_ADMIN = 1;
    const ROLE_DRIVER = 3;
    const RSUD_LAT = -7.4560158877101435;
    const RSUD_LON = 112.39420315449877;

    protected $role = '';
    protected $vendorId = '';
    protected $name = '';
    protected $roleText = '';
    protected $global = array ();

    /**
     * This function used to load views
     * @param {string} $viewName : This is view name
     * @param {mixed} $headerInfo : This is array of header information
     * @param {mixed} $pageInfo : This is array of page information
     * @param {mixed} $footerInfo : This is array of footer information
     * @return {null} $result : null
     */

    protected function secure($allowedRoles = array()) {
        if ($this->session->userdata('s_login') !== TRUE) {
            if ($this->input->is_ajax_request()) {
                $this->output
                    ->set_status_header(401)
                    ->set_content_type('application/json', 'utf-8')
                    ->set_output(json_encode(array(
                        'status' => 0,
                        'alert'  => 'warning',
                        'pesan'  => 'Sesi Anda telah berakhir. Silakan login kembali.',
                        'title'  => 'Unauthorized'
                    )))
                    ->_display();
                exit;
            }
            redirect('login');
        }

        if (!empty($allowedRoles)) {
            $userRole = (int) $this->session->userdata('s_usr_role');
            $allowed = array_map('intval', $allowedRoles);
            if (!in_array($userRole, $allowed, TRUE)) {
                $this->denyAccess();
            }
        }

        return TRUE;
    }

    protected function secure_non_driver() {
        $this->secure();
        if ((int) $this->session->userdata('s_usr_role') === self::ROLE_DRIVER) {
            $this->denyAccess();
        }
        return TRUE;
    }

    protected function require_post() {
        if (strtoupper($_SERVER['REQUEST_METHOD']) !== 'POST') {
            if ($this->input->is_ajax_request()) {
                $this->output
                    ->set_status_header(405)
                    ->set_content_type('application/json', 'utf-8')
                    ->set_output(json_encode(array(
                        'status' => 0,
                        'alert'  => 'warning',
                        'pesan'  => 'Metode request tidak diizinkan.',
                        'title'  => 'Method Not Allowed'
                    )))
                    ->_display();
                exit;
            }
            show_error('Metode request tidak diizinkan.', 405, 'Method Not Allowed');
        }
        return TRUE;
    }

    protected function denyAccess($message = 'Anda tidak memiliki izin untuk mengakses fitur ini.') {
        if ($this->input->is_ajax_request()) {
            $this->output
                ->set_status_header(403)
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode(array(
                    'status' => 0,
                    'alert'  => 'error',
                    'pesan'  => $message,
                    'title'  => 'Akses Ditolak'
                )))
                ->_display();
            exit;
        }
        show_error($message, 403, 'Akses Ditolak');
    }

    protected function calculate_haversine_km($lat1, $lon1, $lat2, $lon2) {
        $earthRadiusKm = 6371.0;
        $dLat = deg2rad((float) $lat2 - (float) $lat1);
        $dLon = deg2rad((float) $lon2 - (float) $lon1);
        $a = sin($dLat / 2) * sin($dLat / 2)
            + cos(deg2rad((float) $lat1)) * cos(deg2rad((float) $lat2))
            * sin($dLon / 2) * sin($dLon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(max(0.0, 1 - $a)));
        return $earthRadiusKm * $c;
    }

    protected function calculate_shipping_fee($distanceKm) {
        $distanceKm = max(0, (int) round((float) $distanceKm));
        if ($distanceKm <= 5) {
            return 10000;
        }
        return 10000 + (($distanceKm - 5) * 2000);
    }

    protected function is_valid_date($dateStr) {
        if (!is_string($dateStr) || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $dateStr)) {
            return FALSE;
        }
        $dt = DateTime::createFromFormat('Y-m-d', $dateStr);
        return $dt !== FALSE && $dt->format('Y-m-d') === $dateStr;
    }
    
    protected function load_views($viewName = "", $headerInfo = NULL, $pageInfo = NULL, $footerInfo = NULL){
        $this->load->view('include/header', $headerInfo);
        $this->load->view($viewName, $pageInfo);
        $this->load->view('include/footer', $footerInfo);
    }

    protected function add_notif($ntf_for_patient, $ntf_title, $ntf_text, $ntf_detail, $ntf_status) {
        $this->load->model('M_dashboard');
        return $this->M_dashboard->add_notif($ntf_for_patient, $ntf_title, $ntf_text, $ntf_detail, $ntf_status);
    }

    protected function update_notif($ntf_for_patient, $ntf_title, $ntf_text, $ntf_detail, $ntf_status) {
        $this->load->model('M_dashboard');
        return $this->M_dashboard->add_notif($ntf_for_patient, $ntf_title, $ntf_text, $ntf_detail, $ntf_status);
    }

    protected function input_error() {
        $json['status'] = 0;
        $json['alert']    = 'warning';
        $json['pesan']  = "<div class='alert alert-warning error_validasi'>".validation_errors()."</div>";
        echo json_encode($json);
    }

    // function query_error($pesan = "Terjadi kesalahan, coba lagi !") {
    //     $json['status'] = 2;
    //     $json['pesan']  = "<div class='alert alert-danger error_validasi'>".$pesan."</div>";
    //     echo json_encode($json);
    // }

    //alert success
    protected function success($pesan = "Data berhasil ditambahkan", $tambahan = null, $title = "Sukses") {
        $json['status']       = 1;
        $json['alert']        = 'success';
        $json['pesan']        = $pesan;
        $json['title']        = $title;
        $json['tambahan']     = $tambahan;
        echo json_encode($json);
    }

    //alert error
    protected function error($pesan = "Data tidak diproses!", $title = "Peringatan!") {
        $json['status']   = 2;
        $json['alert']    = 'warning';
        $json['pesan']    = $pesan;
        $json['title']    = $title;
        echo json_encode($json);
    }
    
    protected function clean_tag_input($str) {
        $t = preg_replace('/<[^<|>]+?>/', '', htmlspecialchars_decode($str));
        $t = htmlentities($t, ENT_QUOTES, "UTF-8");
        $t = trim($t);
        return $t;
    }

    protected function bln_indo($tanggal){
        $bulan = array (
            1 =>   'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        );
        $pecahkan = explode('-', (string) $tanggal);
        if (count($pecahkan) !== 3 || !isset($bulan[(int)$pecahkan[1]])) {
            return html_escape((string) $tanggal);
        }
        
        // variabel pecahkan 0 = tanggal
        // variabel pecahkan 1 = bulan
        // variabel pecahkan 2 = tahun
     
        return $pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
    }

    // function input_notif($link_notif, $isi_notif, $akses_notif) {
        
    //     $this->load->model('m_notif');

    //     $this->m_notif->addNotif($link_notif, $isi_notif, $akses_notif);

    // }

    // function update_notif($link_notif, $isi_notif, $akses_notif) {
        
    //     $this->load->model('m_notif');

    //     $update = $this->m_notif->updateNotif($link_notif, $isi_notif, $akses_notif);

    //     if ($update == false) {

    //         $update = $this->m_notif->addNotif($link_notif, $isi_notif, $akses_notif);

    //     }

    // }
}