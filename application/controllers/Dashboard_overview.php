<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_overview extends MY_Controller {

	public function index()
	{
		// Set userID variable
		$userID = $this->tank_auth->get_user_id();

		// Get user ID and user name from session variables via Tank_auth library
		$data['user_id']	= $this->tank_auth->get_user_id();
		$data['username']	= $this->tank_auth->get_username();

		// check is user in admin group
		$data['isAdmin'] = $this->user_model->is_user_admin($userID);

		// load template library for handling the view
		$this->load->library('template');

		// if user is admin then load admin version of Dashboard overview page
		if($data['isAdmin']) {
			$this->template->load('default','dashboard_overview_admin' , $data);
		}
		else {
			$this->template->load('default','dashboard_overview_operator' , $data);
		}

	}

}
