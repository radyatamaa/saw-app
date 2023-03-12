<div class="content">
	<div class="container">
		<div class="row animated fadeIn slower">
			<div class="col-xs-12">
				<div class="page-title-box">
					<h4 class="page-title">Data Pengguna </h4>
					<ol class="breadcrumb p-0 m-0">
						<li>
							<a href="#">Master Data</a>
						</li>
						<li class="active">
							Data Pengguna
						</li>
					</ol>
					<div class="clearfix"></div>
				</div>
			</div>
		</div>

		<div class="row animated fadeIn slower">
			<div class="col-xs-12">
				<?php echo empty($user_save['alert']) ? "" : $user_save['alert']; ?>
				<button type="button" onclick="location.href='<?php echo site_url('user/form'); ?>';"
						class="btn btn-block btn-sm btn-teal waves-effect waves-light">Tambah Data Pengguna
				</button>
			</div>
		</div>
		<!-- end row -->
		<?php
		if ($users->num_rows() > 0) {
			?>
			<div class="row animated fadeInUp">
				<div class="col-sm-12">
					<div class="card-box table-responsive">
						<table id="datatable" class="table table-striped table-bordered">
							<thead>
							<tr>
								<th width="3%">No</th>
								<th>Nama</th>
								<th>Email</th>
								<th>Tanggal Dibuat</th>
								<th>Tanggal Diupdate</th>
								<th>Aksi</th>
							</tr>
							</thead>
							<tbody>
							<?php $n = 0;
							foreach ($users->result_array() as $user) {
								$n++;
								?>
								<tr>
									<td><?php echo $n; ?></td>
									<td><?php echo $user['name']; ?></td>
									<td><?php echo $user['email']; ?></td>
									<td><?php echo $user['created_at']; ?></td>
									<td><?php echo $user['updated_at']; ?></td>
									<td>
										<a href="<?php echo site_url('user/form/' . $user['id']); ?>"
										   class="btn btn-icon btn-xs waves-effect waves-light btn-success m-b-5"><i
													class="mdi mdi-pencil"></i></a>
										<a onclick="return confirm('Are you sure?')"
										   href="<?php echo site_url('user/delete/' . $user['id']); ?>"
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
			<?php
		} else {
			$this->load->view("no_data.php");
		}
		?>
	</div> <!-- container -->
</div> <!-- content -->
