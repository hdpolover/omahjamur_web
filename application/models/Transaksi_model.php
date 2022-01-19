<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Transaksi_model extends CI_Model
{
    public function get_transaksi($id = null)
    {
        if ($id == null) {
            $query = "select * from transaksi";
            return $this->db->query($query)->result_array();
        } else {
            $query = "select * from transaksi where id_pengguna = " . $id;
            return $this->db->query($query)->result_array();
        }
    }

    public function get_berlangsung($id = null)
    {
        if ($id == null) {
            $query = "select * from transaksi where status_transaksi < 3";
            return $this->db->query($query)->result_array();
        } else {
            $query = "select * from transaksi where status_transaksi < 3 and id_pengguna = " . $id;
            return $this->db->query($query)->result_array();
        }
    }

    public function get_detail($id)
    {
        $query = "select * from transaksi where id_transaksi = '" . $id ."'";
        return $this->db->query($query)->result_array();
    }

    public function get_selesai($id = null)
    {
        if ($id == null) {
            $query = "select * from transaksi where status_transaksi = 3";
            return $this->db->query($query)->result_array();
        } else {
            $query = "select * from transaksi where status_transaksi = 3 and id_pengguna = " . $id;
            return $this->db->query($query)->result_array();
        }
    }

    public function login_pengguna($param)
    {
        return $this->db->where($param)->get('pengguna')->result();
    }

    public function simpan_baru($data)
    {
        $this->db->insert('transaksi', $data);
        return $this->db->affected_rows();
    }

    public function save_edit($data)
    {
        $this->db->set('full_name', $data['full_name']);
        $this->db->set('institution', $data['institution']);
        $this->db->set('tiktok', $data['tiktok']);
        $this->db->set('status', $data['status']);
        $this->db->set('instagram', $data['instagram']);
        $this->db->set('field_of_study', $data['field_of_study']);
        $this->db->where('referral_code', $data['referral_code']);
        return $this->db->update('influencers');
    }

    public function update_status($data)
    {
        $this->db->set('status_pengiriman', $data['status_pengiriman']);
        $this->db->where('id_transaksi', $data['id_transaksi']);
        return $this->db->update('transaksi');
    }

    public function update_resi($data)
    {
        $this->db->set('status_pengiriman', $data['status_pengiriman']);
        $this->db->set('no_resi', $data['no_resi']);
        $this->db->where('id_transaksi', $data['id_transaksi']);
        return $this->db->update('transaksi');
    }
}
