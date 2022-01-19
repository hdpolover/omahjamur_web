<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 *
 */
class Petani_model extends CI_Model
{
    public function get_petani($id = null)
    {
        if ($id == null) {
            $query = "select * from pengguna where peran = 'petani'";
            return $this->db->query($query)->result();
        } else {
            $query = "select * from pengguna where peran = 'petani' and id_pengguna = " . $id;
            return $this->db->query($query)->result();
        }
    }

    public function get_pengajuan_petani()
    {
        $query = "select * from pengguna where peran = 'petani' and status = '0'";
        return $this->db->query($query)->result();
    }

    public function get_lengkap_petani()
    {
        $query = "select * from pengguna where peran = 'petani' and status = '1'";
        return $this->db->query($query)->result();
    }

    public function insert_petani($param)
    {
        return $this->db->insert('petani', $param);
    }

    public function get_detail($id)
    {
        $query = "select * from petani where id_pengguna = " . $id;
        return $this->db->query($query)->result();
    }

    public function get_detail_id($id)
    {
        $query = "select * from petani where id_petani = " . $id;
        return $this->db->query($query)->result();
    }

    public function validasi_pengajuan($data, $id)
    {
        $this->db->where('id_petani', $id);
        $this->db->update('petani', $data);
        return $this->db->affected_rows();
    }
}
