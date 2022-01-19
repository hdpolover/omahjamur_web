<?php
defined('BASEPATH') or exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Auth extends RestController
{

    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set("Asia/Bangkok");
        $this->load->model('pengguna_model', 'pengguna');
    }

    public function login_get()
    {
        $param = $this->get();

        $where = array(
            'email' => $param['email'],
            'password' => $param['password']
        );

        $data = $this->pengguna->login_pengguna($where);

        if ($data != null) {
            $this->response(['status' => true, 'message' => 'Berhasil login.', 'data' => $data], 200);
        } else {
            $this->response(['status' => false, 'message' => 'Email tidak ditemukan atau password salah. Silakan coba lagi.'], 200);
        }
    }

    public function daftar_cust_post()
    {
        $param = $this->post();

        $now = new DateTime();
        $email = $param['email'];
        $peran = $param['peran'];
        $password = $param['password'];
        $alamat = $param['alamat'];
        $username = $param['username'];
        $no_telp = $param['no_telp'];
        $lat = $param['latitude'];
        $id_kota = $param['id_kota'];
        $nama_kota = $param['nama_kota'];
        $longi = $param['longitude'];

        $upload_image = $_FILES['image']['name'];

        if ($upload_image) {
            $newPath = './assets/profil/';

            if (!is_dir($newPath)) {
                mkdir($newPath, 0777, TRUE);
            }

            $config['upload_path'] = $newPath;
            $config['allowed_types'] = 'jpg|png|jpeg';
            $config['max_size']      = '3000';

            $this->upload->initialize($config);

            if ($this->upload->do_upload('image')) {
                $data = array(
                    'peran' => $peran,
                    'email' => $email,
                    'password' => $password,
                    'tgl_daftar' => $now->format('Y-m-d H:i:s'),
                    'status' => 1,
                    'foto' => $upload_image,
                    'alamat' => $alamat,
                    'username' => $username,
                    'no_telp' => $no_telp,
                    'latitude' => $lat,
                    'longitude' => $longi,
                    'id_kota' => $id_kota,
                    'nama_kota' => $nama_kota
                );

                $res = $this->pengguna->daftar_pengguna($data);

                if ($res > 0) {
                    $this->response([
                        'status' => true,
                        'message' => 'pengguna terdaftar'
                    ],  200);
                } else {
                    $this->response([
                        'status' => false,
                        'message' => 'gagal mendaftarkan pengguna'
                    ],  200);
                }
            } else {
                echo $this->upload->display_errors();
            }
        } else {
            $this->response(['status' => false, 'message' => 'failed to register'],  200);
        }
    }

    public function daftar_petani_post()
    {
        $param = $this->post();

        $now = new DateTime();
        $email = $param['email'];
        $peran = $param['peran'];
        $password = $param['password'];
        $alamat = $param['alamat'];
        $username = $param['username'];
        $no_telp = $param['no_telp'];
        $lat = $param['latitude'];
        $id_kota = $param['id_kota'];
        $nama_kota = $param['nama_kota'];
        $longi = $param['longitude'];

        $upload_image = $_FILES['image']['name'];

        if ($upload_image) {
            $newPath = './assets/profil/';

            if (!is_dir($newPath)) {
                mkdir($newPath, 0777, TRUE);
            }

            $config['upload_path'] = $newPath;
            $config['allowed_types'] = 'jpg|png|jpeg';
            $config['max_size']      = '3000';

            $this->upload->initialize($config);

            if ($this->upload->do_upload('image')) {
                $data = array(
                    'peran' => $peran,
                    'email' => $email,
                    'password' => $password,
                    'tgl_daftar' => $now->format('Y-m-d H:i:s'),
                    'status' => 0,
                    'foto' => $upload_image,
                    'alamat' => $alamat,
                    'username' => $username,
                    'no_telp' => $no_telp,
                    'latitude' => $lat,
                    'longitude' => $longi,
                    'id_kota' => $id_kota,
                    'nama_kota' => $nama_kota
                );

                $res = $this->pengguna->daftar_pengguna($data);

                if ($res > 0) {
                    $this->response([
                        'status' => true,
                        'message' => 'pengguna terdaftar'
                    ],  200);
                } else {
                    $this->response([
                        'status' => false,
                        'message' => 'gagal mendaftarkan pengguna'
                    ],  200);
                }
            } else {
                echo $this->upload->display_errors();
            }
        } else {
            $this->response(['status' => false, 'message' => 'failed to register'],  200);
        }
    }
}
