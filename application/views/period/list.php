<div class="content">
	<div class="container">
		<div class="row animated fadeIn slower">
			<div class="col-xs-12">
				<div class="page-title-box">
					<h4 class="page-title">Data Periode </h4>
					<ol class="breadcrumb p-0 m-0">
						<li>
							<a href="#">Master Data</a>
						</li>
						<li class="active">
							Data Periode
						</li>
					</ol>
					<div class="clearfix"></div>
				</div>
			</div>
		</div>
		<div class="row animated fadeIn slower">
			<div class="col-xs-12">
				<form method="post" action="<?= site_url('period/import_excel'); ?>" class="form-inline" id="formFilter" enctype="multipart/form-data">
					<div class="form-group">
						<label class="control-label col-md-3">Import Excel</label>
						<input type="file" accept=".xlsx, .xls" name="fileExcel" class="form-control" id="file_excel_input">
					</div>
					<div class="form-group">
						<button id="importButton" type="submit" class="btn btn-primary import-button">
							Import
						</button>
					</div>
					<div class="form-group">
						<button type="button" class="btn btn-success download-template-button">
							<a href="<?= site_url('period/export_template_excel'); ?>">Download Template</a>
						</button>
					</div>
				</form>
			</div>
			<br><br><br><br>
			<div class="col-xs-12">
				<?php echo empty($user_save['alert']) ? "" : $user_save['alert']; ?>
				<a href="<?php echo site_url('period/form'); ?>"
				   class="btn btn-block btn-sm btn-teal waves-effect waves-light">Tambah Data Periode</a>
			</div>
		</div>
		<!-- end row -->
		<?php
		if ($periods->num_rows() > 0) {
			?>
			<div class="row animated fadeInUp">
				<div class="col-sm-12">
					<div class="card-box table-responsive">
						<table id="datatable" class="table table-striped table-bordered table-responsive">
							<thead>
							<tr>
								<th width="3%">No</th>
								<th>ID Periode</th>
								<th>Nama Periode</th>
								<th>Action</th>
							</tr>
							</thead>
							<tbody>
							<?php $n = 0;
							foreach ($periods->result_array() as $period) {
								$n++; ?>
								<tr>
									<td><?php echo $n; ?></td>
									<td><?php echo $period['id']; ?></td>
									<td><?php echo $period['name']; ?></td>
									<td>
										<a href="<?php echo site_url('period/form/' . $period['id']); ?>"
										   class="btn btn-icon btn-xs waves-effect waves-light btn-success m-b-5"><i
													class="mdi mdi-pencil"></i></a>
										<a onclick="return confirm('Are you sure?')"
										   href="<?php echo site_url('period/delete/' . $period['id']); ?>"
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
			<?php
		} else {
			$this->load->view("no_data.php");
		}
		?>
	</div> <!-- container -->
</div>
