<style type="text/css">
.post-title a {
  display: inline-block;
  max-width: 630px;
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
  float: left;
  padding-top: 7px;
  font-size: 18px;
  padding-right: 7px;
}
.post-time {
  text-align: right;
}
.post-time h4, .post-title h4 {
  padding-top: 5px;
  margin-bottom: 5px;
}
</style>
<table class="table table-hover">
  <thead>
    <tr>
      <th>Title</th>
      <th class="post-time"></th>
    </tr>
  </thead>
  <tbody>
  <?php foreach ($posts as $post) { ?>
  <tr>
    <td class="post-title">
        <a href="<?php echo base_url() . 'post/' . $post->id; ?>">
        <?php echo $post->title; ?></a>
      <h4>
        <small>REPLY(<?php echo $post->numrep; ?>)</small>
      </h4>
    </td>
    <td class="post-time">
      <h4>
        <small><abbr class="timeago" data-toggle="tooltip" data-container="body" rel="tooltip" title="<?php echo $post->time; ?>"></abbr>
        </small>
      </h4>
    </td>
  </tr>
  <?php  } ?>
  </tbody>
</table>
<div class="row">
<div class="col-xs-6">
<?php echo $page_html; ?>
</div>
<div class="col-xs-6">
  <p class="form-control-static pull-right">
    <span class="glyphicon glyphicon-file"></span>
     TOTALLY, THERE ARE <strong> <?php echo $num_post; ?> POSTS </strong>
  </p>
</div>
</div>
