<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!------------------------------------------------------------------------------------------------->
<!DOCTYPE html>
<html lang="en">
<!------------------------------------------------------------------------------------------------->
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta name="viewport" content="X-Content-Type-Options: nosniff, width=device-width, initial-scale=1.0, maximum-scale=1.0" />
	<title><?php echo $this->M_library_module->WEB_TITLE; ?></title>
	<meta name="description" content="RL" />
	<meta name="author" content="RL" />
	<link rel="icon" href="<?php echo base_url('template/rion/'.$this->M_library_module->WEB_ICON); ?>" />

	<!-- CSS / JAVA SCRIPT / BOOTSTRAP / ETC -->
	<!-- bootstrap & fontawesome -->
	<link rel="stylesheet" href="<?php echo base_url('template/backend/assets/css/bootstrap.min.css'); ?>" />
	<link rel="stylesheet" href="<?php echo base_url('template/backend/assets/font-awesome/4.5.0/css/font-awesome.min.css'); ?>" />
	<!-- text fonts -->
	<link rel="stylesheet" href="<?php echo base_url('template/backend/assets/css/fonts.googleapis.com.css'); ?>" />
	<!-- ace styles -->
	<link rel="stylesheet" href="<?php echo base_url('template/backend/assets/css/ace.min.css'); ?>" />

	<!--[if lte IE 9]>
		<link rel="stylesheet" href="<?php echo base_url('template/backend/assets/css/ace-part2.min.css'); ?>" />
	<![endif]-->
	<link rel="stylesheet" href="<?php echo base_url('template/backend/assets/css/ace-rtl.min.css'); ?>" />

	<!--[if lte IE 9]>
	  <link rel="stylesheet" href="<?php echo base_url('template/backend/assets/css/ace-ie.min.css'); ?>" />
	<![endif]-->

	<!-- HTML5shiv and Respond.js for IE8 to support HTML5 elements and media queries -->

	<!--[if lte IE 8]>
	<script src="<?php echo base_url('template/backend/assets/js/html5shiv.min.js'); ?>"></script>
	<script src="<?php echo base_url('template/backend/assets/js/respond.min.js'); ?>"></script>
	<![endif]-->
</head>
<!------------------------------------------------------------------------------------------------->
<body class="login-layout">
	<!------------------------------------------------------------------------------------------------->
	<!-- CONTENT -->
	<div class="main-container">
		<div class="main-content">
			<div class="row">
				<div class="col-sm-10 col-sm-offset-1">
					<div class="login-container">
					
						<div class="center">
							<h1>
								<i class="ace-icon fa fa-laptop green"></i>
								<span class="red">WMS</span>
								<span class="white" id="id-text2"><?php echo $this->M_library_module->WEB_TITLE; ?></span>
							</h1>
						</div>

						<div class="space-6"></div>

						<div class="position-relative">
							<div id="login-box" class="login-box visible widget-box no-border">
								<div class="widget-body">
									<div class="widget-main">
										<h4 class="header blue lighter bigger">
											<i class="ace-icon fa fa-users green"></i>
											Login Form
										</h4>

										<div class="space-6"></div>

										<form id="form" name="form" action="<?php echo site_url('C_index/login'); ?>" method="post" enctype="multipart/form-data">
											<fieldset>
												<label class="block clearfix">
													<span class="block input-icon input-icon-right">
														<input type="text" id="si_userid" name="si_userid" class="form-control" maxlength="150" autocomplete="off" onkeyup="auto_caps(this)" placeholder="Username" required="required"/>
														<i class="ace-icon fa fa-user"></i>
													</span>
												</label>

												<label class="block clearfix">
													<span class="block input-icon input-icon-right">
														<input type="password" id="si_password" name="si_password" class="form-control" maxlength="150" autocomplete="off" onkeyup="auto_caps(this)" placeholder="Password" required="required"/>
														<i class="ace-icon fa fa-lock"></i>
													</span>
												</label>

												<div class="space"></div>

												<div class="clearfix">
													<label class="inline">
														<input type="checkbox" class="ace" />
														<span class="lbl"> Remember Me</span>
													</label>

													<button id="btn_login" name="btn_login" type="submit" class="width-35 pull-right btn btn-sm btn-primary">
														<i class="ace-icon fa fa-key"></i>
														<span class="bigger-110">Login</span>
													</button>
												</div>

												<div class="space-4"></div>
											</fieldset>
										</form>
									</div>

									<div class="toolbar clearfix">
										<div class="pull-right">
											<a>2018 &copy; AceMod RL</a>
										</div>
									</div>
								</div>
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- CONTENT -->
	<!------------------------------------------------------------------------------------------------->
	<!-- JAVA SCRIPT / BOOTSTRAP / ETC -->
	<script src="<?php echo base_url('template/rion/jquery_costum.js'); ?>"></script>
	
	<!--[if !IE]> -->
	<script src="<?php echo base_url('template/backend/assets/js/jquery-2.1.4.min.js'); ?>"></script>
	<!-- <![endif]-->
	
	<!--[if IE]>
	<script src="<?php echo base_url('template/backend/assets/js/jquery-1.11.3.min.js'); ?>"></script>
	<![endif]-->
	<script type="text/javascript">
		if('ontouchstart' in document.documentElement) document.write("<script src='<?php echo base_url('template/backend/assets/js/jquery.mobile.custom.min.js'); ?>'>"+"<"+"/script>");
	</script>

	<!-- inline scripts related to this page -->
	<script type="text/javascript">
		jQuery(function($) {
			$(document).on('click', '.toolbar a[data-target]', function(e) {
				e.preventDefault();
				var target = $(this).data('target');
				$('.widget-box.visible').removeClass('visible');//hide others
				$(target).addClass('visible');//show target
			});
		});

		//you don't need this, just used for changing background
		jQuery(function($) {
			$('body').attr('class', 'login-layout light-login');
			$('#id-text2').attr('class', 'grey');
			$('#id-company-text').attr('class', 'blue');
			
			//$('#btn-login-dark').on('click', function(e) {
			//	$('body').attr('class', 'login-layout');
			//	$('#id-text2').attr('class', 'white');
			//	$('#id-company-text').attr('class', 'blue');
			//	
			//	e.preventDefault();
			//});
			//$('#btn-login-light').on('click', function(e) {
			//	$('body').attr('class', 'login-layout light-login');
			//	$('#id-text2').attr('class', 'grey');
			//	$('#id-company-text').attr('class', 'blue');
			//	
			//	e.preventDefault();
			//});
			//$('#btn-login-blur').on('click', function(e) {
			//	$('body').attr('class', 'login-layout blur-login');
			//	$('#id-text2').attr('class', 'white');
			//	$('#id-company-text').attr('class', 'light-blue');
			//	
			//	e.preventDefault();
			//});
		});
	</script>
	<!------------------------------------------------------------------------------------------------->
</body>
<!------------------------------------------------------------------------------------------------->
</html>
<!------------------------------------------------------------------------------------------------->