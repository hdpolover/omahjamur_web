<?php
defined('BASEPATH') or exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Detail_jenis_produk extends RestController
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('detail_jenis_produk_model', 'detail_jenis_produk');
    }

    public function get_djp_get()
    {
        $detail_jenis_produk = $this->detail_jenis_produk->get_djp_tambah();

        if ($detail_jenis_produk) {
            $this->response(['status' => true, 'message' => 'Detail Jenis Produk ditemukan', 'data' => $detail_jenis_produk],  200);
        } else {
            $this->response(['status' => false, 'message' => 'Detail Jenis Produk tidak ditemukan'],  200);
        }
    }

    public function index_get()
    {
        $id = $this->get('id_detail_jenis_produk');

        if ($id === NULL) {
            $detail_jenis_produk = $this->detail_jenis_produk->get_detail_jenis_produk();
        } else {
            $detail_jenis_produk = $this->detail_jenis_produk->get_detail_jenis_produk($id);
        }

        if ($detail_jenis_produk) {
            $this->response(['status' => true, 'message' => 'Detail Jenis Produk ditemukan', 'data' => $detail_jenis_produk],  200);
        } else {
            $this->response(['status' => false, 'message' => 'Detail Jenis Produk tidak ditemukan'],  200);
        }
    }

    public function tambah_post()
    {
        $param = $this->post();

        $id_jenis_produk = $param['id_jenis_produk'];
        $deskripsi = $param['deskripsi'];

        $data = [
            'id_jenis_produk' => $id_jenis_produk,
            'deskripsi' => $deskripsi
        ];

        $res = $this->detail_jenis_produk->simpan($data);

        if ($res > 0) {
            $this->response([
                'status' => true, 'message' => 'detail_jenis_produk ditambahkan'
            ],  200);
        } else {
            $this->response([
                'status' => false, 'message' => 'gagal menambahkan detail_jenis_produk'
            ],  200);
        }
    }
}
