<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Admin extends CI_Controller {
    public function __construct() {
        parent::__construct();
        // Load model yang diperlukan
        $this->load->model('admin_model');
        $this->load->helper('my_helper');
        $this->load->library('form_validation');
    }

    public function index() {
            // Set zona waktu ke 'Asia/Jakarta'
            date_default_timezone_set('Asia/Jakarta');
    
            $absensi = $this->admin_model->get_data('absensi')->result();
    
            $totalIzin = $this->hitungTotalIzin($absensi);
            $totalMasuk = $this->hitungTotalMasuk($absensi);
            $totalKeseluruhan = count($absensi);
    
            $data['absensi'] = $absensi;
            $data['totalIzin'] = $totalIzin;
            $data['totalMasuk'] = $totalMasuk;
            $data['totalKeseluruhan'] = $totalKeseluruhan;
    
            $this->load->view('admin/dashboard', $data);
    
    }

    public function daftar_karyawan() {
        $tanggalMulai = $this->input->get('tanggalMulai');
        $tanggalAkhir = $this->input->get('tanggalAkhir');
    
        if (!empty($tanggalMulai) && !empty($tanggalAkhir)) {
            $data['absensi'] = $this->admin_model->getAbsensiByDateRange($tanggalMulai, $tanggalAkhir);
        } else {
            $data['absensi'] = $this->admin_model->getKaryawan();
        }
    
        $this->load->view('admin/daftar_karyawan', $data);
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

    public function hapus($absen_id) {
        $this->admin_model->hapusAbsensi($absen_id);
        redirect('admin/daftar_karyawan');
}

    public function export_karyawan()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $style_col = [
            'font' => ['bold' => true],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\style\Alignment::VERTICAL_CENTER
            ],
            'borders' => [
                'top' => ['borderstyle' => \PhpOffice\PhpSpreadsheet\style\Border::BORDER_THIN],
                'right' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                'bottom' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                'left' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\style\Border::BORDER_THIN]
            ]
        ];

            $style_row = [
                'alignment' => [
                    'vertical' => \PhpOffice\PhpSpreadsheet\style\Alignment::VERTICAL_CENTER
                ],
                'borders' => [
                    'top' => ['borderstyle' => \PhpOffice\PhpSpreadsheet\style\Border::BORDER_THIN],
                    'right' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\style\Border::BORDER_THIN],
                    'bottom' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\style\Border::BORDER_THIN],
                    'left' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\style\Border::BORDER_THIN]
                ]
            ];

        // set judul
        $sheet->setCellValue('A1', "DATA ABSESNI KARYAWAN");
        $sheet->mergeCells('A1:E1');
        $sheet->getStyle('A1')->getFont()->setBold(true);
        // set thead
        $sheet->setCellValue('A3', "ID");
        $sheet->setCellValue('B3', "NAMA KARYAWAN");
        $sheet->setCellValue('C3', "KEGIATAN");
        $sheet->setCellValue('D3', "TANGGAL");
        $sheet->setCellValue('E3', "JAM MASUK");
        $sheet->setCellValue('F3', "JAM PULANG");
        $sheet->setCellValue('G3', "STATUS");

        // mengaplikasikan style thead
        $sheet->getStyle('A3')->applyFromArray($style_col);
        $sheet->getStyle('B3')->applyFromArray($style_col);
        $sheet->getStyle('C3')->applyFromArray($style_col);
        $sheet->getStyle('D3')->applyFromArray($style_col);
        $sheet->getStyle('E3')->applyFromArray($style_col);
        $sheet->getStyle('F3')->applyFromArray($style_col);
        $sheet->getStyle('G3')->applyFromArray($style_col);

        // get dari database
        $data_siswa = $this->admin_model->getExportKaryawan();

        $no = 1;
        $numrow = 4;
        foreach ($data_siswa as $data) {
            $sheet->setCellValue('A' . $numrow, $data->id);
            $sheet->setCellValue('B' . $numrow, $data->username);
            $sheet->setCellValue('C' . $numrow, $data->kegiatan);
            $sheet->setCellValue('D' . $numrow, $data->tanggal);
            $sheet->setCellValue('E' . $numrow, $data->jam_masuk);
            $sheet->setCellValue('F' . $numrow, $data->jam_pulang);
            $sheet->setCellValue('G' . $numrow, $data->status);

            $sheet->getStyle('A' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('B' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('C' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('D' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('E' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('F' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('G' . $numrow)->applyFromArray($style_row);

            $no++;
            $numrow++;
        }

        // set panjang column
        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->getColumnDimension('B')->setWidth(25);
        $sheet->getColumnDimension('C')->setWidth(25);
        $sheet->getColumnDimension('D')->setWidth(25);
        $sheet->getColumnDimension('E')->setWidth(30);
        $sheet->getColumnDimension('F')->setWidth(30);
        $sheet->getColumnDimension('G')->setWidth(25);

        $sheet->getDefaultRowDimension()->setRowHeight(-1);

        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);

        // set nama file saat di export
        $sheet->setTitle("LAPORAN DATA PEMBAYARAN");
        header('Content-Type: aplication/vnd.openxmlformants-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="KARYAWAN.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');

    }

    public function rekap_harian() {
        $tanggal = $this->input->get('tanggal'); 
        $data['tanggal'] = $tanggal;
        $data['rekap_harian'] = $this->admin_model->getRekapHarian($tanggal);
        $this->load->view('admin/rekap_harian', $data);
    }
    
    
    public function rekap_mingguan() {
        $tanggal = $this->input->get('tanggal'); // Ambil tanggal dari parameter GET
        $data['tanggal'] = $tanggal; // Menyimpan tanggal ke dalam data untuk tampilan
        $data['absensi'] = $this->admin_model->getAbsensiLast7Days();     
        $this->load->view('admin/rekap_mingguan', $data);
    }
    
    
    public function rekap_bulanan() {
        $data['bulan'] = $this->input->get('bulan');
        $bulan = $this->input->get('bulan'); 
        $data['rekap_bulanan'] = $this->admin_model->getRekapBulanan($bulan);
        $data['rekap_harian'] = $this->admin_model->getRekapHarianByBulan($bulan);
        $this->load->view('admin/rekap_bulanan', $data);
    }
    
    public function export_rekap_harian() {
        $tanggal = $this->input->get('tanggal');
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        if (!empty($tanggal)) {
            $style_col = [
                'font' => ['bold' => true],
                'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
                'borders' => ['outline' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]],
            ];
    
            $style_row = [
                'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT],
                'borders' => ['outline' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]],
            ];
    
            $sheet->setCellValue('A1', "DATA ABSEN KARYAWAN");
            $sheet->mergeCells('A1:H1');
            $sheet->getStyle('A1')->getFont()->setBold(true);
    
            $sheet->setCellValue('A3', "No");
            $sheet->setCellValue('B3', "NAMA KARYAWAN");
            $sheet->setCellValue('C3', "KEGIATAN");
            $sheet->setCellValue('D3', "TANGGAL MASUK");
            $sheet->setCellValue('E3', "JAM MASUK");
            $sheet->setCellValue('F3', "JAM PULANG");
            $sheet->setCellValue('G3', "KETERANGAN IZIN");
            $sheet->setCellValue('H3', "STATUS");
    
            $sheet->getStyle('A3:H3')->applyFromArray($style_col);
    
            $data = $this->admin_model->getHarianData($tanggal);
            $no = 1;
            $numrow = 4;
    
            foreach ($data as $row) {
                $sheet->setCellValue('A' . $numrow, $no);
                $sheet->setCellValue('B' . $numrow, $row->username);
                $sheet->setCellValue('C' . $numrow, $row->kegiatan);
                $sheet->setCellValue('D' . $numrow, $row->date);
                $sheet->setCellValue('E' . $numrow, $row->jam_masuk);
                $sheet->setCellValue('F' . $numrow, $row->jam_pulang);
                $sheet->setCellValue('G' . $numrow, $row->keterangan_izin);
                $sheet->setCellValue('H' . $numrow, $row->status);
    
                $sheet->getStyle('A' . $numrow . ':H' . $numrow)->applyFromArray($style_row);
    
                $no++;
                $numrow++;
            }

            $sheet->getColumnDimension('A')->setWidth(5);
            $sheet->getColumnDimension('B')->setWidth(25);
            $sheet->getColumnDimension('C')->setWidth(50);
            $sheet->getColumnDimension('D')->setWidth(20);
            $sheet->getColumnDimension('E')->setWidth(30);
            $sheet->getColumnDimension('F')->setWidth(30);
            $sheet->getColumnDimension('G')->setWidth(30);
            $sheet->getColumnDimension('H')->setWidth(30);
    
    
            $sheet->calculateColumnWidths();
            $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
    
            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
    
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment; filename="Rekap_Harian.xlsx"');
            header('Cache-Control: max-age=0');
    
            $writer->save('php://output');
        }
    }
    
    
    public function export_rekap_mingguan() {
        $tanggal_akhir = date('Y-m-d');
        $tanggal_awal = date('Y-m-d', strtotime('-7 days', strtotime($tanggal_akhir)));
        $tanggal_awal = date('W', strtotime($tanggal_awal));
        $tanggal_akhir = date('W', strtotime($tanggal_akhir));
    
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
    
        if (!empty($tanggal_awal) && !empty($tanggal_akhir)) {
            $style_col = [
                'font' => ['bold' => true],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
                ],
                'borders' => [
                    'top' => ['borderstyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                    'right' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                    'bottom' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                    'left' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]
                ]
            ];
    
            $style_row = [
                'alignment' => [
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
                ],
                'borders' => [
                    'top' => ['borderstyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                    'right' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                    'bottom' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                    'left' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]
                ]
            ];
    
            $sheet->setCellValue('A1', "DATA ABSEN KARYAWAN");
            $sheet->mergeCells('A1:H1');
            $sheet->getStyle('A1')->getFont()->setBold(true);
    
            $sheet->setCellValue('A3', "ID");
            $sheet->setCellValue('B3', "NAMA KARYAWAN");
            $sheet->setCellValue('C3', "KEGIATAN");
            $sheet->setCellValue('D3', "TANGGAL MASUK");
            $sheet->setCellValue('E3', "JAM MASUK");
            $sheet->setCellValue('F3', "JAM PULANG");
            $sheet->setCellValue('G3', "KETERANGAN IZIN");
            $sheet->setCellValue('H3', "STATUS");
    
            $sheet->getStyle('A3')->applyFromArray($style_col);
            $sheet->getStyle('B3')->applyFromArray($style_col);
            $sheet->getStyle('C3')->applyFromArray($style_col);
            $sheet->getStyle('D3')->applyFromArray($style_col);
            $sheet->getStyle('E3')->applyFromArray($style_col);
            $sheet->getStyle('F3')->applyFromArray($style_col);
            $sheet->getStyle('G3')->applyFromArray($style_col);
            $sheet->getStyle('H3')->applyFromArray($style_col);
    
            $data = $this->admin_model->getMingguanData($tanggal_awal, $tanggal_akhir);
    
            $no = 1;
            $numrow = 4;
            foreach ($data as $row) {
                $sheet->setCellValue('A' . $numrow, $no);
                $sheet->setCellValue('B' . $numrow, $row->username);
                $sheet->setCellValue('C' . $numrow, $row->kegiatan);
                $sheet->setCellValue('D' . $numrow, $row->date);
                $sheet->setCellValue('E' . $numrow, $row->jam_masuk);
                $sheet->setCellValue('F' . $numrow, $row->jam_pulang);
                $sheet->setCellValue('G' . $numrow, $row->keterangan_izin);
                $sheet->setCellValue('H' . $numrow, $row->status);
    
                $sheet->getStyle('A' . $numrow)->applyFromArray($style_row);
                $sheet->getStyle('B' . $numrow)->applyFromArray($style_row);
                $sheet->getStyle('C' . $numrow)->applyFromArray($style_row);
                $sheet->getStyle('D' . $numrow)->applyFromArray($style_row);
                $sheet->getStyle('E' . $numrow)->applyFromArray($style_row);
                $sheet->getStyle('F' . $numrow)->applyFromArray($style_row);
                $sheet->getStyle('G' . $numrow)->applyFromArray($style_row);
                $sheet->getStyle('H' . $numrow)->applyFromArray($style_row);
    
                $no++;
                $numrow++;
            }
    
            $sheet->getColumnDimension('A')->setWidth(5);
            $sheet->getColumnDimension('B')->setWidth(25);
            $sheet->getColumnDimension('C')->setWidth(50);
            $sheet->getColumnDimension('D')->setWidth(20);
            $sheet->getColumnDimension('E')->setWidth(30);
            $sheet->getColumnDimension('F')->setWidth(30);
            $sheet->getColumnDimension('G')->setWidth(30);
            $sheet->getColumnDimension('H')->setWidth(30);
    
            $sheet->getDefaultRowDimension()->setRowHeight(-1);
    
            $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
    
            $sheet->setTitle("LAPORAN DATA ABSEN KARYAWAN");
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment; filename="Rekap_Mingguan.xlsx"');
            header('Cache-Control: max-age=0');
    
            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
            $writer->save('php://output');
        }
    }    
    
    
    public function export_rekap_bulanan()
    {
        $bulan = $this->input->post('bulan');
        $bulan = date('Y-m', strtotime($bulan)); // Ubah format bulan sesuai kebutuhan
        $absensi = $this->admin_model->getBulananData($bulan);
        $file_name = "rekap_bulanan_$bulan.xlsx";

        // Membuat objek Spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Konfigurasi gaya kolom dan baris
        $style_col = [
            'font' => ['bold' => true],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
            ],
            'borders' => [
                'top' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                'right' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                'bottom' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                'left' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]
            ]
        ];

        $style_row = [
            'alignment' => [
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
            ],
            'borders' => [
                'top' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                'right' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                'bottom' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                'left' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]
            ]
        ];

        // Menambahkan judul ke file Excel
        $sheet->setCellValue('A1', "DATA ABSEN KARYAWAN");
        $sheet->mergeCells('A1:E1');
        $sheet->getStyle('A1')->getFont()->setBold(true);

        // Menambahkan header kolom
        $sheet->setCellValue('A3', "ID");
        $sheet->setCellValue('B3', "NAMA KARYAWAN");
        $sheet->setCellValue('C3', "KEGIATAN");
        $sheet->setCellValue('D3', "TANGGAL MASUK");
        $sheet->setCellValue('E3', "JAM MASUK");
        $sheet->setCellValue('F3', "JAM PULANG");
        $sheet->setCellValue('G3', "KETERANGAN IZIN");
        $sheet->setCellValue('H3', "STATUS");

        // Mengaplikasikan gaya kolom pada header
        $sheet->getStyle('A3:H3')->applyFromArray($style_col);

        // Mengisi data dari database
        $no = 1;
        $numrow = 4;
        foreach ($absensi as $data) {
            $sheet->setCellValue('A' . $numrow, $no);
            $sheet->setCellValue('B' . $numrow, $data->username);
            $sheet->setCellValue('C' . $numrow, $data->kegiatan);
            $sheet->setCellValue('D' . $numrow, $data->tanggal);
            $sheet->setCellValue('E' . $numrow, $data->jam_masuk);
            $sheet->setCellValue('F' . $numrow, $data->jam_pulang);
            $sheet->setCellValue('G' . $numrow, $data->keterangan_izin);
            $sheet->setCellValue('H' . $numrow, $data->status);

            // Mengaplikasikan gaya baris pada data
            $sheet->getStyle('A' . $numrow . ':H' . $numrow)->applyFromArray($style_row);

            $no++;
            $numrow++;
        }

        // Mengatur lebar kolom dan orientasi halaman
        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->getColumnDimension('B')->setWidth(25);
        $sheet->getColumnDimension('C')->setWidth(50);
        $sheet->getColumnDimension('D')->setWidth(20);
        $sheet->getColumnDimension('E')->setWidth(30);
        $sheet->getColumnDimension('F')->setWidth(30);
        $sheet->getColumnDimension('G')->setWidth(30);
        $sheet->getColumnDimension('H')->setWidth(30);

        $sheet->getDefaultRowDimension()->setRowHeight(-1);
        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
        $sheet->setTitle("LAPORAN DATA ABSEN KARYAWAN");

        // Mengatur header HTTP untuk mengunduh file Excel
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $file_name . '"');
        header('Cache-Control: max-age=0');

        // Menyimpan file Excel ke output
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save('php://output');
    }


    public function profile() {
        $data['user'] = $this->admin_model->get_user_data($this->session->userdata('id')); // Menggunakan model untuk mengambil data pengguna
        $this->load->view('admin/profile', $data);
    }
    

    public function upload_image($field_name)
    {
        $config['upload_path'] = './images/admin/';
        $config['allowed_types'] = 'jpg|png|jpeg';
        $config['max_size'] = 30000;
        $config['overwrite'] = TRUE; // Menimpa file jika sudah ada

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload($field_name)) {
            $error = array('error' => $this->upload->display_errors());
            return array(false, $error);
        } else {
            $data = $this->upload->data();
            $file_name = $data['file_name'];
            return array(true, $file_name);
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
            $user = $this->admin_model->get_by_id('user', 'id', $user_id);

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

            $update_result = $this->admin_model->update('user', $data, ['id' => $user_id]);

            if ($update_result) {
                redirect('admin/profile');
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Gagal memperbarui profil']);
            }
        }

    public function aksi_ubah_foto()
    {
        $image = $this->upload_image('image'); 
        
        if ($image[0] === false) {
            redirect(base_url('admin/profile'));
        } else {
            $data = [
                'image' => $image[1],
            ];
            
            $this->session->set_userdata('image', $data['image']);
            $update_result = $this->admin_model->update('user', $data, ['id' => $this->session->userdata('id')]);
            
            if ($update_result) {
                redirect(base_url('admin/profile'));
            } else {
                redirect(base_url('admin/profile'));
            }
        }
    }

       
}