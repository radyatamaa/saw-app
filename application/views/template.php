<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
	<meta name="author" content="Coderthemes">

	<!-- App favicon -->
	<link rel="shortcut icon" href="<?php echo base_url(); ?>assets/image/logo.png">
	<!-- App title -->
	<title>SAW Application</title>

	<?php $this->load->view('default_css/' . $this->css_default) ?>
</head>
<body class="fixed-left">
<!-- Begin page -->
<div id="wrapper">
	<!-- Top Bar Start -->
	<div class="topbar">
		<!-- LOGO -->
		<div class="topbar-left">
			<!-- <a href="index.html" class="logo"><span>Ko<span>Proll</span></span><i class="mdi mdi-layers"></i></a> -->
			<!-- Image logo -->
			<a href="<?php echo base_url(); ?>index.php/defaults" class="logo">
                        <span>
                            <img src="<?php echo base_url(); ?>assets/image/logo.png" alt="" height="50">
							SAW
							<span></span>
                        </span>
				<i>
					<img src="<?php echo base_url(); ?>assets/image/code.png" alt="" height="40">
				</i>
			</a>
		</div>
		<!-- Button mobile view to collapse sidebar menu -->
		<div class="navbar navbar-default" role="navigation">
			<div class="container">

				<!-- Navbar-left -->
				<ul class="nav navbar-nav navbar-left">
					<li>
						<button class="button-menu-mobile open-left waves-effect">
							<i class="mdi mdi-menu"></i>
						</button>
					</li>
				</ul>
				<!-- Right(Notification) -->
				<ul class="nav navbar-nav navbar-right">
					<li class="dropdown user-box">
						<a class="waves-effect user-link" aria-expanded="true">
							<h5>Hi, <?php echo empty($user_name) ? "" : $user_name; ?></h5>
						</a>
					</li>

				</ul>
				<!-- end navbar-right -->
			</div><!-- end container -->
		</div><!-- end navbar -->
	</div>
	<!-- Top Bar End -->

	<!-- ========== Left Sidebar Start ========== -->
	<div class="left side-menu">
		<div class="sidebar-inner slimscrollleft">

			<!--- Sidemenu -->
			<div id="sidebar-menu">
				<ul>
					<li class="menu-title">Menu</li>
					<li class="has_sub">
						<a href="<?php echo site_url('defaults') ?>" class="waves-effect"><i
									class="mdi mdi-chart-bar"></i><span> Dashboard </span> </a>
					</li>
					<li class="has_sub">
						<a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-library-books"></i>
							<span> Master Data </span>
							<span class="menu-arrow"></span></a>
						<ul class="list-unstyled">
							<li><a href="<?php echo site_url('user') ?>">Pengguna</a></li>
							<li><a href="<?php echo site_url('period') ?>">Periode</a></li>
							<li><a href="<?php echo site_url('criteria') ?>">Kriteria</a></li>
							<li><a href="<?php echo site_url('subcriteria') ?>">Nilai Crips</a></li>
							<li><a href="<?php echo site_url('alternative') ?>">Kandidat</a></li>
						</ul>
					</li>
					<li class="has_sub">
						<a href="<?php echo site_url('alternativevalue') ?>" class="waves-effect"><i
									class="mdi mdi-content-paste"></i><span>Nilai Kandidat</span> </a>
						<a href="<?php echo site_url('sawcalculation') ?>" class="waves-effect"><i
									class="mdi mdi-contrast"></i><span>Kalkulasi Perhitungan</span> </a>
					</li>
					<li class="has_sub">
						<a href="<?php echo site_url('login/out') ?>" class="waves-effect"><i class="mdi mdi-logout"></i><span> Logout </span>
						</a>
					</li>
				</ul>
			</div>
			<!-- Sidebar -->
			<div class="clearfix"></div>
		</div>
		<!-- Sidebar -left -->
	</div>
	<!-- Left Sidebar End -->

	<!-- ============================================================== -->
	<!-- Start right Content here -->
	<!-- ============================================================== -->
	<div class="content-page">
		<!-- Start content -->
		<?= $content ?>
		<footer class="footer text-right">
		</footer>
	</div>
	<!-- ============================================================== -->
	<!-- End Right content here -->
	<!-- ============================================================== -->
	<!-- Right Sidebar -->
	<!-- /Right-bar -->
</div>
<!-- END wrapper -->
<?php $this->load->view('default_js/' . $this->js_default) ?>
<!-- /#wrapper -->
</body>
</html>
