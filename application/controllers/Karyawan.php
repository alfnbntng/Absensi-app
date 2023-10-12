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
        if ($this->session->userdata('role') === 'karyawan') {
            $data['absensi'] = $this->karyawan_model->get_data('absensi')->num_rows();
            $data['absensi_data'] = $this->karyawan_model->get_data('absensi')->result();
            $this->load->view('karyawan/dashboard', $data);
        } else {
            redirect('other_page');
        }
    }

    public function history_absen() {
        if ($this->session->userdata('role') === 'karyawan') {
            // Set zona waktu ke 'Asia/Jakarta'
            date_default_timezone_set('Asia/Jakarta');
    
            $data['absensi'] = $this->karyawan_model->get_data('absensi')->result();
            $this->load->view('karyawan/history_absen', $data);
        } else {
            redirect('other_page');
        }
    }
    

    public function menu_absen() {
        if ($this->session->userdata('role') === 'karyawan') {
            $user_id = $this->session->userdata('id'); // Ambil id pengguna yang sedang login
            $this->form_validation->set_rules('kegiatan', 'Kegiatan', 'required');
    
            if ($this->form_validation->run() == FALSE) {
                $this->load->view('karyawan/menu_absen');
            } else {
                date_default_timezone_set('Asia/Jakarta');
                $jam_masuk = date('H:i:s');

                $data = array(
                    'id_karyawan' => $user_id, // Tetapkan id_karyawan berdasarkan pengguna yang sedang login
                    'kegiatan' => $this->input->post('kegiatan'),
                    'tanggal' => date('Y-m-d'),
                    'jam_masuk' => $jam_masuk,
                    'status' => 'belum done',
                    'keterangan_izin' => '-'
                );
    
                // Menambahkan absensi dan mendapatkan ID data yang baru ditambahkan
                $new_absensi_id = $this->karyawan_model->addAbsensi($data);
    
                // Redirect ke halaman history_absen dengan membawa ID baru
                redirect('karyawan/history_absen/' . $new_absensi_id);
            }
        } else {
            redirect('other_page');
        }
    }

    public function menu_izin() {
        if ($this->session->userdata('role') === 'karyawan') {
            $user_id = $this->session->userdata('id');
            $this->form_validation->set_rules('keterangan', 'Keterangan Izin', 'required');
    
            if ($this->form_validation->run() == FALSE) {
                $this->load->view('karyawan/menu_izin');
            } else {
                $data = array(
                    'id_karyawan' => $user_id,
                    'keterangan' => $this->input->post('keterangan'), // Mengambil data dari form input
                );
    
                // Memanggil fungsi untuk menambahkan izin
                $this->karyawan_model->addIzin($data);
    
                // Redirect ke halaman history_absen
                redirect('karyawan/history_absen');
            }
        } else {
            redirect('other_page');
        }
    }
    
    public function pulang($absen_id) {
        if ($this->session->userdata('role') === 'karyawan') {
            $this->karyawan_model->setAbsensiPulang($absen_id);
    
            // Set pesan sukses
            $this->session->set_flashdata('success', 'Jam pulang berhasil diisi.');
    
            // Panggil fungsi JavaScript untuk menampilkan SweetAlert2
            echo '<script>showSweetAlert("Jam pulang berhasil diisi.");</script>';
    
            redirect('karyawan/history_absen');
        } else {
            redirect('other_page');
        }
    } 

    public function ubah_absensi($absen_id) {
        if ($this->session->userdata('role') === 'karyawan') {
            // Mengambil data absensi berdasarkan ID yang diberikan
            $absensi = $this->karyawan_model->getAbsensiById($absen_id);
    
            // Periksa apakah data absensi ditemukan
            if ($absensi) {
                // Mengecek apakah pengguna mengirimkan formulir perubahan
                if ($this->input->post()) {
                    // Lakukan validasi terhadap input
                    $this->form_validation->set_rules('kegiatan', 'Kegiatan', 'required');
                    $this->form_validation->set_rules('jam_masuk', 'Jam Masuk', 'required');
                    $this->form_validation->set_rules('jam_pulang', 'Jam Pulang', 'required');
    
                    if ($this->form_validation->run() === TRUE) {
                        // Dapatkan data input pengguna
                        $kegiatan = $this->input->post('kegiatan');
                        $jam_masuk = $this->input->post('jam_masuk');
                        $jam_pulang = $this->input->post('jam_pulang');
    
                        // Lakukan pembaruan data absensi
                        $data = array(
                            'kegiatan' => $kegiatan,
                            'jam_masuk' => $jam_masuk,
                            'jam_pulang' => $jam_pulang
                        );
    
                        $this->karyawan_model->updateAbsensi($absen_id, $data);
    
                        // Set pesan sukses
                        $this->session->set_flashdata('success', 'Data absensi berhasil diubah.');
    
                        // Redirect kembali ke halaman riwayat absen
                        redirect('karyawan/history_absen');
                    }
                }
    
                $data['absensi'] = $absensi;
                $data['absen_id'] = $absen_id;
                $this->load->view('karyawan/ubah_absensi', $data);
                
            } else {
                // Data absensi tidak ditemukan, tampilkan pesan error
                show_error('Data absensi tidak ditemukan.', 404, 'Data Tidak Ditemukan');
            }
        } else {
            // Pengguna bukan karyawan, redirect ke halaman lain
            redirect('other_page');
        }
    }

    public function batal_pulang($absen_id) {
        if ($this->session->userdata('role') === 'karyawan') {
            $this->karyawan_model->batalPulang($absen_id);
    
            // Set pesan sukses
            $this->session->set_flashdata('success', 'Batal Pulang berhasil.');
    
            // Redirect kembali ke halaman riwayat absen
            redirect('karyawan/history_absen');
        } else {
            redirect('other_page');
        }
    }
    

    public function hapus($absen_id) {
        if ($this->session->userdata('role') === 'karyawan') {
            $this->karyawan_model->hapusAbsensi($absen_id);
            redirect('karyawan/history_absen');
        } else {
            redirect('other_page');
        }
    }
    public function profile() {
        $this->load->view('karyawan/profile');
    }
    
}
