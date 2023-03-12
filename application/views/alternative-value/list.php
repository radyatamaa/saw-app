<div class="content">
	<div class="container">
		<div class="row animated fadeIn slower">
			<div class="col-xs-12">
				<div class="page-title-box">
					<h4 class="page-title">Data Nilai Kandidat </h4>
					<ol class="breadcrumb p-0 m-0">
						<li>
							<a href="#">Master Data</a>
						</li>
						<li class="active">
							Data Nilai Kandidat
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
						<label class="control-label col-md-3">Tanggal Dibuat</label>
						<input type="date" name="start_date" class="form-control" id="start_date_input"
							   value="<?= isset($_REQUEST["start_date"]) ? $_REQUEST["start_date"] : "" ?>"
							   placeholder="tanggal mulai">
					</div>
					<div class="form-group">
						<label class="control-label col-md-3">Sampai tanggal</label>
						<input type="date" name="end_date" class="form-control" id="end_date_input"
							   value="<?= isset($_REQUEST["end_date"]) ? $_REQUEST["end_date"] : "" ?>"
							   placeholder="tanggal selesai">
					</div>
					<div class="form-group">
						<label class="control-label col-md-3">Periode</label>
						<?php echo form_dropdown('period_id', $periods, empty($_REQUEST["period_id"]) ? "" : $_REQUEST["period_id"], 'class="form-control" id="period_id_input" style="width:200px;"'); ?>
					</div>
					<div class="form-group">
						<input type="text" name="alternative_name" class="form-control" id="alternative_name_input"
							   value="<?= isset($_REQUEST["alternative_name"]) ? $_REQUEST["alternative_name"] : "" ?>"
							   placeholder="nama kandidat">
					</div>
					<div class="form-group">
						<input type="text" name="alternative_email" class="form-control" id="alternative_email_input"
							   value="<?= isset($_REQUEST["alternative_email"]) ? $_REQUEST["alternative_email"] : "" ?>"
							   placeholder="email kandidat">
					</div>
					<div class="form-group">
						<input type="text" name="alternative_phone" class="form-control" id="alternative_phone_input"
							   value="<?= isset($_REQUEST["alternative_phone"]) ? $_REQUEST["alternative_phone"] : "" ?>"
							   placeholder="no hp kandidat">
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
				<a href="<?php echo site_url('alternativevalue/form'); ?>"
				   class="btn btn-block btn-sm btn-teal waves-effect waves-light">Tambah Nilai Kandidat</a>
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
							<th>Nama Kandidat</th>
							<th>Periode</th>
							<th>Tanggal Dibuat</th>
							<th>Tanggal Diupdate</th>
							<th>Nama Admin</th>
							<th>Aksi</th>
						</tr>
						</thead>
						<tbody>
						<?php
						$n = 0;
						foreach ($alternative_values->result_array() as $av) {
							$n++;
							?>
							<tr>
								<td><?php echo $n; ?></td>
								<td><?php echo $av['alternative_name']; ?></td>
								<td><?php echo $av['period_name']; ?></td>
								<td><?php echo $av['created_at']; ?></td>
								<td><?php echo $av['updated_at']; ?></td>
								<td><?php echo $av['user_name']; ?></td>
								<td>
									<button id="exampleModal" type="button"
											class="exampleModal btn btn-icon btn-xs waves-effect waves-light btn-primary m-b-5"
											data-toggle="modal"
											data-id="<?= $av['id'] ?>"
											data-target="#exampleModalLong">
										<i class="mdi mdi-magnify"></i>
									</button>
									<a href="<?php echo site_url('alternativevalue/print_alternative_value_with_detail/' . $av['id']); ?>"
									   target="_blank"
									   class="btn btn-icon btn-xs waves-effect waves-light btn-success m-b-5"><i
												class="mdi mdi-printer"></i></a>
									<a href="<?php echo site_url('alternativevalue/update/' . $av['id']); ?>"
									   class="btn btn-icon btn-xs waves-effect waves-light btn-success m-b-5"><i
												class="mdi mdi-pencil"></i></a>
									<a onclick="return confirm('Are you sure?')"
									   href="<?php echo site_url('alternativevalue/delete/' . $av['id']); ?>"
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

<div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog"
	 aria-labelledby="exampleModalLongTitle"
	 aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 class="modal-title text-teal" id="myLargeModalLabel">Detail Nilai Kandidat</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<h4 class="modal-title text-teal" id="myLargeModalLabel">Data Kandidat</h4>
						</div>
						<div class="form-group">
							<label for="field-3" class="control-label">Periode</label>
							<input type="text" readonly="" class="form-control" id="period_name" placeholder="">
						</div>
						<div class="form-group">
							<label for="field-3" class="control-label">Nama Kandidat</label>
							<input type="text" readonly="" class="form-control" id="alternative_name" placeholder="">
						</div>
						<div class="form-group">
							<label for="field-3" class="control-label">Perusahaan Sebelumnya</label>
							<input type="text" readonly="" class="form-control" id="alternative_previous_company"
								   placeholder="">
						</div>
						<div class="form-group">
							<label for="field-3" class="control-label">Jabatan Terakhir</label>
							<input type="text" readonly="" class="form-control" id="alternative_current_job_position"
								   placeholder="">
						</div>
						<div class="form-group">
							<label for="field-3" class="control-label">No HP</label>
							<input type="text" readonly="" class="form-control" id="alternative_phone_number"
								   placeholder="">
						</div>
						<div class="form-group">
							<label for="field-3" class="control-label">Email</label>
							<input type="text" readonly="" class="form-control" id="alternative_email" placeholder="">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<h4 class="modal-title text-teal" id="myLargeModalLabel">Data Kriteria</h4>
						</div>
						<div class="row" id="criteria_detail">
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
			document.getElementById('alternative_name_input').value = ''
			document.getElementById('alternative_email_input').value = ''
			document.getElementById('alternative_phone_input').value = ''
			document.getElementById("formFilter").submit();
			window.location.href = 'alternativevalue'
		});

		$('#filter').click(function () {
			var period_id = ''
			if ($("#period_id_input").val() > 0) {
				period_id = $("#period_id_input").val()
			}
			window.location.href = 'alternativevalue?start_date=' + $("#start_date_input").val() + '&end_date=' + $("#end_date_input").val() + '&alternative_name=' + $("#alternative_name_input").val() + '&alternative_email=' + $("#alternative_email_input").val() + '&alternative_phone=' + $("#alternative_phone_input").val() + '&period_id=' + period_id
		});

		$('.exampleModal').click(function () {
			var id = $(this).attr("data-id");
			$.ajax({
				type: 'get',
				url: '<?= site_url('alternativevalue/get_detail_json'); ?>',
				data: {id: id},
				dataType: 'json',
				success: function (data) {
					console.log(data);
					$("#period_name").val(data.alternative_value.period_name)
					$("#alternative_name").val(data.alternative_value.alternative_name)
					$("#alternative_previous_company").val(data.alternative_value.alternative_previous_company)
					$("#alternative_current_job_position").val(data.alternative_value.alternative_current_job_position)
					$("#alternative_phone_number").val(data.alternative_value.alternative_phone_number)
					$("#alternative_email").val(data.alternative_value.alternative_email)

					$('#criteria_detail').empty()
					for (const val in data.alternative_value_detail) {
						const criteria_detail_col_md_9 = $("<div>", {"class": "col-md-9"})
						const criteria_detail_form_group = $("<div>", {"class": "form-group"})
						const criteria_detail_label = $("<label>", {
							"class": "control-label",
							"for": "criteria_detail_name"
						})
						const criteria_detail_form_input = $("<input>", {
							"class": "form-control",
							"type": "text",
							"readonly": "",
							"id": "criteria_detail_with_sub_criteria",
							"value": data.alternative_value_detail[val].sub_criteria_name ? data.alternative_value_detail[val].sub_criteria_name : '-'
						})

						criteria_detail_label.html(data.alternative_value_detail[val].criteria_name ? data.alternative_value_detail[val].criteria_name + ' (' + data.alternative_value_detail[val].criteria_type_str + ')' : '-')
						criteria_detail_form_group.append(criteria_detail_label)
						criteria_detail_form_group.append(criteria_detail_form_input)
						criteria_detail_col_md_9.append(criteria_detail_form_group)
						$('#criteria_detail').append(criteria_detail_col_md_9);
					}
				}
			});
		})

	});
</script>


