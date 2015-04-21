<?php
class Score extends CI_Model {

  public function insert() {
    $this->uid = $this->session->userdata('uid');
    $ligname = $this->input->post('lig');
    $recname = $this->input->post('rec');

    $this->lid = $this->db->query("SELECT * FROM molecule WHERE name='$ligname'")->result()[0]->id;
    $this->rid = $this->db->query("SELECT * FROM molecule WHERE name='$recname'")->result()[0]->id;
    $this->result = $this->input->post('result');
    $this->mark = $this->input->post('mark');
    $this->matrix = $this->input->post('matrix');
    // var_dump($this);
    return $this->db->insert('score', $this);
  }

  public function get_top($offset, $limit){
    $limit += 1;
    $sql = "SELECT user.id AS uid, user.name AS username,sum(mark) AS sumscore FROM score JOIN user ON(user.id = score.uid) GROUP BY user.id ORDER BY sumscore DESC,user.id ASC LIMIT $offset,$limit";
    $query = $this->db->query($sql);
    // return $query->result_array();
    return $query->result();
  }



}
