<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_model extends CI_Model {
    public function __construct() {
        parent::__construct();
    }

    function get_data($table){
        return $this->db->get($table);
    }

    public function getKaryawan() {
        $query = $this->db->get('absensi');
        return $query->result_array();
    }

    public function get_by_id($table, $field, $id) {
        return $this->db->get_where($table, array($field => $id))->row();
    }    

    public function update($table, $data, $where)
    {
        $data = $this->db->update($table, $data, $where);
        return $this->db->affected_rows();
    }

    function get_karyawan_data(){
        $this->db->where('role', 'karyawan'); // Filter berdasarkan peran "karyawan"
        return $this->db->get('user')->result();
    }
    

    public function hapusAbsensi($absen_id) {
        $this->db->where('id', $absen_id);
        $this->db->delete('absensi');
    }    

        public function getHarianData($tanggal) {
            $this->db->select('absensi.id, user.username, absensi.kegiatan, absensi.tanggal as date, absensi.jam_masuk, absensi.jam_pulang, absensi.keterangan_izin, absensi.status');
            $this->db->from('absensi');
            $this->db->join('user', 'user.id = absensi.id_karyawan', 'left');
            $this->db->where('absensi.tanggal', $tanggal);
        
            $query = $this->db->get();
        
            return $query->result();

        }

    public function getMingguanData($tanggal_awal, $tanggal_akhir) {
        $this->db->select('absensi.id, user.username, absensi.kegiatan, absensi.tanggal as date, absensi.jam_masuk, absensi.jam_pulang, absensi.keterangan_izin, absensi.status');
        $this->db->from('absensi');
        $this->db->join('user', 'user.id = absensi.id_karyawan', 'left');
        $this->db->where("WEEK(absensi.tanggal, 3) BETWEEN $tanggal_awal AND $tanggal_akhir");
    
        $query = $this->db->get();
    
        return $query->result();
    }

    public function getBulananData($bulan)
    {
        $this->db->select("absensi.*, user.username");
        $this->db->from("absensi");
        $this->db->join("user", "absensi.id_karyawan = user.id", "left");
        $this->db->where("DATE_FORMAT(tanggal, '%Y-%m') = '$bulan'");
        $query = $this->db->get();
        return $query->result();
    }

    public function getRekapHarian($tanggal) {
        $this->db->select('absensi.id, absensi.tanggal, absensi.kegiatan, absensi.id_karyawan, absensi.jam_masuk, absensi.jam_pulang, absensi.status');
        $this->db->from('absensi');
        $this->db->where('absensi.tanggal', $tanggal); // Menyaring data berdasarkan tanggal
        $query = $this->db->get();
        return $query->result_array();
    }
    
    public function getAbsensiLast7Days() {
        $this->load->database();
        $end_tanggal = date('Y-m-d');
        $start_tanggal = date('Y-m-d', strtotime('-7 days', strtotime($end_tanggal)));            
        $query = $this->db->select('tanggal, kegiatan, jam_masuk, jam_pulang, keterangan_izin, status, COUNT(*) AS total_absences')
                            ->from('absensi')
                            ->where('tanggal >=', $start_tanggal)
                            ->where('tanggal <=', $end_tanggal)
                            ->group_by('tanggal, kegiatan, jam_masuk, jam_pulang, keterangan_izin, status')
                            ->get();

        return $query->result_array();
    }
    
    
    public function getRekapBulanan($bulan) {
        $this->db->select('MONTH(tanggal) as bulan, COUNT(*) as total_absensi');
        $this->db->from('absensi');
        $this->db->where('MONTH(tanggal)', $bulan); // Menyaring data berdasarkan bulan
        $this->db->group_by('bulan');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getRekapHarianByBulan($bulan) {
        $this->db->select('absensi.id, absensi.tanggal, absensi.kegiatan, absensi.id_karyawan, absensi.jam_masuk, absensi.jam_pulang, absensi.status');
        $this->db->from('absensi');
        $this->db->where('MONTH(absensi.tanggal)', $bulan);
        $query = $this->db->get();
        return $query->result_array();
    }    
    
    public function getExportKaryawan() {
        $this->db->select('absensi.id, user.username, absensi.kegiatan, absensi.tanggal, absensi.jam_masuk, absensi.jam_pulang, absensi.status');
        $this->db->from('absensi');
        $this->db->join('user', 'user.id = absensi.id_karyawan', 'left');
        $query = $this->db->get();
        
        return $query->result();
    }

    public function get_user_data($user_id) {
            // Mengambil data pengguna dari database (termasuk informasi foto profil)
            $query = $this->db->get_where('user', ['id' => $user_id]);
            return $query->row(); // Mengembalikan data pengguna sebagai objek
        }
        
    public function getAbsensiByDateRange($tanggalMulai, $tanggalAkhir) {
            $this->db->select('absensi.id, user.username, absensi.kegiatan, absensi.tanggal, absensi.jam_masuk, absensi.jam_pulang, absensi.keterangan_izin, absensi.status');
            $this->db->from('absensi');
            $this->db->join('user', 'user.id = absensi.id_karyawan', 'left');
            $this->db->where('absensi.tanggal >=', $tanggalMulai);
            $this->db->where('absensi.tanggal <=', $tanggalAkhir);
        
            $query = $this->db->get();
        
            return $query->result();
        }
        

   
    
}
