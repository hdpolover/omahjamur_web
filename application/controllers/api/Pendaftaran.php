<?php
defined('BASEPATH') or exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Pendaftaran extends RestController
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

    public function index_post()
    {
        $param = $this->post();

        $now = new DateTime();
        $email = $param['email'];
        $role = $param['id_role'];

        $data = [
            'email' => $email,
            'id_role' => $role,
            'status' => 1,
            'tanggal_dibuat' => $now->format('Y-m-d H:i:s'),
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
