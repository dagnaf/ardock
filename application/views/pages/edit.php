<?php
function avatar($uid) {
  $img_file = 'assets/img/avatar/' . $uid . '.png';
  if (file_exists($img_file)) return base_url() . $img_file;
  else return base_url() . 'assets/img/markers/'.($uid%100);

}
?>
<style type="text/css">
input[type=file] {
  display: none;
}
.btn-avatar {
  margin-left: 15px;
}
.crop {
  width: 140px;
  height: 140px;
  overflow: hidden;
}
.photo-container {
  margin: 0 auto;
  overflow: hidden;
  width: 480px;
  /*height: 480px;*/
}
.photo-container canvas {
/*  -webkit-transform: scale(-1,1);
  -moz-transform: scale(-1,1);
*/  margin-left: -80px;
}
</style>
<div class="page-header">
  <h1>EDIT<small> PROFILE</small></h1>
</div>
<?php if (isset($msg)) { ?>
<div class="alert alert-info alert-dismissible fade in" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
  <strong>Success!</strong> Your profile is updated.
</div>
<?php } ?>
<form class="form-horizontal edit-form" role="form" action="<?php echo base_url(); ?>edit" method="post">
  <div class="form-group">
    <label for="inputAvatar" class="col-xs-3 control-label">AVATAR</label>
    <div class="col-xs-5">
      <div class="img-thumbnail pull-left">
      <div class="crop">
        <img class="img-preview" data-src="holder.js/140x140" alt="140x140" src="<?php echo avatar($this->session->userdata('uid'));?>">
      </div>
    </div>
      <div class="col-xs-4">
      <div class="btn-group">
        <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">
          CHANGE AVATAR <span class="caret"></span>
        </button>
        <ul class="dropdown-menu" role="menu">
          <li><a href="javascript:void(0);" class="btn-upload">UPLOAD PHOTO</a></li>
          <li><a href="javascript:void(0);" class="btn-photo">TAKE PHOTO</a></li>
        </ul>
      </div>
    </div>
      <input type="file" class="form-control" placeholder="AVATAR">
      <input type="hidden" name="src">
      <input type="hidden" name="submit" value="submit">
    </div>
  </div>
<!--   <div class="form-group">

  </div> -->
  <div class="form-group">
    <label for="inputCurrentPassword" class="col-xs-3 control-label">CURRENT PASSWORD</label>
    <div class="col-xs-5">
      <input type="password" class="form-control" name="current" value="" placeholder="CURRENT PASSWORD">
    </div>
  </div>
  <div class="form-group">
    <label for="inputPassword" class="col-xs-3 control-label">NEW PASSWORD</label>
    <div class="col-xs-5">
      <input type="password" class="form-control" name="password" value="" placeholder="NEW PASSWORD">
    </div>
  </div>
  <div class="form-group">
    <label for="inputConfirm" class="col-xs-3 control-label">CONFIRM PASSWORD</label>
    <div class="col-xs-5">
      <input type="password" class="form-control" name="passconf" placeholder="PASSWORD CONFIRM">
    </div>
    <div class="col-xs-offset-3 col-xs-9">
      <p class="form-control-static">LEAVE ALL PASSWORDS EMPTY IF NOT WANT TO CHANGE</p>
    </div>
  </div>
  <div class="form-group">
    <div class="col-xs-offset-3 col-xs-5">
      <button type="submit" class="btn btn-default btn-save" value="SAVE">SAVE</button>
      <button type="button" class="btn btn-default btn-reset" value="CANCEL">CANCEL</button>
    </div>
  </div>
</form>
          <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <form class="form-horizontal" role="form" action="<?php echo base_url();?>login" method="post">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="myModalLabel">TAKE A PHOTO</h4>
                  </div>
                  <div class="modal-body">
                    <div class="photo-container">
                      <canvas id="canvasPhoto"></canvas>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <label for="loading" class="col-xs-offset-4 col-xs-3 control-label" style="display: none;">
                      <span class="glyphicon glyphicon-refresh"></span> LOADING
                    </label>
                    <button type="button" class="btn btn-default" for="btn-take">TAKE</button>
                    <button type="button" class="btn btn-default" for="btn-ok">OK</button>
                    <button type="button" class="btn btn-default" for="btn-retake">RETAKE</button>
                    <button type="button" class="btn btn-default" for="btn-notake">CLOSE</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
<!-- <img id="image-preview">
<div></div>
    <a href="#" class="btn btn-upload">Choose your photo</a>
    <div class="fileupload">
        <label for="picture">Your Image:</label>
        <input type='file' name="picture" id="picture" enctype = "multipart/form-data" required />
    </div> -->
