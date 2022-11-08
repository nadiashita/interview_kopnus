<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function index()
    {
        $data = '';
        if ($this->session->userdata('email')) {

            if ($this->session->userdata('role') == 1 ) {
                $data = 'login berhasil sebagai admin';
                echo $data;
            } else {
                
                $data = 'Anda telah login';
                echo $data;
            }     
            
        }else{
            $email = $this->input->post('email');
            $password = $this->input->post('password');
            $user = $this->db->get_where('user', ['email' => $email])->row_array();
            
    
            if ($user) {
                    // cek password
                    if (password_verify($password, $user['password'])) {
                        $data = [
                            'email' => $user['email'],
                            'user_id' =>$user['user_id'],
                            'role' => $user['role_id']
                        ];
                        $this->session->set_userdata($data);   
                        if ($user['role_id'] == 1) {
                            $data = 'login berhasil sebagai admin';
                            echo $data;
                        } else {
                            $data = 'login berhasil';
                            echo $data;
                        }         
                        
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


    public function logout()
    {
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('role_id');
        $data = 'Anda telah logout';
        echo $data;

    }

    public function addUser(){
        if ($this->session->userdata('role') != 1) {
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
                        'password' => $password,
                        'role_id' => 0
                    ];
                    $this->db->insert('user', $data);
                    echo 'Data berhasil ditambahkan';
                }else{
                    echo 'username sudah digunakan';
                }
            }
        }

    }
    public function deleteakun($id){
        if ($this->session->userdata('role') == 1) {
            $this->db->where('user_id', $id);
            $this->db->delete('user');

            echo 'Data telah dihapus';
           
        }else{
           echo 'Anda tidak dapat menghapus user';
        }

    }
    public function listUser(){
        if ($this->session->userdata('role') == 1) {
           $list = $this->db->query("SELECT * FROM user a left join role b on a.role_id = b.role_id")->result();
          print_r(json_encode( $list))  ;
           
        }else{
           echo 'Anda tidak dapat melihat user';
        }
    }

    public function editUser(){
        if ($this->session->userdata('role') == 1) {
            $id = $this->input->post('id');
            if($id != NULL){
                $nama = htmlspecialchars($this->input->post('nama'));
                $email = $this->input->post('email', true);
                $username = htmlspecialchars($this->input->post('username', true));
                $data = [
                    'username' => $username,
                    'nama' => $nama,
                    'email' => $email
                ];
                $this->db->set($data);
                $this->db->where('user_id', $id);
                $this->db->update('user');
    
                echo 'data berhasil diupdate';
            }else{
                echo 'input id terlebih dahulu';
            }
           
        }else{
           echo 'Anda tidak dapat mengedit user';
        }
    }

}
