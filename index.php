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
<script type="text/javascript" src="assets/js/jquery.tooltipster.js"></script>
<script type="text/javascript" src="assets/js/SizeStructure.js"></script>
<script type="text/javascript" src="assets/js/TimeStructure.js"></script>
<script type="text/javascript" src="assets/js/script.js"></script>

<div class="container" id="fileuploadpage">
  <div class="main-content col-lg-12 text-center">
    <?php if (!empty($success_message)) : ?>
      <div class="message-wrapper">
        <div class="alert alert-success">
          <?php echo $success_message; ?>
        </div>
        <form action="">
          <button class="btn btn-default"><?php _e('Try again'); ?></button>
        </form>
      </div>
    <?php else :
      ?>
      <h1><?php _e('Your files up to 5GB'); ?></h1>
      <p class="info-meta"><?php _e('encrypted access, fast and free'); ?></p>
      <form class='frm_contact' action="<?php echo add_query_arg('method', 'attach'); ?>" method="post">
        <div class="uploaded_files"></div>
        <div class="upload-progress"></div>
        <div class="form-group form-group-dropbox">
          <button id='dropbox' data-bv-trigger="progress_end" name="dropbox" type="text" class="dropbox btn btn-default btn-lg btn-block">
            <span class="icon fileupload"></span> <?php _e('Add a file'); ?>
          </button>
        </div>
        <input type="file" id="fileElem" multiple="true" accept="*" onchange="handleFiles(this.files)">
        <div class="form-group password-wrapper">
          <label for="filepassword" id="filepassword" class="pull-left"><?php _e('Enter the password for protect file'); ?></label>
          <input type="password" class="form-control pull-right" id='inputFilePassword' name='filepassword' />
        </div>
        <div class="clearfix"></div>
        <div class="form-group">
          <span class='icon site_help'></span>
          <span class='icon_wrapper'><span class="icon file_protect"><?php _e('Protect your files'); ?></span></span>
        </div>
        <div class="form-group pull-left to_email">
          <input type="email" class="input-group pull-left" name="to_email" id="to_email" value="" placeholder="<?php _e('Recipient\'s email address'); ?>" />
        </div>
        <div class="form-group pull-right from_email">
          <input type="email" class="input-group pull-right" name="from_email" id="from_email" value="" placeholder="<?php _e('Your email address'); ?>" />
        </div>
        <div class="clearfix"></div>
        <div class="form-group">
          <textarea rows='5' class='form-control' id='inputMessage' name="message"  placeholder="<?php _e('Your Message'); ?>"></textarea>
        </div>
        <?php
        require_once './lib/captcha.php';

        $captcha = new captcha();
        $captcha->generateCaptcha();
        ?>
        <div class='form-group pull-left'>
          <?php echo $captcha->showCaptcha(); ?>
        </div>
        <div class="form-group pull-left num_captcha">
          <input type="text" class="form-control" id="num_captcha" name="captcha" />
        </div>
        <div class="form-group confirm_btn">
          <button id="confirm_btn" class="btn btn-default pull-right" type="submit" ><?php _e('Email(s) file(s)'); ?></button>
        </div>
        <div class="clearfix"></div>
        <?php if (!empty($error_message)) : ?>
          <div class="alert alert-warning">
            <a href="#" class="close" data-dismiss="alert">&times;</a>
            <?php echo $error_message; ?>
          </div>
        <?php endif; ?>
      </form>
    <?php endif; ?>
  </div>
</div>
<?php
require_once 'footer.php';
