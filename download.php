<?php
require_once 'header.php';
$file_id = $_REQUEST['file'];
?>
<div class="main" id='fileuploadpage'>
  <div class="main_top"></div>
  <section class="container-fluid">
    <div class="container">
      <div class="main-content col-lg-4 col-md-4 col-lg-offset-4 col-md-offset-4">
        <div class="inner-content">
          <div class="content-header"><p><?php _e('Files up to 5GB'); ?></p></div>
          <form class='frm_contact' action="lib/download.php" method="post">
            <div class="content-body col-lg-12">
              <div class="form-group">
                <label for="filepassword"><?php _e('Enter the password for protect file'); ?></label>
                <input type="password" class="form-control" id='inputFilePassword' name='filepassword' />
              </div>
              <div class="form-group confirm_btn">
                <button type="submit" ><?php _e('Download File'); ?></button>
                <span class='file_protect'></span>
              </div>
            </div>
            <input type="hidden" name='file' value="<?php echo $file_id; ?>" />
          </form>
          <br/>
          <?php if (!empty($_REQUEST['error'])) : ?>
            <div class="alert alert-warning">
              <a href="#" class="close" data-dismiss="alert">&times;</a>
              <?php echo _e('Incorrect the password'); ?>
            </div> 
          <?php endif; ?>
        </div>
      </div>
    </div>
  </section>
  <?php
  require_once 'footer.php';
  