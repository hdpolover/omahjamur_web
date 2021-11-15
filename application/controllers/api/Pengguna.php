<?php
defined('BASEPATH') or exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Pengguna extends RestController
{

    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set("Asia/Bangkok");
        $this->load->model('pengguna_model', 'pengguna');
    }

    public function index_get()
    {
        $param = $this->get();

        $email = $param['email'];

        if ($email === NULL) {
            $pengguna = $this->pengguna->get_pengguna();
        } else {
            $pengguna = $this->pengguna->get_pengguna($email);
        }

        if ($pengguna) {
            $this->response(['status' => true, 'message' => 'Pengguna ditemukan', 'data' => $pengguna],  200);
        } else {
            $this->response([
                'status' => false, 'message' => 'Pengguna tidak ditemukan'],  200);
        }
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
            $this->response(['status' => false, 'message' => 'Email atau password salah. Silakan coba lagi.'], 200);
        }
    }

    public function daftar_post()
    {
        $param = $this->post();

        $now = new DateTime();
        $email = $param['email'];
        $role = $param['id_role'];
        $password = $param['password'];

        $data = [
            'id_role' => $role,
            'email' => $email,
            'password' => $password,
            'tanggal_dibuat' => $now->format('Y-m-d H:i:s'),
            'status' => 1,
        ];
 
        $res = $this->pengguna->simpan_pengguna($data);

        if ($res > 0) {
            $this->response([
                'status' => true, 'message' => 'pengguna terdaftar'],  200);
        } else {
            $this->response([
                'status' => false, 'message' => 'gagal mendaftarkan pengguna'],  200);
        }
    }
}
