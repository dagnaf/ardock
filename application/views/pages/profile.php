<?php
$username = $this->session->userdata('username');
$uid = $this->session->userdata('uid');
function splus($num, $noun, $noun2 = '/') {
  if ($noun2 == '/') $noun2 = $noun.'S';
  if ($noun == 'IS') return $num > 1 ? 'ARE' : 'IS';
  if ($noun == 'HAS') return $num > 1 ? 'HAVE' : 'HAS';
  if ($noun == 'DOES') return $num > 1 ? 'DO' : 'DOES';
  return $num > 1 ? $noun2 : $noun;
}
function avatar($uid) {
  $img_file = 'assets/img/avatar/' . $uid . '.png';
  if (file_exists($img_file)) return base_url() . $img_file;
  else return base_url() . 'assets/img/markers/'.($uid%100);

}
?>
<style>
.banner {
  margin-top: -20px;
  margin-bottom: 95px;
  position: relative;
}
.header-pic {
  background-color: lightgray;
  height: 120px;
}
.avatar {
  position: absolute;
  bottom: -95px;
  left: 50px;
}
ul.user-stats {
  /*padding: 3px 0;*/
  /*border-radius: 4px;*/
  /*border: 1px solid lightgray;*/
  text-align: center;
  /*font-size: 10px;*/
}
ul.user-stats {
  margin-bottom: 20px;
  position: absolute;
  bottom: -95px;
  right: 0;
}
ul.user-stats > li > a:hover .stats-number {
  /*text-decoration: underline;*/
  color: black;
}
ul.user-stats > li > a:hover {
  background: none;
}
ul.user-stats > li:first-child > a {
  border-left: 0;
}
ul.user-stats > li > a {
  border-left: 1px solid lightgray;
  color: gray;
  padding: 0px 6px;
  min-width: 60px;
}

li .stats-number {
  display: block;
  /*font-size: 16px;*/
  /*color: black;*/
}
.user-content {
  margin-bottom: 20px;
  bottom: -95px;
  left: 220px;
  position: absolute;
}
.user-content h3 {
  margin-top: 0;
  word-wrap: break-word;
}
.content-list {
  color: gray;
}
.user-nav {
  margin-bottom: 120px;
}
.user-stats h3.active {
  color: black;
}
</style>
<div class="banner">
  <div class="header-pic"></div>
    <div class="avatar">
      <a href="#" class="thumbnail">
        <img src="<?php echo avatar($profile->id);?>" style="width: 140px; height: 140px;">
      </a>
    </div>
    <ul class="nav navbar-nav user-stats">
      <li data-toggle="tooltip" data-placement="bottom" title="POSTS IN BOARD" rel="tooltip">
        <a href="<?php echo base_url().'profile/'.$profile->name; ?>/post">
        <span>
          <h3 class="stats-number <?php echo $page == 'post' ? 'active' : ''; ?>">
            <?php echo $num_post; ?>
          </h3>
          <span>POSTS</span>
        </span>
        </a>
      </li>
      <li data-toggle="tooltip" data-placement="bottom" title="REPLIESS TO POSTS" rel="tooltip">
        <a href="<?php echo base_url().'profile/'.$profile->name; ?>/reply">
        <span>
          <h3 class="stats-number <?php echo $page == 'reply' ? 'active' : ''; ?>">
            <?php echo $num_reply; ?>
          </h3>
          <span>REPLIES</span>
        </span>
        </a>
      </li>
      <li data-toggle="tooltip" data-placement="bottom" title="GAME HISTORY" rel="tooltip">
        <a href="<?php echo base_url().'profile/'.$profile->name; ?>/submission">
        <span>
          <h3 class="stats-number <?php echo $page == 'submission' ? 'active' : ''; ?>">
            <?php echo $num_submission; ?>
          </h3>
          <span>SUBMISSIONS</span>
        </span>
        </a>
      </li>
      <li data-toggle="tooltip" data-placement="bottom" data-container="body" title="POINTS FOR RANK" rel="tooltip">
        <a href="<?php echo base_url().'rank/'.$profile->name; ?>">
        <span>
          <h3 class="stats-number <?php echo $page == 'point' ? 'active' : ''; ?>">
            <?php echo $mark; ?>
          </h3>
          <span>POINTS</span>
        </span>
        </a>
      </li>
      <li data-toggle="tooltip" data-placement="bottom" data-container="body" title="RANK" rel="tooltip">
        <a href="<?php echo base_url().'rank/'.$profile->name; ?>">
        <span>
          <h3 class="stats-number <?php echo $page == 'point' ? 'active' : ''; ?>">
            #<?php echo $rank; ?>
          </h3>
          <span>of <?php echo $num_user; ?></span>
        </span>
        </a>
      </li>
    </ul>
    <div class="user-content">
      <h3>
        <?php echo strtoupper($profile->name) . ' '; ?>
        <small>
          <?php if($username == $profile->name) {?>
            <a href="<?php echo base_url() . 'edit'; ?>">edit</a>
          <?php } ?>
      </small></h3>
      <span class="content-list"><span class="glyphicon glyphicon-time"></span>
      JOINED <abbr class="timeago" data-placement="bottom" data-toggle="tooltip" data-container="body" rel="tooltip" title="<?php echo $profile->reg_time; ?>"></abbr></span>
    </div>
</div>


