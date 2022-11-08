<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Perkerjaan extends CI_Controller
{
    public function index()
    {
        if ($this->session->userdata('role') == 1) {
            $list = $this->db->query("SELECT * FROM perkerjaan")->result();
            print_r(json_encode( $list));
         }else{
            $list = $this->db->query("SELECT * FROM perkerjaan WHERE status = 1")->result();
            print_r(json_encode( $list));
         }
    }   
    public function addPerkerjaan(){
        if ($this->session->userdata('role') == 1) {
            $perkerjaan = $this->input->post('perkerjaan');
            $status = $this->input->post('status');
            $deskripsi = $this->input->post('deskripsi');
            $syarat = $this->input->post('syarat');
           
            if($perkerjaan == NULL || $deskripsi == NULL){
                echo 'Input data terlebih dahulu';
            }else{
                    $data = [
                        'nama_perkerjaan' => $perkerjaan,
                        'status' => $status,
                        'deskripsi' => $deskripsi,
                        'syarat' => $syarat
                    ];
                    $this->db->insert('perkerjaan', $data);
                    echo 'Data berhasil ditambahkan';
            }
            
         }else{
            echo 'Anda tidak dapat menambahkan perkerjaan';
         }
    }
    public function deletePerkerjaan(){
        $id = $this->input->post('id');
        if ($this->session->userdata('role') == 1) {
            $this->db->where('perkerjaan_id', $id);
            $this->db->delete('perkerjaan');

            echo 'Data perkerjaan telah dihapus';
        }else{
           echo 'Anda tidak dapat menghapus perkerjaan';
        }
    }

    public function editPerkerjaan(){
        if ($this->session->userdata('role') == 1) {
            $id = $this->input->post('id');
            if($id != NULL){
                $perkerjaan = $this->input->post('perkerjaan');
                $status = $this->input->post('status');
                $deskripsi = $this->input->post('deskripsi');
                $syarat = $this->input->post('syarat');
                $data = [
                    'nama_perkerjaan' => $perkerjaan,
                    'status' => $status,
                    'deskripsi' => $deskripsi,
                    'syarat' => $syarat
                ];
                $this->db->set($data);
                $this->db->where('perkerjaan_id', $id);
                $this->db->update('perkerjaan');
    
                echo 'data berhasil diupdate';
            }else{
                echo 'input id terlebih dahulu';
            }
           
        }else{
           echo 'Anda tidak dapat mengedit user';
        }
    }

}