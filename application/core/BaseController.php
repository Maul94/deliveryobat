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

    function secure() {
        if ($this->session->userdata('s_login') == TRUE) {
            return TRUE;
        }else{
            redirect('login');
            // return FALSE;
        }
    }
    
    function load_views($viewName = "", $headerInfo = NULL, $pageInfo = NULL, $footerInfo = NULL){
        $this->load->view('include/header', $headerInfo);
        $this->load->view($viewName, $pageInfo);
        $this->load->view('include/footer', $footerInfo);
    }

    function add_notif($ntf_for_patient, $ntf_title, $ntf_text, $ntf_detail, $ntf_status) {
        $this->load->model('M_dashboard');
        return $this->M_dashboard->add_notif($ntf_for_patient, $ntf_title, $ntf_text, $ntf_detail, $ntf_status);
    }

    function update_notif($ntf_for_patient, $ntf_title, $ntf_text, $ntf_detail, $ntf_status) {
        $this->load->model('M_dashboard');
        return $this->M_dashboard->add_notif($ntf_for_patient, $ntf_title, $ntf_text, $ntf_detail, $ntf_status);
    }

    function input_error() {
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
    function success($pesan = "Data berhasil ditambahkan", $tambahan = null, $title = "Sukses") {
        $json['status']       = 1;
        $json['alert']        = 'success';
        $json['pesan']        = $pesan;
        $json['title']        = $title;
        $json['tambahan']     = $tambahan;
        echo json_encode($json);
    }

    //alert error
    function error($pesan = "Data tidak diproses!", $title = "Peringatan!") {
        $json['status']   = 2;
        $json['alert']    = 'warning';
        $json['pesan']    = $pesan;
        $json['title']    = $title;
        echo json_encode($json);
    }
    
    function clean_tag_input($str) {
        $t = preg_replace('/<[^<|>]+?>/', '', htmlspecialchars_decode($str));
        $t = htmlentities($t, ENT_QUOTES, "UTF-8");
        $t = trim($t);
        return $t;
    }

    function bln_indo($tanggal){
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
        $pecahkan = explode('-', $tanggal);
        
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