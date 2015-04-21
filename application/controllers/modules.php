<?php
// never try to comment like <!-- --> in php
class Modules extends CI_Controller {
  public function nav($module) {
    $this->load->view('modules/nav-'.$module);
  }
  public function html($module) {
    if ($this->input->get('recname')) {
      $viewname = 'modules/html-'.$module.'-'.strtolower($this->input->get('recname'));
      if (!file_exists('application/views/'.$viewname.'.php')) {
        show_404();
      }
      $this->load->view($viewname);
    } else {
      $this->load->view('modules/html-'.$module);
    }
  }
}
