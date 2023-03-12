<div class="content">
	<div class="container">
		<div class="row animated fadeIn">
			<div class="col-xs-12">
				<div class="page-title-box">
					<h4 class="page-title">Tambah Data Nilai Kandidat</h4>
					<ol class="breadcrumb p-0 m-0">
						<li>
							<a href="#">Master Data</a>
						</li>
						<li>
							<a href="<?php echo site_url('/alternativevalue'); ?>">Data Nilai Kandidat</a>
						</li>
						<li class="active">
							Tambah Data Nilai Kandidat
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
								<div class="row">
									<div class="col-md-12">
										<div class="form-group row">
											<label class="control-label col-md-2">Periode
												<span class="text-danger">*</span></label>
											<div class="col-md-10">
												<?php echo form_dropdown('period_id', $period, empty($data['period_id']) ? "" : $data['period_id'], 'class="form-control" id="period"'); ?>
												<?php echo form_error('period_id', '<div class="error">', '</div>'); ?>
											</div>
										</div>
										<div class="form-group row">
											<label class="control-label col-md-2">Nama Kandidat
												<span class="text-danger">*</span></label>
											<div class="col-md-10">
												<?php echo form_dropdown('alternative_id', $alternative, empty($data['alternative_id']) ? "" : $data['alternative_id'], 'class="form-control" id="alternative"'); ?>
												<?php echo form_error('alternative_id', '<div class="error">', '</div>'); ?>
											</div>
										</div>
										<div></div>
									</div>
								</div>
								</br>
								<div class="form-horizontal">
									<div class="form-group row">
										<label class="control-label col-md-2">Kriteria
											<span class="text-danger">*</span></label>
										<div class="col-md-10">
											<?php
											foreach ($criterias as $value) {
												?>
												<?php
												if (count($value['sub_criterias']) > 1) {
													?>
													<input type="hidden" name="criteria_ids[]" class="form-control"
														   value="<?php echo empty($data['id']) ? $value['id'] : $data['id']; ?>">
													<div class="form-group row">
														<label class="control-label col-md-4"><?php echo $value['name'] ?></label>
														<div class="col-md-4">
															<div class="input-group">
																<?php echo form_dropdown('sub_criteria_ids[]', $value['sub_criterias'], empty($data['sub_criteria_id']) ? "" : $data['sub_criteria_id'], 'class="form-control" id="sub_criteria" name="sub_criteria_ids[]"'); ?>
																<?php echo form_error('sub_criteria_id', '<div class="error">', '</div>'); ?>
															</div>
														</div>
													</div>
												<?php } ?>
												<?php
											}
											?>
											<div class="col-md-2"></div>
										</div>
									</div>
									<div class="form-group row text-right m-b-0">
										<input type="hidden" name="id"
											   value="<?php echo empty($data['id']) ? '' : $data['id']; ?>">
										<div class="col-md-12">
											<a href="<?php echo site_url('/alternativevalue'); ?>"
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
	$(document).ready(function () {

	});
</script>
