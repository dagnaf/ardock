<style type="text/css">
.preview {
  display: block;
  width: 300px;
  height: 150px;
  /*background-color: teal;*/
  border-radius: 5px;
  background-repeat: no-repeat;
  background-position: 0% 0%;
  transition: ease 750ms background-position;
}
#p1.preview:hover,
#p1.preview:focus {
  background-position: 50% 70%;
}
#p2.preview:hover,
#p2.preview:focus {
  background-position: 100% 0%;
}
#p3 {
  background-position: 100% 0%;
}
#p3.preview:hover,
#p3.preview:focus {
  background-position: 30% 10%;
}
.preview span {
  text-shadow: 1px 1px 0 #fff, 1px -1px 0 #fff, -1px 1px 0 #fff, -1px -1px 0 #fff;
  font-size: 20px;
  text-decoration: underline;
  position: absolute;
  bottom: 10px;
  left: 40px;
}
.jumbotron video {
  width: 400px;
  float: right;
  border-radius: 5px;
  margin-top: -10px;
}
</style>
<div class="jumbotron">
<video src="http://localhost/ci/assets/video/demo.mp4" controls="" ></video>
  <h1>ARDock</h1>
  <p>DOCKING in AUGMENTED REALITY</p>
  <p><a class="btn btn-primary btn-success btn-lg" role="button" href="<?php echo base_url(); ?>game">START</a></p>
</div>
<div class="row">

<div class="col-xs-4">
  <a id="p2" href="<?php echo base_url() . 'markers'; ?>" class="preview"
  style="background-image: url(<?php echo base_url() . 'assets/img/markers-preview.png' ?>);"
  >
    <span>Control Markers</span>
  </a>
</div>
<div class="col-xs-4">
  <a id="p1" href="<?php echo base_url() . 'game'; ?>" class="preview"
  style="background-image: url(<?php echo base_url() . 'assets/img/game-preview.png' ?>);"
  >
    <span>Visualize Molecules</span>
  </a>
</div>
<div class="col-xs-4">
  <a id="p3" href="<?php echo base_url() . 'about#share'; ?>" class="preview"
  style="background-image: url(<?php echo base_url() . 'assets/img/share-preview2.jpg' ?>);"
  >
    <span>Share with Us</span>
  </a>
</div>
</div>
