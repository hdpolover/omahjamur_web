<?php
defined('BASEPATH') or exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Petani extends RestController
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library(array('upload', 'image_lib'));
        $this->load->model('petani_model', 'petani');
    }

    public function index_get()
    {
        $id = $this->get('id_petani');

        if ($id === NULL) {
            $petani = $this->petani->get_petani();
        } else {
            $petani = $this->petani->get_petani($id);
        }

        if ($petani) {
            $this->response(['status' => true, 'message' => 'Petani ditemukan', 'data' => $petani],  200);
        } else {
            $this->response(['status' => false, 'message' => 'Petani tidak ditemukan'],  200);
        }
    }

    public function get_detail_get()
    {
        $id = $this->get('id_pengguna');

        $petani = $this->petani->get_detail($id);

        if ($petani) {
            $this->response(['status' => true, 'message' => 'Petani ditemukan', 'data' => $petani],  200);
        } else {
            $this->response(['status' => false, 'message' => 'Petani tidak ditemukan'],  200);
        }
    }

    public function get_detail_id_get()
    {
        $id = $this->get('id_petani');

        $petani = $this->petani->get_detail_id($id);

        if ($petani) {
            $this->response(['status' => true, 'message' => 'Petani ditemukan', 'data' => $petani],  200);
        } else {
            $this->response(['status' => false, 'message' => 'Petani tidak ditemukan'],  200);
        }
    }

    public function validasi_post()
    {
        $param = $this->post();

        $id_petani = $param['id_pengguna'];
        
        $data = [
            'status' => '1'
        ];

        $res = $this->petani->validasi_pengajuan($data, $id_petani);

        if ($res > 0) {
            $this->response([
                'status' => true, 'message' => 'petani berhasil divalidasi'],  200);
        } else {
            $this->response([
                'status' => false, 'message' => 'petani berhasil gagal divalidasi'],  200);
        }
    }

    public function pengajuan_petani_get()
    {
        $petani = $this->petani->get_pengajuan_petani();
        
        if ($petani) {
            $this->response(['status' => true, 'message' => 'Petani ditemukan', 'data' => $petani],  200);
        } else {
            $this->response(['status' => false, 'message' => 'Petani tidak ditemukan'],  200);
        }
    }

    public function lengkap_petani_get()
    {
        $petani = $this->petani->get_lengkap_petani();
        
        if ($petani) {
            $this->response(['status' => true, 'message' => 'Petani ditemukan', 'data' => $petani],  200);
        } else {
            $this->response(['status' => false, 'message' => 'Petani tidak ditemukan'],  200);
        }
    }

    public function daftar_petani_post()
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
                    'latitude' => $param['latitude'],
                    'longitude' => $param['longitude'],
                    'status' => 0
                );

                $insert = $this->petani->insert_petani($data);

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
