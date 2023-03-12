<div class="content">
	<div class="container">
		<div class="row animated fadeIn">
			<div class="col-xs-12">
				<div class="page-title-box">
					<h4 class="page-title">Selamat datang, <?php echo empty($user_name) ? "" : $user_name; ?></h4>
					<ol class="breadcrumb p-0 m-0">
						<li>
							<a href="<?php echo site_url('defaults') ?>">Dashboard </a>
						</li>
					</ol>
					<div class="clearfix"></div>
				</div>
			</div>
		</div>
		<!-- end row -->
		<div class="row animated fadeInUp">
			<div class="col-md-12">
				<div class="card-box">
					<div class="table-responsive">
						<table class="dashboard-wrapper">
							<tr>
								<td>
									<table class="dashboard-box">
										<tr>
											<td rowspan="2" class="dashboard-box-icon"><img
														src="<?= base_url() ?>assets/image/candidate.png" width="30px"></td>
											<td class="dashboard-box-text">Total Kandidat</td>
										</tr>
										<tr>
											<td class="dashboard-box-value"><?php echo $count_alternatives; ?></td>
										</tr>
									</table>
								</td>
								<td>
									<table class="dashboard-box">
										<tr>
											<td rowspan="2" class="dashboard-box-icon"><img
														src="<?= base_url() ?>assets/image/period.png" width="50px">
											</td>
											<td class="dashboard-box-text">Total Periode</td>
										</tr>
										<tr>
											<td class="dashboard-box-value"><?php echo $count_periods; ?></td>
										</tr>
									</table>
								</td>
								<td>
									<table class="dashboard-box">
										<tr>
											<td rowspan="2" class="dashboard-box-icon"><img
														src="<?= base_url() ?>assets/image/nilai.png"
														width="50px"></td>
											<td class="dashboard-box-text">Total Nilai</td>
										</tr>
										<tr>
											<td class="dashboard-box-value"><?php echo $count_alternative_values; ?></td>
										</tr>
									</table>
								</td>
								<td>
									<table class="dashboard-box">
										<tr>
											<td rowspan="2" class="dashboard-box-icon"><img
														src="<?= base_url() ?>assets/image/criteria2.png" width="50px">
											</td>
											<td class="dashboard-box-text">Total Kriteria</td>
										</tr>
										<tr>
											<td class="dashboard-box-value"><?php echo $count_criterias; ?></td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</div> <!-- table-responsive -->
				</div> <!-- end card -->
				<div class="card-box">
					<h4 class="header-title m-t-0 m-b-30">About</h4>
					Website ini bertujuan untuk membantu memberikan rekomendasi dalam pengambilan keputusan penerimaan
					<b><i>Programmer </i></b>di setiap perusahaan Fintech
					<br>
					dengan menggunakan SPK (Sistem Pendukung Keputusan) dengan metode <b><i>SAW (Simple Additive
							Weighting)</i></b> serta
					<br>
					bahasa pemrograman <b><i>PHP</i></b> dengan <b><i>framework Code Igniter</i></b>, dan <b><i>database
							MySQL</i></b>.
					<br>
					<br><br>
					<footer><b>Copyright &copy; 2023 Moh. Radyatama Suryana</b></footer>
				</div>

			</div>
			<!-- end col -->
		</div>
		<!-- end row -->
	</div> <!-- container -->
</div> <!-- content -->
