<?php

class User_model extends CI_Model{
  public function __construct(){
    $this->load->database();
  }

  public function is_user_admin($userID){
    // Load group model to be used
    $this->load->model('group_model');
    // Get "admin" group id
    $adminGroupID = $this->group_model->get_group_id('admin');

    // Check if user ID and admin group ID has binding
    // (are they both found as record from user_group_binding table)
    $query = $this->db->get_where('user_group_binding', array('group_id' => $adminGroupID, 'user_id' => $userID));
    if($query->row_array()){
      return TRUE;
    } else {
      return FALSE;
    }
  }
}
