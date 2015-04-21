<!-- footer.php -->
      </div>
    </div>
  </div>
  <div id="footer" style="min-width: 970px;">
    <div class="container">
      <p class="text-muted">2014 @<a href="http://www.ecust.edu.cn" target="_blank">ECUST</a></p>
    </div>
  </div>

  <!-- Bootstrap core JavaScript
  ================================================== -->
  <!-- Placed at the end of the document so the pages load faster -->
<?php
if (!file_exists('assets/js/'.$filename.'.js'))
  $filename = 'anypage';
?>
  <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/lib/require.js" data-main="<?php echo base_url(); ?>assets/js/<?php echo $filename; ?>"></script>
  <?php if ($this->session->userdata('username')) echo '<span ardock></span>' ?>
  </body>
</html>
