<?php
// never try to comment like <!-- --> in php
class Pages extends CI_Controller {
  // pages/view/(home|game|about)
  public function view($page = 'home') {
    // echo 'pages/view' . $page;
    if (!file_exists('application/views/pages/'.$page.'.php')) {
      show_404();
    }
    $data['filename'] = $page;
    $data['title'] = $page;
    $data = array_map('htmlentities', $data);
    $this->load->view('templates/header', $data);
    $this->load->view('pages/'.$page, $data);
    $this->load->view('templates/footer', $data);
  }
  // profile/avatar/(username)
  public function avatar($username = '', $width = 20, $height = 20) {
    $config['new_image'] = 'assets/img/'.$username.$width.$height.'.jpg';
    if (file_exists($config['new_image'].'.jpg'))
      return $config['new_image'].'.jpg';
    $this->load->library('image_lib');
    $config['image_library'] = 'gd2';
    $config['source_image'] = 'assets/img/99.jpg';
    $config['create_thumb'] = TRUE;
    $config['new_image'] = 'assets/img/'.$username.$width.$height.'.jpg';
    $config['maintain_ratio'] = TRUE;
    $config['width'] = $width;
    $config['height'] = $height;
    $config['thumb_marker'] = '';
    $this->image_lib->initialize($config);
    if(!$this->image_lib->resize()) echo $this->image_lib->display_errors();
    // $filename=$config['new_image'].'.png';
    // if(file_exists($filename)){
    //   header('Content-Length: '.filesize($filename));
    //   header('Content-Type: image/png');
    //   header('Content-Disposition: inline; filename="'.$filename.'";');
    //   readfile($filename);
    // }else echo $filename
    return $config['new_image'].'.jpg';
  }


  public function logout() {
    $this->session->sess_destroy();
    redirect($this->input->get('last_url'));
  }

  public function signup() {
    $data['title'] = 'register';
    $data['filename'] = 'register';

    $this->load->library('form_validation');
    $this->form_validation->set_rules('username', 'Username', 'trim|required|is_unique[user.name]|alpha_numeric');
    $this->form_validation->set_rules('password', 'Password', 'trim|required');
    $this->form_validation->set_rules('passconf', 'Password Confirmation', 'trim|required|matches[password]');
    $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[user.email]');

    if ($this->form_validation->run() === FALSE) {
      $this->load->view('templates/header', $data);
      $this->load->view('pages/register');
      $this->load->view('templates/footer', $data);
    } else {
      $this->load->model('User');
      $this->User->insert();
      // $this->session->set_userdata('username', $this->input->post('username'));
      $this->ajax_login();
      redirect(base_url());
    }

  }



  public function test($a = '') {
    $user = getenv("ACTIVEMQ_USER");
    if( !$user ) $user = "admin";

    $password = getenv("ACTIVEMQ_PASSWORD");
    if( !$password ) $password = "password";

    $host = getenv("ACTIVEMQ_HOST");
    if( !$host ) $host = "localhost";

    $port = getenv("ACTIVEMQ_PORT");
    if( !$port ) $port = 61613;

    $destination  = '/queue/Matrix.FOO';

    // $body = "1,0,4,0,0,1,0,0,0,0,1,0,0,0,0,1";
    $body = $this->input->post('body');

    try {
      $url = 'tcp://'.$host.":".$port;
      $stomp = new Stomp($url, $user, $password);
      $stomp->send($destination, $body, array('type' => 'Matrix'));
      // echo "message sent\n";
    } catch(StompException $e) {
      echo $e->getMessage();
    }
    try {
      $stomp->subscribe('/queue/Score.FOO');
      while(true) {
        $frame = $stomp->readFrame();
        if( $frame ) {
          if( $frame->command == "MESSAGE" ) {
            echo $frame->body;
            // var_dump($frame);
          } else {
            echo "Unexpected frame.\n";
            var_dump($frame);
          }
          $stomp->ack($frame);
          break;
        }
      }
    } catch(StompException $e) {
      echo $e->getMessage();
    }
  }
}
?>
