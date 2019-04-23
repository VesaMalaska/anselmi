<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users_Controller extends MY_Controller {

  public function index() {
    // Set userID variable
		$userID = $this->tank_auth->get_user_id();

		// Get user ID and user name from session variables via Tank_auth library
		$data['user_id']	= $this->tank_auth->get_user_id();
		$data['username']	= $this->tank_auth->get_username();

		// check is user in admin group
		$data['isAdmin'] = $this->user_model->is_user_admin($userID);

		// get the operator online status
		$data['operatorOnlineStatus'] = $this->operator_model->get_operator_online_status($userID);

		// test online operators check
		$data['operatorsOnline'] = $this->operator_model->is_there_online_operators();

    // page title
    $data['page_title'] = 'K&auml;ytt&auml;j&auml;t';

    // get list of all operators in the system
    $list_of_operators = $this->operator_model->get_all_operators();

    /* ****************************************** */
    // create a table of operators
    $this->load->library('table');

    // set table open tag properties
    $template = array( 'table_open' => '<table class="table table-striped cmu_table">' );
    $this->table->set_template($template);

    $this->table->set_heading(array('#', '<input class="table_checkbox" type="checkbox" id="select_all_checkbox">', 'Nimi', 'Email', '', '<a href="" class="btn btn-danger btn-sm"><i class="far fa-trash-alt table-icon" id="table-icon-delete-selected"></i></a>'));

    // loop through operators and put them to table
    foreach($list_of_operators as $operator){
      $table_row_array[0] = $operator['id'];
      $table_row_array[1] = '<input class="table_checkbox" type="checkbox" id="select_'.$operator['id'].'" value="'.$operator['id'].'">';
      $table_row_array[2] = $operator['username'];
      $table_row_array[3] = $operator['email'];
      $table_row_array[4] = '<a href="" class="btn btn-info btn-sm"><i class="fas fa-pencil-alt table-icon"></i></a>';
      $table_row_array[5] = '<a href="" class="btn btn-info btn-sm"><i class="far fa-trash-alt table-icon"></i></a>';

      $this->table->add_row($table_row_array);
    }

    $data['operatorsTable'] = $this->table->generate();
    /* ****************************************** */

		// load template library for handling the view
		$this->load->library('template');

		// if user is admin then load list_users view in default template
		if($data['isAdmin']) {
			$this->template->load('default','users/list_users' , $data);
		}
    // if user is NOT admin then show access denied page
		else {
			$this->template->load('default','access_denied' , $data);
		}
  }
}
