<?php
class User extends CI_Controller {

  public function __construct()
  {
    parent::__construct();
    $this->load->model('user_model');
  }


public function index(){
  $data['user'] = $this->user_model->get_user();
  $data['rank'] = $this->user_model->get_rank();
  $data['title'] = 'user info';
  $this->load->view('templates/header', $data);
  
  $this->load->view('pages/user', $data);
  $this->load->view('templates/footer');
}
}