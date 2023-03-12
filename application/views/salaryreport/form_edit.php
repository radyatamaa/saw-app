<div class="content">
	<div class="container">
		<div class="row animated fadeIn">
			<div class="col-xs-12">
				<div class="page-title-box">
					<h4 class="page-title">Ubah Data Transaksi</h4>
					<ol class="breadcrumb p-0 m-0">
						<li>
							<a href="#">Master Data</a>
						</li>
						<li>
							<a href="<?php echo site_url('/salaryreport'); ?>">Transaksi </a>
						</li>
						<li class="active">
							Ubah Data Transaksi
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
											<label class="control-label col-md-2">Nama Karyawan
												<span class="text-danger">*</span></label>
											<div class="col-md-10">
												<?php echo form_dropdown('employee_id', $employee, empty($data['employee_id']) ? "" : $data['employee_id'], 'class="form-control"'); ?>
												<?php echo form_error('employee_id', '<div class="error">', '</div>'); ?>
											</div>
										</div>
										<div class="form-group row">
											<label class="control-label col-md-2">Gaji <span
														class="text-danger">*</span></label>
											<div class="col-md-10">
												<input type="text" name="salary" class="form-control"
													   value="<?php echo empty($data['salary']) ? "" : $data['salary']; ?>"
													   placeholder="Isi dgn angka saja. Contoh: 5000000">
												<?php echo form_error('salary', '<div class="error">', '</div>'); ?>
											</div>
										</div>
									</div>
								</div>
								</br>
								<div class="row">
									<div class="col-md-2"></div>
									<div class="col-md-10">
										<h5>Tambahan</h5>
										<?php
										foreach ($salary_type_increase as $sti) {
											?>
											<input type="hidden" name="salary_report_detail_id[]" class="form-control"
												   value="<?php echo empty($sti['salary_report_detail_id']) ? '' : ($sti['salary_report_detail_id']); ?>">
											<input type="hidden" name="salary_type_id[]" class="form-control"
												   value="<?php echo empty($sti['id']) ? '' : $sti['id']; ?>">
											<div class="form-group row">
												<label class="control-label col-md-4"><?php echo $sti['name'] ?></label>
												<div class="col-md-4">
													<div class="input-group">
														<span class="input-group-addon">RP: </span>
														<input type="text" name="salary_type_amount[]"
															   class="form-control"
															   value="<?php echo empty($sti['salary_type_amount']) ? "" : $sti['salary_type_amount']; ?>"
															   placeholder="Isi dgn angka saja. Contoh: 5000000">
													</div>
													<?php echo form_error('salary_type_amount', '<div class="error">', '</div>'); ?>
												</div>
												<div class="col-md-4">
													<div class="input-group">
														<span class="input-group-addon">Pembayaran Ke :</span>
														<input type="text" name="salary_type_installment[]"
															   class="form-control"
															   value="<?php echo empty($sti['salary_type_installment']) ? "" : $sti['salary_type_installment']; ?>">
													</div>

													<?php echo form_error('salary_type_installment', '<div class="error">', '</div>'); ?>
												</div>
											</div>
											<?php
										}
										?>
									</div>
									<div class="col-md-2"></div>
									<div class="col-md-10">
										<h5>Pengurangan</h5>
										<?php
										foreach ($salary_type_decrease as $std) {
											?>
											<input type="hidden" name="salary_report_detail_id[]" class="form-control"
												   value="<?php echo empty($std['salary_report_detail_id']) ? '' : $std['salary_report_detail_id']; ?>">
											<input type="hidden" name="salary_type_id[]" class="form-control"
												   value="<?php echo empty($std['id']) ? '' : $std['id']; ?>">
											<div class="form-group row">
												<label class="control-label col-md-4"><?php echo $std['name'] ?></label>
												<div class="col-md-4">
													<div class="input-group">
														<span class="input-group-addon">RP: </span>
														<input type="text" name="salary_type_amount[]"
															   class="form-control"
															   value="<?php echo empty($std['salary_type_amount']) ? "" : $std['salary_type_amount']; ?>"
															   placeholder="Isi dgn angka saja. Contoh: 5000000">
													</div>
													<?php echo form_error('salary_type_amount', '<div class="error">', '</div>'); ?>
												</div>
												<div class="col-md-4">
													<div class="input-group">
														<span class="input-group-addon">Pembayaran Ke :</span>
														<input type="text" name="salary_type_installment[]"
															   class="form-control"
															   value="<?php echo empty($std['salary_type_installment']) ? "" : $std['salary_type_installment']; ?>">
													</div>

													<?php echo form_error('salary_type_installment', '<div class="error">', '</div>'); ?>
												</div>
											</div>
											<?php
										}
										?>
									</div>
								</div>
								<div class="form-group row text-right">
									<input type="hidden" name="id"
										   value="<?php echo empty($data['id']) ? '' : $data['id']; ?>">
									<div class="col-md-12">
										<a href="<?php echo site_url('/salaryreport'); ?>" class="btn btn-danger">Kembali</a>
										<input type="submit" name="update" class="btn btn-success" value="Simpan">
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
