<div class="content">
	<div class="container">
		<div class="row animated fadeIn">
			<div class="col-xs-12">
				<div class="page-title-box">
					<?php
					$id = "";
					if (!empty($data)) {
						$id = $data['id'];
					}
					if ($id == "") {
						?>
						<h4 class="page-title">Tambah Data Pengguna</h4>
					<?php } else { ?>
						<h4 class="page-title">Ubah Data Pengguna</h4>
					<?php } ?>
					<ol class="breadcrumb p-0 m-0">
						<li>
							<a href="#">Master Data</a>
						</li>
						<li>
							<a href="<?php echo site_url('/user'); ?>">Pengguna </a>
						</li>
						<li class="active">
							Tambah Data Pengguna
						</li>
					</ol>
					<div class="clearfix"></div>
				</div>
			</div>
		</div>
		<!-- end row -->
		<div class="row animated fadeInUp">
			<div class="col-sm-12">
				<div class="card-box">
					<div class="row">
						<div class="col-md-12">
							<?php echo $alert; ?>
							<form method="post" class="form-horizontal">
								<div class="form-group">
									<label class="control-label col-md-2">Nama <span
												class="text-danger">*</span></label>
									<div class="col-md-10">
										<input type="text" name="name" class="form-control"
											   value="<?php echo empty($data['name']) ? "" : $data['name']; ?>">
										<?php echo form_error('name', '<div class="error">', '</div>'); ?>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-2">
										Password
										<?php
										$id = "";
										if (!empty($data)) {
											$id = $data['id'];
										}
										if ($id == "") {
											?>
											<span class="text-danger">*</span>
										<?php } ?>
									</label>
									<div class="col-md-10">
										<input type="password" name="password" class="form-control" value=""
												<?php
												$id = "";
												if (!empty($data)) {
													$id = $data['id'];
												}
												if ($id != "") {
												?>
											   placeholder="(Kosongkan password bila tidak ingin di ubah)
										<?php } ?>
										">
										<?php echo form_error('password', '<div class="error">', '</div>'); ?>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-2">Email <span
												class="text-danger">*</span></label>
									<div class="col-md-10">
										<input type="text" name="email" class="form-control"
											   value="<?php echo empty($data['email']) ? "" : $data['email']; ?>">
										<?php echo form_error('email', '<div class="error">', '</div>'); ?>
									</div>
								</div>
								<div class="form-group text-right m-b-0">
									<div class="col-md-2">
										<input type="hidden" name="id"
											   value="<?php echo empty($data['id']) ? '' : $data['id']; ?>">
									</div>
									<div class="col-md-10">
										<a href="<?php echo site_url('/user'); ?>" class="btn btn-danger">Back</a>
										<input type="submit" name="save" class="btn btn-success" value="Simpan">
									</div>
								</div>
							</form>
						</div>
					</div>
					<!-- end row -->
				</div>
			</div>
		</div>
		<!-- end row -->
	</div> <!-- container -->
</div>
