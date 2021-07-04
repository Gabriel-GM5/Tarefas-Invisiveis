<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Custom_Model extends CI_Model
{
    public function get_user_group($userID = null, $groupID = null)
    {
        if ($userID && $groupID) {
            $this->db->select('id');
            $this->db->from('users_x_grupos_familiares');
            $this->db->where('user_id', $userID);
            $this->db->where('grupo_familiar_id', $groupID);
            $this->db->where('ativo', 1);
            $this->db->limit(1);
            return $this->db->get()->row();
        } else {
            return false;
        }
    }
}
