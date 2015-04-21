<?php 

class Preview extends CI_Controller {

	// function preview()
	// {
	// 	parent::__construct();	
		
	// 	// $this->load->helper('url');
	// }
	
	function index($height='20',$width='20')
	{
		// header('content-type: image/png');
		$arr_data['height']	=	$height;
		$arr_data['width']	=	$width;
		$arr_data['src']	=	$this->get_photo();
		$this->load->view('preview', $arr_data);
	}
	
	public function get_photo($a = '',$width = 20, $height = 20) {
		header('content-type: image/png');

		// $path = 'assets/img/16.png';
		// $this->load->library('image_lib');
		// // $this->image_lib->clear();
		// $imageinit['image_library'] 	= 'gd2';
		// $imageinit['quality']			= '90%';
		// $imageinit['dynamic_output']	= true;
		// $imageinit['source_image'] 		= $path;
		// $imageinit['maintain_ratio'] 	= false;
		// $imageinit['width'] 			= $width;
		// $imageinit['height'] 			= $height;
		
		// $this->image_lib->initialize($imageinit);
		// if(!$this->image_lib->resize()){
		// 	echo $this->image_lib->display_errors();
		// }
		$img_src = 'assets/img/99.png';
$imgbinary = fread(fopen($img_src, "r"), filesize($img_src));
$img_str = base64_encode($imgbinary);
echo 'data:image/png;base64,'.$img_str;
	}
}
