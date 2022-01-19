<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Detail_transaksi_model extends CI_Model
{

    public function get_detail($id)
    {
        $query = "select * from detail_transaksi where id_transaksi = '" . $id . "'";
        return $this->db->query($query)->result_array();
    }

    public function simpan_baru($data)
    {
        $this->db->insert('detail_transaksi', $data);
        return $this->db->affected_rows();
    }
}
