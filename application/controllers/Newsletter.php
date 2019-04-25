<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Newsletter extends MY_Controller {

  public function index() {
    // Set userID variable
		$userID = $this->tank_auth->get_user_id();

		// Get user ID and user name from session variables via Tank_auth library
		$data['user_id']	= $this->tank_auth->get_user_id();
		$data['username']	= $this->tank_auth->get_username();

		// check is user in admin group
		$data['isAdmin'] = $this->user_model->is_user_admin($userID);

    // page title
    $data['page_title'] = 'Uutiskirjeiden l&auml;hett&auml;minen';

    // Load the email config model
		$this->load->model('email_config_model');

    // Get the email config from the database
    $email_config = $this->email_config_model->get_email_config();

    // put the email config data to data array
    $data['email_config_set_name'] = $email_config['config_set_name'];
    $data['email_protocol'] = $email_config['protocol'];
    $data['email_smtp_host'] = $email_config['smtp_host'];
    $data['email_smtp_user'] = $email_config['smtp_user'];
    $data['email_smtp_pass'] = $email_config['smtp_pass'];
    $data['email_smtp_port'] = $email_config['smtp_port'];
    $data['email_smtp_crypto'] = $email_config['smtp_crypto'];
    $data['email_mailtype'] = $email_config['mailtype'];
    $data['email_charset'] = $email_config['charset'];
    $data['email_crlf'] = $email_config['crlf'];
    $data['email_newline'] = $email_config['newline'];

		// load template library for handling the view
		$this->load->library('template');

		// load newsletter view in default template
		$this->template->load('default','newsletter' , $data);
  }
}
