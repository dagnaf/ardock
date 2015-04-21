<?php
// nav-logout.php
$username = htmlentities($this->session->userdata('username'));
$q = $_SERVER['QUERY_STRING'];
$last_url = urlencode(current_url() . ($q ? '?'.$q : ''));
?>
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button">
                  <span class="glyphicon glyphicon-user"></span><?php echo ' '.strtoupper($username); ?>
                  <span class="caret"></span>
                </a>
                <ul class="dropdown-menu" role="menu">
                  <li><a role="menuitem" tabindex="-1" href="<?php echo base_url().'profile/'.$username?>">PROFILE</a></li>
                  <li><a role="menuitem" tabindex="-1" href="<?php echo base_url(); ?>edit">EDIT</a></li>
                  <!-- <li><a role="menuitem" tabindex="-1" href="<?php echo base_url(); ?>points">POINTS</a></li> -->
                  <li class="divider"></li>
                  <li><a role="menuitem" id="logoutButton" tabindex="-1" href="<?php echo base_url().'logout?last_url='.$last_url; ?>">LOG OUT</a></li>
                </ul>
              </li>