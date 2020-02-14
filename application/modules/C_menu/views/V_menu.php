<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//-----------------------------------------------------------------------------------------------//
$SESSION_ID = $this->session->userdata("session_mursmedic_id");
$SESSION_NAME = $this->session->userdata("session_mursmedic_name");
$SESSION_PHONE = $this->session->userdata("session_mursmedic_phone");
$SESSION_EMAIL = $this->session->userdata("session_mursmedic_email");
$SESSION_GRANT = $this->session->userdata("session_mursmedic_grant");
//-----------------------------------------------------------------------------------------------//
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

	<!-- page specific plugin styles -->

	<!-- text fonts -->
	<link rel="stylesheet" href="<?php echo base_url('template/backend/assets/css/fonts.googleapis.com.css'); ?>" />

	<!-- ace styles -->
	<link rel="stylesheet" href="<?php echo base_url('template/backend/assets/css/ace.min.css'); ?>" class="ace-main-stylesheet" id="main-ace-style" />

	<!--[if lte IE 9]>
		<link rel="stylesheet" href="<?php echo base_url('template/backend/assets/css/ace-part2.min.css'); ?>" class="ace-main-stylesheet" />
	<![endif]-->
	<link rel="stylesheet" href="<?php echo base_url('template/backend/assets/css/ace-skins.min.css'); ?>" />
	<link rel="stylesheet" href="<?php echo base_url('template/backend/assets/css/ace-rtl.min.css'); ?>" />

	<!--[if lte IE 9]>
	  <link rel="stylesheet" href="<?php echo base_url('template/backend/assets/css/ace-ie.min.css'); ?>" />
	<![endif]-->

	<!-- inline styles related to this page -->

	<!-- ace settings handler -->
	<script src="<?php echo base_url('template/backend/assets/js/ace-extra.min.js'); ?>"></script>

	<!-- HTML5shiv and Respond.js for IE8 to support HTML5 elements and media queries -->

	<!--[if lte IE 8]>
	<script src="<?php echo base_url('template/backend/assets/js/html5shiv.min.js'); ?>"></script>
	<script src="<?php echo base_url('template/backend/assets/js/respond.min.js'); ?>"></script>
	<![endif]-->
</head>
<!------------------------------------------------------------------------------------------------->
<body class="no-skin">
	<!------------------------------------------------------------------------------------------------->
	<!-- CONTENT -->
	<div id="navbar" class="navbar navbar-default ace-save-state">
		<div class="navbar-container ace-save-state" id="navbar-container">
			<button type="button" class="navbar-toggle menu-toggler pull-left" id="menu-toggler" data-target="#sidebar">
				<span class="sr-only">Toggle sidebar</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<div class="navbar-header pull-left">
				<a href="<?php echo site_url('menu'); ?>" class="navbar-brand">
					<!-- ??? -->
				</a>
			</div>

			<div class="navbar-buttons navbar-header pull-right" role="navigation">
				<ul class="nav ace-nav">

					<li class="light-blue dropdown-modal">
						<a data-toggle="dropdown" href="#" class="dropdown-toggle">
							<img class="nav-user-photo" src="<?php echo base_url('template/backend/assets/images/avatars/user.jpg'); ?>" />
							<span class="user-info">
								<small>Welcome,</small>
								<?php echo $SESSION_ID; ?>
							</span>
							<i class="ace-icon fa fa-caret-down"></i>
						</a>
						<ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
							<li>
								<a href="<?php echo site_url('profile'); ?>">
									<i class="ace-icon fa fa-user"></i>
									Profile
								</a>
							</li>
							<li class="divider"></li>
							<li>
								<a href="<?php echo site_url('C_menu/logout'); ?>">
									<i class="ace-icon fa fa-power-off"></i>
									Logout
								</a>
							</li>
						</ul>
					</li>

				</ul>
			</div>
		</div><!-- /.navbar-container -->
	</div>

	<div class="main-container ace-save-state" id="main-container">
		<script type="text/javascript">
			try{ace.settings.loadState('main-container')}catch(e){}
		</script>

		<div id="sidebar" class="sidebar responsive ace-save-state">
			<script type="text/javascript">
				try{ace.settings.loadState('sidebar')}catch(e){}
			</script>

			<div class="sidebar-shortcuts" id="sidebar-shortcuts">
				<div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">
					<button class="btn btn-success">M</button>
					<button class="btn btn-info">U</button>
					<button class="btn btn-warning">R</button>
					<button class="btn btn-danger">S</button>
				</div>

				<div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">
					<span class="btn btn-success">M</span>
					<span class="btn btn-info">U</span>
					<span class="btn btn-warning">R</span>
					<span class="btn btn-danger">S</span>
				</div>
			</div><!-- /.sidebar-shortcuts -->

			<ul class="nav nav-list">
				<!-- menu main-->
				<li class="active open">
					<a href="#" class="dropdown-toggle">
						<i class="menu-icon fa fa-desktop"></i>
						WMS
						<b class="arrow fa fa-angle-down"></b>
					</a>
					<b class="arrow"></b>
					
					<ul class="submenu">
						<li class="">
							<a href="#" class="dropdown-toggle">
								<i class="menu-icon fa fa-caret-right"></i>
								Master Data
								<b class="arrow fa fa-angle-down"></b>
							</a>
							<b class="arrow"></b>
							<ul class="submenu">
								<li class="">
									<a href="<?php echo site_url('md_grant'); ?>">
										<i class="menu-icon fa fa-folder"></i>
										Grant
									</a>
									<b class="arrow"></b>
								</li>
								<li class="">
									<a href="<?php echo site_url('md_user'); ?>">
										<i class="menu-icon fa fa-folder"></i>
										User
									</a>
									<b class="arrow"></b>
								</li>
								<li class="">
									<a href="<?php echo site_url('md_rack'); ?>">
										<i class="menu-icon fa fa-folder"></i>
										Rack
									</a>
									<b class="arrow"></b>
								</li>
								<li class="">
									<a href="<?php echo site_url('md_storage'); ?>">
										<i class="menu-icon fa fa-folder"></i>
										Warehouse
									</a>
									<b class="arrow"></b>
								</li>
								<li class="">
									<a href="<?php echo site_url('md_product_category'); ?>">
										<i class="menu-icon fa fa-folder"></i>
										Product Category
									</a>
									<b class="arrow"></b>
								</li>
								<li class="">
									<a href="<?php echo site_url('md_product'); ?>">
										<i class="menu-icon fa fa-folder"></i>
										Product
									</a>
									<b class="arrow"></b>
								</li>
								<li class="">
									<a href="<?php echo site_url('md_distributor'); ?>">
										<i class="menu-icon fa fa-folder"></i>
										Distributor
									</a>
									<b class="arrow"></b>
								</li>
								<li class="">
									<a href="<?php echo site_url('md_supplier'); ?>">
										<i class="menu-icon fa fa-folder"></i>
										Supplier
									</a>
									<b class="arrow"></b>
								</li>
								<li class="">
									<a href="<?php echo site_url('md_ekspedisi'); ?>">
										<i class="menu-icon fa fa-folder"></i>
										Ekspedisi
									</a>
									<b class="arrow"></b>
								</li>
								<li class="">
									<a href="<?php echo site_url('md_forwarder'); ?>">
										<i class="menu-icon fa fa-folder"></i>
										Forwarder
									</a>
									<b class="arrow"></b>
								</li>
							</ul>
						</li>
					</ul>
					
					<ul class="submenu">
						<li class="">
							<a href="#" class="dropdown-toggle">
								<i class="menu-icon fa fa-caret-right"></i>
								Inbound
								<b class="arrow fa fa-angle-down"></b>
							</a>
							<b class="arrow"></b>
							<ul class="submenu">
								<li class="">
									<a href="<?php echo site_url('i_input_data'); ?>">
										<i class="menu-icon fa fa-cloud-download"></i>
										Input Data
									</a>
									<b class="arrow"></b>
								</li>
								<li class="">
									<a href="<?php echo site_url('i_approve_data'); ?>">
										<i class="menu-icon fa fa-cloud-download"></i>
										Approve Data
									</a>
									<b class="arrow"></b>
								</li>
								<li class="">
									<a href="<?php echo site_url('i_summary'); ?>">
										<i class="menu-icon fa fa-cloud-download"></i>
										Summary
									</a>
									<b class="arrow"></b>
								</li>
								<?php if ($SESSION_GRANT == "ADMIN") { ?>
								<li class="">
									<a href="<?php echo site_url('i_inbound'); ?>">
										<i class="menu-icon fa fa-cloud-download"></i>
										Data Inbound
									</a>
									<b class="arrow"></b>
								</li>
								<?php } ?>
							</ul>
						</li>
					</ul>
					
					<ul class="submenu">
						<li class="">
							<a href="#" class="dropdown-toggle">
								<i class="menu-icon fa fa-caret-right"></i>
								Outbound
								<b class="arrow fa fa-angle-down"></b>
							</a>
							<b class="arrow"></b>
							<ul class="submenu">
								<li class="">
									<a href="<?php echo site_url('o_input_data'); ?>">
										<i class="menu-icon fa fa-cloud-upload"></i>
										Input Data
									</a>
									<b class="arrow"></b>
								</li>
								<li class="">
									<a href="<?php echo site_url('o_tally_sheet'); ?>">
										<i class="menu-icon fa fa-cloud-upload"></i>
										Tally Sheet
									</a>
									<b class="arrow"></b>
								</li>
								<li class="">
									<a href="<?php echo site_url('o_approve_data'); ?>">
										<i class="menu-icon fa fa-cloud-upload"></i>
										Approve Data
									</a>
									<b class="arrow"></b>
								</li>
								<li class="">
									<a href="<?php echo site_url('o_delivery_note'); ?>">
										<i class="menu-icon fa fa-cloud-upload"></i>
										Delivery Note
									</a>
									<b class="arrow"></b>
								</li>
								<li class="">
									<a href="<?php echo site_url('o_delivery_note_status'); ?>">
										<i class="menu-icon fa fa-cloud-upload"></i>
										Delivery Note Status
									</a>
									<b class="arrow"></b>
								</li>
							</ul>
						</li>
					</ul>
					
					<ul class="submenu">
						<li class="">
							<a href="#" class="dropdown-toggle">
								<i class="menu-icon fa fa-caret-right"></i>
								Quarantine
								<b class="arrow fa fa-angle-down"></b>
							</a>
							<b class="arrow"></b>
							<ul class="submenu">
								<li class="">
									<a href="<?php echo site_url('q_data'); ?>">
										<i class="menu-icon fa fa-cloud-upload"></i>
										Data
									</a>
									<b class="arrow"></b>
								</li>
								<li class="">
									<a href="<?php echo site_url('q_sample'); ?>">
									<i class="menu-icon fa fa-book"></i>
									Sample
									</a>
									<b class="arrow"></b>
								</li>
								<li class="">
									<a href="<?php echo site_url('q_return'); ?>">
									<i class="menu-icon fa fa-book"></i>
									Return
									</a>
									<b class="arrow"></b>
								</li>
							</ul>
						</li>
					</ul>
					
					<ul class="submenu">
						<li class="">
							<a href="#" class="dropdown-toggle">
								<i class="menu-icon fa fa-caret-right"></i>
								Report
								<b class="arrow fa fa-angle-down"></b>
							</a>
							<b class="arrow"></b>
							<ul class="submenu">
								<li class="">
									<a href="<?php echo site_url('r_stock_rack'); ?>">
										<i class="menu-icon fa fa-book"></i>
										Stock Rack
									</a>
									<b class="arrow"></b>
								</li>
								<li class="">
									<a href="<?php echo site_url('r_stock_product'); ?>">
										<i class="menu-icon fa fa-book"></i>
										Stock Product
									</a>
									<b class="arrow"></b>
								</li>
								<li class="">
									<a href="<?php echo site_url('r_inbound'); ?>">
										<i class="menu-icon fa fa-book"></i>
										Inbound
									</a>
									<b class="arrow"></b>
								</li>
								<li class="">
									<a href="<?php echo site_url('C_r_outbound'); ?>">
										<i class="menu-icon fa fa-book"></i>
										Outbound
									</a>
									<b class="arrow"></b>
								</li>
							</ul>
						</li>
					</ul>

					<ul class="submenu">
						<li class="">
							<a href="<?php echo site_url('log'); ?>">
								<i class="menu-icon fa fa-caret-right"></i>
								Log
							</a>
							<b class="arrow"></b>
						</li>
					</ul>
					
				</li>
				<!-- menu logout -->
				<li class="">
					<a href="<?php echo site_url('C_menu/logout'); ?>">
						<i class="menu-icon fa fa-power-off"></i>
						<span class="menu-text"> Logout </span>
					</a>
					<b class="arrow"></b>
				</li>
			</ul>

			<div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
				<i id="sidebar-toggle-icon" class="ace-icon fa fa-angle-double-left ace-save-state" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
			</div>
		</div>

		<div class="main-content">
			<div class="main-content-inner">
				<div class="breadcrumbs ace-save-state" id="breadcrumbs">
					<ul class="breadcrumb">
						<li>
							<i class="ace-icon fa fa-home home-icon"></i>
							<a href="<?php echo site_url('menu'); ?>">Home</a>
						</li>
						<li class="active">Dashboard</li>
					</ul>
				</div>

				<div class="page-content">
					<div class="page-header">
						<h1>
							Dashboard
						</h1>
					</div>

					<div class="row">
						<div class="col-xs-12">
							<!-- PAGE CONTENT BEGINS -->
							<div class="alert alert-block alert-success">
								<button type="button" class="close" data-dismiss="alert">
									<i class="ace-icon fa fa-times"></i>
								</button>
								<i class="ace-icon fa fa-check green"></i>
								Welcome to
								<strong class="green">
									WMS<small> (v1.0)</small>
								</strong>
							</div>
							
							<div class="row">
								<div class="col-xs-12">
									<!-- ??? -->
								</div>
							</div>
							<!-- PAGE CONTENT ENDS -->
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="footer">
			<div class="footer-inner">
				<div class="footer-content">
					<span class="bigger-120">
						2018 &copy; AceMod RL
					</span>
				</div>
			</div>
		</div>

		<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
			<i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
		</a>
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
	<script src="<?php echo base_url('template/backend/assets/js/bootstrap.min.js'); ?>"></script>

	<!-- page specific plugin scripts -->

	<!--[if lte IE 8]>
	  <script src="<?php echo base_url('template/backend/assets/js/excanvas.min.js'); ?>"></script>
	<![endif]-->
	<script src="<?php echo base_url('template/backend/assets/js/jquery-ui.custom.min.js'); ?>"></script>
	<script src="<?php echo base_url('template/backend/assets/js/jquery.ui.touch-punch.min.js'); ?>"></script>
	<script src="<?php echo base_url('template/backend/assets/js/jquery.easypiechart.min.js'); ?>"></script>
	<script src="<?php echo base_url('template/backend/assets/js/jquery.sparkline.index.min.js'); ?>"></script>
	<script src="<?php echo base_url('template/backend/assets/js/jquery.flot.min.js'); ?>"></script>
	<script src="<?php echo base_url('template/backend/assets/js/jquery.flot.pie.min.js'); ?>"></script>
	<script src="<?php echo base_url('template/backend/assets/js/jquery.flot.resize.min.js'); ?>"></script>

	<!-- ace scripts -->
	<script src="<?php echo base_url('template/backend/assets/js/ace-elements.min.js'); ?>"></script>
	<script src="<?php echo base_url('template/backend/assets/js/ace.min.js'); ?>"></script>

	<!-- inline scripts related to this page -->
	<script type="text/javascript">
		<!-- ??? -->
	</script>
	<!------------------------------------------------------------------------------------------------->
</body>
<!------------------------------------------------------------------------------------------------->
</html>
<!------------------------------------------------------------------------------------------------->