<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/game.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/bootstrap-slider.css" >
<style type="text/css">
#info-content {
  /*height: 442px;*/
  overflow: hidden;
  overflow-y: auto;
}
#v3d {
  text-align: center;
  background-color: #f0f0f0;
}
#mousep {
  position: absolute;
  bottom: 0;
  height: 50px;
}
#game {
  width: 642px;
  height: 482px;
  margin-right: 10px;
  position: relative;
  border: 1px solid #ddd;
  border-radius: 4px;
  overflow: hidden;
}
#game-info {
  width: 290px;
  float: right;
}
#game-info .panel-body {
  height: 441px;
  overflow: hidden;
  overflow-y: auto;
  padding-top: 0px;
  padding-bottom: 0px;
}
#game-info .panel, #game-info table {
  margin-bottom: 0px;
}
#general-buttons {
  position: absolute;
  top: 2%;
  right: 2%;
  z-index: 0;
  transform: translate3d(60px,0,0);
  opacity: 0;
  transition: opacity 0.5s, transform 0.5s;
}
.slide-left {
  transform: translate3d(0,0,0) !important;
  opacity: 1 !important;
}
#molecule-buttons, #submit-buttons {
  width: 100%;
  position: absolute;
  bottom: 2%;
  text-align: center;
  opacity: 0;
  transform: translate3d(0,68px,0);
  transition: opacity 0.5s, transform 0.5s;
}

#submit-buttons .input-group{
  width: 340px;
  margin: 0 auto;
}
input[disabled]:hover {
  cursor: initial;
}
#submit-buttons input {
  z-index: 0;
}
.feedback {
  height: 0;
  position: absolute;
  width: 100%;
  text-align: center;
  /*display: none;*/
  top: 0;
  opacity: 0;
  transition: opacity .15s,transform 0.15s linear;
  transform: translate3d(0,-25px,0);
}
.fall-down {
  transform: translate3d(0,25px,0);
  opacity: 1;
}
.feedback .alert {
  display: inline-block;
}
.mask {
  position: absolute;
  width: 100%;
  height: 100%;
  background-color: rgba(128,128,128,0.6);
  top: 0;
  display: none;
}
.mask .wrap-center {
  top: 50%;
  position: relative;
  text-align: center;
}
.mask span {
  font-size: 80px;
  top: -40px;
  color: white;
}
.mask .feedback {
  display: block;
}
#game .modal {
  /*opacity: 1;*/
  /*display: block;*/
  position: absolute;
  z-index: 0;
}
,slider {
  margin-top: 7px;
}
#settings-backdrop {
  width: 100%;
  height: 100%;
  background-color: rgba(128,128,128,0.6);
  display: none;
  position: absolute;
  top: 0;
}
.mirror {
  -webkit-transform: scale(-1,1);
  -moz-transform: scale(-1,1);
}

#list-lig a.selected,
#list-rec a.selected {
  background-color: #e0e0e0;
}
#game.pre-game #debugCanvas {
  display: none !important;
}
.rise-up {
  transform: translate3d(0,0,0) !important;
  opacity: 1 !important;
}
</style>
<div class="flex-container">

  <div id="game-info">
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><span class="glyphicon glyphicon-info-sign"></span> INFORMATION</h3>
      </div>
      <div class="panel-body" id="info-content"></div>
    </div>
    <div id="score-hud"></div>
  </div>

  <div id="game">
    <div></div>
    <!-- canvas begin-->
    <div id="v3d"></div>
    <!-- canvas end -->
    <!-- controls begin-->
    <!-- general-buttons begin-->
    <div class="btn-group-vertical" id="general-buttons">
      <button id="btn-fullscreen" type="button" class="btn btn-default" data-toggle="tooltip" data-container="body" rel="tooltip" data-placement="right" title="FULLSCREEN">
        <span class="glyphicon glyphicon-fullscreen"></span>
      </button>
      <button id="btn-settings" data-toggle="modal" data-target="#settingsModal" type="button" class="btn btn-default" data-toggle="tooltip" data-container="body" rel="tooltip" data-placement="right" title="SETTINGS">
        <span class="glyphicon glyphicon-cog"></span>
      </button>
      <button id="btn-qrcode" type="button" class="btn btn-default" data-toggle="tooltip" data-container="body" rel="tooltip" data-placement="right" title="QRCODE">
        <span class="glyphicon glyphicon-qrcode"></span>
      </button>
      <button id="btn-tutorial" type="button" class="btn btn-default" data-toggle="tooltip" data-container="body" rel="tooltip" data-placement="right" title="TUTORIAL">
        <span class="glyphicon glyphicon-question-sign"></span>
      </button>
    </div>
    <!-- general-buttons end-->
    <!-- molecule buttons begin -->
    <div id="molecule-buttons">
      <div class="btn-group">
        <div class="btn-group dropup">
          <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
            LIGAND <span class="caret"></span>
          </button>
          <ul id="list-lig" class="dropdown-menu" role="menu">

  <?php
  for ($i = 0; $i < count($molecules); ++$i) {
    $molecule = $molecules[$i];
    if ($molecule->type == 'ligand') { ?>

            <li><a href="#"><?php echo $molecule->name; ?></a></li>

  <?php
    }
  } ?>

            <li class="divider"></li>
            <li><a href="#" class="selected" id="random-lig-a">RANDOM</a></li>
          </ul>
        </div>
        <!-- btn-go-is-here -->
        <button id="btn-go" class="btn btn-default">PLAY</button>
        <!-- btn-go-is-here -->
        <div class="btn-group dropup">
          <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
            RECEPTOR <span class="caret"></span>
          </button>
          <ul id="list-rec" class="dropdown-menu" role="menu">

  <?php
  for ($i = 0; $i < count($molecules); ++$i) {
    $molecule = $molecules[$i];
    if ($molecule->type == 'receptor') { ?>

            <li><a href="#"><?php echo $molecule->name; ?></a></li>

  <?php
    }
  } ?>

            <li class="divider"></li>
            <li><a href="#" class="selected" id="random-rec-a">RANDOM</a></li>
          </ul>
        </div>
      </div>
      <img src="<?php echo base_url() . 'assets/img/mouse2.png'; ?>" id="mousep" />
    </div>
    <!-- molecule buttons end -->
    <!-- submit buttons begin -->
    <div id="submit-buttons">
      <div class="input-group">
        <span class="input-group-btn">
            <button id="btn-back" type="button" class="btn btn-default">BACK</button>
        </span>
        <span class="input-group-addon" data-toggle="tooltip" data-container="body" rel="tooltip" title="BEST SCORE">
          <span class="glyphicon glyphicon-star-empty"></span>
        </span>
        <input id="best-score-hud" type="text" class="form-control" disabled value="0000">
        <span class="input-group-addon" data-toggle="tooltip" data-container="body" rel="tooltip" title="CURRENT SCORE">
          <span class="glyphicon glyphicon-stats"></span>
        </span>
        <input  id="current-score-hud" type="text" class="form-control" disabled value="0000">
        <span class="input-group-btn">
          <button id="btn-submit" type="button" class="btn btn-default">SUBMIT</button>
        </span>
      </div>
    </div>
    <!-- submit buttons end -->
    <!-- controls end -->
    <!-- modal begin -->
    <div id="settings-backdrop"></div>
    <div class="modal fade" id="settingsModal" data-backdrop="">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">SETTINGS</h4>
          </div>
          <div class="modal-body">
            <form class="form-horizontal">
              <div class="form-group">
                <label for="mode" class="col-xs-3 control-label">Mode</label>
                <div class="col-xs-5">
                  <label class="radio-inline">
                    <input type="radio" name="mode" id="radio-single" value="1" checked="checked"> SINGLE
                  </label>
                  <label class="radio-inline">
                    <input type="radio" name="mode" id="radio-double" value="0"> DOUBLE
                  </label>
                </div>
              </div>
              <div class="form-group">
                <label for="videoSource" class="col-xs-3 control-label">VIDEO SOURCE</label>
                <div class="col-xs-5">
                  <label class="radio-inline">
                    <input type="radio" name="videosrc" id="radio-webcam" value="webcam" checked="checked"> WEBCAM
                  </label>
                  <label class="radio-inline">
                    <input type="radio" name="videosrc" id="radio-tutorial" value="tutorial"> TUTORIAL
                  </label>
                </div>
              </div>
              <div class="form-group">
                <label for="showDebug" class="col-xs-3 control-label">ARTOOLKIT</label>
                <div class="col-xs-5">
                  <label class="checkbox-inline">
                    <input type="checkbox" id="debugcheck" value="debug"> SHOW DEBUG
                  </label>
                </div>
              </div>
              <div class="form-group">
                <label for="showDebug" class="col-xs-3 control-label">MOLECULE</label>
                <div class="col-xs-5">
                  <label class="checkbox-inline">
                    <input type="checkbox" id="cachecheck" value="debug"> CACHEABLE
                  </label>
                </div>
              </div>
              <div class="form-group">
                <label for="threshold" class="col-xs-3 control-label">THRESHOLD</label>
                <div class="col-xs-5">
                  <input id="ex1" data-slider-id='ex1Slider' type="text" data-slider-min="0" data-slider-max="255" data-slider-step="1" data-slider-value="70"/>
                </div>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            <button  id="btn-settings-ok" type="button" class="btn btn-primary">OK</button>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <!-- modal end -->

    <!-- masks begin -->
    <div id="mask-wait" class="mask">
      <div class="wrap-center"><span class="glyphicon glyphicon-refresh"></span></div>
    </div>
    <div id="mask-auth" class="mask"></div>
    <!-- masks end -->
    <!-- feedback begin -->
    <!-- FIXME -->
    <div class="feedback" id="auth-info">
      <div class="alert alert-info"><strong>HEADS UP!</strong> PLEASE AUTHORIZE!</div>
    </div>
    <div class="feedback" id="submit-succeed">
      <div class="alert alert-success"><strong>GOOD JOB!</strong> YOUR SCORE WAS SAVED!</div>
    </div>
    <div class="feedback" id="auth-fail">
      <div class="alert alert-danger"><strong>OH SNAP!</strong> WE NEED A WEBCAM AT LEAST!</div>
    </div>
    <div class="feedback" id="load-chunk">
      <div class="alert alert-info"><strong>WAIT!</strong> IT TAKES SOME TIME TO RENDER RECEPTOR!</div>
    </div>
    <div class="feedback" id="auth-succeed">
      <div class="alert alert-success"><strong>WELL DONE!</strong> YOU HAVE AUTHORIZED THE WEBCAM!</div>
    </div>
    <div class="feedback" id="load-ok">
      <div class="alert alert-success"><strong>OK!</strong> LET'S PLAY RIGHT NOW!</div>
    </div>
    <div class="feedback" id="change-mode-success">
      <div class="alert alert-success"><strong>OK!</strong> MODE HAS BEEN CHANGED!</div>
    </div>
    <div class="feedback" id="new-record">
      <div class="alert alert-success"><strong>GOOD JOB!</strong> A New Record!</div>
    </div>
    <!-- feedback end -->
  </div>
  <!-- end of game div -->

<!--   <div class="col-xs-12" style="display: none">
    <canvas style="width: 940px; height: 800px;" height="800" width="940" id="iview">Your browser does not support WebGL.</canvas>
  </div> -->
</div>
<div style="display: none">
<span id="best-data-hidden"></span>
<span id="#best-matrix-hidden"></span>
</div>
<!-- 0-21 34-1.42 -->
