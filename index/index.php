<!DOCTYPE html>
<html lang="en">
<?php session_start();ob_start();?>
<?php if(!isset($_SESSION['username'])){header("location:login.php");}
else{
    include('lib/db_connect_dashboard.php');
    $cek_login = mysqli_query($db_dash,"select * from `user` where id_user = '".$_SESSION['id_user']."'");      
    $dcek_login = mysqli_fetch_array($cek_login);
    if($dcek_login['password']!=$_SESSION['password'])
    {
        header("location:login.php");
    }
    else if($_SESSION['kind_app']!="dashboardd"){
        header("location:login.php");
    }
}
include('lib/db_connect_task_management.php');
include('lib/db_connect_dashboard.php');
include('lib/db_connect.php');
include('lib/db_connect_ams.php');
include('lib/db_connect_co.php');
include('lib/db_postgre.php');
include('lib/db_connect_workbook.php');
include('lib/db_connect_deposales.php');
include('lib/db_connect_depo_admin.php');
include('lib/db_connect_depoworkbook.php');
include('lib/db_sqlserver.php');
include('lib/class_paging.php');
include('lib/fungsi_rupiah.php');




$chat = mysqli_query($db_dash,"select * from tbl_user_chat where id_user = '".$_SESSION['id_user']."'");		
$dchat = mysqli_fetch_array($chat);


?>
<?php if( $_SESSION['url_status']=="internal" || $_SESSION['url_status']=="eksternal,internal" || $_SESSION['url_status']=="internal,eksternal" || $_SESSION['url_status']=='null' || $_SESSION['url_status']==null){ ?>
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta charset="utf-8" />
		<link rel="icon" type="image/gif/png" href="images/padma_logo.gif">
		<title>Padmatirta | Dashboard</title>

		<meta name="description" content="overview &amp; stats" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

		<!-- bootstrap & fontawesome -->
		<link rel="stylesheet" href="assets/css/bootstrap.min.css" />
		<link rel="stylesheet" href="assets/font-awesome/4.5.0/css/font-awesome.min.css" />

		<!-- page specific plugin styles -->

		<!-- text fonts -->
		<link rel="stylesheet" href="assets/css/fonts.googleapis.com.css" />

		<!-- ace styles -->
		<link rel="stylesheet" href="assets/css/ace.min.css" class="ace-main-stylesheet" id="main-ace-style" />

		<!--[if lte IE 9]>
			<link rel="stylesheet" href="assets/css/ace-part2.min.css" class="ace-main-stylesheet" />
		<![endif]-->
		<link rel="stylesheet" href="assets/css/ace-skins.min.css" />
		<link rel="stylesheet" href="assets/css/ace-rtl.min.css" />
		<link rel="stylesheet" href="assets/css/jquery-ui.custom.min.css" />
		<link rel="stylesheet" href="assets/css/chosen.min.css" />
		<link rel="stylesheet" href="assets/css/bootstrap-datepicker3.min.css" />
		<link rel="stylesheet" href="assets/css/bootstrap-timepicker.min.css" />
		<link rel="stylesheet" href="assets/css/daterangepicker.min.css" />
		<link rel="stylesheet" href="assets/css/bootstrap-datetimepicker.min.css" />
		<link rel="stylesheet" href="assets/css/bootstrap-colorpicker.min.css" />
		<link rel="stylesheet" href="assets/css/jquery.gritter.min.css" />

		<!--[if lte IE 9]>
		  <link rel="stylesheet" href="assets/css/ace-ie.min.css" />
		<![endif]-->

		<!-- inline styles related to this page -->

		<!-- ace settings handler -->
		<script src="assets/js/ace-extra.min.js"></script>
		<!-- basic scripts -->

		<!--[if !IE]> -->
		<script src="assets/js/jquery-2.1.4.min.js"></script>

		<!-- <![endif]-->

		<!--[if IE]>
		<script src="assets/js/jquery-1.11.3.min.js"></script>
		<![endif]-->
		<script type="text/javascript">
			if('ontouchstart' in document.documentElement) document.write("<script src='assets/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
		</script>
		<script src="assets/js/bootstrap.min.js"></script>

		<!-- page specific plugin scripts -->

		<!--[if lte IE 8]>
		  <script src="assets/js/excanvas.min.js"></script>
		<![endif]-->
		
		<script src="assets/js/jquery-ui.custom.min.js"></script>
		<script src="assets/js/jquery.ui.touch-punch.min.js"></script>
		<script src="assets/js/jquery.easypiechart.min.js"></script>
		<script src="assets/js/jquery.sparkline.index.min.js"></script>
		<script src="assets/js/jquery.flot.min.js"></script>
		<script src="assets/js/jquery.flot.pie.min.js"></script>
		<script src="assets/js/jquery.flot.resize.min.js"></script>
		<script src="assets/js/chosen.jquery.min.js"></script>
		<script src="assets/js/spinbox.min.js"></script>
		<script src="assets/js/bootstrap-datepicker.min.js"></script>
		<script src="assets/js/bootstrap-timepicker.min.js"></script>
		<script src="assets/js/moment.min.js"></script>
		<script src="assets/js/daterangepicker.min.js"></script>
		<script src="assets/js/bootstrap-datetimepicker.min.js"></script>
		<script src="assets/js/bootstrap-colorpicker.min.js"></script>
		<script src="assets/js/jquery.knob.min.js"></script>
		<script src="assets/js/autosize.min.js"></script>
		<script src="assets/js/jquery.inputlimiter.min.js"></script>
		<script src="assets/js/jquery.maskedinput.min.js"></script>
		<script src="assets/js/bootstrap-tag.min.js"></script>
		<!-- page specific plugin scripts -->
		<script src="assets/js/jquery.dataTables.min.js"></script>
		<script src="assets/js/jquery.dataTables.bootstrap.min.js"></script>
		<script src="assets/js/dataTables.buttons.min.js"></script>
		<script src="assets/js/buttons.flash.min.js"></script>
		<script src="assets/js/buttons.html5.min.js"></script>
		<script src="assets/js/daterangepicker.min.js"></script>
		<script src="assets/js/buttons.print.min.js"></script>
		<script src="assets/js/buttons.colVis.min.js"></script>
		<script src="assets/js/dataTables.select.min.js"></script>
		<script src="assets/js/jquery.gritter.min.js"></script>
		<!-- ace scripts -->
		<script src="assets/js/ace-elements.min.js"></script>
		<script src="assets/js/ace.min.js"></script>

		<!-- inline scripts related to this page -->

		<!-- HTML5shiv and Respond.js for IE8 to support HTML5 elements and media queries -->

		<!--[if lte IE 8]>
		<script src="assets/js/html5shiv.min.js"></script>
		<script src="assets/js/respond.min.js"></script>
		<![endif]-->
		<!-- ==== NEW JS CHAT =============================================== -->
		<!--<script src="js/highchart/highcharts.js"></script>-->
		<script src="js/highchart/highstock.js"></script>
		<script src="js/highchart/data.js"></script>
		<script src="js/highchart/drilldown.js"></script>
		<script src="js/highchart/exporting.js"></script>
		<script src="js/highchart/highcharts-3d.js"></script>
		<script src="js/highchart/grouped-categories.js"></script>
		<script src="js/chart_lama/Chart.bundle.js"></script>

		<!-- ======== END ================================================== -->
		<!-- ======== Fancy box ================================================== -->
		<script type="text/javascript" src="js/source/jquery.fancybox.js?v=2.1.5"></script>
		<link rel="stylesheet" type="text/css" href="js/source/jquery.fancybox.css?v=2.1.5" media="screen" />

		<link rel="stylesheet" type="text/css" href="js/source/helpers/jquery.fancybox-buttons.css?v=1.0.5" />
		<script type="text/javascript" src="js/source/helpers/jquery.fancybox-buttons.js?v=1.0.5"></script>
		<link rel="stylesheet" type="text/css" href="js/source/helpers/jquery.fancybox-thumbs.css?v=1.0.7" />
		<script type="text/javascript" src="js/source/helpers/jquery.fancybox-thumbs.js?v=1.0.7"></script>

		<script type="text/javascript" src="js/source/helpers/jquery.fancybox-media.js?v=1.0.6"></script>
		<!-- ======== Fancy box ================================================== -->
		
		<!-- Combo Select-->
		<script src="js/bootstrap-select.js"></script>
		<link rel='stylesheet' href="styles/bootstrap-select.css" type='text/css' />

		<!-- DATA TABLE NEW -->
		
		
		<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.2.4/js/dataTables.buttons.min.js"></script>
		<script type="text/javascript" charset="utf8" src="//cdn.datatables.net/buttons/1.2.4/js/buttons.flash.min.js"></script>
		<script type="text/javascript" charset="utf8" src="//cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
		<script type="text/javascript" charset="utf8" src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.24/build/pdfmake.min.js"></script>
		<script type="text/javascript" charset="utf8" src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.24/build/vfs_fonts.js"></script>
		<script type="text/javascript" charset="utf8" src="//cdn.datatables.net/buttons/1.2.4/js/buttons.html5.min.js"></script>
		<script type="text/javascript" charset="utf8" src="//cdn.datatables.net/buttons/1.2.4/js/buttons.print.min.js "></script>
		
		<script type="text/javascript" charset="utf8" src="//cdn.datatables.net/plug-ins/1.10.13/sorting/numeric-comma.js "></script>	
		<script type="text/javascript" charset="utf8" src="//cdn.datatables.net/plug-ins/1.10.13/type-detection/numeric-comma.js "></script>	
		
		<!-- jquery sorttable -->
		
		<script src="js/sortable/jquery.tablesorter.js"></script>
		<link rel="stylesheet" href="js/sortable/themes/blue/style.css" />
		<!-- jquery flot thead -->
		<script src="js/jquery.floatThead.js"></script>
		
		<!-- Bootstrap combo -->
	<script type="text/javascript" src="js/combo_bootstrap/bootstrap-combobox.js"></script>
	<link rel="stylesheet" href="styles/combo_bootstrap/bootstrap-combobox.css">
	</head>

	<body class="no-skin">
		<div id="navbar" class="navbar navbar-default ace-save-state">
			<div class="navbar-container ace-save-state" id="navbar-container">
				<button type="button" class="navbar-toggle menu-toggler pull-left" id="menu-toggler" data-target="#sidebar">
					<span class="sr-only">Toggle sidebar</span>

					<span class="icon-bar"></span>

					<span class="icon-bar"></span>

					<span class="icon-bar"></span>
				</button>

				<div class="navbar-header pull-left">
					<a href="index.html" class="navbar-brand">
						<small>
							Dashboard Padmatirta Wisesa
						</small>
					</a>
				</div>

				<div class="navbar-buttons navbar-header pull-right" role="navigation">
					<ul class="nav ace-nav">
											
						<li class="light-blue dropdown-modal">
							<a data-toggle="dropdown" href="#" class="dropdown-toggle">
								<?php $lokasi_foto = "images/employee/".$_SESSION['user_foto'];
									if($_SESSION['user_foto']!='' or $_SESSION['user_foto']!=null){
								?>
					                <img class="nav-user-photo" src="images/employee/<?php echo $_SESSION['user_foto'];?>" class="img-circle m-b" width="50" alt="logo">
								<?php }else{?>
									<img class="nav-user-photo" src="images/unknown_photo.png" class="img-circle m-b" width="50" alt="logo" />
								<?php }?>
								<span class="user-info">
									<small>Welcome,</small>
									<?php echo $_SESSION['nama'];?>
								</span>

								<i class="ace-icon fa fa-caret-down"></i>
							</a>

							<ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
								<li>
									<a href="#">
										<i class="ace-icon fa fa-cog"></i>
										Settings
									</a>
								</li>

								<li>
									<a href="#" id="change_pass">
										<i class="ace-icon fa fa-user"></i>
										Change Password
									</a>
								</li>
								

								<li class="divider"></li>

								<li>
									<a href="proc/logoutsubmit.php">
										<i class="ace-icon fa fa-power-off"></i>
										Logout
									</a>
								</li>
							</ul>
						</li>
					</ul>
				</div>
			</div>
		</div>

		<div class="main-container ace-save-state" id="main-container">
			<script type="text/javascript">
				try{ace.settings.loadState('main-container')}catch(e){}
			</script>

			<div id="sidebar" class="sidebar responsive ace-save-state">
				<script type="text/javascript">
					try{ace.settings.loadState('sidebar')}catch(e){}
				</script>				

				<ul class="nav nav-list">
					 <?php include"menu_left.php";?>
				</ul><!-- /.nav-list -->
				<div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
					<i id="sidebar-toggle-icon" class="ace-icon fa fa-angle-double-left ace-save-state" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
				</div>
				
			</div>

			<div class="main-content">
				<?php include"inc/inc.content.php";?>	
			</div>

			<div class="footer">
				<div class="footer-inner">
					<div class="footer-content">
						 Created By IT Team 2016
						<span class="pull-right">
				            Padmatirta Wisesa
				        </span>
					</div>
				</div>
			</div>

			<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
				<i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
			</a>
			
		</div>
		
	</body>
<?php }else{?>
	PAGE NOT FOUND
<?php }?>
</html>

