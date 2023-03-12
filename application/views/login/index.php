<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="" content="">
	<!-- App favicon -->
	<link rel="shortcut icon" href="<?= base_url() ?>assets/image/logo.png">
	<!-- App title -->
	<title>SAW Application</title>
	<!-- App css -->
	<link href="<?= base_url() ?>plugins/animate/animate.min.css" rel="stylesheet" type="text/css"/>
	<link href="<?= base_url() ?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
	<link href="<?= base_url() ?>assets/css/core.css" rel="stylesheet" type="text/css"/>
	<link href="<?= base_url() ?>assets/css/components.css" rel="stylesheet" type="text/css"/>
	<link href="<?= base_url() ?>assets/css/icons.css" rel="stylesheet" type="text/css"/>
	<link href="<?= base_url() ?>assets/css/pages.css" rel="stylesheet" type="text/css"/>
	<link href="<?= base_url() ?>assets/css/menu.css" rel="stylesheet" type="text/css"/>
	<link href="<?= base_url() ?>assets/css/responsive.css" rel="stylesheet" type="text/css"/>

	<!-- HTML5 Shiv and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
	<script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
	<![endif]-->

	<script src="assets/js/modernizr.min.js"></script>
	<script>
		(function (i, s, o, g, r, a, m) {
			i['GoogleAnalyticsObject'] = r;
			i[r] = i[r] || function () {
				(i[r].q = i[r].q || []).push(arguments)
			}, i[r].l = 1 * new Date();
			a = s.createElement(o),
					m = s.getElementsByTagName(o)[0];
			a.async = 1;
			a.src = g;
			m.parentNode.insertBefore(a, m)
		})(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');

		ga('create', 'UA-83057131-1', 'auto');
		ga('send', 'pageview');

	</script>
</head>


<body class="bg-images">
<!-- HOME -->
<section class="animated fadeIn">
	<div class="container-alt">
		<div class="row">
			<div class="col-sm-12">
				<div class="wrapper-page">
					<div class="m-t-40 account-pages">
						<div class="text-center account-logo-box">
							<h2 class="text-uppercase">
								<a href="index.html" class="text-success">
									<span><img src="<?= base_url() ?>assets/image/login.png" alt="" height="100"></span>
								</a>
							</h2>
							<h2 class="text-uppercase">
								Application
							</h2>
							<h3 class="text-uppercase">
								Simple Additive Weighting
							</h3>
							<!--<h4 class="text-uppercase font-bold m-b-0">Sign In</h4>-->
						</div>
						<div class="account-content">
							<form class="form-horizontal" method="post" action="<?php echo site_url(); ?>/login/in">
								<div class="form-group ">
									<div class="col-xs-12">
										<input class="form-control" type="text" required="" placeholder="Username"
											   name="email">
									</div>
								</div>

								<div class="form-group">
									<div class="col-xs-12">
										<input class="form-control" type="password" name="password" required=""
											   placeholder="Password">
										<?php
										if (isset($message)) {
											echo $message;
										}
										?>
									</div>
								</div>
								<div class="form-group account-btn text-center m-t-10">
									<div class="col-xs-12">
										<button class="btn w-md btn-bordered btn-teal waves-effect waves-light"
												type="submit">Log In
										</button>
									</div>
								</div>

							</form>
							<div class="clearfix"></div>
						</div>
					</div>
					<!-- end card-box-->
				</div>
				<!-- end wrapper -->
			</div>
		</div>
	</div>
</section>
<!-- END HOME -->

<script>
	var resizefunc = [];
</script>

<!-- jQuery  -->
<script src="<?= base_url() ?>assets/js/jquery.min.js"></script>
<script src="<?= base_url() ?>assets/js/bootstrap.min.js"></script>
<script src="<?= base_url() ?>assets/js/detect.js"></script>
<script src="<?= base_url() ?>assets/js/fastclick.js"></script>
<script src="<?= base_url() ?>assets/js/jquery.blockUI.js"></script>
<script src="<?= base_url() ?>assets/js/waves.js"></script>
<script src="<?= base_url() ?>assets/js/jquery.slimscroll.js"></script>
<script src="<?= base_url() ?>assets/js/jquery.scrollTo.min.js"></script>

<!-- App js -->
<script src="<?= base_url() ?>assets/js/jquery.core.js"></script>
<script src="<?= base_url() ?>assets/js/jquery.app.js"></script>

</body>
</html>
