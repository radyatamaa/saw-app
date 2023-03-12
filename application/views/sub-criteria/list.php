<div class="content">
	<div class="container">
		<div class="row animated fadeIn slower">
			<div class="col-xs-12">
				<div class="page-title-box">
					<h4 class="page-title">Data Nilai Crips</h4>
					<ol class="breadcrumb p-0 m-0">
						<li>
							<a href="#">Master Data</a>
						</li>
						<li class="active">
							Data Nilai Crips
						</li>
					</ol>
					<div class="clearfix"></div>
				</div>
			</div>
		</div>

		<div class="row animated fadeIn slower">
			<div class="col-xs-12">
				<form method="post" class="form-inline" id="formFilter">
					<div class="form-group col-md-2">
						<label class="control-label">Nama Kriteria</label><br>
						<?php echo form_dropdown('criteria_id', $criterias, empty($_REQUEST["criteria_id"]) ? "" : $_REQUEST["criteria_id"], 'class="form-control" id="criteria" style="width:245px;"'); ?>
					</div>
					<div class="form-group">
						<input type="button" id="filter" name="filter" class="btn btn-primary filter-button" value="Filter">
						
						<button id="clearButton" type="button" class="btn btn-danger clear-button">Clear</button>
					</div>
					<div class="form-group">
					</div>
				</form>
			</div>
			<br><br><br><br>
			<div class="col-xs-12">
				<form method="post" action="<?= site_url('subcriteria/import_excel'); ?>" class="form-inline" id="formFilter"
					  enctype="multipart/form-data">
					<div class="form-group">
						<label class="control-label col-md-3">Import Excel</label>
						<input type="file" accept=".xlsx, .xls" name="fileExcel" class="form-control"
							   id="file_excel_input">
					</div>
					<div class="form-group">
						<button id="importButton" type="submit" class="btn btn-primary import-button">
							Import
						</button>
					</div>
					<div class="form-group">
						<button type="button" class="btn btn-success download-template-button">
							<a href="<?= site_url('subcriteria/export_template_excel'); ?>">Download Template</a>
						</button>
					</div>
				</form>
			</div>
			<br><br><br><br>
			<div class="col-xs-12">
				<?php echo empty($sub_criteria_save['alert']) ? "" : $sub_criteria_save['alert']; ?>
				<button type="button" onclick="location.href='<?php echo site_url('subcriteria/form'); ?>';"
						class="btn btn-block btn-sm btn-teal waves-effect waves-light">Tambah Nilai Crips
				</button>
			</div>
			<br><br>
		</div>
		<!-- end row -->
		<?php
		if ($sub_criterias->num_rows() > 0) {
			?>
			<div class="row animated fadeInUp">
				<div class="col-sm-12">
					<div class="card-box table-responsive">
						<table id="datatable" class="table table-striped table-bordered">
							<thead>
							<tr>
								<th width="3%">No</th>
								<th>ID Crips</th>
								<th>ID Kriteria</th>
								<th>Nama Kriteria</th>
								<th>Keterangan</th>
								<th>Nilai</th>
								<th>Aksi</th>
							</tr>
							</thead>
							<tbody>
							<?php $n = 0;
							foreach ($sub_criterias->result_array() as $criteria) {
								$n++;
								?>
								<tr>
									<td><?php echo $n; ?></td>
									<td><?php echo $criteria['id']; ?></td>
									<td><?php echo $criteria['criteria_id']; ?></td>
									<td><?php echo $criteria['criteria_name']; ?></td>
									<td><?php echo $criteria['name']; ?></td>
									<td><?php echo $criteria['point']; ?></td>
									<td>
										<a href="<?php echo site_url('subcriteria/form/' . $criteria['id']); ?>"
										   class="btn btn-icon btn-xs waves-effect waves-light btn-success m-b-5"><i
													class="mdi mdi-pencil"></i></a>
										<a onclick="return confirm('Are you sure?')"
										   href="<?php echo site_url('subcriteria/delete/' . $criteria['id']); ?>"
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

			<?php
		} else {
			$this->load->view("no_data.php");
		}
		?>
	</div> <!-- container -->
</div> <!-- content -->

<script src="<?php echo base_url('assets/js/jquery.js'); ?>" type="text/javascript"></script>
<script type="text/javascript">
	$(document).ready(function () {
		$('#clearButton').click(function () {
			document.getElementById('criteria').value = ''
			document.getElementById("formFilter").submit();
			window.location.href = 'subcriteria'
		});

		$('#filter').click(function () {
			window.location.href = 'subcriteria?criteria_id=' + $("#criteria").val()
		});
	});
</script>
