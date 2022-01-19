<?php
defined('BASEPATH') or exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Pembayaran extends RestController
{

    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set("Asia/Bangkok");
        $this->load->model('pembayaran_model', 'pembayaran');
        $this->load->model('transaksi_model', 'transaksi');

    }

    public function validasi_get()
    {
        $id = $this->get('id_pembayaran');
        $id_tr = $this->get('id_transaksi');

        $pembayaran = $this->pembayaran->validasi($id);

        $data = array(
            'id_transaksi' => $id_tr,
            'status_pengiriman' => 1
        );

        $transaksi = $this->transaksi->update_tr($data);

        if ($transaksi) {
            $this->response([
                'status' => true, 'message' => 'Pembayaran divalidasi'
            ],  200);
        } else {
            $this->response([
                'status' => false, 'message' => 'Pembayaran gagal'
            ],  200);
        }
    }

    public function get_pembayaran_get()
    {
        $id = $this->get('id_transaksi');

        $pembayaran = $this->pembayaran->get_bayar($id);

        if ($pembayaran) {
            $this->response([
                'status' => true, 'message' => 'Pembayaran ditemukan', 'data' => $pembayaran
            ],  200);
        } else {
            $this->response([
                'status' => false, 'message' => 'Pembayaran tidak ditemukan'
            ],  200);
        }
    }

    public function simpan_post()
    {
        $param = $this->post();

        $this->load->helper('inflector');
        $file_name = underscore($_FILES['image']['name']);
        $config['file_name'] = $file_name;

        if ($file_name) {
            $newPath = './assets/pembayaran/';

            if (!is_dir($newPath)) {
                mkdir($newPath, 0777, TRUE);
            }

            $config['upload_path'] = $newPath;
            $config['allowed_types'] = 'jpg|png|jpeg';
            $config['max_size']      = '3000';

            $this->upload->initialize($config);

            if ($this->upload->do_upload('image')) {
                $data = array(
                    'id_transaksi' => $param['id_transaksi'],
                    'bank_pengirim' => $param['bank_pengirim'],
                    'nama_akun_pengirim' => $param['nama_akun_pengirim'],
                    'status' => 0,
                    'nominal_transfer' => $param['nominal_transfer'],
                    'tgl_transfer' => $param['tgl_transfer'],
                    'bukti' => $file_name,
                );

                $insert = $this->pembayaran->simpan_pembayaran($data);

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
}
