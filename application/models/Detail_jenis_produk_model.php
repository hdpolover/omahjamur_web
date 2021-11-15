<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 *
 */
class Detail_jenis_produk_model extends CI_Model
{
    public function get_detail_jenis_produk($id = null)
    {
        if ($id == null) {
            $query = "select djp.id_detail_jenis_produk, jp.id_jenis_produk, jp.deskripsi as deskripsi_jp, djp.deskripsi as deskripsi_djp from detail_jenis_produk djp left join jenis_produk jp on jp.id_jenis_produk = djp.id_jenis_produk order by deskripsi_jp ASC";
            return $this->db->query($query)->result();
        } else {
            $query = "select djp.id_detail_jenis_produk, jp.id_jenis_produk, jp.deskripsi as deskripsi_jp, djp.deskripsi as deskripsi_djp from detail_jenis_produk djp left join jenis_produk jp on jp.id_jenis_produk = djp.id_jenis_produk where djp.id_detail_jenis_produk = " . $id;
            return $this->db->query($query)->result();
        }
    }

    public function simpan($data)
    {
        $this->db->insert('detail_jenis_produk', $data);
        return $this->db->affected_rows();
    }

}
