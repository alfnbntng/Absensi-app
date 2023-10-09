<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {
    function __construct(){
        parent::__construct(); 
        $this->load->library('form_validation');
        $this->load->model('m_model'); 
        $this->load->helper('my_helper'); 
    } 

    public function register() {
        $this->load->view('register');
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
                $query = $this->m_model->getwhere('admin', $data);
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
                        redirect(base_url() . "admin"); 
                    } else { 
                        redirect(base_url() . "auth"); 
                    } 
                } else { 
                    // Set pesan kesalahan
                    $data['login_error'] = 'Email atau kata sandi salah';
                    $this->load->view('auth/login', $data);
                }
            }
    }

    public function process_register() {
        $this->form_validation->set_rules('username', 'Username', 'trim|required|is_unique[admin.username]');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|regex_match[/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/]');
        $this->form_validation->set_rules('password', 'Password', 'required|regex_match[/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{8,}$/]');
        $this->form_validation->set_rules('role', 'Role', 'required');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('register');
        } else {
            $hashed_password = md5($this->input->post('password'));

            $data = [
                'username' => $this->input->post('username'),
                'email' => $this->input->post('email'),
                'password' => $hashed_password,
                'role' => $this->input->post('role')
            ];

            $this->db->insert('admin', $data);

            redirect(base_url('auth'));
        }
    }

    function logout() { 
        $this->session->sess_destroy(); 
        redirect(base_url('auth')); 
    } 
}