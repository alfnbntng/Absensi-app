<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {
    function __construct(){
        parent::__construct(); 
        $this->load->library('form_validation');
        $this->load->model('m_model');
    } 

    public function register_admin() {
        $this->load->view('auth/register_admin');
    }
    
    public function register_karyawan() {
        $this->load->view('auth/register_karyawan');
    }
    
    public function index() { 
        $this->load->view('auth/login'); 
    } 

    public function process_login() {
        $this->form_validation->set_rules('email', 'Email', 'trim|required|regex_match[/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/]');
        $this->form_validation->set_rules('password', 'Password', 'required|regex_match[/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{8,}$/]');
    
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('auth/login');
        } else {
            $email = $this->input->post('email', true);
            $password = $this->input->post('password', true);
            $data = ['email' => $email];
            $query = $this->m_model->getwhere('user', $data);
            $result = $query->row_array();
    
            if (!empty($result) && md5($password) === $result['password']) {
                $data = [
                    'logged_in' => TRUE,
                    'email' => $result['email'],
                    'username' => $result['username'],
                    'role' => $result['role'],
                    'id' => $result['id'],
                ];
                $this->session->set_userdata($data);
                if ($this->session->userdata('role') == 'admin') {
                    redirect(base_url() . 'admin');
                }elseif($this->session->userdata('role') == 'karyawan'){ 
                    redirect(base_url() . 'karyawan');
                } else {
                    redirect(base_url() . 'auth');
                }
            } else {
                // Set pesan kesalahan
                $data['login_error'] = 'Email atau kata sandi salah';
                $this->load->view('auth/login', $data);
                return;
            }
        }
    }
    
    public function process_register_karyawan() {
        $this->form_validation->set_rules('email', 'Email', 'trim|required|regex_match[/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/]');
        $this->form_validation->set_rules('password', 'Password', 'required|regex_match[/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{8,}$/]');
    
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('auth/register_karyawan');
        } else {
            $email = $this->input->post('email');
            $username = $this->input->post('username');
    
            // Periksa apakah email atau username sudah ada
            $email_exists = $this->m_model->userExists('email', $email);
            $username_exists = $this->m_model->userExists('username', $username);
    
            if ($email_exists) {
                $this->session->set_flashdata('error_message', 'Email sudah digunakan!');
                redirect('auth/register_karyawan');
            } elseif ($username_exists) {
                $this->session->set_flashdata('error_message', 'Username sudah digunakan!');
                redirect('auth/register_karyawan');
            } else  {
                // Jika tidak ada email atau username yang digunakan, lanjutkan pendaftaran
                $hashed_password = md5($this->input->post('password'));
    
                $data = [
                    'username' => $username,
                    'first_name' => $this->input->post('first_name'),
                    'last_name' => $this->input->post('last_name'),
                    'email' => $email,
                    'password' => $hashed_password,
                    'role' => 'karyawan',
                    'image' => 'images/admin/user.png'
                ];
    
                $this->db->insert('user', $data);
                
                $this->session->set_flashdata('success_message', 'Registrasi berhasil! Anda telah mendaftar sebagai karyawan.');
                redirect('auth');
            }
        }
    }
    
    

    public function process_register_admin() {
        $this->form_validation->set_rules('email', 'Email', 'trim|required|regex_match[/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/]');
        $this->form_validation->set_rules('password', 'Password', 'required|regex_match[/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{8,}$/]');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('auth/register');
        } else {
            $hashed_password = md5($this->input->post('password'));

            $data = [
                'username' => $this->input->post('username'),
                'first_name' => $this->input->post('first_name'),
                'last_name' => $this->input->post('last_name'),
                'email' => $this->input->post('email'),
                'password' => $hashed_password,
                'role' => 'admin',
                'image' =>'images/admin/user.png'
            ];

            $this->db->insert('user', $data);

            redirect(base_url('auth'));
        }
    }

    function logout() { 
        $this->session->sess_destroy(); 
        redirect(base_url('auth')); 
    } 
}