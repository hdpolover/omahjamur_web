<?php
defined('BASEPATH') or exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Jenis_produk extends RestController
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('jenis_produk_model', 'jenis_produk');
    }

    public function index_get()
    {
        $id = $this->get('id_jenis_produk');

        if ($id === NULL) {
            $jenis_produk = $this->jenis_produk->get_jenis_produk();
        } else {
            $jenis_produk = $this->jenis_produk->get_jenis_produk($id);
        }

        if ($jenis_produk) {
            $this->response(['status' => true, 'message' => 'Jenis Produk ditemukan', 'data' => $jenis_produk],  200);
        } else {
            $this->response(['status' => false, 'message' => 'Jenis Produk tidak ditemukan'],  200);
        }
    }

    public function tambah_post()
    {
        $param = $this->post();

        $deskripsi = $param['deskripsi'];

        $data = [
            'deskripsi' => $deskripsi
        ];
 
        $res = $this->jenis_produk->simpan($data);

        if ($res > 0) {
            $this->response([
                'status' => true, 'message' => 'jenis_produk ditambahkan'],  200);
        } else {
            $this->response([
                'status' => false, 'message' => 'gagal menambahkan jenis_produk'],  200);
        }
    }

    public function edit_post()
    {
        $param = $this->post();

        $id_jenis_produk = $param['id_jenis_produk'];
        $deskripsi = $param['deskripsi'];

        $data = [
            'deskripsi' => $deskripsi
        ];
 
        $res = $this->jenis_produk->edit($data, $id_jenis_produk);

        if ($res > 0) {
            $this->response([
                'status' => true, 'message' => 'jenis_produk diedit'],  200);
        } else {
            $this->response([
                'status' => false, 'message' => 'gagal mengedit jenis_produk'],  200);
        }
    }
}
