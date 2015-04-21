<!-- <div class="col-xs-12">
  <div class="thumbnail">
    <img src="<?php echo base_url() . 'assets/img/markers/0'?>">
    <div class="caption">
      <h3>Receptor Marker</h3>
      <p>Print the marker if you play in DOUBLE mode.</p>
    </div>
  </div>
  <div class="thumbnail">
    <img src="<?php echo base_url() . 'assets/img/markers/1';?>">
    <div class="caption">
      <h3>Ligand Marker</h3>
      <p>Print the marker if you play in SINGLE or DOUBLE mode.</p>
    </div>
  </div>
</div> -->
<style type="text/css">
#qrcode-table th {
  padding-left: 40px;
}
#qrcode-table a.thumbnail {
  width: 150px;
}
</style>
<div id="qrcode-table" class="row">
<table class="table table-hover">
  <thead>
    <th>#</th>
    <th>QRCode</th>
  </thead>
  <tbody>
    <?php for ($i = 0; $i < 2; ++$i) { ?>
    <tr>
      <th><?php echo $i; ?></th>
      <td><a href="<?php echo base_url() . 'assets/img/markers/'.$i;?>" class="thumbnail">
        <img src="<?php echo base_url() . 'assets/img/markers/'.$i;?>" style="width: 140px; height: 140px;">
      </a></td>
    </tr>
     <?php } ?>
    <tr>
      <td colspan="2" style="text-align: center;">
        <a href="<?php echo base_url() . 'markers'?>">Want more (No. 2-99)?</a>
      </td>
    </tr>
  </tbody>
</table>
</div>
