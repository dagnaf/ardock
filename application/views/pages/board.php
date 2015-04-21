<?php
function avatar($uid) {
  $img_file = 'assets/img/avatar/' . $uid . '.png';
  if (file_exists($img_file)) return base_url() . $img_file;
  else return base_url() . 'assets/img/markers/'.($uid%100);
  // else return base_url() . 'assets/img/markers/'+($uid%100)+'.png';
}
?>
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
if (!isset($q)) { $q = ''; }
?>
<style type="text/css">
.media-span {
  color: gray;
}
.media:hover .media-body{
  background: lightgray;
}
.media-body {
  padding: 5px;
}
</style>
<div class="page-header">
<?php if ($q == '') { ?>
<h1>POSTS <small><a id="newPost" href="javascript:void(0)">START NEW THREAD</a></small></h1>
<?php } else { ?>
<h1>Search Results <small><a href="<?php echo base_url() . 'board'; ?>">Return</a></small></h1>
<?php } ?>
</div>
<?php if ($this->session->flashdata('msg')) { ?>

<div class="alert alert-info alert-dismissible fade in" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
      <strong>Success!</strong> Check your submission in the board.
    </div>
<?php } ?>
<form class="form-horizontal" role="form" action="<?php echo base_url().'board/search'; ?>" method="get">
  <div class="form-group">
    <div class="col-xs-6"><?php echo $page_html; ?></div>
    <div class="col-xs-6">
      <div class="input-group">
        <span class="input-group-addon">
          <span class="glyphicon glyphicon-search"></span>
        </span>
        <input type="text" class="form-control" name="q" maxlength="25" placeholder="SEARCH CONTENT OR USERNAME" value="<?php echo $q; ?>"/>
        <span class="input-group-btn">
          <button class="btn btn-default" type="submit">SEARCH</button>
        </span>
      </div>
    </div>
  </div>
</form>

<ul class="media-list">

<?php
foreach ($rows as $row) {
// echo htmlentities(mb_substr($row->content, 0, 250, 'utf-8')).' ...';
?>
  <li class="media ">
    <a class="pull-left" href="#">
      <img class="media-object" src="<?php echo avatar($row->uid); ?>" style="width: 64px; height: 64px;">
    </a>
    <div class="media-body">
      <h4 class="media-heading"><?php echo $row->title . ' '; ?>
        <small>
          <span class="media-span pull-right">
            <!-- <span class="glyphicon glyphicon-time"></span>  -->
            <abbr class="timeago" data-toggle="tooltip" data-container="body" rel="tooltip" title="<?php echo $row->time; ?>"></abbr>
          </span>
          <a href="<?php echo base_url().'profile/'.$row->username; ?>">
          <?php echo htmlentities($row->username); ?>
          </a>
        </small>
      </h4>
      <p>
        <?php echo htmlentities(mb_substr($row->content, 0, 200, 'utf-8')).' ...'; ?>
        <a href="<?php echo base_url().'post/',$row->id; ?>">FULL&raquo;</a>
      </p>

      <span class="media-span">
        <span class="glyphicon glyphicon-comment"></span>
        <?php echo ' '.$row->numrep.' '.splus($row->numrep, 'COMMENT'); ?>
      </span>
    </div>
  </li>
<?php
}
?>
</ul>
<form class="form-horizontal">
  <div class="form-group">
    <div class="col-xs-6"><?php echo $page_html; ?></div>
    <div class="col-xs-6">
      <p class="form-control-static pull-right">
        <span class="glyphicon glyphicon-file"></span>
         TOTALLY, THERE
         <?php echo splus($total_rows, 'IS').' '; ?>
         <strong>
          <?php echo $total_rows.' '.splus($total_rows, 'POST'); ?>
        </strong>
      </p>
    </div>
  </div>
</form>
<?php if ($username && $q == '') {?>
<form class="form-horizontal" role="form" action="<?php echo base_url(); ?>board" method="post">
  <div class="form-group">
    <div class="col-xs-6">
      <div class="input-group">
        <span class="input-group-addon">
          <span class="glyphicon glyphicon-pencil"></span>
        </span>
        <input type="text" class="form-control" name="title" maxlength="50" placeholder="POST TITLE" required />
      </div>
    </div>
    <div class="col-xs-6">
    </div>
  </div>
  <div class="form-group">
    <div class="col-xs-6">
      <div class="input-group">
        <span class="input-group-addon"><span class="glyphicon glyphicon-comment"></span></span>
        <textarea class="form-control" rows="3" maxlength="500" name="content" style="resize: none;" placeholder="POST CONTENT" required></textarea>
      </div>
    </div>
  </div>
  <div class="form-group">
    <div class="col-xs-6">
      <button class="btn btn-default pull-right" type="submit" name="post" value="post">POST</button>
    </div>
  </div>

</form>
<?php } ?>
