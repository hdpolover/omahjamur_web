<?php
defined('BASEPATH') or exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Admin extends RestController
{

    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set("Asia/Bangkok");
        $this->load->model('admin_model', 'admin');
    }

    public function get_detail_get()
    {
        $id = $this->get('id_pengguna');

        $admin = $this->admin->get_detail($id);

        if ($admin) {
            $this->response(['status' => true, 'message' => 'Petani ditemukan', 'data' => $admin],  200);
        } else {
            $this->response(['status' => false, 'message' => 'Petani tidak ditemukan'],  200);
        }
    }

    public function index_get()
    {
        $id = $this->get('id_admin');

        if ($id == null) {
            $data = $this->admin->get_admin();
        } else {
            $data = $this->admin->get_admin($id);
        }

        if ($data != null) {
            $this->response(['status' => true, 'message' => 'Admin ditemukan', 'data' => $data], 200);
        } else {
            $this->response(['status' => false, 'message' => 'Admin tidak ditemukan'], 200);
        }
    }

    public function detail_get()
    {
        $param = $this->get();

        $where = array(
            'id_pengguna' => $param['id_pengguna']
        );

        $data = $this->admin->detail_admin($where);

        if ($data != null) {
            $this->response(['status' => true, 'message' => 'Berhasil login.', 'data' => $data], 200);
        } else {
            $this->response(['status' => false, 'message' => 'Username tidak ditemukan atau password salah. Silakan coba lagi.'], 200);
        }
    }

    public function login_get()
    {
        $param = $this->get();

        $where = array(
            'username' => $param['username'],
            'password' => $param['password']
        );

        $data = $this->admin->login_admin($where);

        if ($data != null) {
            $this->response(['status' => true, 'message' => 'Berhasil login.', 'data' => $data], 200);
        } else {
            $this->response(['status' => false, 'message' => 'Username tidak ditemukan atau password salah. Silakan coba lagi.'], 200);
        }
    }

    public function tambah_post()
    {
        $param = $this->post();

        $now = new DateTime();

        $data = [
            'username' => $param['username'],
            'password' => $param['password'],
            'status' => 1,
            'tanggal_dibuat' => $now->format('Y-m-d H:i:s'),
            'foto' => 'default.jpg',
            'nama' => $param['nama']
        ];

        $res = $this->admin->tambah_admin($data);

        if ($res > 0) {
            $this->response(['status' => true, 'message' => 'Admin berhasil ditambahkan'],  200);
        } else {
            $this->response(['status' => false, 'message' => 'Gagal menambahkan admin'],  200);
        }
    }
}
