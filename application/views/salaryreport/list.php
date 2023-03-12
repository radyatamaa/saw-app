<div class="content">
	<div class="container">
		<div class="row animated fadeIn slower">
			<div class="col-xs-12">
				<div class="page-title-box">
					<h4 class="page-title">Data Transaksi </h4>
					<ol class="breadcrumb p-0 m-0">
						<li>
							<a href="#">Master Data</a>
						</li>
						<li class="active">
							Data Transaksi
						</li>
					</ol>
					<div class="clearfix"></div>
				</div>
			</div>
		</div>
		<div class="row animated fadeIn slower">
			<!-- show alert from controller -->
			<?php echo empty($user_save['alert']) ? "" : $user_save['alert']; ?>
			<div class="col-xs-12">
				<form method="post" class="form-inline" id="formFilter">
					<div class="form-group">
						<label class="control-label col-md-3">Tanggal Mulai</label>
						<input type="date" name="start_date" class="form-control" id="start_date_input"
							   value="<?= isset($_REQUEST["start_date"]) ? $_REQUEST["start_date"] : "" ?>"
							   placeholder="tanggal mulai">
					</div>
					<div class="form-group">
						<label class="control-label col-md-3">Tanggal Selesai</label>
						<input type="date" name="end_date" class="form-control" id="end_date_input"
							   value="<?= isset($_REQUEST["end_date"]) ? $_REQUEST["end_date"] : "" ?>"
							   placeholder="tanggal selesai">
					</div>
					<div class="form-group">
						<input type="text" name="employee_name" class="form-control" id="employee_name_input"
							   value="<?= isset($_REQUEST["employee_name"]) ? $_REQUEST["employee_name"] : "" ?>"
							   placeholder="nama karyawan">
					</div>
					<div class="form-group">
						<input type="button" id="filter" name="filter" class="btn btn-primary" value="Filter">
					</div>
					<div class="form-group">
						<button id="clearButton" type="button" class="btn btn-primary">
							Clear
						</button>
					</div>
				</form>
			</div>
			<br><br><br><br>
			<div class="col-xs-12">
				<!-- button cetak pdf -->
				<a href="<?php echo site_url('salaryreport/get_report_list' . '?start_date=' . "" . '&end_date=' . "" . '&employee_name=' . ""); ?>"
				   target="_blank" class="btn btn-block btn-sm btn-primary waves-effect waves-light" id="print_all_pdf">Cetak
					PDF</a>
				<!-- button add -->
				<?php
				if ($access == 3) { ?> <!-- 3: akses bendahara -->
					<a href="<?php echo site_url('salaryreport/form'); ?>"
					   class="btn btn-block btn-sm btn-teal waves-effect waves-light">Tambah Data Transaksi</a>
				<?php } ?>
				<br><br>
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
							<th>Nama Karyawan</th>
							<th>Status Karyawan</th>
							<th>Gaji Kotor</th>
							<th>Tanggal Dibuat</th>
							<th>Tanggal Diupdate</th>
							<th>Nama Admin</th>
							<th>Aksi</th>
						</tr>
						</thead>
						<tbody>
						<?php
						$n = 0;
						foreach ($salary_report->result_array() as $sr) {
							$n++;
							?>
							<tr>
								<td><?php echo $n; ?></td>
								<td><?php echo $sr['employee_name']; ?></td>
								<?php if ($sr['employee_status'] == 1) {
									$employee_status = 'Aktif';
								} else {
									$employee_status = 'Tidak Aktif';
								}
								?>
								<td><?php echo $employee_status; ?></td>
								<td><?php echo 'Rp. ' . number_format($sr['salary']) . ',-'; ?></td>
								<td><?php echo $sr['created_at']; ?></td>
								<td><?php echo $sr['updated_at']; ?></td>
								<td><?php echo $sr['user_name']; ?></td>
								<td>
									<button id="exampleModal" type="button"
											class="exampleModal btn btn-icon btn-xs waves-effect waves-light btn-primary m-b-5"
											data-toggle="modal"
											data-id="<?= $sr['id'] ?>" data-target="#exampleModalLong">
										<i class="mdi mdi-magnify"></i>
									</button>
									<a href="<?php echo site_url('salaryreport/get_detail_salary/' . $sr['id']); ?>"
									   target="_blank"
									   class="btn btn-icon btn-xs waves-effect waves-light btn-success m-b-5"><i
												class="mdi mdi-printer"></i></a>
									<?php
									if ($access == 3) { ?> <!-- 3: akses bendahara -->
										<a href="<?php echo site_url('salaryreport/update/' . $sr['id']); ?>"
										   class="btn btn-icon btn-xs waves-effect waves-light btn-success m-b-5"><i
													class="mdi mdi-pencil"></i></a>
										<a onclick="return confirm('Are you sure?')"
										   href="<?php echo site_url('salaryreport/delete/' . $sr['id']); ?>"
										   class="btn btn-icon btn-xs waves-effect waves-light btn-danger m-b-5"><i
													class="mdi mdi-delete"></i></a>
									<?php } ?>
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

<div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog"
	 aria-labelledby="exampleModalLongTitle"
	 aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<!--				<a href="-->
				<?php //echo site_url('salaryreport/get_detail_salary/' . $sr['id']); ?><!--"-->
				<!--				   target="_blank" class="btn btn-icon btn-xs waves-effect waves-light btn-success m-b-5"><i-->
				<!--							class="mdi mdi-printer"></i> Cetak</a>-->
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 class="modal-title text-teal" id="myLargeModalLabel">Detail Transaksi</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="field-3" class="control-label">Nama Karyawan</label>
							<input type="text" readonly="" class="form-control" id="employee_name" placeholder="">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="field-3" class="control-label">Status Karyawan</label>
							<input type="text" readonly="" class="form-control" id="employee_status" placeholder="">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="field-3" class="control-label">Gaji Kotor</label>
							<input type="text" readonly="" class="form-control" id="gross_salary"
								   placeholder="">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="field-3" class="control-label">Gaji Diterima</label>
							<input type="text" readonly="" class="form-control" id="net_salary"
								   placeholder="">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="field-3" class="control-label">Total Tambahan Gaji</label>
							<input type="text" readonly="" class="form-control" id="salary_type_increase_total"
								   placeholder="">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="field-3" class="control-label">Total Potongan Gaji</label>
							<input type="text" readonly="" class="form-control" id="salary_type_decrease_total"
								   placeholder="">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<h4 class="modal-title text-teal" id="myLargeModalLabel">Tambahan</h4>
						</div>
						<div class="row" id="salary_increase">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<h4 class="modal-title text-teal" id="myLargeModalLabel">Potongan</h4>
						</div>
						<div class="row" id="salary_decrease">
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>


<script src="<?php echo base_url('assets/js/jquery.js'); ?>" type="text/javascript"></script>
<script type="text/javascript">
	$(document).ready(function () {

		$('#clearButton').click(function () {
			document.getElementById('start_date_input').value = ''
			document.getElementById('end_date_input').value = ''
			document.getElementById('employee_name_input').value = ''
			document.getElementById("formFilter").submit();
			window.location.href = 'salaryreport'
		});

		$('#filter').click(function () {
			window.location.href = 'salaryreport?start_date=' + $("#start_date_input").val() + '&end_date=' + $("#end_date_input").val() + '&employee_name=' + $("#employee_name_input").val()
		});

		$('#print_all_pdf').click(function () {
			window.open('salaryreport/get_report_list?start_date=' + $("#start_date_input").val() + '&end_date=' + $("#end_date_input").val() + '&employee_name=' + $("#employee_name_input").val(), '_blank');
		});

		$('.exampleModal').click(function () {
			var id = $(this).attr("data-id");
			$.ajax({
				type: 'get',
				url: '<?= site_url('salaryreport/get_detail_json'); ?>',
				data: {id: id},
				dataType: 'json',
				success: function (data) {
					console.log(data);
					$("#employee_name").val(data.employee_name)
					$("#employee_status").val(data.employee_status == 1 ? 'Aktif' : 'Tidak Aktif')
					$("#gross_salary").val('Rp. ' + data.gross_salary + ',-')
					$("#net_salary").val('Rp. ' + data.net_salary + ',-')
					$("#salary_type_increase_total").val('Rp. ' + data.salary_type_increase_total + ',-')
					$("#salary_type_decrease_total").val('Rp. ' + data.salary_type_decrease_total + ',-')

					// looping salary increase detail
					$('#salary_increase').empty()
					for (const val in data.salary_type_increase) {
						const salary_increase_col_md_9 = $("<div>", {"class": "col-md-8"})
						const salary_increase_form_group = $("<div>", {"class": "form-group"})
						const salary_increase_label = $("<label>", {
							"class": "control-label",
							"for": "salary_increase_name"
						})
						const salary_increase_form_input = $("<input>", {
							"class": "form-control",
							"type": "text",
							"readonly": "",
							"id": "salary_increase_amount",
							"value": data.salary_type_increase[val].salary_type_amount ? data.salary_type_increase[val].salary_type_amount : '-'
						})

						salary_increase_label.html(data.salary_type_increase[val].name ? data.salary_type_increase[val].name : '-')
						salary_increase_form_group.append(salary_increase_label)
						salary_increase_form_group.append(salary_increase_form_input)
						salary_increase_col_md_9.append(salary_increase_form_group)
						$('#salary_increase').append(salary_increase_col_md_9);

						const installment_col_md_3 = $("<div>", {"class": "col-md-4"})
						const installment_form_group = $("<div>", {"class": "form-group"})
						const installment_label = $("<label>", {
							"class": "control-label",
							"for": "salary_increase_qty_name"
						})
						const installment_form_input = $("<input>", {
							"class": "form-control",
							"type": "text",
							"readonly": "",
							"id": "salary_increase_qty",
							"value": data.salary_type_increase[val].salary_type_installment ? data.salary_type_increase[val].salary_type_installment : '-'
						})

						installment_label.html("Pembayaran Ke :")
						installment_form_group.append(installment_label)
						installment_form_group.append(installment_form_input)
						installment_col_md_3.append(installment_form_group)
						$('#salary_increase').append(installment_col_md_3);
					}

					// looping salary decrease detail
					$('#salary_decrease').empty()
					for (const val in data.salary_type_decrease) {
						const salary_decrease_col_md_9 = $("<div>", {"class": "col-md-8"})
						const salary_decrease_form_group = $("<div>", {"class": "form-group"})
						const salary_decrease_label = $("<label>", {
							"class": "control-label",
							"for": "salary_decrease_name"
						})
						const salary_decrease_form_input = $("<input>", {
							"class": "form-control",
							"type": "text",
							"readonly": "",
							"id": "salary_decrease_amount",
							"value": data.salary_type_decrease[val].salary_type_amount ? data.salary_type_decrease[val].salary_type_amount : '-'
						})

						salary_decrease_label.html(data.salary_type_decrease[val].name ? data.salary_type_decrease[val].name : '-')
						salary_decrease_form_group.append(salary_decrease_label)
						salary_decrease_form_group.append(salary_decrease_form_input)
						salary_decrease_col_md_9.append(salary_decrease_form_group)
						$('#salary_decrease').append(salary_decrease_col_md_9);

						const installment_decrease_col_md_3 = $("<div>", {"class": "col-md-4"})
						const installment_decrease_form_group = $("<div>", {"class": "form-group"})
						const installment_decrease_label = $("<label>", {
							"class": "control-label",
							"for": "salary_decrease_qty_name"
						})
						const installment_decrease_form_input = $("<input>", {
							"class": "form-control",
							"type": "text",
							"readonly": "",
							"id": "salary_decrease_qty",
							"value": data.salary_type_decrease[val].salary_type_installment ? data.salary_type_decrease[val].salary_type_installment : '-'
						})

						installment_decrease_label.html("Pembayaran Ke :")
						installment_decrease_form_group.append(installment_decrease_label)
						installment_decrease_form_group.append(installment_decrease_form_input)
						installment_decrease_col_md_3.append(installment_decrease_form_group)
						$('#salary_decrease').append(installment_decrease_col_md_3);
					}
				}
			});
		})

	});
</script>


