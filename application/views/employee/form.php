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
						<h4 class="page-title">Tambah Data Karyawan</h4>
					<?php } else { ?>
						<h4 class="page-title">Ubah Data Karyawan</h4>
					<?php } ?>
					<ol class="breadcrumb p-0 m-0">
						<li>
							<a href="#">Master Data</a>
						</li>
						<li>
							<a href="<?php echo site_url('/employee'); ?>">Karyawan</a>
						</li>
						<li class="active">
							Tambah Data Karyawan
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
									<label class="control-label col-md-2">Gaji <span
												class="text-danger">*</span></label>
									<div class="col-md-10">
										<input type="text" name="salary" class="form-control"
											   value="<?php echo empty($data['salary']) ? "" : $data['salary']; ?>"
											   placeholder="Isi hanya dengan angka saja. Contoh: 5000000">
										<?php echo form_error('salary', '<div class="error">', '</div>'); ?>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-2">Umur </label>
									<div class="col-md-10">
										<input type="text" name="age" class="form-control"
											   value="<?php echo empty($data['age']) ? "" : $data['age']; ?>">
										<?php echo form_error('age', '<div class="error">', '</div>'); ?>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-2">Jabatan <span
												class="text-danger">*</span></label>
									<div class="col-md-10">
										<input type="text" name="position" class="form-control"
											   value="<?php echo empty($data['position']) ? "" : $data['position']; ?>">
										<?php echo form_error('position', '<div class="error">', '</div>'); ?>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-2">Alamat </label>
									<div class="col-md-10">
										<input type="text" name="domisili" class="form-control"
											   value="<?php echo empty($data['domisili']) ? "" : $data['domisili']; ?>">
										<?php echo form_error('domisili', '<div class="error">', '</div>'); ?>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-2">Status <span
												class="text-danger">*</span></label>
									<div class="col-md-10">
										<?php echo form_dropdown('status', $status, empty($data['status']) ? "" : $data['status'], 'class="form-control"'); ?>
										<?php echo form_error('status', '<div class="error">', '</div>'); ?>
									</div>
								</div>
								<div class="form-group text-right m-b-0">
									<div class="col-md-2">
										<input type="hidden" name="id"
											   value="<?php echo empty($data['id']) ? '' : $data['id']; ?>">
									</div>
									<div class="col-md-10">
										<a href="<?php echo site_url('/employee'); ?>"
										   class="btn btn-danger">Kembali</a>
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
