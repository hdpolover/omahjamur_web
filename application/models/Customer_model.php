<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 *
 */
class Customer_model extends CI_Model
{
    public function get_customer($id = null)
    {
        if ($id == null) {
            $query = "select * from customer";
            return $this->db->query($query)->result();
        } else {
            $query = "select * from customer where id_customer = " . $id;
            return $this->db->query($query)->result();
        }
    }

    public function get_pengajuan_customer()
    {
        $query = "select * from customer where status = '0'";
        return $this->db->query($query)->result();
    }

    public function get_lengkap_customer()
    {
        $this->db->where('status', "1");
        return $this->db->get('customer')->result();
    }

    public function insert_customer($param)
    {
        return $this->db->insert('customer', $param);
    }

    public function get_detail($id)
    {
        $query = "select * from customer where id_pengguna = " . $id;
        return $this->db->query($query)->result();
    }

    public function get_detail_id($id)
    {
        $query = "select * from customer where id_customer = " . $id;
        return $this->db->query($query)->result();
    }

    public function validasi_pengajuan($data, $id)
    {
        $this->db->where('id_customer', $id);
        $this->db->update('customer', $data);
        return $this->db->affected_rows();
    }
}
