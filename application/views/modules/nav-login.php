<!-- nav-login.php -->
<?php
$nav_class = strcmp('register', $title) ? '' : 'active';
?>
              <li class="<?php echo $nav_class; ?>"><a href="<?php echo base_url(); ?>register">SIGN UP</a></li>
              <li><a href="#" data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-user"></span> LOGIN</a></li>
