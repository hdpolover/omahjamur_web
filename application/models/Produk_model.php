<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 *
 */
class Produk_model extends CI_Model
{

    public function get_produk($id = null)
    {
        if ($id == null) {
            $query = "select * from produk";
            return $this->db->query($query)->result();
        } else {
            $query = "select * from produk where id_produk = " . $id;
            return $this->db->query($query)->result();
        }
    }

    public function tambah_p($param)
    {
        return $this->db->insert('produk', $param);
    }

    public function get_produk_p($id)
    {
        $query = "SELECT p.*, djp.deskripsi as deskripsi_djp, jp.deskripsi as deskripsi_jp FROM produk p left join detail_jenis_produk djp on p.id_detail_jenis_produk = djp.id_detail_jenis_produk LEFT join jenis_produk jp on jp.id_jenis_produk = djp.id_jenis_produk where p.id_petani = " . $id;
        return $this->db->query($query)->result();
    }

    public function get_produk_id($id)
    {
        $query = "SELECT p.*, djp.deskripsi as deskripsi_djp, jp.deskripsi as deskripsi_jp FROM produk p left join detail_jenis_produk djp on p.id_detail_jenis_produk = djp.id_detail_jenis_produk LEFT join jenis_produk jp on jp.id_jenis_produk = djp.id_jenis_produk where p.id_produk = " . $id;
        return $this->db->query($query)->result();
    }
}
