<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pembayaran_model extends CI_Model
{
    public function get_pengguna($email = null)
    {
        if ($email == null) {
            $query = "select * from pengguna";
            return $this->db->query($query)->result_array();
        } else {
            $query = "select * from pengguna where email = '" . $email . "'";
            return $this->db->query($query)->result_array();
        }
    }

    public function validasi($id)
    {
        $this->db->set('status', 1);
        $this->db->where('id_pembayaran', $id);
        return $this->db->update('pembayaran');
    }

    public function get_bayar($id)
    {
        $query = "select * from pembayaran where id_transaksi = '" . $id . "'";
        return $this->db->query($query)->result_array();
    }

    public function simpan_pembayaran($data)
    {
        $this->db->insert('pembayaran', $data);
        return $this->db->affected_rows();
    }

    public function save_edit($data)
    {
        $this->db->set('full_name', $data['full_name']);
        $this->db->set('institution', $data['institution']);
        $this->db->where('referral_code', $data['referral_code']);
        return $this->db->update('influencers');
    }
}
