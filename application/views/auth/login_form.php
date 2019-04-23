<?php
$login = array(
	'name'	=> 'login',
	'id'	=> 'login',
	'value' => set_value('login'),
	'maxlength'	=> 80,
	'size'	=> 30,
	'class'  => 'form-control'
);
if ($login_by_username AND $login_by_email) {
	$login_label = 'S&auml;hk&ouml;postiosoite tai k&auml;ytt&auml;j&auml;tunnus';
} else if ($login_by_username) {
	$login_label = 'K&auml;ytt&auml;j&auml;tunnus';
} else {
	$login_label = 'S&auml;hk&ouml;postiosoite';
}
$password = array(
	'name'	=> 'password',
	'id'	=> 'password',
	'size'	=> 30,
	'class'  => 'form-control'
);
$remember = array(
	'name'	=> 'remember',
	'id'	=> 'remember',
	'value'	=> 1,
	'checked'	=> set_value('remember'),
	'style' => 'margin:0;padding:0',
);
$captcha = array(
	'name'	=> 'captcha',
	'id'	=> 'captcha',
	'maxlength'	=> 8,
	'class'  => 'form-control'
);
$submit = array(
	'name'  => 'submit',
	'id'  => 'submit',
	'value'  => 'Kirjaudu',
	'class'  => 'btn btn-primary'
);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">

	<!-- BOOTSTRAP CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
  <!-- FONTAWESOME CSS -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
  <!-- SITE STYLESHEET CSS -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/login.css">

	<!-- FONTS -->
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400" rel="stylesheet">

	<title>Anselmi - Kirjaudu sis&auml;&auml;n</title>
</head>
<body>
	<div class="container-fluid h-100 m-0 p-0 page-container">
		<div class="row h-100 justify-content-center align-items-center">
			<div class="card login-card">
  			<div class="card-body">
					<?php echo form_open($this->uri->uri_string()); ?>
						<div class="form-group">
							<?php echo form_label($login_label, $login['id']); ?>
							<?php echo form_input($login); ?>
							<?php echo form_error($login['name']); ?><?php echo isset($errors[$login['name']])?$errors[$login['name']]:''; ?>
						</div>
						<div class="form-group">
							<?php echo form_label('Salasana', $password['id']); ?>
							<?php echo form_password($password); ?>
							<?php echo form_error($password['name']); ?><?php echo isset($errors[$password['name']])?$errors[$password['name']]:''; ?>
						</div>

						<?php if ($show_captcha) {
							if ($use_recaptcha) { ?>
						<div class="form-group">
							<div id="recaptcha_image"></div>
							<a href="javascript:Recaptcha.reload()">Get another CAPTCHA</a>
							<div class="recaptcha_only_if_image"><a href="javascript:Recaptcha.switch_type('audio')">Get an audio CAPTCHA</a></div>
							<div class="recaptcha_only_if_audio"><a href="javascript:Recaptcha.switch_type('image')">Get an image CAPTCHA</a></div>
						</div>
						<div class="form-group">
							<div class="recaptcha_only_if_image">Enter the words above</div>
							<div class="recaptcha_only_if_audio">Enter the numbers you hear</div>
							<input type="text" id="recaptcha_response_field" name="recaptcha_response_field" />
							<?php echo form_error('recaptcha_response_field'); ?>
							<?php echo $recaptcha_html; ?>
						</div>
						<?php } else { ?>
						<div class="form-group">
								<p>Enter the code exactly as it appears:</p>
								<?php echo $captcha_html; ?>
						</div>
						<div class="form-group">
							<?php echo form_label('Confirmation Code', $captcha['id']); ?>
							<?php echo form_input($captcha); ?>
							<?php echo form_error($captcha['name']); ?>
						</div>
						<?php }
						} ?>

						<div class="form-group">
							<?php echo form_checkbox($remember); ?>
							<?php echo form_label('Muista minut', $remember['id']); ?>
						</div>
						<div class="form-group">
							<?php echo anchor('/auth/forgot_password/', 'Salasana unohtunut?'); ?>
							<?php if ($this->config->item('allow_registration', 'tank_auth')) echo ' | ' . anchor('/auth/register/', 'Rekister&ouml;idy'); ?>
						</div>
					<?php echo form_submit($submit); ?>
					<?php echo form_close(); ?>
				</div> <!-- End of card body -->
			</div> <!-- End of card -->
		</div> <!-- End of row -->
	</div> <!-- End of container -->

	<!-- JQUERY -->
	<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>

	<!-- BOOTSTRAP JS -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>

	<!-- MAIN JS -->
	<!-- <script src="<?php echo base_url(); ?>assets/js/main.js"></script> -->

</body>
</html>
