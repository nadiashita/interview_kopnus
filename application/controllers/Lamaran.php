<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Lamaran extends CI_Controller
{
    public function index()
    {
        if ($this->session->userdata('role') == 1) {
            $listlamaran = $this->db->query("SELECT b.nama,c.nama_perkerjaan, a.catatan FROM lamaran a LEFT JOIN perkerjaan c On c.perkerjaan_id = a.perkerjaan_id LEFT JOIN user b ON b.user_id= a.user_id")->result();
            print_r(json_encode($listlamaran));
         }else{
            $id = $this->session->userdata('user_id');
            $ceklamaran = $this->db->query("SELECT b.nama, c.nama_perkerjaan, a.catatan FROM lamaran a LEFT JOIN perkerjaan c On c.perkerjaan_id = a.perkerjaan_id LEFT JOIN user b ON b.user_id = a.user_id WHERE a.user_id = $id")->result();
            print_r(json_encode($ceklamaran));
         }
    }
    public function addlamaran(){
        if ($this->session->userdata('role') != 1) {
            $perkerjaan = $this->input->post('perkerjaanid');
            $catatan = $this->input->post('catatan');
           
            if($perkerjaan == NULL || $catatan == NULL){
                echo 'Input data terlebih dahulu';
            }else{
                $userid = $this->session->userdata('user_id');
                    $data = [
                        'user_id' => $userid,
                        'perkerjaan_id' => $perkerjaan,
                        'catatan' => $catatan,
                    ];
                    $this->db->insert('lamaran', $data);
                    echo 'Lamaran berhasil di submit';
            }
        }else{
           echo 'Admin tidak dapat menambahkan lamaran';
        }
    }
}