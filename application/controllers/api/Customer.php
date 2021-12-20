<?php
defined('BASEPATH') or exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Customer extends RestController
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library(array('upload', 'image_lib'));
        $this->load->model('customer_model', 'customer');
    }

    public function index_get()
    {
        $id = $this->get('id_customer');

        if ($id === NULL) {
            $customer = $this->customer->get_customer();
        } else {
            $customer = $this->customer->get_customer($id);
        }

        if ($customer) {
            $this->response(['status' => true, 'message' => 'customer ditemukan', 'data' => $customer],  200);
        } else {
            $this->response(['status' => false, 'message' => 'customer tidak ditemukan'],  200);
        }
    }

    public function get_detail_get()
    {
        $id = $this->get('id_pengguna');

        $customer = $this->customer->get_detail($id);

        if ($customer) {
            $this->response(['status' => true, 'message' => 'customer ditemukan', 'data' => $customer],  200);
        } else {
            $this->response(['status' => false, 'message' => 'customer tidak ditemukan'],  200);
        }
    }

    public function get_detail_id_get()
    {
        $id = $this->get('id_customer');

        $customer = $this->customer->get_detail_id($id);

        if ($customer) {
            $this->response(['status' => true, 'message' => 'customer ditemukan', 'data' => $customer],  200);
        } else {
            $this->response(['status' => false, 'message' => 'customer tidak ditemukan'],  200);
        }
    }

    public function validasi_post()
    {
        $param = $this->post();

        $id_customer = $param['id_customer'];
        
        $data = [
            'status' => '1'
        ];

        $res = $this->customer->validasi_pengajuan($data, $id_customer);

        if ($res > 0) {
            $this->response([
                'status' => true, 'message' => 'customer berhasil divalidasi'],  200);
        } else {
            $this->response([
                'status' => false, 'message' => 'customer berhasil gagal divalidasi'],  200);
        }
    }

    public function pengajuan_customer_get()
    {
        $customer = $this->customer->get_pengajuan_customer();
        
        if ($customer) {
            $this->response(['status' => true, 'message' => 'customer ditemukan', 'data' => $customer],  200);
        } else {
            $this->response(['status' => false, 'message' => 'customer tidak ditemukan'],  200);
        }
    }

    public function lengkap_customer_get()
    {
        $customer = $this->customer->get_lengkap_customer();
        
        if ($customer) {
            $this->response(['status' => true, 'message' => 'customer ditemukan', 'data' => $customer],  200);
        } else {
            $this->response(['status' => false, 'message' => 'customer tidak ditemukan'],  200);
        }
    }

    public function daftar_customer_post()
    {
        $param = $this->post();

        $upload_image = $_FILES['image']['name'];

        if ($upload_image) {
            $newPath = './assets/profile/';

            if (!is_dir($newPath)) {
                mkdir($newPath, 0777, TRUE);
            }

            $config['upload_path'] = $newPath;
            $config['allowed_types'] = 'jpg|png|jpeg';
            $config['max_size']      = '3000';

            $this->upload->initialize($config);

            if ($this->upload->do_upload('image')) {
                $data = array(
                    'id_pengguna' => $param['id_pengguna'],
                    'nama' => $param['nama'],
                    'alamat' => $param['alamat'],
                    'foto' => $upload_image,
                    'status' => 1
                );

                $insert = $this->customer->insert_customer($data);

                if ($insert == 1) {
                    $this->response(['status' => true, 'message' => 'Berhasil mendaftar silahkan lakukan login.'], 200);
                } else {
                    $this->response(['status' => false, 'message' => 'Gagal melakukan pendaftaran, silahkan coba lagi.'], 200);
                }
            } else {
                echo $this->upload->display_errors();
            }
        } else {
            $this->response(['status' => false, 'message' => 'failed to register'],  200);
        }
    }
}
