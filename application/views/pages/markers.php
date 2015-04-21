<style type="text/css">
#markers {
  display: flex;
  align-content: space-between;
  flex-direction: row;
  flex-wrap: wrap;
  justify-content: center;
}
#markers img {
  width: 100px;
  height: 100px;
}
#markers a {
  margin: 10px;
  text-align: center;
}
</style>
<div id="markers" class="row">
  <?php for ($i = 0; $i < 100; ++$i) {
    $link = base_url() . 'assets/img/markers/' . $i; ?>
  <a href="<?php echo $link; ?>" class="thumbnail">
    <img src="<?php echo $link;?>">
    <?php echo $i; ?>
  </a>
  <?php } ?>
</div>
