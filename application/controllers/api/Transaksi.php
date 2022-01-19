<?php
defined('BASEPATH') or exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Transaksi extends RestController
{
    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set("Asia/Bangkok");
        $this->load->model('transaksi_model', 'transaksi');
    }

    public function index_get()
    {
        $id = $this->get('id_pengguna');

        if ($id === NULL) {
            $transaksi = $this->transaksi->get_transaksi();
        } else {
            $transaksi = $this->transaksi->get_transaksi($id);
        }

        if ($transaksi) {
            $this->response([
                'status' => true, 'message' => 'transaksi ditemukan', 'data' => $transaksi
            ],  200);
        } else {
            $this->response([
                'status' => false, 'message' => 'transaksi tidak ditemukan'
            ],  200);
        }
    }

    public function get_detail_transaksi_get()
    {
        $id = $this->get('id_transaksi');

        $transaksi = $this->transaksi->get_detail($id);

        if ($transaksi) {
            $this->response([
                'status' => true, 'message' => 'transaksi ditemukan', 'data' => $transaksi
            ],  200);
        } else {
            $this->response([
                'status' => false, 'message' => 'transaksi tidak ditemukan'
            ],  200);
        }
    }

    public function get_kategori_get()
    {
        $id = $this->get('kategori');

        $transaksi = $this->transaksi->get_kategori_transaksi($id);

        if ($transaksi) {
            $this->response([
                'status' => true, 'message' => 'transaksi ditemukan', 'data' => $transaksi
            ],  200);
        } else {
            $this->response([
                'status' => false, 'message' => 'transaksi tidak ditemukan'
            ],  200);
        }
    }

    public function get_tr_berlangsung_get()
    {
        $id = $this->get('id_pengguna');

        if ($id === NULL) {
            $transaksi = $this->transaksi->get_berlangsung();
        } else {
            $transaksi = $this->transaksi->get_berlangsung($id);
        }

        if ($transaksi) {
            $this->response([
                'status' => true, 'message' => 'transaksi ditemukan', 'data' => $transaksi
            ],  200);
        } else {
            $this->response([
                'status' => false, 'message' => 'transaksi tidak ditemukan'
            ],  200);
        }
    }

    public function get_tr_selesai_get()
    {
        $id = $this->get('id_pengguna');

        if ($id === NULL) {
            $transaksi = $this->transaksi->get_selesai();
        } else {
            $transaksi = $this->transaksi->get_selesai($id);
        }

        if ($transaksi) {
            $this->response([
                'status' => true, 'message' => 'transaksi ditemukan', 'data' => $transaksi
            ],  200);
        } else {
            $this->response([
                'status' => false, 'message' => 'transaksi tidak ditemukan'
            ],  200);
        }
    }

    public function simpan_post()
    {
        $param = $this->post();

        $now = new DateTime();
        $id_transaksi = $param['id_transaksi'];
        $total = $param['total'];
        $id_pengguna = $param['id_pengguna'];
        $ongkir = $param['ongkir'];

        $data = [
            'id_transaksi' => $id_transaksi,
            'id_pengguna' => $id_pengguna,
            'total' => $total,
            'tgl_transaksi' => $now->format('Y-m-d H:i:s'),
            'kurir' => "JNE REG",
            'no_resi' => 'Nomor Resi belum tersedia',
            'status_pengiriman' => 0,
            'status_transaksi' => 'normal',
            'ongkir' => $ongkir,
        ];

        $res = $this->transaksi->simpan_baru($data);

        if ($res > 0) {
            $this->response([
                'status' => true,
                'message' => 'transaksi baru'
            ],  200);
        } else {
            $this->response([
                'status' => false,
                'message' => 'gagal menyimpan transaksi'
            ],  200);
        }
    }

    public function update_resi_get()
    {
        $param = $this->get();

        $data = [
            'id_transaksi' => $param['id_transaksi'],
            'no_resi' => $param['no_resi'],
            'status_pengiriman' => 2
        ];

        $i = $this->transaksi->update_resi($data);

        if ($i == 1) {
            $this->response(['status' => true, 'message' => 'Berhasil'], 200);
        } else {
            $this->response(['status' => false, 'message' => 'gagal.'], 200);
        }
    }
}
