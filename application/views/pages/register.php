<?php
$username = $this->session->userdata('username');
if ($username) {
  redirect(base_url());
}
$errors = validation_errors();
if (strcmp($errors, '') != 0) {
?>
<div class="alert alert-warning alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
  <?php echo $errors; ?>
</div>
<?php
}
?>

<div class="page-header">
  <h1>REGISTER<small> PLAY AND POST</small></h1>
</div>

<form class="form-horizontal" role="form" action="<?php echo base_url(); ?>register" method="post">
  <div class="form-group">
    <label for="inputUsername" class="col-xs-2 control-label">USERNAME</label>
    <div class="col-xs-5">
      <input type="username" class="form-control" name="username" value="<?php echo set_value('username'); ?>" placeholder="USERNAME" required>
    </div>
  </div>
  <div class="form-group">
    <label for="inputEmail" class="col-xs-2 control-label">E-MAIL</label>
    <div class="col-xs-5">
      <input type="email" class="form-control" name="email" value="<?php echo set_value('email'); ?>" placeholder="EMAIL" required>
    </div>
  </div>
  <div class="form-group">
    <label for="inputPassword" class="col-xs-2 control-label">PASSWORD</label>
    <div class="col-xs-5">
      <input type="password" class="form-control" name="password" placeholder="PASSWORD" required>
    </div>
  </div>
  <div class="form-group">
    <label for="inputConfirm" class="col-xs-2 control-label">CONFIRM</label>
    <div class="col-xs-5">
      <input type="password" class="form-control" name="passconf" placeholder="PASSWORD CONFIRM" required>
    </div>
  </div>
  <div class="form-group">
    <div class="col-xs-offset-2 col-xs-5">
      <button type="submit" class="btn btn-default" value="SIGN UP">SIGN UP</button>
    </div>
  </div>
</form> 