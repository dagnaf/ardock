<?php
class User extends CI_Model {

  var $id = '';
  var $name = '';
  var $passwd = '';
  var $email = '';
  var $data = '';
  public function get($data)
  {
    $query = $this->db->from('user')->where($data)->get();
    if ($query->num_rows() == 0) return FALSE;
    else if ($query->num_rows() == 1) return $query->row(0);
    return $query->result();
  }
  public function insert() {
    $this->name = $this->input->post('username');
    $this->passwd = sha1($this->input->post('password'));
    $this->email = $this->input->post('email');
    $this->db->insert('user', $this);
  }
  public function get_num_of($table)
  {
    $uid = $this->data->id;
    return $this->db->query("SELECT COUNT(*) AS cnt FROM $table WHERE uid = '$uid'")->result()[0]->cnt;
  }
  public function get_num_of_users()
  {
    return $this->db->query("SELECT COUNT(*) AS cnt FROM user")->result()[0]->cnt;
  }
  public function get_mark_and_rank(){
    $uid = $this->data->id;
    $query = $this->db->query("SELECT fwq.sumscore,COUNT(*)+1 AS rank FROM (SELECT SUM(mark) AS sumscore, uid FROM score GROUP BY uid) AS tmp JOIN (SELECT SUM(mark) AS sumscore, uid FROM score WHERE uid='$uid') AS fwq WHERE tmp.uid != fwq.uid AND ((tmp.sumscore > fwq.sumscore) OR (tmp.sumscore = fwq.sumscore AND tmp.uid < fwq.uid))");
    return $query->result()[0];
  }
  public function init($data)
  {
    return $this->data = $this->get($data);
  }
  public function get_all_post($offset, $limit)
  {
    $uid = $this->data->id;
    $query = $this->db->query("SELECT * FROM post_brief WHERE uid='$uid' ORDER BY time DESC LIMIT $offset,$limit");
    return $query->result();
  }
}
