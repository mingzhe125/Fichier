<?php
require_once 'header.php';
?>
<link rel="stylesheet" type="text/css" href="assets/css/tooltipster.css" />
<link rel="stylesheet" type="text/css" href="assets/css/themes/tooltipster-light.css" />
<link rel="stylesheet" type="text/css" href="assets/css/themes/tooltipster-noir.css" />
<link rel="stylesheet" type="text/css" href="assets/css/themes/tooltipster-punk.css" />
<link rel="stylesheet" type="text/css" href="assets/css/themes/tooltipster-shadow.css" />

<script type="text/javascript" src="assets/js/jquery.jgfeed.js"></script>
<script type="text/javascript" src="assets/js/prettify.js"></script>
<script type="text/javascript" src="assets/js/lang-css.js"></script>
<script type="text/javascript" src="assets/js/jquery.tooltipster.min.js"></script>
<!-- Main jumbotron for a primary marketing message or call to action -->
<script src="./assets/js/script.js"></script>
<div class="main" id='fileuploadpage'>
  <div class="main_top"></div>
  <section class="container-fluid">
    <div class="container">
      <div class="main-content col-lg-4 col-md-4 col-lg-offset-4 col-md-offset-4">
        <div class="inner-content">
          <div class="content-header"><p><?php _e('Files up to 5GB'); ?></p></div>
          <form class='frm_contact' action="<?php echo add_query_arg('method', 'attach'); ?>" method="post">
            <div class="content-body col-lg-12 hr">
              <div class="form-group form-group-dropbox">
                <!--<input id="uploaded_files_list" name="uploaded_files_list" class="uploaded_files_list" value="" />-->
                <button id='dropbox' data-bv-trigger="progress_end" name="dropbox" type="text" class="dropbox btn btn-default btn-lg btn-block"><span class="glyphicon glyphicon-plus-sign"></span> <?php _e('Your file (s)'); ?></button>
              </div>
              <input type="file" id="fileElem" multiple="true" accept="image/*" onchange="handleFiles(this.files)">
              <div class="uploaded_files">
              </div>
              <div class="upload-progress"></div>
            </div>
            <div class="content-body col-lg-12 hr">
              <div class="form-group">
                <input type="email" class="input-group" name="to_email" id="to_email" value="" placeholder="<?php _e('Email Sender'); ?>" />
              </div>
            </div>
            <div class="content-body col-lg-12">
              <div class="form-group">
                <input type="email" class="input-group" name="from_email" id="from_email" value="" placeholder="<?php _e('Your Email'); ?>" />
              </div>
              <div class="form-group">
                <textarea rows='5' class='form-control' id='inputMessage' name="message"  placeholder="<?php _e('Your Message'); ?>"></textarea>
              </div>
              <img src="lib/captcha.php" />
              <div class='form-group'>
                <label for="inputCapture"><?php _e('Enter the code'); ?><sup>*</sup></label>
                <input type="text" class="form-control" id="inputCapture" name="captcha" />
              </div>
              <div class="form-group password-wrapper">
                <label for="filepassword"><?php _e('Enter the password for protect file'); ?></label>
                <input type="password" class="form-control" id='inputFilePassword' name='filepassword' />
              </div>
              <div class="form-group confirm_btn">
                <button type="submit" ><?php _e('Send the file'); ?></button>
                <span class='file_protect'></span>
              </div>
            </div>
          </form>
          <br/>
          <?php if (!empty($error_message)) : ?>
            <div class="alert alert-warning">
              <a href="#" class="close" data-dismiss="alert">&times;</a>
              <?php echo $error_message; ?>
            </div> 
          <?php endif; ?>
          <?php if (!empty($success_message)) : ?>
            <div class="alert alert-success">
              <a href="#" class="close" data-dismiss="alert">&times;</a>
              <?php echo $success_message; ?>
            </div> 
          <?php endif; ?>
        </div>
      </div>
    </div>
  </section>
  <?php
  require_once 'footer.php';
  ?>

