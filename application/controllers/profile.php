<?php
// never try to comment like <!-- --> in php
class Profile extends CI_Controller {
  public function __construct()
  {
    parent::__construct();
    // var_dump($this->config);
    $this->load->library('pagination');
    $config['per_page'] = 10;
    $config['use_page_numbers'] = TRUE;
    $config['page_query_string'] = FALSE;
    $config['first_link'] = 'FIRST';
    $config['first_tag_open'] = '<li>';
    $config['first_tag_close'] = '</li>';
    $config['last_link'] = 'LAST';
    $config['last_tag_open'] = '<li>';
    $config['last_tag_close'] = '</li>';
    $config['next_link'] = '&raquo;';
    $config['next_tag_open'] = '<li>';
    $config['next_tag_close'] = '</li>';
    $config['prev_link'] = '&laquo;';
    $config['prev_tag_open'] = '<li>';
    $config['prev_tag_close'] = '</li>';
    $config['cur_tag_open'] = '<li class="active"><a>';
    $config['cur_tag_close'] = '</a></li>';
    $config['num_tag_open'] = '<li>';
    $config['num_tag_close'] = '</li>';
    $config['full_tag_open'] = '<div style="margin: -20px 0;"><ul class="pagination">';
    $config['full_tag_close'] = '</ul></div>';
    $this->page_config = $config;
  }
  public function index($name, $page = 'post', $p = 1) {
    if ((!$name && !$this->session->userdata('username')) ||
      !in_array($page, array('reply', 'submission', 'post'))) {
      $data['title'] = '404';
      $this->load->view('templates/header', $data);
      $this->load->view('pages/404', $data);
      $this->load->view('templates/footer', $data);
      return;
    }
    if ($p <= 0) {
      $p = 1;
    }
    $this->data['filename'] = 'profile';
    $this->data['page'] = $page;
    $this->data['p'] = $p;
    $this->load->model('User');
    $this->User->init(array('name' => $name));
    $this->data['profile'] = $this->User->data;
    $this->data['num_post'] = $this->User->get_num_of('post_brief');
    $this->data['num_reply'] = $this->User->get_num_of('reply');
    $this->data['num_submission'] = $this->User->get_num_of('score');
    $this->data['mark'] = $this->User->get_mark_and_rank()->sumscore;
    $this->data['rank'] = $this->User->get_mark_and_rank()->rank;
    $this->data['num_user'] = $this->User->get_num_of_users();
    $this->$page($p);
  }

  public function submission($p) {
    $this->data['title'] = 'Profile - Submission';

    $name = $this->data['profile']->name;

    $this->page_config['base_url'] = base_url() . "profile/$name/submission";
    $this->page_config['uri_segment'] = 4;
    $this->data['offset'] = ($p - 1) * $this->page_config['per_page'];

    $data['total_rows'] = $this->data['num_post'];
    $this->page_config['total_rows'] = $data['total_rows'];
    //     var_dump($data);
    // var_dump($this->page_config);

    $this->pagination->initialize($this->page_config);
    $this->data['page_html'] = $this->pagination->create_links();


    $this->data['posts'] = $this->User->get_all_post($this->data['offset'], $this->page_config['per_page']);

    $this->load->view('templates/header', $this->data);
    $this->load->view('pages/profile', $this->data);
    $this->load->view('pages/user-submission', $this->data);
    $this->load->view('templates/footer', $this->data);
  }
  public function post($p) {
    $this->data['title'] = 'Profile - Post';
    // echo $p;
    // echo $this->data['num_post'];
    $name = $this->data['profile']->name;

    $this->page_config['base_url'] = base_url() . "profile/$name/post";
    $this->page_config['uri_segment'] = 4;
    $this->data['offset'] = ($p - 1) * $this->page_config['per_page'];

    $data['total_rows'] = $this->data['num_post'];
    $this->page_config['total_rows'] = $data['total_rows'];
    //     var_dump($data);
    // var_dump($this->page_config);

    $this->pagination->initialize($this->page_config);
    $this->data['page_html'] = $this->pagination->create_links();


    $this->data['posts'] = $this->User->get_all_post($this->data['offset'], $this->page_config['per_page']);

    $this->load->view('templates/header', $this->data);
    $this->load->view('pages/profile', $this->data);
    $this->load->view('pages/user-post', $this->data);
    $this->load->view('templates/footer', $this->data);
  }
  public function reply($p) {
    $this->data['title'] = 'Profile - Reply';

    $name = $this->data['profile']->name;

    $this->page_config['base_url'] = base_url() . "profile/$name/reply";
    $this->page_config['uri_segment'] = 4;
    $this->data['offset'] = ($p - 1) * $this->page_config['per_page'];

    $data['total_rows'] = $this->data['num_post'];
    $this->page_config['total_rows'] = $data['total_rows'];
    //     var_dump($data);
    // var_dump($this->page_config);

    $this->pagination->initialize($this->page_config);
    $this->data['page_html'] = $this->pagination->create_links();


    $this->data['posts'] = $this->User->get_all_post($this->data['offset'], $this->page_config['per_page']);

    $this->load->view('templates/header', $this->data);
    $this->load->view('pages/profile', $this->data);
    $this->load->view('pages/user-reply', $this->data);
    $this->load->view('templates/footer', $this->data);
  }
}
