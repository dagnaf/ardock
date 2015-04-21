<?php
// never try to comment like <!-- --> in php
class Actions extends CI_Controller {
  public function delete($table, $id) {
    if ($table == 'post') {
      $this->load->model('Post');
      $row = $this->Post->get_topic($id);
      if ($row[0]->uid == $this->session->userdata('uid')) {
        $this->Post->delete_topic($id);
        redirect(base_url().'board');
      }
    }
    if ($table == 'reply') {
      $this->load->model('Post');
      $row = $this->Post->get_reply($id);
      if ($row[0]->uid == $this->session->userdata('uid')) {
        $this->Post->delete_reply($id);
        redirect(base_url().'post/'.$row[0]->tid);
      }
    }
  }
}
