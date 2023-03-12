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
						<h4 class="page-title">Tambah Data Kandidat</h4>
					<?php } else { ?>
						<h4 class="page-title">Ubah Data Kandidat</h4>
					<?php } ?>
					<ol class="breadcrumb p-0 m-0">
						<li>
							<a href="#">Master Data</a>
						</li>
						<li>
							<a href="<?php echo site_url('/alternative'); ?>">Kandidat</a>
						</li>
						<li class="active">
							Tambah Data Kandidat
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
									<label class="control-label col-md-2">Perusahaan Sebelumnya <span
												class="text-danger">*</span></label>
									<div class="col-md-10">
										<input type="text" name="previous_company" class="form-control"
											   value="<?php echo empty($data['previous_company']) ? "" : $data['previous_company']; ?>">
										<?php echo form_error('previous_company', '<div class="error">', '</div>'); ?>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-2">Jabatan Terakhir<span
												class="text-danger">*</span></label>
									<div class="col-md-10">
										<input type="text" name="current_job_position" class="form-control"
											   value="<?php echo empty($data['current_job_position']) ? "" : $data['current_job_position']; ?>">
										<?php echo form_error('current_job_position', '<div class="error">', '</div>'); ?>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-2">No HP<span
												class="text-danger">*</span></label>
									<div class="col-md-10">
										<input type="text" name="phone_number" class="form-control"
											   value="<?php echo empty($data['phone_number']) ? "" : $data['phone_number']; ?>"
											   onkeypress="return isNumber(event)">
										<?php echo form_error('phone_number', '<div class="error">', '</div>'); ?>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-2">Email<span
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
										<a href="<?php echo site_url('/alternative'); ?>"
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

<script src="<?php echo base_url('assets/js/jquery.js'); ?>" type="text/javascript"></script>
<script type="text/javascript">
	function isNumber(evt) {
		evt = (evt) ? evt : window.event;
		var charCode = (evt.which) ? evt.which : evt.keyCode;
		if ((charCode > 31 && charCode < 48) || charCode > 57) {
			return false;
		}
		return true;
	}
</script>
