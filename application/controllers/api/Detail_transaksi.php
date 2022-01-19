<?php
defined('BASEPATH') or exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Detail_transaksi extends RestController
{

    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set("Asia/Bangkok");
        $this->load->model('detail_transaksi_model', 'detail_transaksi');
    }

    public function get_detail_transaksi_get()
    {
        $id = $this->get('id_transaksi');

        $detail_transaksi = $this->detail_transaksi->get_detail($id);

        if ($detail_transaksi) {
            $this->response([
                'status' => true, 'message' => 'Produk ditemukan', 'data' => $detail_transaksi
            ],  200);
        } else {
            $this->response([
                'status' => false, 'message' => 'Produk tidak ditemukan'
            ],  200);
        }
    }

    public function get_detail_produk_get()
    {
        $id = $this->get('id_produk');

        $detail_transaksi = $this->detail_transaksi->get_detail_produk($id);

        if ($detail_transaksi) {
            $this->response([
                'status' => true, 'message' => 'Produk ditemukan', 'data' => $detail_transaksi
            ],  200);
        } else {
            $this->response([
                'status' => false, 'message' => 'Produk tidak ditemukan'
            ],  200);
        }
    }

    public function simpan_post()
    {
        $param = $this->post();

        $now = new DateTime();
        $id_transaksi = $param['id_transaksi'];
        $sub_total = $param['subtotal'];
        $id_produk = $param['id_produk'];
        $jumlah = $param['jumlah'];

        $data = [
            'id_transaksi' => $id_transaksi,
            'id_produk' => $id_produk,
            'subtotal' => $sub_total,
            'jumlah' => $jumlah
        ];

        $res = $this->detail_transaksi->simpan_baru($data);

        if ($res > 0) {
            $this->response([
                'status' => true,
                'message' => 'detail transaksi baru'
            ],  200);
        } else {
            $this->response([
                'status' => false,
                'message' => 'gagal menyimpan detail transaksi'
            ],  200);
        }
    }
}
