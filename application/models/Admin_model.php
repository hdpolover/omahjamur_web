<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 *
 */
class Admin_model extends CI_Model
{
    public function get_admin($id = null)
    {
        if ($id == null) {
            $query = "select * from admin";
            return $this->db->query($query)->result();
        } else {
            $query = "select * from admin where id_admin = " . $id;
            return $this->db->query($query)->result();
        }
    }

    public function detail_admin($id)
    {
        $query = "select * from admin where id_pengguna = " . $id;
        return $this->db->query($query)->result();
    }

    public function login_admin($param)
    {
        return $this->db->where($param)->get('admin')->result();
    }

    public function tambah_admin($param)
    {
        return $this->db->insert('admin', $param);
    }

    public function get_detail($id)
    {
        $query = "select * from admin where id_pengguna = " . $id;
        return $this->db->query($query)->result();
    }
}
