<div id="top"></div>
<div class="content">
	<div class="container">
		<div class="row animated fadeIn slower">
			<div class="col-xs-12">
				<div class="page-title-box">
					<h4 class="page-title">Perhitungan Nilai Kandidat</h4>
					<ol class="breadcrumb p-0 m-0">
						<li>
							<a href="#">Master Data</a>
						</li>
						<li>
							<a href="<?php echo site_url('sawcalculation') ?>">Data Perhitungan Nilai Kandidat</a>
						</li>
						<li class="active">
							Perhitungan Nilai Kandidat
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
						<label class="control-label col-md-3">Periode</label>
						<?php echo form_dropdown('period_id', $periods, empty($_REQUEST["period_id"]) ? "" : $_REQUEST["period_id"], 'class="form-control" id="period_id_input" style="width:200px;"'); ?>
					</div>
					<div class="form-group">
						<div class="col-lg-12">
							<?php echo form_dropdown('order_column', $order_column, empty($_REQUEST["order_column"]) ? "" : $_REQUEST["order_column"], 'class="form-control" id="order_column" style="width:200px;"'); ?>
						</div>
					</div>
					<div class="form-group">
						<div class="col-lg-12">
							<?php echo form_dropdown('order_direction', $order_direction, empty($_REQUEST["order_direction"]) ? "" : $_REQUEST["order_direction"], 'class="form-control" id="order_direction" style="width:200px;"'); ?>
						</div>
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
			<?php if (!empty($_REQUEST["period_id"]) && count($alternative_values) > 0) { ?>
				<div class="col-xs-12">
					<a href="<?php echo site_url('sawcalculation/print_result_saw_calculation_with_detail/' . $_REQUEST["period_id"] . '/' . $_REQUEST["order_column"] . '/' . $_REQUEST["order_direction"]); ?>"
					   target="_blank" class="btn btn-block btn-sm btn-primary waves-effect waves-light"
					   id="print_all_pdf">Cetak</a>
					<br><br>
				</div>
			<?php } ?>
		</div>
		<!-- end row -->
		<?php if (!empty($_REQUEST["period_id"]) && count($alternative_values) > 0) { ?>
			<table border="1" class="table-calculate">
				<tr class="title-table-calculate">
					<td colspan="<?= count($criterias) + 1 ?>">Hasil Analisa</td>
				</tr>
				<tr class="header-table-calculate">
					<td>Kandidat</td>
					<?php
					foreach ($criterias as $criteria) {
						?>
						<td><?= $criteria["name"] ?></td>
						<?php
					}
					?>
				</tr>
				<?php
				foreach ($alternative_values as $idx => $alternative) {
					$color = "dark";
					if ($idx % 2 == 0) {
						$color = "light";
					}
					?>
					<tr class="detail-table-calculate <?= $color ?>">
						<td><?= $alternative["alternative_name"] ?></td>
						<?php
						foreach ($alternative["details"] as $sub_criteria) {
							?>
							<td><?= $sub_criteria["sub_criteria_name"] ?></td>
							<?php
						}
						?>
					</tr>
					<?php
				}
				?>
				<tr>
					<td colspan="<?= count($criterias) + 1 ?>"></td>
				</tr>
				<tr class="header-table-calculate">
					<td>Kandidat</td>
					<?php
					foreach ($criterias as $criteria) {
						?>
						<td><?= $criteria["name"] ?></td>
						<?php
					}
					?>
				</tr>
				<?php
				foreach ($alternative_values as $idx => $alternative) {
					$color = "dark";
					if ($idx % 2 == 0) {
						$color = "light";
					}
					?>
					<tr class="detail-table-calculate <?= $color ?>">
						<td><?= $alternative["alternative_name"] ?></td>
						<?php
						foreach ($alternative["details"] as $sub_criteria) {
							?>
							<td><?= $sub_criteria["point_sub_criteria"] ?></td>
							<?php
						}
						?>
					</tr>
					<?php
				}
				?>
			</table>
			<br>
			<!-- Normalisasi -->
			<table border="1" class="table-calculate">
				<tr class="title-table-calculate">
					<td colspan="<?= count($criterias) + 1 ?>">Normalisasi</td>
				</tr>
				<tr class="header-table-calculate">
					<td>Kandidat</td>
					<?php
					foreach ($criterias as $criteria) {
						?>
						<td><?= $criteria["name"] ?></td>
						<?php
					}
					?>
				</tr>
				<?php
				foreach ($alternative_values as $idx => $alternative) {
					$color = "dark";
					if ($idx % 2 == 0) {
						$color = "light";
					}
					?>
					<tr class="detail-table-calculate <?= $color ?>">
						<td><?= $alternative["alternative_name"] ?></td>
						<?php
						foreach ($alternative["details"] as $sub_criteria) {
							?>
							<td><?= $sub_criteria["value"] ?></td>
							<?php
						}
						?>
					</tr>
					<?php
				}
				?>
			</table>
			<br>
			<!-- Ranking -->
			<table border="1" class="table-calculate">
				<tr class="title-table-calculate">
					<td colspan="<?= count($criterias) + 3 ?>">Perangkingan</td>
				</tr>
				<tr class="header-table-calculate">
					<td>Kandidat</td>
					<?php
					foreach ($criterias as $criteria) {
						?>
						<td><?= $criteria["name"] ?></td>
						<?php
					}
					?>
					<td>Total</td>
					<td>Rank</td>
				</tr>
				<?php
				foreach ($alternative_values as $idx => $alternative) {
					$color = "dark";
					if ($idx % 2 == 0) {
						$color = "light";
					}
					?>
					<tr class="detail-table-calculate <?= $color ?>">
						<td><?= $alternative["alternative_name"] ?></td>
						<?php
						foreach ($alternative["details"] as $sub_criteria) {
							?>
							<td><?= $sub_criteria["weight_value"] ?></td>
							<?php
						}
						?>
						<td><?= $alternative["total"] ?></td>
						<td><?= $alternative["rank"] ?></td>
					</tr>
					<?php
				}
				?>
			</table>
			<br><br>
			<p align="right">(<a href="#top">Kembali keatas</a>)</p>
			<?php
		} else {
			$this->load->view("no_data.php");
		}
		?>
	</div>
</div>

<script src="<?php echo base_url('assets/js/jquery.js'); ?>" type="text/javascript"></script>
<script type="text/javascript">
	$(document).ready(function () {

		$('#clearButton').click(function () {
			document.getElementById("formFilter").submit();
			window.location.href = 'sawcalculation'
		});

		$('#filter').click(function () {
			var period_id = ''
			if ($("#period_id_input").val() > 0) {
				period_id = $("#period_id_input").val()
			}
			var order_column = ''
			if ($("#order_column").val() != 'empty') {
				order_column = $("#order_column").val()
			}
			var order_direction = ''
			if ($("#order_direction").val() != 'empty') {
				order_direction = $("#order_direction").val()
			}
			window.location.href = 'sawcalculation?period_id=' + period_id + '&order_column=' + order_column + '&order_direction=' + order_direction
		});
	});
</script>
