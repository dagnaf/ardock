<?php
class Molecule extends CI_Model {

  public function getAll()
  {
    $sql = "SELECT * FROM molecule";
    $query = $this->db->query($sql);
    return $query->result();
  }
}
