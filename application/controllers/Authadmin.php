<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Authadmin extends CI_Controller
{
    public function index()
    {
        $data = '';
        if ($this->session->userdata('email')) {
            $data = 'Anda Telah Login';
            echo $data; 
        }else{
            $email = $this->input->post('email');
            $password = $this->input->post('password');
            $user = $this->db->get_where('user', ['email' => $email])->row_array();
            
    
            if ($user) {
                    // cek password
                    if (password_verify($password, $user['password'])) {
                        $data = [
                            'email' => $user['email'],
                            'user_id' =>$user['user_id']
                        ];
                        $this->session->set_userdata($data);            
                            $data = 'login berhasil';
                            echo $data;
                        
                    } else {
                        $data = "Login Gagal";
                        echo $data;
                    }
               
            } else {
                $data = "Login Gagal";
                echo $data;
            }
        }
        
       
    }


    public function registration()
    {
        if ($this->session->userdata('email')) {
            redirect('user');
        }

        $data['settings'] = $this->db->query('SELECT * FROM settings WHERE id_system = "1"')->row_array();
        $sett = $this->db->query('SELECT * FROM settings WHERE id_system = "1"')->row_array();

        $this->form_validation->set_rules('name', 'Name', 'required|trim');
        $this->form_validation->set_rules('email2', 'Email', 'required|trim|valid_email|is_unique[user.email]', [
            'is_unique' => 'This email has already registered!'
        ]);
        $this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[6]|matches[password2]', [
            'matches' => 'Password dont match!',
            'min_length' => 'Password too short!'
        ]);
        $this->form_validation->set_rules('password2', 'Password', 'required|trim|matches[password1]');
        $namasistem = $sett['logo_title'];
        // $namasistem = 'Master System';
        if ($this->form_validation->run() == false) {
            $data['title'] = $namasistem . ' Registration';
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/login2', $data);
            $this->load->view('templates/auth_footer', $data);
        } else {
            $email = $this->input->post('email2', true);
            $data = [
                'name' => htmlspecialchars($this->input->post('name', true)),
                'email' => htmlspecialchars($email),
                'image' => 'default.jpg',
                'password' => password_hash($this->input->post('password1'), PASSWORD_DEFAULT),
                'role_id' => 2,
                'is_active' => 0,
                'date_created' => time()
            ];

            // siapkan token
            $token = base64_encode(random_bytes(32));
            $user_token = [
                'email' => $email,
                'token' => $token,
                'date_created' => time()
            ];

            $this->db->insert('user', $data);
            $this->db->insert('user_token', $user_token);

            $this->_sendEmail($token, 'verify');

            $this->session->set_tempdata('message', '<div class="alert alert-success" role="alert">Congratulation! your account has been created. Please activate your account.<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button></div>', 3);
            redirect('auth');
        }
    }

    


    public function logout()
    {
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('role_id');
        $data = 'Anda telah logout';
        echo $data;

    }

    public function registrasi(){
        if ($this->session->userdata('email')) {
            echo 'Anda telah login, registrasi dapat dilakukan sebelum login';
        }else{
            $email = $this->input->post('email', true);
            $username = htmlspecialchars($this->input->post('username', true));
            $password = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
            if($password == NULL || $username == NULL){
                echo 'Input data terlebih dahulu';
            }else{
                $cekusername = $this->db->query("SELECT * FROM user where username = '$username'")->row();
                if($cekusername == NULL){
                    $data = [
                        'username' => $username,
                        'nama' => htmlspecialchars($this->input->post('nama', true)),
                        'email' => htmlspecialchars($email),
                        'password' => $password
                    ];
                    $this->db->insert('user', $data);
                    echo 'Data berhasil ditambahkan';
                }else{
                    echo 'username sudah digunakan';
                }
            }
        }

    }
    public function deleteakun(){
        if ($this->session->userdata('user_id')) {
            $id = $this->session->userdata('user_id');
            $this->db->where('user_id', $id);
            $this->db->delete('user');

            echo 'Data telah dihapus';
           
        }else{
           echo 'Anda tidak dapat menghapus user';
        }

    }

}
