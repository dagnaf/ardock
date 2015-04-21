<?php
// never try to comment like <!-- --> in php
class Board extends CI_Controller {
  public function __construct()
  {
    parent::__construct();
    // var_dump($this->config);
    $this->load->model('Post');
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
  public function index($page = 1) {
    // var_dump($this->page_config);
    if ($page <= 0) $page = 1;
    $data['filename'] = 'board';
    $data['title'] = 'board';

    if ($this->input->post('post') == 'post' &&
      $this->session->userdata('username')) {
      // echo 'login and submit';
      $this->Post->insert();
      $this->session->set_flashdata('msg', 'success');
      redirect('board');
    }
    $this->page_config['base_url'] = base_url() . "board";
    $this->page_config['uri_segment'] = 2;
    $data['offset'] = ($page - 1) * $this->page_config['per_page'];
    $data['rows'] = $this->Post->get_topic_row($this->page_config['per_page'], $data['offset']);
    $data['total_rows'] = $this->Post->get_topic_num();
    $this->page_config['total_rows'] = $data['total_rows'];
    //     var_dump($data);
    // var_dump($this->page_config);

    $this->pagination->initialize($this->page_config);
    $data['page_html'] = $this->pagination->create_links();
    $this->load->view('templates/header', $data);
    $this->load->view('pages/board', $data);

    $this->load->view('templates/footer', $data);
  }
  function search($q = '', $page = 1) {
    // var_dump($this->input->get('q'));
    if ($this->input->get('q')) {
      // FIXME: escape character
      redirect(base_url() . 'board/search/'.$this->input->get('q'));
    }
    if ($q == '') redirect('board');
    if ($page <= 0) $page = 1;
    $data['filename'] = 'board';
    $data['title'] = 'board';

    $this->page_config['base_url'] = base_url() . "board/search/$q";
    $this->page_config['uri_segment'] = 4;
    $data['offset'] = ($page - 1) * $this->page_config['per_page'];
    $data['rows'] = $this->Post->get_topic_row($this->page_config['per_page'], $data['offset'], $q);
    $data['total_rows'] = $this->Post->get_topic_num($q);
    $this->page_config['total_rows'] = $data['total_rows'];

    $data['q'] = $q;
    $this->pagination->initialize($this->page_config);
    $data['page_html'] = $this->pagination->create_links();
    $this->load->view('templates/header', $data);
    $this->load->view('pages/board', $data);
    $this->load->view('templates/footer', $data);

  }

  public function post($id, $page = 1) {
    $data['id'] = $id;
    $data['title'] = 'post';
    $data['filename'] = 'board';
    $data['page'] = $page;

    $this->load->view('templates/header', $data);

    $data['trow'] = $this->Post->get_topic($id);
    if (count($data['trow']) == 0) {
      $this->load->view('pages/404');
      $this->load->view('templates/footer');
    }

    if ($this->input->post('post') == 'post' &&
      $this->session->userdata('username')) {
      // echo 'login and submit';
      $this->Post->insert_reply($id);
      $this->session->set_flashdata('msg', 'success');
      redirect("post/$id/$page");
    }

    $this->page_config['base_url'] = base_url() . "post/$id";
    $this->page_config['uri_segment'] = 3;
    $this->page_config['per_page'] = 5;
    $data['per_page'] = $this->page_config['per_page'];
    $data['post_base_url'] = $this->page_config['base_url'];

    $data['offset'] = ($page - 1) * $this->page_config['per_page'];
    $data['rows'] = $this->Post->get_reply_row($this->page_config['per_page'], $data['offset'], $id);
    $data['total_rows'] = $this->Post->get_reply_num($id);
    $this->page_config['total_rows'] = $data['total_rows'];
    $this->pagination->initialize($this->page_config);
    $data['page_html'] = $this->pagination->create_links();
    $this->load->view('pages/reply', $data);

    $this->load->view('templates/footer', $data);
  }
}
