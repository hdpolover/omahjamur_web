<?php
defined('BASEPATH') or exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Keranjang extends RestController
{
    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set("Asia/Bangkok");
        $this->load->model('keranjang_model', 'keranjang');
    }

    public function get_keranjang_get()
    {
        $id = $this->get('id_pengguna');

        $keranjang = $this->keranjang->get_keranjang($id);

        if ($keranjang) {
            $this->response([
                'status' => true, 'message' => 'keranjang ditemukan', 'data' => $keranjang
            ],  200);
        } else {
            $this->response([
                'status' => false, 'message' => 'keranjang tidak ditemukan'
            ],  200);
        }
    }

    public function simpan_post()
    {
        $param = $this->post();

        $id_pengguna = $param['id_pengguna'];
        $id_produk = $param['id_produk'];

        $data = [
            'id_produk' => $id_produk,
            'id_pengguna' => $id_pengguna
        ];

        $res = $this->keranjang->simpan_baru($data);

        if ($res > 0) {
            $this->response([
                'status' => true,
                'message' => 'keranjang baru'
            ],  200);
        } else {
            $this->response([
                'status' => false,
                'message' => 'gagal menyimpan keranjang'
            ],  200);
        }
    }

    public function hapus_get()
    {
        $id = $this->get('id_keranjang');

        $i = $this->keranjang->hapus_ker($id);

        if ($i == 1) {
            $this->response(['status' => true, 'message' => 'Berhasil'], 200);
        } else {
            $this->response(['status' => false, 'message' => 'gagal.'], 200);
        }
    }
}
