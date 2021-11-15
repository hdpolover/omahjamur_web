<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 *
 */
class Jenis_produk_model extends CI_Model
{
    public function get_jenis_produk($id = null)
    {
        if ($id == null) {
            $query = "select * from jenis_produk";
            return $this->db->query($query)->result();
        } else {
            $query = "select * from jenis_produk where id_jenis_produk = " . $id;
            return $this->db->query($query)->result();
        }
    }

    public function simpan($data)
    {
        $this->db->insert('jenis_produk', $data);
        return $this->db->affected_rows();
    }

    public function edit($data, $id)
    {
        $this->db->where('id_jenis_produk', $id);
        $this->db->update('jenis_produk', $data);
        return $this->db->affected_rows();
    }
}
