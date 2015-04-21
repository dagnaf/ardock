<?php
class Rank extends CI_Controller {

  public function __construct()
  {
    parent::__construct();
    $this->load->model('Score');
    $this->per_page = 14;
    $this->first_page = 10;
  }


  public function index($page = 1, $rank_name = ''){
    // echo $page;
    $page -= 1;
    $data['page'] = $page;
    if ($page == 0){
      $data['offset'] = 1;
      $data['score'] = $this->Score->get_top(0, $this->first_page+1);
      $data['limit'] = min(array(count($data['score']), $this->first_page));
    } else if ($page > 0) {
      $data['offset'] = $page*$this->per_page-3;
      $data['score'] = $this->Score->get_top($page*$this->per_page-3-1, $this->per_page+1);
      $data['limit'] = min(array(count($data['score']), $this->per_page));
    } else{
      redirect(base_url() . 'rank');
    }
    $data['per_page'] = $this->per_page;
    $data['first_page'] = $this->first_page;
    $data['rank_name'] = $rank_name;
    $data['title'] = 'rank';
    $data['filename'] = 'rank';
    $this->load->view('templates/header', $data);
    $this->load->view('pages/rank', $data);
    $this->load->view('templates/footer', $data);
  }
  public function user($name) {
    $this->load->model('User');
    if (!$this->User->init(array('name' => $name))) {
      redirect('rank');
    }
    $rank = $this->User->get_mark_and_rank()->rank;
    // 1 1-10
    // 2 11 24
    // 3 25
    // echo $rank . 'rank';
    if ($rank <= $this->first_page){
      $this->index(1, $this->User->data->id);
    } else {
    // echo floor(($rank-$this->first_page-1)/$this->per_page)+1;
      $this->index(floor(($rank-$this->first_page-1)/$this->per_page)+2, $this->User->data->id);
    }
  }
}
