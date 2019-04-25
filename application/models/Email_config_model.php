<?php

class Email_config_model extends CI_Model{
  public function __construct(){
    $this->load->database();
  }

  public function get_email_config(){
    // Fetch email configs from database
    $query = $this->db->get_where('email_config', array('ID' => 1));
    $email_config = $query->row_array();

    if (isset($email_config))
    {
      return $email_config;
    } else {
      return 0;
    }
  }
}
