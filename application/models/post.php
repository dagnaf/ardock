<?php
class Post extends CI_Model {

  public function get($data)
  {
    $query = $this->db->from('user')->where($data)->get();
    return $query->row_array();
  }
  public function insert() {
    $this->title = $this->input->post('title');
    $this->content = $this->input->post('content');
    $this->uid = $this->session->userdata('uid');
    $this->db->insert('post', $this);
  }
  public function get_topic($id) {
    $this->db->from('post_brief')->where('id', $id);
    $query = $this->db->get();
    return $query->result();
  }
  public function delete_topic($id) {
    $data['del'] = 1;
    $this->db->where('id', $id);
    $query = $this->db->update('post', $data);
    // return $query->result();
  }
  public function get_topic_row($per_page = 10, $offset = 0, $q = '') {
    $this->db->from('post_brief')->limit($per_page, $offset);
    if ($q != '') {
      $this->db->like('title', $q)->or_like('content', $q)->or_like('username', $q);
    }
    $query = $this->db->get();
    return $query->result();
  }
  public function get_topic_num($q = '') {
    if ($q != '') {
      $this->db->like('title', $q)->or_like('content', $q)->or_like('username', $q);
    }
    return $this->db->count_all_results('post_brief');
  }
  public function get_reply($id) {
    $this->db->from('reply_brief')->where('id', $id);
    $query = $this->db->get();
    return $query->result();
  }
  public function delete_reply($id) {
    $data['del'] = 1;
    $this->db->where('id', $id);
    $query = $this->db->update('reply', $data);
    // return $query->result();
  }
  public function get_reply_row($per_page = 10, $offset = 0, $id) {
    $this->db->from('reply_brief')->where('del', '0')->where('tid', $id)->order_by('time asc')->limit($per_page, $offset);
    $query = $this->db->get();
    return $query->result();
  }
  public function get_reply_num($id) {
    $this->db->where('tid', $id)->where('del', '0');
    return $this->db->count_all_results('reply_brief');
  }
  public function insert_reply($id) {
    $data['tid'] = $id;
    $data['content'] = $this->input->post('content');
    if ($this->input->post('parent'))
      $data['pid'] = $this->input->post('parent');
    $data['uid'] = $this->session->userdata('uid');
    $data['floor'] = $this->db->query("SELECT COUNT(*)+1 as cnt FROM reply WHERE tid = $id")->result()[0]->cnt;
    $this->db->insert('reply', $data);
  }
  public function get_user_post_num($uid) {
    // $data['uid'] = $uid;
    return $this->db->query("SELECT COUNT(*) as cnt FROM post WHERE uid = $uid")->result()[0]->cnt;
  }
  public function get_user_reply_num($uid) {
    // $data['uid'] = $uid;
    return $this->db->query("SELECT COUNT(*) as cnt FROM reply WHERE uid = $uid")->result()[0]->cnt;
  }

}
