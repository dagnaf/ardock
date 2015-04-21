<?php
// var_dump($rows);
$username = $this->session->userdata('username');
$uid = $this->session->userdata('uid');
function splus($num, $noun, $noun2 = '/') {
  if ($noun2 == '/') $noun2 = $noun.'S';
  if ($noun == 'IS') return $num > 1 ? 'ARE' : 'IS';
  if ($noun == 'HAS') return $num > 1 ? 'HAVE' : 'HAS';
  if ($noun == 'DOES') return $num > 1 ? 'DO' : 'DOES';
  return $num > 1 ? $noun2 : $noun;
}
function htmls($str) {
  return '<pre>' . htmlentities($str) . '</pre>';
}
// 2 3 4 5 6
// echo $per_page;
function tofloor($fl,$page,$per_page,$post_base_url) {
  $fl_page = floor(($fl - 2) / $per_page);
  return $post_base_url . "/$fl_page#f".($fl+1);
}
function avatar($uid) {
  $img_file = 'assets/img/avatar/' . $uid . '.png';
  if (file_exists($img_file)) return base_url() . $img_file;
  else return base_url() . 'assets/img/markers/'.($uid%100);

}
?>
<style type="text/css">
.media-span {
  color: gray;
  padding-bottom: 5px;
}
.post-content {
  border-bottom: 1px dashed gray;
}
.new-reply {
  display: none;
}
.media:hover .media-body{
  background: lightgray;
}
.media-body {
  padding: 5px;
}
li a.pull-left {
  text-align: center;
}
</style>
<div class="page-header">
<h1><?php echo $trow[0]->title; ?>
  <small><a href="<?php echo base_url(); ?>board">board &raquo;</a>
  </small></h1>
</div>
<?php if ($this->session->flashdata('msg')) { ?>

<div class="alert alert-info alert-dismissible fade in" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
      <strong>Success!</strong> Check your submission in the post.
    </div>
<?php } ?>
<ul class="media-list post-content">
  <li class="media">
    <a class="pull-left" href="<?php echo base_url() . 'profile/' . $trow[0]->username; ?>">
      <img class="media-object" src="<?php echo avatar($trow[0]->uid); ?>" style="width: 64px; height: 64px;">
      <?php echo '#1'; ?>
    </a>
    <div class="media-body">
      <h4 class="media-heading">
        <a href="<?php echo base_url().'profile/'.$trow[0]->username; ?>">
          <?php echo htmlentities($trow[0]->username); ?>
        </a>
        <small class="pull-right">
            <!-- <span class="glyphicon glyphicon-time"></span>  -->
            <abbr class="timeago" data-toggle="tooltip" data-container="body" rel="tooltip" title="<?php echo $trow[0]->time; ?>"></abbr>
        </small>
      </h4>
      <p><?php echo htmls($trow[0]->content); ?></p>
      <div class="row">
        <div class="media-span col-xs-8">
            <span class="glyphicon glyphicon-comment"></span>
            <a class="reply-link" href="javascript:void(0)">REPLY</a>
<?php if ($username) { ?>
          <form class="form-horizontal" style="display: none; padding: 5px; margin-bottom: -15px;" role="form" action="<?php echo base_url().'post/'.$id; ?>" method="post">
            <div class="form-group">
              <div class="col-xs-8">
                  <textarea class="form-control" rows="3" maxlength="500" name="content" style="resize: none;" placeholder="POST CONTENT" required data-container="body" data-toggle="popover" data-placement="bottom" data-trigger="focus" data-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus."></textarea>
              </div>
              <div class="col-xs-4">
                  <button class="btn btn-default" type="submit" name="post" value="post">REPLY</button>
              </div>
            </div>
          </form>
<?php } ?>
        </div>
        <div class="media-span col-xs-4">
          <span class="pull-right">
<?php if ($uid && $uid == $trow[0]->uid) { ?>
            <span class="glyphicon glyphicon-trash"></span>
            <a class="" href="<?php echo base_url().'delete/post/'.$trow[0]->id;?>">DELETE</a>
<?php } ?>
          <span>
        </div>
      </div>
    </div>
  </li>
</ul>
<!-- replies -->
<ul class="media-list">

<?php
foreach ($rows as $row) {
?>
  <li class="media medias" pid="<?php echo $row->pid; ?>" id="<?php echo 'f'.($row->floor+1); ?>">
    <a class="pull-left" href="<?php echo base_url() . 'profile/' . $trow[0]->username; ?>">
      <img class="media-object" src="<?php echo avatar($row->uid); ?>" style="width: 64px; height: 64px;">
      <?php echo '#'.($row->floor+1); ?>
    </a>
    <div class="media-body">
      <h4 class="media-heading">
        <a href="<?php echo base_url().'profile/'.$row->username; ?>">
          <?php echo htmlentities($row->username); ?>
        </a>
        <small>
<?php if ($row->pid) { ?>
          REPLIED TO
          <a href="<?php echo tofloor($row->pfloor, $page, $per_page, $post_base_url); ?>">
            <?php // echo htmlentities($row->pusername);
            echo '#'.($row->pfloor+1);
            ?>
          </a>
<?php } ?>
          <span class="pull-right">
            <!-- <span class="glyphicon glyphicon-time"></span>  -->
            <abbr class="timeago" data-toggle="tooltip" data-container="body" rel="tooltip" title="<?php echo $row->time; ?>"></abbr>
          </span>
        </small>
      </h4>
      <p><?php echo htmls($row->content); ?></p>
      <div class="row">
        <div class="media-span col-xs-8 ">
            <span class="glyphicon glyphicon-comment"></span>
            <a class="reply-link" href="javascript:void(0)">REPLY</a>
<?php if ($username) { ?>
          <form class="form-horizontal" style="display: none; padding: 5px; margin-bottom: -15px;" role="form" action="<?php echo base_url().'post/'.$id; ?>" method="post">
            <input type="hidden" name="parent" value="<?php echo $row->id; ?>" />
            <div class="form-group">
              <div class="col-xs-8">
                  <textarea class="form-control" rows="3" maxlength="500" name="content" style="resize: none;" placeholder="POST CONTENT" required></textarea>
              </div>
              <div class="col-xs-4">
                  <button class="btn btn-default" type="submit" name="post" value="post">REPLY</button>
              </div>
            </div>
          </form>
<?php } ?>
        </div>
        <div class="media-span col-xs-4">
          <span class="pull-right">
<?php if ($uid && $uid == $row->uid) { ?>
          <span class="pull-right">
            <span class="glyphicon glyphicon-trash"></span>
            <a class="" href="<?php echo base_url().'delete/reply/'.$row->id;?>">DELETE</a>
          </span>
<?php } ?>
          </span>
        </div>
      </div>
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
          <?php echo $total_rows.' '.splus($total_rows, 'REPLY', 'REPLIES'); ?>
        </strong>
      </p>
    </div>
  </div>
</form>

