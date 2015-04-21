<?php
$username = $this->session->userdata('username');
$uid = $this->session->userdata('uid');
?>

<!DOCTYPE html>
<html lang="en"><head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/img/favicon.ico">

    <title><?php echo strtoupper($title); ?> - ARDOCK</title>
    <!-- Bootstrap core CSS -->
    <link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/css/bootstrap-theme.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="<?php echo base_url(); ?>assets/css/sticky-footer-navbar.css" rel="stylesheet">

    <link  href="<?php echo base_url(); ?>assets/css/common.css" rel="stylesheet" type="text/css">

  </head>

  <body>
    <!-- Wrap all page content here -->
    <div id="wrap">

      <!-- Fixed navbar -->
      <div class="navbar navbar-default navbar-static-top" role="navigation" style="min-width: 970px;">
        <div class="container">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?php echo base_url(); ?>">ARDOCK</a>
          </div>
          <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
              <?php
              $nav_name = array('home', 'game', 'board', 'rank', 'about');
              foreach ($nav_name as $key => $value) {
                $nav_class = strcmp($value, $title) ? '' : 'active';
              ?>
                <li class="<?php echo $nav_class; ?>">
                  <a href="<?php echo base_url().$value; ?>"><?php echo strtoupper($value); ?></a>
                </li>
              <?php
              }
              ?>
            </ul>
            <ul class="nav navbar-nav navbar-right">

<?php
if ($username) {
  $this->load->view('modules/nav-logout');
} else {
  $this->load->view('modules/nav-login');
}
?>

            </ul>
          </div>
        </div>
      </div>
      <!-- .navbar -->
      <div id="page-container" class="container">
        <div>
        <!-- <div style="margin: 20px 0;"> -->
          <!-- #Modal -->
<?php if (!$username) { ?>
          <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <form class="form-horizontal" role="form" action="<?php echo base_url();?>login" method="post">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="myModalLabel">SIGN IN</h4>
                  </div>
                  <div class="modal-body">
                    <div class="form-group">
                      <label for="inputUsername" class="col-xs-offset-2 col-xs-2 control-label">USERNAME</label>
                      <div class="col-xs-5">
                        <input type="username" class="form-control" name="username" placeholder="USERNAME" required>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="inputPassword" class="col-xs-offset-2 col-xs-2 control-label">PASSWORD</label>
                      <div class="col-xs-5">
                        <input type="password" class="form-control" name="password" placeholder="PASSWORD" required>
                      </div>

                    </div>
                  </div>
                  <div class="modal-footer">
                    <label for="loading" class="col-xs-offset-4 col-xs-3 control-label" style="display: none;">
                      <span class="glyphicon glyphicon-refresh"></span> LOADING
                    </label>
                    <button type="submit" class="btn btn-default">SUBMIT</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
<?php } ?>
