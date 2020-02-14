<?php
defined('BASEPATH') or exit('No direct script access allowed');
//-----------------------------------------------------------------------------------------------//
$SESSION_ID = $this->session->userdata("session_mursmedic_id");
$SESSION_NAME = $this->session->userdata("session_mursmedic_name");
$SESSION_PHONE = $this->session->userdata("session_mursmedic_phone");
$SESSION_EMAIL = $this->session->userdata("session_mursmedic_email");
$SESSION_GRANT = $this->session->userdata("session_mursmedic_grant");
//-----------------------------------------------------------------------------------------------//
$is_continue_distributor = true;
$get_data_distributor = $this->M_library_database->DB_GET_DATA_ALL_DISTRIBUTOR();
if (empty($get_data_distributor) || $get_data_distributor == "") {
	$is_continue_distributor = false;
}
//-----------------------------------------------------------------------------------------------//
$is_continue_product = true;
$get_data_product = $this->M_library_database->DB_GET_DATA_ALL_PRODUCT();
if (empty($get_data_product) || $get_data_product == "") {
	$is_continue_product = false;
}
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
	<link rel="icon" href="<?php echo base_url('template/rion/' . $this->M_library_module->WEB_ICON); ?>" />

	<!-- CSS / JAVA SCRIPT / BOOTSTRAP / ETC -->
	<!-- bootstrap & fontawesome -->
	<link rel="stylesheet" href="<?php echo base_url('template/backend/assets/css/bootstrap.min.css'); ?>" />
	<link rel="stylesheet" href="<?php echo base_url('template/backend/assets/font-awesome/4.5.0/css/font-awesome.min.css'); ?>" />

	<!-- page specific plugin styles -->
	<link rel="stylesheet" href="<?php echo base_url('template/backend/assets/css/jquery-ui.custom.min.css'); ?>" />
	<link rel="stylesheet" href="<?php echo base_url('template/backend/assets/css/chosen.min.css'); ?>" />
	<link rel="stylesheet" href="<?php echo base_url('template/backend/assets/css/bootstrap-datepicker3.min.css'); ?>" />
	<link rel="stylesheet" href="<?php echo base_url('template/backend/assets/css/bootstrap-timepicker.min.css'); ?>" />
	<link rel="stylesheet" href="<?php echo base_url('template/backend/assets/css/daterangepicker.min.css'); ?>" />
	<link rel="stylesheet" href="<?php echo base_url('template/backend/assets/css/bootstrap-datetimepicker.min.css'); ?>" />
	<link rel="stylesheet" href="<?php echo base_url('template/backend/assets/css/bootstrap-colorpicker.min.css'); ?>" />
	<link rel="stylesheet" href="<?php echo base_url('template/backend/assets/css/bootstrap-duallistbox.min.css'); ?>" />
	<link rel="stylesheet" href="<?php echo base_url('template/backend/assets/css/bootstrap-multiselect.min.css'); ?>" />
	<link rel="stylesheet" href="<?php echo base_url('template/backend/assets/css/select2.min.css'); ?>" />

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
						<li class="active open">
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
								<li class="active">
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
						<li class="active">Return</li>
					</ul>
				</div>

				<div class="page-content">
					<div class="page-header">
						<h1>
							Data
						</h1>
					</div>

					<div class="row">
						<div class="col-xs-12">
							<!-- PAGE CONTENT BEGINS -->
							<?php //var_dump($_POST); ?>
							
							<!-- Search -->
							<div class="row">
								<div class="col-xs-12">
									<form action="<?php echo site_url('q_return'); ?>" method="post" enctype="multipart/form-data">
										<div class="col-xs-12 col-sm-3">
											<div class="form-group">
												<label for="ss_date_from" class="control-label">Tgl Dari</label>
												<div class="input-group">
													<input class="form-control date-picker" id="ss_date_from" name="ss_date_from" type="text" data-date-format="yyyy-mm-dd" value="<?php echo date('Y-m-d'); ?>" required="required"/>
													<span class="input-group-addon">
														<i class="fa fa-calendar bigger-110"></i>
													</span>
												</div>
											</div>
										</div>
										<div class="col-xs-12 col-sm-3">
											<div class="form-group">
												<label for="ss_date_to" class="control-label">Tgl Sampai</label>
												<div class="input-group">
													<input class="form-control date-picker" id="ss_date_to" name="ss_date_to" type="text" data-date-format="yyyy-mm-dd" value="<?php echo date('Y-m-d'); ?>" required="required"/>
													<span class="input-group-addon">
														<i class="fa fa-calendar bigger-110"></i>
													</span>
												</div>
											</div>
										</div>
										<div class="col-xs-12">
											<div class="form-group">
												<button type="submit" id="btn_search" name="btn_search" class="btn btn-info btn-sm"><i class="fa fa-search"></i> Search</button>
											</div>
										</div>
									</form>
								</div>
							</div>
							<!-- Search -->

							<div class="hr hr-18 dotted hr-single"></div>
							
							<!-- printMe -->
							<div id='printMe'>

								<div class="row">
									<div class="col-xs-12">
										<div class="col-xs-3 center">
											Mursmedic
											<br />
											Warehouse Departement
										</div>
										<div class="col-xs-6 center">
											<h4>Quarantine</h4>
										</div>
										<div class="col-xs-3 center">
											<?php echo date('d-m-Y H:i:s'); ?>
										</div>
									</div>
								</div>
								
								<div class="hr hr-18 dotted hr-single"></div>
							
								<!-- Table -->
								<div class="row">
									<div class="col-xs-12">		
										<div class="table-responsive">
											<div>
												<table id="tb_item" name="tb_item" class="table table-striped table-bordered">
													<thead>
														<tr>
															<th>No</th>
															<th>Product ID</th>
															<th>Name Product</th>
															<th>Qty</th>
															<th>Status</th>
														</tr>
													</thead>
													<tbody>
														
														<?php
													$is_continue = true;
														//-----------------------------------------------------------------------------------------------//
													if (isset($_POST['btn_search'])) {
														$ss_date_from = trim($this->input->post('ss_date_from'));
														$ss_date_to = trim($this->input->post('ss_date_to'));
													} else {
														$is_continue = false;
													}
														//-----------------------------------------------------------------------------------------------//
													if ($is_continue) {
														$get_data = $this->M_library_database->DB_GET_DATA_SEARCH_RETURN($ss_date_from, $ss_date_to);
														if (empty($get_data) || $get_data == "") {
															$is_continue = false;
														}
													}
														//-----------------------------------------------------------------------------------------------//
													if ($is_continue) {
														$index = 1;
														$sum_stock = 0;
														foreach ($get_data as $data_row) :
														?>

														<!-- Table Row -->
														<tr>
															<td><?php echo $index; ?></td>
															<td><?php echo $data_row->PT_ID; ?></td>
															<td><?php echo $data_row->PTRN_NAME; ?></td>
															<td><?php echo $data_row->PTRN_QTY; ?></td>
															<td><?php echo $data_row->PTRN_STATUS; ?></td>
														</tr>
														<!-- Table Row -->

														<?php
													$index++;
													$sum_stock += ($data_row->PTRN_QTY);
													endforeach;

													?>
														<tr>
															<td colspan="4">Sum Product Item</td>
															<td><?php echo ($index - 1); ?></td>
														<tr>
														<tr>
															<td colspan="4">Sum Stock</td>
															<td><?php echo $sum_stock; ?></td>
														<tr>
														<?php
													if ($sum_stock == 0) {
														$is_continue = false;
													}
												}
												?>
													</tbody>
												</table>
											</div>
										</div>
									</div>
								</div>
								<!-- Table -->
							
							</div>
							<!-- printMe -->
							
							<div class="hr hr-18 dotted hr-single"></div>
							
							<!-- Download -->
							<?php if ($is_continue) { ?>
							<div class="row">
								<div class="col-xs-12">
									<p>
										<button id="btn_print" name="btn_print" class="btn btn-info btn-xs" onclick="printIt('printMe')"><i class="fa fa-print"></i></button>
	
										<form action="<?php echo site_url('C_q_return/data_download'); ?>" method="post" enctype="multipart/form-data">
											<input type="hidden" id="table_data_all" name="table_data_all" value="<?php echo base64_encode(serialize($get_data)); ?>" required="required"/>
											<button type="submit" id="btn_download" name="btn_download" class="btn btn-info btn-sm"><i class="fa fa-download"></i> Download *</button>
										</form>
									</p>
								</div>
							</div>
							<?php 
					} ?>
							<!-- Download -->
							

							<!-- End Modal -->
							
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
	<!-- MODAL -->
	<!-- ??? -->
	<!-- MODAL -->
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
	<script src="<?php echo base_url('template/backend/assets/js/jquery.dataTables.min.js'); ?>"></script>
	<script src="<?php echo base_url('template/backend/assets/js/jquery.dataTables.bootstrap.min.js'); ?>"></script>
	<script src="<?php echo base_url('template/backend/assets/js/dataTables.buttons.min.js'); ?>"></script>
	<script src="<?php echo base_url('template/backend/assets/js/buttons.flash.min.js'); ?>"></script>
	<script src="<?php echo base_url('template/backend/assets/js/buttons.html5.min.js'); ?>"></script>
	<script src="<?php echo base_url('template/backend/assets/js/buttons.print.min.js'); ?>"></script>
	<script src="<?php echo base_url('template/backend/assets/js/buttons.colVis.min.js'); ?>"></script>
	<script src="<?php echo base_url('template/backend/assets/js/dataTables.select.min.js'); ?>"></script>
	<script src="<?php echo base_url('template/backend/assets/js/chosen.jquery.min.js'); ?>"></script>
	<script src="<?php echo base_url('template/backend/assets/js/spinbox.min.js'); ?>"></script>
	<script src="<?php echo base_url('template/backend/assets/js/bootstrap-datepicker.min.js'); ?>"></script>
	<script src="<?php echo base_url('template/backend/assets/js/bootstrap-timepicker.min.js'); ?>"></script>
	<script src="<?php echo base_url('template/backend/assets/js/moment.min.js'); ?>"></script>
	<script src="<?php echo base_url('template/backend/assets/js/daterangepicker.min.js'); ?>"></script>
	<script src="<?php echo base_url('template/backend/assets/js/bootstrap-datetimepicker.min.js'); ?>"></script>
	<script src="<?php echo base_url('template/backend/assets/js/bootstrap-colorpicker.min.js'); ?>"></script>
	<script src="<?php echo base_url('template/backend/assets/js/jquery.knob.min.js'); ?>"></script>
	<script src="<?php echo base_url('template/backend/assets/js/autosize.min.js'); ?>"></script>
	<script src="<?php echo base_url('template/backend/assets/js/jquery.inputlimiter.min.js'); ?>"></script>
	<script src="<?php echo base_url('template/backend/assets/js/jquery.maskedinput.min.js'); ?>"></script>
	<script src="<?php echo base_url('template/backend/assets/js/bootstrap-tag.min.js'); ?>"></script>
	<script src="<?php echo base_url('template/backend/assets/js/jquery.bootstrap-duallistbox.min.js'); ?>"></script>
	<script src="<?php echo base_url('template/backend/assets/js/jquery.raty.min.js'); ?>"></script>
	<script src="<?php echo base_url('template/backend/assets/js/bootstrap-multiselect.min.js'); ?>"></script>
	<script src="<?php echo base_url('template/backend/assets/js/select2.min.js'); ?>"></script>
	<script src="<?php echo base_url('template/backend/assets/js/jquery-typeahead.js'); ?>"></script>
	<script src="<?php echo base_url('template/backend/assets/js/wizard.min.js'); ?>"></script>
	<script src="<?php echo base_url('template/backend/assets/js/jquery.validate.min.js'); ?>"></script>
	<script src="<?php echo base_url('template/backend/assets/js/jquery-additional-methods.min.js'); ?>"></script>
	<script src="<?php echo base_url('template/backend/assets/js/bootbox.js'); ?>"></script>
	
	<!-- ace scripts -->
	<script src="<?php echo base_url('template/backend/assets/js/ace-elements.min.js'); ?>"></script>
	<script src="<?php echo base_url('template/backend/assets/js/ace.min.js'); ?>"></script>

	<!-- inline scripts related to this page -->
	<script type="text/javascript">
		//-----------------------------------------------------------------------------------------------//
		function web_reload() {
			location.href=location.href
		}
		//-----------------------------------------------------------------------------------------------//
		function printIt(divName){
			var printContents = document.getElementById(divName).innerHTML;
			var originalContents = document.body.innerHTML;
			document.body.innerHTML = printContents;
			window.print();
			document.body.innerHTML = originalContents;
		}

		$(document).on( "click", '.btn_view',function(e) {
			var sv_id = $(this).data('sv_id');
			var sv_total = $(this).data('sv_total');
		
			$(".sv_id").val(sv_id);
			$(".sv_total").val(sv_total);
		});

	function hitung() {
		var a = $("#sv_total").val();
		var b = $("#repack").val();
		var c = $("#sample").val();
		var d = $("#destroy").val();
		var e = $("#return").val();
		f = a - b - c - d - e;
		$("#total").val(f);
	}
		//-----------------------------------------------------------------------------------------------//
		jQuery(function($) {
			//-----------------------------------------------------------------------------------------------//
			//TABLE
			//-----------------------------------------------------------------------------------------------//
			//var myTable = 
			//$('#dynamic-table')
			////.wrap("<div class='dataTables_borderWrap' />")   //if you are applying horizontal scrolling (sScrollX)
			//.DataTable({
			//	bAutoWidth: false,
			//	"aoColumns": [
			//		//{ "bSortable": false },
			//		//MUST UPDATE!!!
			//		null,
			//		null,
			//		null,
			//		null,
			//		null,
			//		//MUST UPDATE!!!
			//		{ "bSortable": false }
			//	],
			//	"aaSorting": [],
            //
			//	//"bProcessing": true,
			//    //"bServerSide": true,
			//    //"sAjaxSource": "http://127.0.0.1/table.php"	,
			//
			//	//,
			//	//"sScrollY": "200px",
			//	//"bPaginate": false,
			//
			//	//"sScrollX": "100%",
			//	//"sScrollXInner": "120%",
			//	//"bScrollCollapse": true,
			//	//Note: if you are applying horizontal scrolling (sScrollX) on a ".table-bordered"
			//	//you may want to wrap the table inside a "div.dataTables_borderWrap" element
			//
			//	//"iDisplayLength": 50
            //
			//	select: {
			//		style: 'multi'
			//	}
			//});
			//
			//$.fn.dataTable.Buttons.defaults.dom.container.className = 'dt-buttons btn-overlap btn-group btn-overlap';
			//
			//new $.fn.dataTable.Buttons( myTable, {
			//	buttons: [
			//		{
			//			"extend": "colvis",
			//			"text": "<i class='fa fa-search bigger-110 blue'></i> <span class='hidden'>Show/hide columns</span>",
			//			"className": "btn btn-white btn-primary btn-bold",
			//			columns: ':not(:first):not(:last)'
			//		},
			//		{
			//			"extend": "copy",
			//			"text": "<i class='fa fa-copy bigger-110 pink'></i> <span class='hidden'>Copy to clipboard</span>",
			//			"className": "btn btn-white btn-primary btn-bold"
			//		},
			//		{
			//			"extend": "csv",
			//			"text": "<i class='fa fa-database bigger-110 orange'></i> <span class='hidden'>Export to CSV</span>",
			//			"className": "btn btn-white btn-primary btn-bold"
			//		},
			//		{
			//			"extend": "excel",
			//			"text": "<i class='fa fa-file-excel-o bigger-110 green'></i> <span class='hidden'>Export to Excel</span>",
			//			"className": "btn btn-white btn-primary btn-bold"
			//		},
			//		{
			//			"extend": "pdf",
			//			"text": "<i class='fa fa-file-pdf-o bigger-110 red'></i> <span class='hidden'>Export to PDF</span>",
			//			"className": "btn btn-white btn-primary btn-bold"
			//		},
			//		{
			//			"extend": "print",
			//			"text": "<i class='fa fa-print bigger-110 grey'></i> <span class='hidden'>Print</span>",
			//			"className": "btn btn-white btn-primary btn-bold",
			//			autoPrint: false,
			//			message: 'This print was produced using the Print button for DataTables'
			//		}		  
			//	]
			//} );
			//myTable.buttons().container().appendTo($('.tableTools-container'));
			//
			////style the message box
			//var defaultCopyAction = myTable.button(1).action();
			//myTable.button(1).action(function (e, dt, button, config) {
			//	defaultCopyAction(e, dt, button, config);
			//	$('.dt-button-info').addClass('gritter-item-wrapper gritter-info gritter-center white');
			//});
			//
			//var defaultColvisAction = myTable.button(0).action();
			//myTable.button(0).action(function (e, dt, button, config) {
			//	defaultColvisAction(e, dt, button, config);
			//	if($('.dt-button-collection > .dropdown-menu').length == 0) {
			//		$('.dt-button-collection')
			//		.wrapInner('<ul class="dropdown-menu dropdown-light dropdown-caret dropdown-caret" />')
			//		.find('a').attr('href', '#').wrap("<li />")
			//	}
			//	$('.dt-button-collection').appendTo('.tableTools-container .dt-buttons')
			//});
			//
			//setTimeout(function() {
			//	$($('.tableTools-container')).find('a.dt-button').each(function() {
			//		var div = $(this).find(' > div').first();
			//		if(div.length == 1) div.tooltip({container: 'body', title: div.parent().text()});
			//		else $(this).tooltip({container: 'body', title: $(this).text()});
			//	});
			//}, 500);
			//
			//myTable.on( 'select', function ( e, dt, type, index ) {
			//	if ( type === 'row' ) {
			//		$( myTable.row( index ).node() ).find('input:checkbox').prop('checked', true);
			//	}
			//});
			//myTable.on( 'deselect', function ( e, dt, type, index ) {
			//	if ( type === 'row' ) {
			//		$( myTable.row( index ).node() ).find('input:checkbox').prop('checked', false);
			//	}
			//});
			//
			////table checkboxes
			//$('th input[type=checkbox], td input[type=checkbox]').prop('checked', false);
			//
			////select/deselect all rows according to table header checkbox
			//$('#dynamic-table > thead > tr > th input[type=checkbox], #dynamic-table_wrapper input[type=checkbox]').eq(0).on('click', function(){
			//	var th_checked = this.checked;//checkbox inside "TH" table header
			//	
			//	$('#dynamic-table').find('tbody > tr').each(function(){
			//		var row = this;
			//		if(th_checked) myTable.row(row).select();
			//		else  myTable.row(row).deselect();
			//	});
			//});
			//
			////select/deselect a row when the checkbox is checked/unchecked
			//$('#dynamic-table').on('click', 'td input[type=checkbox]' , function(){
			//	var row = $(this).closest('tr').get(0);
			//	if(this.checked) myTable.row(row).deselect();
			//	else myTable.row(row).select();
			//});
			//
			//$(document).on('click', '#dynamic-table .dropdown-toggle', function(e) {
			//	e.stopImmediatePropagation();
			//	e.stopPropagation();
			//	e.preventDefault();
			//});
			//
			////And for the first simple table, which doesn't have TableTools or dataTables
			////select/deselect all rows according to table header checkbox
			//var active_class = 'active';
			//$('#simple-table > thead > tr > th input[type=checkbox]').eq(0).on('click', function(){
			//	var th_checked = this.checked;//checkbox inside "TH" table header
			//	$(this).closest('table').find('tbody > tr').each(function(){
			//		var row = this;
			//		if(th_checked) $(row).addClass(active_class).find('input[type=checkbox]').eq(0).prop('checked', true);
			//		else $(row).removeClass(active_class).find('input[type=checkbox]').eq(0).prop('checked', false);
			//	});
			//});
			//
			////select/deselect a row when the checkbox is checked/unchecked
			//$('#simple-table').on('click', 'td input[type=checkbox]' , function(){
			//	var $row = $(this).closest('tr');
			//	if($row.is('.detail-row ')) return;
			//	if(this.checked) $row.addClass(active_class);
			//	else $row.removeClass(active_class);
			//});
			//
			////add tooltip for small view action buttons in dropdown menu
			//$('[data-rel="tooltip"]').tooltip({placement: tooltip_placement});
			//
			////tooltip placement on right or left
			//function tooltip_placement(context, source) {
			//	var $source = $(source);
			//	var $parent = $source.closest('table')
			//	var off1 = $parent.offset();
			//	var w1 = $parent.width();
			//
			//	var off2 = $source.offset();
			//	//var w2 = $source.width();
			//
			//	if( parseInt(off2.left) < parseInt(off1.left) + parseInt(w1 / 2) ) return 'right';
			//	return 'left';
			//}
			//
			//$('.show-details-btn').on('click', function(e) {
			//	e.preventDefault();
			//	$(this).closest('tr').next().toggleClass('open');
			//	$(this).find(ace.vars['.icon']).toggleClass('fa-angle-double-down').toggleClass('fa-angle-double-up');
			//});
			//
			///**
			////add horizontal scrollbars to a simple table
			//$('#simple-table').css({'width':'2000px', 'max-width': 'none'}).wrap('<div style="width: 1000px;" />').parent().ace_scroll(
			//  {
			//	horizontal: true,
			//	styleClass: 'scroll-top scroll-dark scroll-visible',//show the scrollbars on top(default is bottom)
			//	size: 2000,
			//	mouseWheelLock: true
			//  }
			//).css('padding-top', '12px');
			//*/
			//-----------------------------------------------------------------------------------------------//
			//TABLE
			//-----------------------------------------------------------------------------------------------//
			
			
			
			//-----------------------------------------------------------------------------------------------//
			//FORM ELEMENT 1
			//-----------------------------------------------------------------------------------------------//
			$('#id-disable-check').on('click', function() {
				var inp = $('#form-input-readonly').get(0);
				if(inp.hasAttribute('disabled')) {
					inp.setAttribute('readonly' , 'true');
					inp.removeAttribute('disabled');
					inp.value="This text field is readonly!";
				} else {
					inp.setAttribute('disabled' , 'disabled');
					inp.removeAttribute('readonly');
					inp.value="This text field is disabled!";
				}
			});
			
			if(!ace.vars['touch']) {
				$('.chosen-select').chosen({allow_single_deselect:true}); 
				//resize the chosen on window resize
				$(window)
				.off('resize.chosen')
				.on('resize.chosen', function() {
					$('.chosen-select').each(function() {
						 var $this = $(this);
						 //$this.next().css({'width': $this.parent().width()});
						 $this.next().css({'width': '100%'});
					})
				}).trigger('resize.chosen');
				//resize chosen on sidebar collapse/expand
				$(document).on('settings.ace.chosen', function(e, event_name, event_val) {
					if(event_name != 'sidebar_collapsed') return;
					$('.chosen-select').each(function() {
						 var $this = $(this);
						 //$this.next().css({'width': $this.parent().width()});
						 $this.next().css({'width': '100%'});
					})
				});
				$('#chosen-multiple-style .btn').on('click', function(e){
					var target = $(this).find('input[type=radio]');
					var which = parseInt(target.val());
					if(which == 2) $('#form-field-select-4').addClass('tag-input-style');
					 else $('#form-field-select-4').removeClass('tag-input-style');
				});
			}
		
			$('[data-rel=tooltip]').tooltip({container:'body'});
			$('[data-rel=popover]').popover({container:'body'});
			
			autosize($('textarea[class*=autosize]'));
			
			$('textarea.limited').inputlimiter({
				remText: '%n character%s remaining...',
				limitText: 'max allowed : %n.'
			});
			
			$.mask.definitions['~']='[+-]';
			$('.input-mask-date').mask('99/99/9999');
			$('.input-mask-phone').mask('(999) 999-9999');
			$('.input-mask-eyescript').mask('~9.99 ~9.99 999');
			$(".input-mask-product").mask("a*-999-a999",{placeholder:" ",completed:function(){alert("You typed the following: "+this.val());}});
			
			$( "#input-size-slider" ).css('width','200px').slider({
				value:1,
				range: "min",
				min: 1,
				max: 8,
				step: 1,
				slide: function( event, ui ) {
					var sizing = ['', 'input-sm', 'input-lg', 'input-mini', 'input-small', 'input-medium', 'input-large', 'input-xlarge', 'input-xxlarge'];
					var val = parseInt(ui.value);
					$('#form-field-4').attr('class', sizing[val]).attr('placeholder', '.'+sizing[val]);
				}
			});
			
			$( "#input-span-slider" ).slider({
				value:1,
				range: "min",
				min: 1,
				max: 12,
				step: 1,
				slide: function( event, ui ) {
					var val = parseInt(ui.value);
					$('#form-field-5').attr('class', 'col-xs-'+val).val('.col-xs-'+val);
				}
			});
			
			//"jQuery UI Slider"
			//range slider tooltip example
			$( "#slider-range" ).css('height','200px').slider({
				orientation: "vertical",
				range: true,
				min: 0,
				max: 100,
				values: [ 17, 67 ],
				slide: function( event, ui ) {
					var val = ui.values[$(ui.handle).index()-1] + "";
			
					if( !ui.handle.firstChild ) {
						$("<div class='tooltip right in' style='display:none;left:16px;top:-6px;'><div class='tooltip-arrow'></div><div class='tooltip-inner'></div></div>")
						.prependTo(ui.handle);
					}
					$(ui.handle.firstChild).show().children().eq(1).text(val);
				}
			}).find('span.ui-slider-handle').on('blur', function(){
				$(this.firstChild).hide();
			});
			
			$( "#slider-range-max" ).slider({
				range: "max",
				min: 1,
				max: 10,
				value: 2
			});
			
			$( "#slider-eq > span" ).css({width:'90%', 'float':'left', margin:'15px'}).each(function() {
				// read initial values from markup and remove that
				var value = parseInt( $( this ).text(), 10 );
				$( this ).empty().slider({
					value: value,
					range: "min",
					animate: true
					
				});
			});
			
			$("#slider-eq > span.ui-slider-purple").slider('disable');//disable third item
			
			$('#id-input-file-1 , #id-input-file-2').ace_file_input({
				no_file:'No File ...',
				btn_choose:'Choose',
				btn_change:'Change',
				droppable:false,
				onchange:null,
				thumbnail:false //| true | large
				//whitelist:'gif|png|jpg|jpeg'
				//blacklist:'exe|php'
				//onchange:''
				//
			});
			//pre-show a file name, for example a previously selected file
			//$('#id-input-file-1').ace_file_input('show_file_list', ['myfile.txt'])
			
			$('#id-input-file-3').ace_file_input({
				style: 'well',
				btn_choose: 'Drop files here or click to choose',
				btn_change: null,
				no_icon: 'ace-icon fa fa-cloud-upload',
				droppable: true,
				thumbnail: 'small'//large | fit
				//,icon_remove:null//set null, to hide remove/reset button
				/**,before_change:function(files, dropped) {
					//Check an example below
					//or examples/file-upload.html
					return true;
				}*/
				/**,before_remove : function() {
					return true;
				}*/
				,
				preview_error : function(filename, error_code) {
					//name of the file that failed
					//error_code values
					//1 = 'FILE_LOAD_FAILED',
					//2 = 'IMAGE_LOAD_FAILED',
					//3 = 'THUMBNAIL_FAILED'
					//alert(error_code);
				}
			}).on('change', function(){
				//console.log($(this).data('ace_input_files'));
				//console.log($(this).data('ace_input_method'));
			});
			
			//$('#id-input-file-3')
			//.ace_file_input('show_file_list', [
				//{type: 'image', name: 'name of image', path: 'http://path/to/image/for/preview'},
				//{type: 'file', name: 'hello.txt'}
			//]);
			
			//dynamically change allowed formats by changing allowExt && allowMime function
			$('#id-file-format').removeAttr('checked').on('change', function() {
				var whitelist_ext, whitelist_mime;
				var btn_choose
				var no_icon
				if(this.checked) {
					btn_choose = "Drop images here or click to choose";
					no_icon = "ace-icon fa fa-picture-o";
			
					whitelist_ext = ["jpeg", "jpg", "png", "gif" , "bmp"];
					whitelist_mime = ["image/jpg", "image/jpeg", "image/png", "image/gif", "image/bmp"];
				} else {
					btn_choose = "Drop files here or click to choose";
					no_icon = "ace-icon fa fa-cloud-upload";
					
					whitelist_ext = null;//all extensions are acceptable
					whitelist_mime = null;//all mimes are acceptable
				}
				var file_input = $('#id-input-file-3');
				file_input
				.ace_file_input('update_settings',
				{
					'btn_choose': btn_choose,
					'no_icon': no_icon,
					'allowExt': whitelist_ext,
					'allowMime': whitelist_mime
				})
				file_input.ace_file_input('reset_input');
				
				file_input
				.off('file.error.ace')
				.on('file.error.ace', function(e, info) {
					//console.log(info.file_count);//number of selected files
					//console.log(info.invalid_count);//number of invalid files
					//console.log(info.error_list);//a list of errors in the following format
					
					//info.error_count['ext']
					//info.error_count['mime']
					//info.error_count['size']
					
					//info.error_list['ext']  = [list of file names with invalid extension]
					//info.error_list['mime'] = [list of file names with invalid mimetype]
					//info.error_list['size'] = [list of file names with invalid size]
					
					/**
					if( !info.dropped ) {
						//perhapse reset file field if files have been selected, and there are invalid files among them
						//when files are dropped, only valid files will be added to our file array
						e.preventDefault();//it will rest input
					}
					*/
					
					//if files have been selected (not dropped), you can choose to reset input
					//because browser keeps all selected files anyway and this cannot be changed
					//we can only reset file field to become empty again
					//on any case you still should check files with your server side script
					//because any arbitrary file can be uploaded by user and it's not safe to rely on browser-side measures
				});
				
				/**
				file_input
				.off('file.preview.ace')
				.on('file.preview.ace', function(e, info) {
					console.log(info.file.width);
					console.log(info.file.height);
					e.preventDefault();//to prevent preview
				});
				*/
			});
			
			$('#spinner1').ace_spinner({value:0,min:0,max:200,step:10, btn_up_class:'btn-info' , btn_down_class:'btn-info'})
			.closest('.ace-spinner')
			.on('changed.fu.spinbox', function(){
				//console.log($('#spinner1').val())
			}); 
			$('#spinner2').ace_spinner({value:0,min:0,max:10000,step:100, touch_spinner: true, icon_up:'ace-icon fa fa-caret-up bigger-110', icon_down:'ace-icon fa fa-caret-down bigger-110'});
			$('#spinner3').ace_spinner({value:0,min:-100,max:100,step:10, on_sides: true, icon_up:'ace-icon fa fa-plus bigger-110', icon_down:'ace-icon fa fa-minus bigger-110', btn_up_class:'btn-success' , btn_down_class:'btn-danger'});
			$('#spinner4').ace_spinner({value:0,min:-100,max:100,step:10, on_sides: true, icon_up:'ace-icon fa fa-plus', icon_down:'ace-icon fa fa-minus', btn_up_class:'btn-purple' , btn_down_class:'btn-purple'});
			
			//$('#spinner1').ace_spinner('disable').ace_spinner('value', 11);
			//or
			//$('#spinner1').closest('.ace-spinner').spinner('disable').spinner('enable').spinner('value', 11);//disable, enable or change value
			//$('#spinner1').closest('.ace-spinner').spinner('value', 0);//reset to 0
			
			//datepicker plugin
			//link
			$('.date-picker').datepicker({
				autoclose: true,
				todayHighlight: true
			})
			//show datepicker when clicking on the icon
			.next().on(ace.click_event, function(){
				$(this).prev().focus();
			});
			
			//or change it into a date range picker
			$('.input-daterange').datepicker({autoclose:true});
			
			//to translate the daterange picker, please copy the "examples/daterange-fr.js" contents here before initialization
			$('input[name=date-range-picker]').daterangepicker({
				'applyClass' : 'btn-sm btn-success',
				'cancelClass' : 'btn-sm btn-default',
				locale: {
					applyLabel: 'Apply',
					cancelLabel: 'Cancel',
				}
			})
			.prev().on(ace.click_event, function(){
				$(this).next().focus();
			});
			
			$('#timepicker1').timepicker({
				minuteStep: 1,
				showSeconds: true,
				showMeridian: false,
				disableFocus: true,
				icons: {
					up: 'fa fa-chevron-up',
					down: 'fa fa-chevron-down'
				}
			}).on('focus', function() {
				$('#timepicker1').timepicker('showWidget');
			}).next().on(ace.click_event, function(){
				$(this).prev().focus();
			});
			
			if(!ace.vars['old_ie']) $('#date-timepicker1').datetimepicker({
				//format: 'MM/DD/YYYY h:mm:ss A',//use this option to display seconds
				icons: {
					time: 'fa fa-clock-o',
					date: 'fa fa-calendar',
					up: 'fa fa-chevron-up',
					down: 'fa fa-chevron-down',
					previous: 'fa fa-chevron-left',
					next: 'fa fa-chevron-right',
					today: 'fa fa-arrows ',
					clear: 'fa fa-trash',
					close: 'fa fa-times'
				}
			}).next().on(ace.click_event, function(){
				$(this).prev().focus();
			});
			
			$('#colorpicker1').colorpicker();
			//$('.colorpicker').last().css('z-index', 2000);//if colorpicker is inside a modal, its z-index should be higher than modal'safe
			
			$('#simple-colorpicker-1').ace_colorpicker();
			//$('#simple-colorpicker-1').ace_colorpicker('pick', 2);//select 2nd color
			//$('#simple-colorpicker-1').ace_colorpicker('pick', '#fbe983');//select #fbe983 color
			//var picker = $('#simple-colorpicker-1').data('ace_colorpicker')
			//picker.pick('red', true);//insert the color if it doesn't exist
			
			$(".knob").knob();
			
			var tag_input = $('#form-field-tags');
			try{
				tag_input.tag(
				  {
					placeholder:tag_input.attr('placeholder'),
					//enable typeahead by specifying the source array
					source: ace.vars['US_STATES'],//defined in ace.js >> ace.enable_search_ahead
					/**
					//or fetch data from database, fetch those that match "query"
					source: function(query, process) {
					  $.ajax({url: 'remote_source.php?q='+encodeURIComponent(query)})
					  .done(function(result_items){
						process(result_items);
					  });
					}
					*/
				  }
				)
			
				//programmatically add/remove a tag
				var $tag_obj = $('#form-field-tags').data('tag');
				$tag_obj.add('Programmatically Added');
				
				var index = $tag_obj.inValues('some tag');
				$tag_obj.remove(index);
			} catch(e) {
				//display a textarea for old IE, because it doesn't support this plugin or another one I tried!
				tag_input.after('<textarea id="'+tag_input.attr('id')+'" name="'+tag_input.attr('name')+'" rows="3">'+tag_input.val()+'</textarea>').remove();
				//autosize($('#form-field-tags'));
			}
			
			/**
			$('#modal-form-detail input[type=file]').ace_file_input({
				style:'well',
				btn_choose:'Drop files here or click to choose',
				btn_change:null,
				no_icon:'ace-icon fa fa-cloud-upload',
				droppable:true,
				thumbnail:'large'
			})
			
			//chosen plugin inside a modal will have a zero width because the select element is originally hidden
			//and its width cannot be determined.
			//so we set the width after modal is show
			$('#modal-form-detail').on('shown.bs.modal', function () {
				if(!ace.vars['touch']) {
					$(this).find('.chosen-container').each(function(){
						$(this).find('a:first-child').css('width' , '210px');
						$(this).find('.chosen-drop').css('width' , '210px');
						$(this).find('.chosen-search input').css('width' , '200px');
					});
				}
			})
			*/
			
			//or you can activate the chosen plugin after modal is shown
			//this way select element becomes visible with dimensions and chosen works as expected
			$('#modal-form-detail').on('shown', function () {
				$(this).find('.modal-chosen').chosen();
			})
			
			$(document).one('ajaxloadstart.page', function(e) {
				autosize.destroy('textarea[class*=autosize]')
				
				$('.limiterBox,.autosizejs').remove();
				$('.daterangepicker.dropdown-menu,.colorpicker.dropdown-menu,.bootstrap-datetimepicker-widget.dropdown-menu').remove();
			});
			//-----------------------------------------------------------------------------------------------//
			//FORM ELEMENT 1
			//-----------------------------------------------------------------------------------------------//
			
			
			
			//-----------------------------------------------------------------------------------------------//
			//FORM ELEMENT 2
			//-----------------------------------------------------------------------------------------------//
			var demo1 = $('select[name="duallistbox_demo1[]"]').bootstrapDualListbox({infoTextFiltered: '<span class="label label-purple label-lg">Filtered</span>'});
			var container1 = demo1.bootstrapDualListbox('getContainer');
			container1.find('.btn').addClass('btn-white btn-info btn-bold');
			
			/**var setRatingColors = function() {
				$(this).find('.star-on-png,.star-half-png').addClass('orange2').removeClass('grey');
				$(this).find('.star-off-png').removeClass('orange2').addClass('grey');
			}*/
			$('.rating').raty({
				'cancel' : true,
				'half': true,
				'starType' : 'i'
				/**,
				
				'click': function() {
					setRatingColors.call(this);
				},
				'mouseover': function() {
					setRatingColors.call(this);
				},
				'mouseout': function() {
					setRatingColors.call(this);
				}*/
			})//.find('i:not(.star-raty)').addClass('grey');
			
			//select2
			$('.select2').css('width','200px').select2({allowClear:true})
			$('#select2-multiple-style .btn').on('click', function(e){
				var target = $(this).find('input[type=radio]');
				var which = parseInt(target.val());
				if(which == 2) $('.select2').addClass('tag-input-style');
				 else $('.select2').removeClass('tag-input-style');
			});
			
			$('.multiselect').multiselect({
			 enableFiltering: true,
			 enableHTML: true,
			 buttonClass: 'btn btn-white btn-primary',
			 templates: {
					button: '<button type="button" class="multiselect dropdown-toggle" data-toggle="dropdown"><span class="multiselect-selected-text"></span> &nbsp;<b class="fa fa-caret-down"></b></button>',
					ul: '<ul class="multiselect-container dropdown-menu"></ul>',
					filter: '<li class="multiselect-item filter"><div class="input-group"><span class="input-group-addon"><i class="fa fa-search"></i></span><input class="form-control multiselect-search" type="text"></div></li>',
					filterClearBtn: '<span class="input-group-btn"><button class="btn btn-default btn-white btn-grey multiselect-clear-filter" type="button"><i class="fa fa-times-circle red2"></i></button></span>',
					li: '<li><a tabindex="0"><label></label></a></li>',
					divider: '<li class="multiselect-item divider"></li>',
					liGroup: '<li class="multiselect-item multiselect-group"><label></label></li>'
				}
			});
			
			//typeahead.js
			//example taken from plugin's page at: https://twitter.github.io/typeahead.js/examples/
			var substringMatcher = function(strs) {
				return function findMatches(q, cb) {
					var matches, substringRegex;
				 
					// an array that will be populated with substring matches
					matches = [];
				 
					// regex used to determine if a string contains the substring `q`
					substrRegex = new RegExp(q, 'i');
				 
					// iterate through the pool of strings and for any string that
					// contains the substring `q`, add it to the `matches` array
					$.each(strs, function(i, str) {
						if (substrRegex.test(str)) {
							// the typeahead jQuery plugin expects suggestions to a
							// JavaScript object, refer to typeahead docs for more info
							matches.push({ value: str });
						}
					});
			
					cb(matches);
				}
			}
			
			$('input.typeahead').typeahead({
				hint: true,
				highlight: true,
				minLength: 1
			}, {
				name: 'states',
				displayKey: 'value',
				source: substringMatcher(ace.vars['US_STATES']),
				limit: 10
			});
			
			$(document).one('ajaxloadstart.page', function(e) {
				$('[class*=select2]').remove();
				$('select[name="duallistbox_demo1[]"]').bootstrapDualListbox('destroy');
				$('.rating').raty('destroy');
				$('.multiselect').multiselect('destroy');
			});
			//-----------------------------------------------------------------------------------------------//
			//FORM ELEMENT 2
			//-----------------------------------------------------------------------------------------------//
			
			
			
			//-----------------------------------------------------------------------------------------------//
			//FORM WIZARD
			//-----------------------------------------------------------------------------------------------//
			$('[data-rel=tooltip]').tooltip();
			
			$('.select2').css('width','200px').select2({allowClear:true})
			.on('change', function(){
				$(this).closest('form').validate().element($(this));
			});
			
			var $validation = false;
			$('#fuelux-wizard-container')
			.ace_wizard({
				//step: 2 //optional argument. wizard will jump to step "2" at first
				//buttons: '.wizard-actions:eq(0)'
			})
			.on('actionclicked.fu.wizard' , function(e, info){
				if(info.step == 1 && $validation) {
					if(!$('#validation-form').valid()) e.preventDefault();
				}
			})
			//.on('changed.fu.wizard', function() {
			//})
			.on('finished.fu.wizard', function(e) {
				bootbox.dialog({
					message: "Thank you! Your information was successfully saved!", 
					buttons: {
						"success" : {
							"label" : "OK",
							"className" : "btn-sm btn-primary"
						}
					}
				});
			}).on('stepclick.fu.wizard', function(e){
				//e.preventDefault();//this will prevent clicking and selecting steps
			});
			
			//jump to a step
			/**
			var wizard = $('#fuelux-wizard-container').data('fu.wizard')
			wizard.currentStep = 3;
			wizard.setState();
			*/
			
			//determine selected step
			//wizard.selectedItem().step
			
			//hide or show the other form which requires validation
			//this is for demo only, you usullay want just one form in your application
			$('#skip-validation').removeAttr('checked').on('click', function(){
				$validation = this.checked;
				if(this.checked) {
					$('#sample-form').hide();
					$('#validation-form').removeClass('hide');
				}
				else {
					$('#validation-form').addClass('hide');
					$('#sample-form').show();
				}
			})
			
			//documentation : http://docs.jquery.com/Plugins/Validation/validate
			
			$.mask.definitions['~']='[+-]';
			$('#phone').mask('(999) 999-9999');
			
			jQuery.validator.addMethod("phone", function (value, element) {
				return this.optional(element) || /^\(\d{3}\) \d{3}\-\d{4}( x\d{1,6})?$/.test(value);
			}, "Enter a valid phone number.");
			
			$('#validation-form').validate({
				errorElement: 'div',
				errorClass: 'help-block',
				focusInvalid: false,
				ignore: "",
				rules: {
					email: {
						required: true,
						email:true
					},
					password: {
						required: true,
						minlength: 5
					},
					password2: {
						required: true,
						minlength: 5,
						equalTo: "#password"
					},
					name: {
						required: true
					},
					phone: {
						required: true,
						phone: 'required'
					},
					url: {
						required: true,
						url: true
					},
					comment: {
						required: true
					},
					state: {
						required: true
					},
					platform: {
						required: true
					},
					subscription: {
						required: true
					},
					gender: {
						required: true,
					},
					agree: {
						required: true,
					}
				},
			
				messages: {
					email: {
						required: "Please provide a valid email.",
						email: "Please provide a valid email."
					},
					password: {
						required: "Please specify a password.",
						minlength: "Please specify a secure password."
					},
					state: "Please choose state",
					subscription: "Please choose at least one option",
					gender: "Please choose gender",
					agree: "Please accept our policy"
				},
			
			
				highlight: function (e) {
					$(e).closest('.form-group').removeClass('has-info').addClass('has-error');
				},
			
				success: function (e) {
					$(e).closest('.form-group').removeClass('has-error');//.addClass('has-info');
					$(e).remove();
				},
			
				errorPlacement: function (error, element) {
					if(element.is('input[type=checkbox]') || element.is('input[type=radio]')) {
						var controls = element.closest('div[class*="col-"]');
						if(controls.find(':checkbox,:radio').length > 1) controls.append(error);
						else error.insertAfter(element.nextAll('.lbl:eq(0)').eq(0));
					}
					else if(element.is('.select2')) {
						error.insertAfter(element.siblings('[class*="select2-container"]:eq(0)'));
					}
					else if(element.is('.chosen-select')) {
						error.insertAfter(element.siblings('[class*="chosen-container"]:eq(0)'));
					}
					else error.insertAfter(element.parent());
				},
			
				submitHandler: function (form) {
				},
				invalidHandler: function (form) {
				}
			});
			
			$('#modal-wizard-container').ace_wizard();
			$('#modal-wizard .wizard-actions .btn[data-dismiss=modal]').removeAttr('disabled');
			
			/**
			$('#date').datepicker({autoclose:true}).on('changeDate', function(ev) {
				$(this).closest('form').validate().element($(this));
			});
			
			$('#mychosen').chosen().on('change', function(ev) {
				$(this).closest('form').validate().element($(this));
			});
			*/
			
			$(document).one('ajaxloadstart.page', function(e) {
				//in ajax mode, remove remaining elements before leaving page
				$('[class*=select2]').remove();
			});
			//-----------------------------------------------------------------------------------------------//
			//FORM WIZARD
			//-----------------------------------------------------------------------------------------------//
		});
	</script>
	<!------------------------------------------------------------------------------------------------->
</body>
<!------------------------------------------------------------------------------------------------->
</html>
<!------------------------------------------------------------------------------------------------->