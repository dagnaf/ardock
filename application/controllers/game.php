<?php
class Game extends CI_Controller {

  public function __construct()
  {
    parent::__construct();
    $this->load->model('molecule');
  }


  public function index() {
    $data['title'] = 'game';
    $data['filename'] = 'game';
    $data['molecules'] = $this->molecule->getAll();
    $this->load->view('templates/header', $data);
    $this->load->view('pages/game', $data);
    $this->load->view('templates/footer', $data);
  }
}
