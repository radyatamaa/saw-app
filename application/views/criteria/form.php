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
						<h4 class="page-title">Tambah Data Kriteria</h4>
					<?php } else { ?>
						<h4 class="page-title">Ubah Data Kriteria</h4>
					<?php } ?>
					<ol class="breadcrumb p-0 m-0">
						<li>
							<a href="#">Master Data</a>
						</li>
						<li>
							<a href="<?php echo site_url('/criteria'); ?>">Kriteria </a>
						</li>
						<li class="active">
							Tambah Data Kriteria
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
									<label class="control-label col-md-2">Bobot <span
												class="text-danger">*</span></label>
									<div class="col-md-10">
										<input type="text" name="weight" class="form-control"
											   value="<?php echo empty($data['weight']) ? "" : $data['weight']; ?>"
											   onkeypress="return isNumber(event)">
										<?php echo form_error('weight', '<div class="error">', '</div>'); ?>
									</div>
								</div>
								<label class="control-label col-md-2"></label>
								<div class="alert alert-info col-md-10" role="alert">
									<h4 class="alert-heading">💡 Apa itu Tipe Benefit & Cost?</h4>
									<p><b>Benefit merupakan kriteria yang menguntungkan bagi perhitungan, sedangkan cost sebaliknya.</b></p>
									<p>Contoh : dalam kasus menentukan mahasiswa yang layak mendapatkan beasiswa, IPK termasuk ke dalam kriteria benefit, karena semakin tinggi nilai IPK nya peluang untuk mendapatkan beasiswa akan semakin besar.
										<br>Sedangkan penghasilan orang tua termasuk ke dalam kriteria cost, karena semakin besar penghasilan orang tua peluang mendapatkan beasiswa semakin kecil.</p>
									<hr>
									<p class="mb-0">Sumber : <a href="https://bukuinformatika.com/metode-simple-additive-weighting-saw/#:~:text=Pada%20SAW%20kriteria%20ini%20digolongkan,mendapatkan%20beasiswa%20akan%20semakin%20besar." class="alert-link">bukuinformatika.com</a></p>
								</div>
								<div class="form-group">
									<label class="control-label col-md-2">Tipe <span
												class="text-danger">*</span></label>
									<div class="col-md-10">
										<?php echo form_dropdown('type', $type, empty($data['type']) ? "" : $data['type'], 'class="form-control"'); ?>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-2">Keterangan</label>
									<div class="col-md-10">
										<input type="text" name="description" class="form-control"
											   value="<?php echo empty($data['description']) ? "" : $data['description']; ?>">
										<?php echo form_error('description', '<div class="error">', '</div>'); ?>
									</div>
								</div>
								<div class="form-group text-right m-b-0">
									<div class="col-md-2">
										<input type="hidden" name="id"
											   value="<?php echo empty($data['id']) ? '' : $data['id']; ?>">
									</div>
									<div class="col-md-10">
										<a href="<?php echo site_url('/criteria'); ?>" class="btn btn-danger">Back</a>
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
