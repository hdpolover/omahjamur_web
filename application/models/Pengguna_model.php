<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 *
 */
class Pengguna_model extends CI_Model
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

    public function login_pengguna($param)
        {
            return $this->db->where($param)->get('pengguna')->result();
        }

    public function simpan_pengguna($data)
    {
        $this->db->insert('pengguna', $data);
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
}
