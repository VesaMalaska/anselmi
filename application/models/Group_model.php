<?php

class Group_model extends CI_Model{
  public function __construct(){
    $this->load->database();
  }

  public function get_group_id($groupName){
    $query = $this->db->get_where('user_group', array('group_name' => $groupName));
    $groupRow = $query->row_array();

    if($groupRow) {
      return $groupRow['id'];
    } else {
      return FALSE;
    }
  }
}
