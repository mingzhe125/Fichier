<?php
require_once 'header.php';
?>
<!-- Main jumbotron for a primary marketing message or call to action -->
<div class="main" id='contactpage'>
  <div class="main_top"></div>
	<section class="container-fluid">
		<div class="container">
			<div class="main-content col-lg-4 col-md-4 col-lg-offset-4 col-md-offset-4">
				<div class="inner-content">
					<div class="content-header"><p><?php _e('Contact Us'); ?></p></div>
					<div class="content-body col-lg-12">
						<form class='frm_contact' action="?method=mail" method="post">
							<div class="form-group small">
								<label for="inputName"><?php _e('Name'); ?><sup>*</sup></label>
								<input type="text" class="form-control" id="inputName" name="username" placeholder="" />
							</div>
							<div class="form-group">
								<label for="inputName"><?php _e('Email'); ?><sup>*</sup></label>
								<input type="email" class="form-control" id="inputEmail" name="email" placeholder="" />
							</div>
							<div class="form-group">
								<label for="inputMessage"><?php _e('Message'); ?><sup>*</sup></label>
								<textarea rows='5' class='form-control' id='inputMessage' name="message"></textarea>
							</div>
							<img src="lib/captcha.php" />
							<div class='form-group'>
								<label for="inputCapture"><?php _e('Enter the code'); ?><sup>*</sup></label>
								<input type="text" class="form-control" id="inputCapture" name="captcha" />
							</div>

							<button type="submit" class="btn btn-default"><?php _e('Send'); ?></button>
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
		</div>
	</section>
	<?php
	require_once 'footer.php';
	?>

