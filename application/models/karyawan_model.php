<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Karyawan_model extends CI_Model {
    public function __construct() {
        parent::__construct();
    }

    function get_data($table){
        return $this->db->get($table);
    }
    
    public function get_by_id($table, $id) {
        return $this->db->get_where($table, array('id' => $id))->row();
    }
    

    public function addAbsensi($data) {
        // Fungsi ini digunakan untuk menambahkan data absensi.
        // Anda dapat mengisi tanggal dan jam masuk sesuai dengan waktu saat ini.
        // Anda juga harus mengatur status ke "belum done".
        $data['tanggal'] = date('Y-m-d');
        $data['jam_masuk'] = date('H:i:s');
        $data['status'] = 'belum done';

        // Selanjutnya, masukkan data ini ke tabel "absensi".
        $this->db->insert('absensi', $data);
    }


    public function setAbsensiPulang($absen_id) {
        // Fungsi ini digunakan untuk mengisi jam pulang dan mengubah status menjadi "done".
        $data = array(
            'jam_pulang' => date('H:i:s'),
            'status' => 'pulang'
        );

        // Ubah data absensi berdasarkan absen_id.
        $this->db->where('id', $absen_id);
        $this->db->update('absensi', $data);
    }

    public function addIzin($user_id, $kegiatan) {
        // Fungsi ini digunakan untuk menambahkan izin.
        // Anda dapat mengisi tanggal saat ini sebagai tanggal izin.
        // Anda juga perlu mengatur status ke "done" dan jam masuk serta jam pulang ke NULL.
        $data = array(
            'id_karyawan' => $user_id,
            'tanggal' => date('Y-m-d'),
            'jam_masuk' => NULL,
            'jam_pulang' => NULL,
            'status' => 'done',
            'kegiatan' => $kegiatan
        );

        // Selanjutnya, masukkan data ini ke tabel "absensi".
        $this->db->insert('absensi', $data);
    }
}

