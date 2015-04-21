<?php
// never try to comment like <!-- --> in php
class Edit extends CI_Controller {

  public function index() {
    $data['title'] = 'edit';
    $data['filename'] = 'edit';
    if ($this->session->flashdata('msg')) {
      $data['msg'] = $this->session->flashdata('msg');
    }
    if (!$this->session->userdata('uid')) {
      redirect('home');
      return;
    }
    if ($this->input->post('submit')) {
      if ($this->input->post('src')) {
        $img = $this->input->post('src');
        // echo $img;
        $img = str_replace('data:image/png;base64,', '', $img);
        $img = str_replace('data:image/jpeg;base64,', '', $img);
        $img = str_replace('data:image/gif;base64,', '', $img);
        $img = str_replace('data:;base64,', '', $img);
        $img = str_replace(' ', '+', $img);
        // echo '<br/>' . $img;
        $file = 'assets/img/avatar/' . $this->session->userdata('uid') . '.png';
        $imgDecoded = base64_decode($img);
        $im = imagecreatefromstring($imgDecoded);
        imagesavealpha($im, true);
        $origWidth = imagesx($im);
        $origHeight = imagesy($im);
        $x = ($origWidth-$origHeight)/2;
        $w = $origWidth < $origHeight ? $origWidth : $origHeight;
        // echo '<br/>' . $origWidth . ' x ' . $origHeight . ' = ' . $x;
        $imNew = imagecreatetruecolor(140, 140);
        imagealphablending($imNew, false);
        imagesavealpha($imNew, true);
        // Re-sample image to smaller size and display
        // bool imagecopyresampled ( resource $dst_image , resource $src_image , int $dst_x , int $dst_y , int $src_x , int $src_y , int $dst_w , int $dst_h , int $src_w , int $src_h )
        imagecopyresampled($imNew, $im, 0, 0, ($x > 0 ? $x : 0), ($x < 0 ? -$x : 0), 140, 140, $w, $w);
        // imagepng($imNew, $file);
        imagepng($imNew, $file);
        imagedestroy($im);
        imagedestroy($imNew);
      }
      $this->session->set_flashdata('msg', 'success');
      redirect('edit');
    }
    $this->load->view('templates/header', $data);
    $this->load->view('pages/edit');
    $this->load->view('templates/footer', $data);
  }

}
