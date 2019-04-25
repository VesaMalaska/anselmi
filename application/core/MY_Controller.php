<?php
// application/core/My_Controller.php
class MY_Controller extends CI_Controller
{
    public function __construct()
    {
      parent::__construct();



      $this->load->helper('url');
  		$this->load->library('tank_auth');
  		if (!$this->tank_auth->is_logged_in()) {
  		// save the visitors entry point and redirect to login
  		$this->session->set_userdata('redirect', $this->uri->uri_string());
			redirect('/auth/login/');
			exit;
		}

		// Set userID variable
		$userID = $this->tank_auth->get_user_id();

		// Load the needed models
		$this->load->model('user_model');
		
    }
}
?>
