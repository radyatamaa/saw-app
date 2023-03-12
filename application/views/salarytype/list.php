<div class="content">
	<div class="container">
		<div class="row animated fadeIn slower">
			<div class="col-xs-12">
				<div class="page-title-box">
					<h4 class="page-title">Data Potongan/Tambahan </h4>
					<ol class="breadcrumb p-0 m-0">
						<li>
							<a href="#">Master Data</a>
						</li>
						<li class="active">
							Potongan/Tambahan
						</li>
					</ol>
					<div class="clearfix"></div>
				</div>
			</div>
		</div>

		<div class="row animated fadeIn slower">
			<div class="col-xs-12">
				<?php echo empty($user_save['alert']) ? "" : $user_save['alert']; ?>
				<a href="<?php echo site_url('salarytype/form'); ?>"
				   class="btn btn-block btn-sm btn-teal waves-effect waves-light">Tambah Data Potongan/Tambahan</a>
			</div>
		</div>
		<!-- end row -->

		<div class="row animated fadeInUp">
			<div class="col-sm-12">
				<div class="card-box table-responsive">
					<table id="datatable" class="table table-striped table-bordered">
						<thead>
						<tr>
							<th width="3%">No</th>
							<th>Nama</th>
							<th>Status</th>
							<th>Tipe</th>
							<th width="5%">Action</th>
						</tr>
						</thead>
						<tbody>
						<?php
						$n = 0;
						foreach ($salary_types->result_array() as $salary_type) {
							$n++;
							?>
							<tr>
								<td><?php echo $n; ?></td>
								<td><?php echo $salary_type['name']; ?></td>
								<?php if ($salary_type['status'] == 1) {
									$status = 'Aktif';
								} else {
									$status = 'Tidak Aktif';
								}
								?>
								<td><?php echo $status; ?></td>
								<?php if ($salary_type['type'] == 1) {
									$type = 'Penambahan';
								} else {
									$type = 'Pengurangan';
								}
								?>
								<td><?php echo $type; ?></td>
								<td>
									<a href="<?php echo site_url('salarytype/form/' . $salary_type['id']); ?>"
									   class="btn btn-icon btn-xs waves-effect waves-light btn-success m-b-5"><i
												class="mdi mdi-pencil"></i></a>
									<a onclick="return confirm('Are you sure?')"
									   href="<?php echo site_url('salarytype/delete/' . $salary_type['id']); ?>"
									   class="btn btn-icon btn-xs waves-effect waves-light btn-danger m-b-5"><i
												class="mdi mdi-delete"></i></a>
								</td>
							</tr>
						<?php } ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<!-- end row -->
	</div> <!-- container -->
</div>
