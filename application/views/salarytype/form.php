<div class="content">
	<div class="container">
		<div class="row animated fadeIn">
			<div class="col-xs-12">
				<div class="page-title-box">
					<h4 class="page-title">Tambah Data Potongan/Tambahan</h4>
					<ol class="breadcrumb p-0 m-0">
						<li>
							<a href="#">Master Data</a>
						</li>
						<li>
							<a href="<?php echo site_url('/salarytype'); ?>">Potongan/Tambahan</a>
						</li>
						<li class="active">
							Tambah Data Potongan/Tambahan
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
									<label class="control-label col-md-2">Nama <span class="required">*</span></label>
									<div class="col-md-10">
										<input type="text" name="name" class="form-control"
											   value="<?php echo empty($data['name']) ? "" : $data['name']; ?>">
										<?php echo form_error('name', '<div class="error">', '</div>'); ?>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-2">Status <span class="required">*</span></label>
									<div class="col-md-10">
										<?php echo form_dropdown('status', $status, empty($data['status']) ? "" : $data['status'], 'class="form-control"'); ?>
										<?php echo form_error('status', '<div class="error">', '</div>'); ?>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-2">Tipe Gaji <span
												class="required">*</span></label>
									<div class="col-md-10">
										<?php echo form_dropdown('type', $type, empty($data['type']) ? "" : $data['type'], 'class="form-control"'); ?>
										<?php echo form_error('type', '<div class="error">', '</div>'); ?>
									</div>
								</div>
								<div class="form-group text-right m-b-0">
									<div class="col-md-2">
										<input type="hidden" name="id"
											   value="<?php echo empty($data['id']) ? '' : $data['id']; ?>">
									</div>
									<div class="col-md-10">
										<a href="<?php echo site_url('/salarytype'); ?>"
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
