<?php
function avatar($uid) {
  $img_file = 'assets/img/avatar/' . $uid . '.png';
  if (file_exists($img_file)) return base_url() . $img_file;
  else return base_url() . 'assets/img/markers/'.($uid%100);
  // else return base_url() . 'assets/img/avatar/default.png';
}
?>
<style type="text/css">
.media .thumbnail {
  position: relative;
}

img.medal {
  position: absolute;
  /*half of the orig height*/
  height: 80px;
  bottom: -20px;
  right: -10px;
}
#top-3 .media-body {
  padding-top: 25px;
  text-align: center;
}
#ranklist {
  padding-bottom: 10px;
  position: relative;
}
.page-header {
  margin: 10px 100px;
  text-align: center;
}
.not-top-3 .media {
  margin-top: 5px;
}
.not-top-3 .thumbnail span {
  display: block;
  min-width: 25px;
  height: 25px;
  text-align: center;
  padding-top: 2px;
  text-decoration: none !important;
  font-size: 15px;
}
.not-top-3 a.thumbnail:hover {
  text-decoration: none;
}
.media h1, .media small, .media h4 {
  overflow: hidden;
  text-overflow: ellipsis;
}
#prev-page, #next-page {
  display: block;
  position: absolute;
  top: 180px;
  font-size: 30px;
}
#prev-page {
  left: 150px
}
#next-page {
  right: 150px
}
</style>
<?php //echo $page; ?>
<div class="page-header">
<h1><?php echo $page == 0 ? 'TOP 10' : 'Rank List'; ?><small><span></span></small></h1>
</div>
<div id="ranklist" class="row">
<?php
if ($page == 0) { ?>
  <div class="col-xs-offset-3 col-xs-4" id="top-3">
  <?php
  $medals = array('gold', 'silver', 'bronze');
    for ($i = 0; $i < 3 && $i < $limit; ++$i, ++$offset) {
      $rec = $score[$i];
      $link = base_url() . 'profile/' . $rec->username;
      // var_dump($rec);
      ?>
  <div class="media">
    <div class="pull-left">
      <a href="<?php echo $link; ?>" class="thumbnail">
          <img src="<?php echo avatar($rec->uid);?>" style="width: 100px; height: 100px;">
          <img class="medal" src="<?php echo base_url() . 'assets/img/' . $medals[$i]; ?>.png" />
      </a>
    </div>
    <div class="media-body">
      <h1 class="media-heading"><a href="<?php echo $link; ?>"><?php echo $rec->username; ?></a><br />
        <small><?php echo $rec->sumscore; ?></small>
      </h1>
    </div>
  </div>

    <?php  } ?>
  </div>
<?php } else { ?>
  <div class="col-xs-offset-3 col-xs-3 not-top-3">
    <?php for ($i = 0; $i < 7 && $i < $limit; ++$i, ++$offset) {
      $rec = $score[$i];
      $link = base_url() . 'profile/' . $rec->username;
    ?>
    <div class="media">
      <div class="pull-left">
        <a href="<?php echo $link; ?>" class="thumbnail">
            <span><?php echo $offset; ?></span>
        </a>
      </div>
      <div class="media-body">
        <h4 class="media-heading"><a href="<?php echo $link; ?>"><?php echo $rec->username; ?><br /></a>
          <small><?php echo $rec->sumscore; ?></small>
        </h4>
      </div>
    </div>
    <?php  } ?>
  </div>
<?php } ?>


  <div class="col-xs-3 not-top-3">
    <?php for (;$i < $limit; ++$i, ++$offset) {
      $rec = $score[$i];
      $link = base_url() . 'profile/' . $rec->username;
    ?>
    <div class="media">
      <div class="pull-left">
        <a href="<?php echo $link; ?>" class="thumbnail">
            <span><?php echo $offset; ?></span>
        </a>
      </div>
      <div class="media-body">
        <h4 class="media-heading"><a href="<?php echo $link; ?>"><?php echo $rec->username; ?><br /></a>
          <small><?php echo $rec->sumscore; ?></small>
        </h4>
      </div>
    </div>
    <?php  } ?>
  </div>
<?php if ($page > 0) {?>
  <a href="<?php echo base_url() . 'rank/' . ($page-1+1); ?>" id="prev-page"><span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span></a>
<?php  } ?>

<?php if (($page == 0 && count($score) > $first_page) || ($page > 0 && count($score) > $per_page)) {?>
  <a href="<?php echo base_url() . 'rank/' . ($page+1+1); ?>" id="next-page"><span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span></a>
<?php  } ?>

</div>
