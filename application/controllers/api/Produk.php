<?php
defined('BASEPATH') or exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Produk extends RestController
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('produk_model', 'produk');
    }

    public function index_get()
    {
        $param = $this->get();

        $id = $param['id_produk'];

        if ($id === NULL) {
            $produk = $this->produk->get_produk();
        } else {
            $produk = $this->produk->get_produk($id);
        }

        if ($produk) {
            $this->response(['status' => true, 'message' => 'Produk ditemukan', 'data' => $produk],  200);
        } else {
            $this->response(['status' => false, 'message' => 'Produk tidak ditemukan'],  200);
        }
    }

    public function get_produk_petani_get()
    {
        $param = $this->get();

        $id = $param['id_petani'];

        $produk = $this->produk->get_produk_p($id);

        if ($produk) {
            $this->response(['status' => true, 'message' => 'Produk ditemukan', 'data' => $produk],  200);
        } else {
            $this->response(['status' => false, 'message' => 'Produk tidak ditemukan'],  200);
        }
    }

    public function tambah_post()
    {
        $param = $this->post();

        $upload_image = $_FILES['image']['name'];

        if ($upload_image) {
            $newPath = './assets/produk/';

            if (!is_dir($newPath)) {
                mkdir($newPath, 0777, TRUE);
            }

            $config['upload_path'] = $newPath;
            $config['allowed_types'] = 'jpg|png|jpeg';
            $config['max_size']      = '3000';

            $this->upload->initialize($config);

            if ($this->upload->do_upload('image')) {
                $data = array(
                    'id_petani' => $param['id_petani'],
                    'id_detail_jenis_produk' => $param['id_detail_jenis_produk'],
                    'judul' => $param['judul'],
                    'deskripsi' => $param['deskripsi'],
                    'harga' => $param['harga'],
                    'stok' => $param['stok'],
                    'gambar' => $upload_image,
                );

                $insert = $this->produk->tambah_p($data);

                if ($insert == 1) {
                    $this->response(['status' => true, 'message' => 'Berhasil'], 200);
                } else {
                    $this->response(['status' => false, 'message' => 'Gagal'], 200);
                }
            } else {
                echo $this->upload->display_errors();
            }
        } else {
            $this->response(['status' => false, 'message' => 'failed to register'],  200);
        }
    }

    public function index_post()
    {
        $param = $this->post();

        $now = new DateTime();
        $id = $param['id'];
        $role = $param['id_role'];

        $data = [
            'id' => $id,
            'id_role' => $role,
            'status' => 1,
            'tanggal_dibuat' => $now->format('Y-m-d H:i:s'),
        ];

        $res = $this->produk->simpan_pengguna($data);

        if ($res > 0) {
            $this->response([
                'status' => true, 'message' => 'produk terdaftar'
            ],  200);
        } else {
            $this->response([
                'status' => false, 'message' => 'gagal mendaftarkan produk'
            ],  200);
        }
    }
}
