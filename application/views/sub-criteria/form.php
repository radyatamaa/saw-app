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
						<h4 class="page-title">Tambah Nilai Crips</h4>
					<?php } else { ?>
						<h4 class="page-title">Ubah Nilai Crips</h4>
					<?php } ?>
					<ol class="breadcrumb p-0 m-0">
						<li>
							<a href="#">Master Data</a>
						</li>
						<li>
							<a href="<?php echo site_url('/subcriteria'); ?>">Data Nilai Crips</a>
						</li>
						<li class="active">
							Tambah Nilai Crips
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
								<div class="form-group row">
									<label class="control-label col-md-2">Nama Kriteria
										<span class="text-danger">*</span></label>
									<div class="col-md-10">
										<?php echo form_dropdown('criteria_id', $criterias, empty($data['criteria_id']) ? "" : $data['criteria_id'], 'class="form-control" id="criteria"'); ?>
										<?php echo form_error('criteria_id', '<div class="error">', '</div>'); ?>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-2">Keterangan<span
												class="text-danger">*</span></label>
									<div class="col-md-10">
										<input type="text" name="name" class="form-control"
											   value="<?php echo empty($data['name']) ? "" : $data['name']; ?>">
										<?php echo form_error('name', '<div class="error">', '</div>'); ?>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-2">Nilai <span
												class="text-danger">*</span></label>
									<div class="col-md-10">
										<input type="text" name="point" class="form-control"
											   value="<?php echo empty($data['point']) ? "" : $data['point']; ?>"
											   onkeypress="return isNumber(event)">
										<?php echo form_error('point', '<div class="error">', '</div>'); ?>
									</div>
								</div>
								<div class="form-group text-right m-b-0">
									<div class="col-md-2">
										<input type="hidden" name="id"
											   value="<?php echo empty($data['id']) ? '' : $data['id']; ?>">
									</div>
									<div class="col-md-10">
										<a href="<?php echo site_url('/subcriteria'); ?>"
										   class="btn btn-danger">Back</a>
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
