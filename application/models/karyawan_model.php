    <?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    class Karyawan_model extends CI_Model {
        public function __construct() {
            parent::__construct();
        }

        public function getAbsensiByUserId($user_id) {
            $this->db->where('id_karyawan', $user_id);
            return $this->db->get('absensi')->result();
        }

        function get_data($table){
            return $this->db->get($table);
        }
        
        public function get_by_id($table, $field, $id) {
            return $this->db->get_where($table, array($field => $id))->row();
        }    

        public function update($table, $data, $where)
        {
            $data = $this->db->update($table, $data, $where);
            return $this->db->affected_rows();
        }

        public function tambah_data($table, $data)
        {
            $this->db->insert($table, $data);
            return $this->db->insert_id();
        }

        public function getAbsensiById($absen_id) {
            return $this->db->get_where('absensi', array('id' => $absen_id))->row();
        }    

        public function addAbsensi($data) {
            $user_id = $data['id_karyawan'];
            $tanggal_hari_ini = date('Y-m-d');
            
            // Cek apakah sudah ada absensi untuk karyawan pada hari ini
            $existing_absensi = $this->db
                ->where('id_karyawan', $user_id)
                ->where('tanggal', $tanggal_hari_ini)
                ->get('absensi')
                ->row();
        
            if (!$existing_absensi) {
                // Jika belum ada absensi untuk karyawan pada hari ini, tambahkan absensi baru
                $data['tanggal'] = $tanggal_hari_ini;
                $data['jam_masuk'] = date('H:i:s');
                $data['status'] = 'Hadir';
        
                $this->db->insert('absensi', $data);
        
                // Kembalikan ID dari data yang baru saja ditambahkan
                return $this->db->insert_id();
            } else {
                // Jika sudah ada absensi pada hari ini, Anda dapat memberikan pesan kesalahan atau melakukan tindakan lain sesuai kebutuhan Anda.
                // Contoh:
                return false; // Mengembalikan nilai false untuk menandakan kesalahan
            }
        }
        
        public function getExistingAbsensi($user_id) {
            $today = date('Y-m-d');
            $this->db->where('id_karyawan', $user_id);
            $this->db->where('tanggal', $today);
            return $this->db->get('absensi')->row();
        }
        

        public function setAbsensiPulang($absen_id) {
            // Fungsi ini digunakan untuk mengisi jam pulang dan mengubah status menjadi "pulang".
            $data = array(
                'jam_pulang' => date('H:i:s'),
                'status' => 'pulang'
            );

            // Ubah data absensi berdasarkan absen_id.
            $this->db->where('id', $absen_id);
            $this->db->update('absensi', $data);
        }

        public function addIzin($data) {
            // Fungsi ini digunakan untuk menambahkan izin.
            // Anda dapat mengisi tanggal saat ini sebagai tanggal izin.
            // Anda juga perlu mengatur status ke "done" dan jam masuk serta jam pulang ke NULL.
        
            $data = array(
                'id_karyawan' => $data['id_karyawan'], // Menggunakan data dari parameter
                'keterangan_izin' => $data['keterangan'],      // Menggunakan data dari parameter
                'tanggal' => date('Y-m-d'),
                'kegiatan' => '-',
                'jam_masuk' => '-',
                'jam_pulang' => '-',
                'status' => 'Izin'
            );
        
            // Selanjutnya, masukkan data ini ke tabel "absensi".
            $this->db->insert('absensi', $data);
        }

       

        public function updateAbsensi($absen_id, $data) {
            // Perbarui data absensi berdasarkan $absen_id
            $this->db->where('id', $absen_id);
            $this->db->update('absensi', $data);
        }

        public function batalPulang($absen_id) {
            $data = array(
                'jam_pulang' => null,
                'status' => 'Hadir'
            );
        
            $this->db->where('id', $absen_id);
            $this->db->update('absensi', $data);
        }

        public function get_user_data($user_id) {
            // Mengambil data pengguna dari database (termasuk informasi foto profil)
            $query = $this->db->get_where('user', ['id' => $user_id]);
            return $query->row(); // Mengembalikan data pengguna sebagai objek
        }
        

    }
