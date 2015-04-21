<?php
// never try to comment like <!-- --> in php
class Ajax extends CI_Controller {
  // pages/view/(home|game|about)
  public function view($page = 'home') {
    // echo func_num_args() . '<br />';
    // for ($i = 0; $i < func_num_args(); ++$i)
    //   echo func_get_arg($i) . '~<br />';
    // echo 'in pages/view';
    if ( ! file_exists('application/views/pages/'.$page.'.php'))
    {
      show_404();
    }
    // echo $page;
    $data['title'] = $page;
    // $data['script'] = $page;
    // $data['query'] = func_get_args();

    $this->load->view('templates/header', $data);
    $this->load->view('pages/'.$page, $data);
    $this->load->view('templates/footer', $data);
  }
  // profile/(username)/avatar
  public function avatar($username = '', $width = 20, $height = 20) {
    // echo $username . '<br />';
    // echo $width . '<br />';
    // echo $height;
    // $path = 'assets/img/16.png';
    // $this->load->library('image_lib');
    // // $this->image_lib->clear();
    // $imageinit['image_library']   = 'gd2';
    // $imageinit['quality']     = '90%';
    // $imageinit['dynamic_output']  = true;
    // $imageinit['source_image']    = $path;
    // $imageinit['maintain_ratio']  = false;
    // $imageinit['width']       = $width;
    // $imageinit['height']      = $height;

    // $this->image_lib->initialize($imageinit);
    // if(!$this->image_lib->resize()){
    //   echo $this->image_lib->display_errors();
    // }

    $filename='assets/img/16.png'; //<-- specify the image  file
    if(file_exists($filename)){
      header('Content-Length: '.filesize($filename)); //<-- sends filesize header
      header('Content-Type: image/png'); //<-- send mime-type header
      header('Content-Disposition: inline; filename="'.$filename.'";'); //<-- sends filename header
      readfile($filename); //<--reads and outputs the file onto the output buffer
      // die(); //<--cleanup
      // exit; //and exit
    }

    // $img_src = 'assets/img/16.png';
    // $imgbinary = fread(fopen($img_src, "r"), filesize($img_src));
    // $img_str = base64_encode($imgbinary);
    // echo 'data:image/jpg;base64,'.$img_str;
  }
  // not complete
  // login through ajax
  public function login() {
    $this->load->model('User');
    $data['name'] = $this->input->post('username');
    $user = $this->User->get($data);
    if (!$user) {
      echo 'USERNAME NOT FOUND';
      return;
    }
    // $data['passwd'] = sha1($this->input->post('password'));
    $data['passwd'] = $this->input->post('password');
    $user = $this->User->get($data);
    if (!$user) {
      echo 'USERNAME & PASSWORD MISMATCH!';
      return;
    }
    // print_r($user);
    $this->session->set_userdata('username', htmlentities($user->name));
    $this->session->set_userdata('uid', $user->id);
    echo 0;
  }

  function captcha() {
    $this->load->helper('captcha');
    $vals = array(
      'img_path' => 'assets/img/captcha/',
      'img_url' => base_url().'assets/img/captcha/',
      'img_width' => 71,
      'img_height' => 34,
      'expiration' => 180
    );

    $cap = create_captcha($vals);

    $data = array(
        'captcha_time' => $cap['time'],
        'ip_address' => $this->input->ip_address(),
        'word' => $cap['word']
    );

    $query = $this->db->insert_string('captcha', $data);
    $this->db->query($query);

    // echo '提交下面的验证码:';
    echo $cap['image'];
    // echo '<input type="text" name="captcha" value="" />';
  }
  function score() {
    echo 'ajax/score';
    $this->load->model('Score');
    if ($this->Score->insert()) {
      return 'success';
    } else {
      return 'failure';
    }
  }
}
?>
