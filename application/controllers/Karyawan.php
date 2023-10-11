<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Karyawan extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('karyawan_model');
        $this->load->library('form_validation');
        $this->load->library('session');
    }

    public function index() {
        // Pemeriksaan peran pengguna menggunakan session
        if ($this->session->userdata('role') === 'karyawan') {
            $data['absensi'] = $this->karyawan_model->get_data('absensi')->num_rows();
            $data['absensi'] = $this->karyawan_model->get_data('absensi')->result();
            $this->load->view('karyawan/dashboard',$data);
        } else {
            redirect('other_page');
        }
    }

    public function history_absen() {
        if ($this->session->userdata('role') === 'karyawan') {
            $data['absensi'] = $this->karyawan_model->get_data('absensi')->result();
            $this->load->view('karyawan/history_absen', $data);
        } else {
            redirect('other_page');
        }
    }

    public function menu_absen() {
        if ($this->session->userdata('role') === 'karyawan') {
            $this->form_validation->set_rules('kegiatan', 'Kegiatan', 'required');

            if ($this->form_validation->run() == FALSE) {
                $this->load->view('karyawan/menu_absen');
            } else {
                $data = array(
                    'kegiatan' => $this->input->post('kegiatan'),
                    'tanggal' => date('Y-m-d'),
                    'jam_masuk' => date('H:i:s'),
                    'status' => 'belum done'
                );

                $this->karyawan_model->addAbsensi($data);
                redirect('karyawan/history_absen');
            }
        } else {
            redirect('other_page');
        }
    }

    public function pulang($absen_id) {
    if ($this->session->userdata('role') === 'karyawan') {
        $this->karyawan_model->setAbsensiPulang($absen_id);
        redirect('karyawan/history_absen');
    } else {
        redirect('other_page');
    }
}

    
}
