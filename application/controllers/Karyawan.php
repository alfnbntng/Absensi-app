<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Karyawan extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('karyawan_model');
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->helper('my_helper');
        $this->load->library('upload');
    }

    public function index() {
            // Set zona waktu ke 'Asia/Jakarta'
            date_default_timezone_set('Asia/Jakarta');
            $jam_pulang = date('H:i:s');
            $user_id = $this->session->userdata('id');
    
            $absensi = $this->karyawan_model->getAbsensiByUserId($user_id);
            $totalIzin = $this->hitungTotalIzin($absensi);
            $totalMasuk = $this->hitungTotalMasuk($absensi);
            $totalKeseluruhan = count($absensi);
    
            $data['absensi'] = $absensi;
            $data['totalIzin'] = $totalIzin;
            $data['totalMasuk'] = $totalMasuk;
            $data['totalKeseluruhan'] = $totalKeseluruhan;
    
            $this->load->view('karyawan/dashboard', $data);
   
    }
    
    private function convertToJakartaTime($utcTime) {
        $utcDateTime = new DateTime($utcTime, new DateTimeZone('UTC'));
        $utcDateTime->setTimezone(new DateTimeZone('Asia/Jakarta'));    
        return $utcDateTime->format('H:i');
    }

    public function history_absen() {
            // Set zona waktu ke 'Asia/Jakarta'
            date_default_timezone_set('Asia/Jakarta');
            
            $user_id = $this->session->userdata('id'); // Ambil ID pengguna yang sedang login
            
            // Ambil data absensi berdasarkan user_id
            $absensi = $this->karyawan_model->getAbsensiByUserId($user_id);
            
            // Lakukan perhitungan total izin dan total masuk
            $totalIzin = $this->hitungTotalIzin($absensi);
            $totalMasuk = $this->hitungTotalMasuk($absensi);
            $totalKeseluruhan = count($absensi);
    
            // Konversi jam pulang dari UTC ke zona waktu Asia/Jakarta
            foreach ($absensi as &$row) {
                $row->jam_pulang = $this->convertToJakartaTime($row->jam_pulang);
            }
    
            $data['absensi'] = $absensi;
            $data['totalIzin'] = $totalIzin;
            $data['totalMasuk'] = $totalMasuk;
            $data['totalKeseluruhan'] = $totalKeseluruhan;
            
            $this->load->view('karyawan/history_absen', $data);

    }
    
    
    private function hitungTotalIzin($absensi) {
        $totalIzin = 0;
        foreach ($absensi as $absen) {
            if ($absen->status === 'Izin') {
                $totalIzin++;
            }
        }
        return $totalIzin;
    }
    
    private function hitungTotalMasuk($absensi) {
        $totalMasuk = 0;
        foreach ($absensi as $absen) {
            if ($absen->status === 'Hadir') {
                $totalMasuk++;
            }
        }
        return $totalMasuk;
    }
    

    public function menu_absen() {
        $user_id = $this->session->userdata('id'); // Ambil ID pengguna yang sedang login
        $this->form_validation->set_rules('kegiatan', 'Kegiatan', 'required');
    
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('karyawan/menu_absen');
        } else {
            date_default_timezone_set('Asia/Jakarta');
            $jam_masuk = date('H:i:s');
            $jam_pulang = date('H:i:s');
    
            // Periksa apakah sudah ada absensi untuk pengguna pada hari ini
            $existing_absensi = $this->karyawan_model->getExistingAbsensi($user_id);
    
            if (!$existing_absensi) {
                $data = array(
                    'id_karyawan' => $user_id, 
                    'kegiatan' => $this->input->post('kegiatan'),
                    'tanggal' => date('d-m-Y'),
                    'jam_masuk' => $jam_masuk,
                    'status' => 'berangkat',
                    'keterangan_izin' => '-'
                );
            
                $new_absensi_id = $this->karyawan_model->addAbsensi($data);
            
                $this->session->set_flashdata('success', 'Absen berhasil ditambahkan.');
            
                redirect('karyawan/history_absen/' . $new_absensi_id);
            } else {
                // Contoh:
                $this->session->set_flashdata('error', 'Anda sudah melakukan absensi hari ini.');
            
                redirect('karyawan/menu_absen');
            }
            
        }
    }
    

    public function menu_izin() {
       
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
     
    }

    public function pulang($absen_id) {
        
            $this->karyawan_model->setAbsensiPulang($absen_id);

            // Set pesan sukses
            $this->session->set_flashdata('success', 'Jam pulang berhasil diisi.');

            // Panggil fungsi JavaScript untuk menampilkan SweetAlert2
            echo '<script>showSweetAlert("Jam pulang berhasil diisi.");</script>';

            redirect('karyawan/history_absen');
     
    }

    public function ubah_absensi($absen_id) {
        
            // Mengambil data absensi berdasarkan ID yang diberikan
            $absensi = $this->karyawan_model->getAbsensiById($absen_id);

            // Periksa apakah data absensi ditemukan
            if ($absensi) {
                // Mengecek apakah pengguna mengirimkan formulir perubahan
                if ($this->input->post()) {
                    $this->form_validation->set_rules('kegiatan', 'Kegiatan', 'required');

                    if ($this->form_validation->run() === TRUE) {
                        $kegiatan = $this->input->post('kegiatan');

                        $data = array(
                            'kegiatan' => $kegiatan,
                        );

                        $this->karyawan_model->updateAbsensi($absen_id, $data);

                        $this->session->set_flashdata('success', 'Data absensi berhasil diubah.');

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
      
    }

    public function batal_pulang($absen_id) {
            $this->karyawan_model->batalPulang($absen_id);

            $this->session->set_flashdata('success', 'Batal Pulang berhasil.');

            redirect('karyawan/history_absen');
    
    }

   

    public function profile() {
        $data['user'] = $this->karyawan_model->get_by_id('user', 'id', $this->session->userdata('id'));
        $this->load->view('karyawan/profile', $data);
    }

    public function upload_image($value)
		{
			$kode = round(microtime(true) * 1000);
			$config['upload_path'] = './images/karyawan/';
			$config['allowed_types'] = 'jpg|png|jpeg';
			$config['max_size'] = 30000;
			$config['file_name'] = $kode;
			$this->upload->initialize($config);
			if (!$this->upload->do_upload($value)) {
				return array(false, '');
			} else {
				$fn = $this->upload->data();
				$nama = $fn['file_name'];
				return array(true, $nama);
			}
		}


    public function aksi_ubah_akun()
        {
            $password_lama = $this->input->post('password_lama');
            $password_baru = $this->input->post('password_baru');
            $konfirmasi_password = $this->input->post('konfirmasi_password');
            $email = $this->input->post('email');
            $username = $this->input->post('username');
            $first_name = $this->input->post('first_name');
            $last_name = $this->input->post('last_name');

            $user_id = $this->session->userdata('id');
            $user = $this->karyawan_model->get_by_id('user', 'id', $user_id);

            // Validasi Password Lama
            if (md5($password_lama) !== $user->password) {
                echo json_encode(['status' => 'error', 'message' => 'Password Lama Salah']);
                exit;
            }

            $data = [
                'email' => $email,
                'username' => $username,
                'first_name' => $first_name,
                'last_name' => $last_name,
            ];

            if (!empty($password_baru)) {
                if ($password_baru === $konfirmasi_password) {
                    $data['password'] = md5($password_baru);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Password Baru dan Konfirmasi Password harus sama']);
                    exit;
                }
            }

            $update_result = $this->karyawan_model->update('user', $data, ['id' => $user_id]);

            if ($update_result) {
                // Redirect ke halaman "karyawan/profile" setelah profil berhasil diperbarui
                redirect('karyawan/profile');
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Gagal memperbarui profil']);
            }
        }

    
    public function aksi_ubah_foto()
        {
            $image = $this->upload_image('image'); 
            
            if ($image[0] === false) {
                redirect(base_url('karyawan/profile'));
            } else {
                $data = [
                    'image' => $image[1],
                ];
                
                $this->session->set_userdata('image', $data['image']);
                $update_result = $this->karyawan_model->update('user', $data, ['id' => $this->session->userdata('id')]);
                
                if ($update_result) {
                    redirect(base_url('karyawan/profile'));
                } else {
                    redirect(base_url('karyawan/profile'));
                }
            }
        }
    

}
