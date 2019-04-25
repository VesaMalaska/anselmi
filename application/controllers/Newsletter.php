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

		// load template library for handling the view
		$this->load->library('template');

		// load newsletter view in default template
		$this->template->load('default','newsletter' , $data);
  }

  public function send() {

    /***********************************************************/
    /*     FILE UPLOADS
    /***********************************************************/

    // config for file updloads
    $config['upload_path'] = './tmp/';
    $config['allowed_types'] = 'txt';
    $config['file_name'] = 'email_list.txt';
    $this->load->library('upload', $config);

    // Upload email list file
    $this->upload->do_upload("email_list");

    // Override file name for the other file upload
    $config['file_name'] = 'email_template.html';
    $this->upload->initialize($config);

    // Upload email list file
    $this->upload->do_upload("email_template");

    // Load the email config model
		$this->load->model('email_config_model');

    /***********************************************************/
    /*     EMAIL SETTINGS AND SEND
    /***********************************************************/

    // Get the email config from the database
    $email_config = $this->email_config_model->get_email_config();

    // Load email libary
    $this->load->library('email');

    // Set the SMTP configuration for email to be sent
    $this->email->initialize($email_config);

    // Get the recipient email addresses from the email_list file
    $recipients = "";

    // read file row by row
    while(! feof("/tmp/email_list.txt")) {
      $recipients = fgets("/tmp/email_list.txt").", ";
    }

    // set parameters for email to be sent
    $this->email->from('myynti@toimistopoika1.fi', 'Toimistopoika');
    $this->email->to('palvelu@toimistopoika.fi');
    $this->email->bcc($recipients);

    $this->email->subject('Windows 7 tuki p&auml;&auml;ttyy pian!');
    $this->email->message(readfile("/tmp/email_template.html"));

    $this->email->send();

    /***********************************************************/
    /*     LOADING VIEW
    /***********************************************************/

    // page title
    $data['page_title'] = 'Uutiskirjeiden l&auml;hett&auml;minen';

		// load template library for handling the view
		$this->load->library('template');

		// load newsletter view in default template
		$this->template->load('default','newsletter' , $data);
  }
}
