<head>
	<style>
		th, td {
			padding: 5px;
			font-family: Calibri, Candara, Segoe, Segoe UI, Optima, Arial, sans-serif;
		}

		th {
			text-align: center;
			font-weight: bold;
			color: black;
			font-family: Calibri, Candara, Segoe, Segoe UI, Optima, Arial, sans-serif;
		}

		.layout {
			padding: 15px;
		}

		body {
			font-family: Calibri, Candara, Segoe, Segoe UI, Optima, Arial, sans-serif;
		}

		h1, h2, h3, h4, h5, h6 {
			font-family: Calibri, Candara, Segoe, Segoe UI, Optima, Arial, sans-serif;
		}
	</style>
	<style type="text/css" media="print">
		@page {
			size: auto;   /* auto is the initial value */
			margin: 0;  /* this affects the margin in the printer settings */
		}
	</style>
	<link rel="shortcut icon" href="<?php echo base_url(); ?>assets/images/favicon.ico">
	<title>Print Laporan Gaji</title>
</head>

<div class="layout">
	<table border="0" cellpadding="1" cellspacing="1" style="width:500px">
		<tbody>
		<tr>
			<td align="center" style="width:15%">
				<img align="left" src="<?php echo base_url(); ?>assets/images/logo-kop.png" alt="" width="75%">
			</td>
			<td style="width:75%"><strong>KOPERASI KARYAWAN PELABUHAN <br>TANJUNGPANDAN</strong></td>
		</tr>
		<tr>
			<td><span style="font-size:10px">TANJUNGPANDAN</span></td>
		</tr>
		</tbody>
	</table>

	<h2 style="text-align:center">&nbsp;</h2>

	<h3 style="text-align:center">DAFTAR GAJI PEKERJA<br/>
		PENGAMANAN DAN ADMINISTRASI KANTOR PELABUHAN TANJUNG PANDAN<br/>
		<?php if ($start_date !== '' && $end_date !== '') { ?>
			<?php echo $start_date . ' sampai ' . $end_date; ?>
		<?php } ?>
	</h3>
	<p>&nbsp;
		<?php if ($employee_name_request !== '') { ?>
		<?php echo 'Nama Karyawan : ' . $employee_name_request; ?>
	</p>
	<p>&nbsp;
		<?php } else { ?>
		<?php } ?>
	</p>
	<table align="left" border="1" cellpadding="1" cellspacing="1" style="width:100%">
		<thead>
		<tr>
			<th style="text-align:center" rowspan="2" scope="col">No</th>
			<th style="text-align:center" rowspan="2" scope="col">Nama</th>
			<th style="text-align:center" rowspan="2" scope="col">Gaji Kotor</th>
			<th style="text-align:center" colspan="<?= count($all_increase_salary_type)*2; ?>" scope="col">Tambahan
				Penghasilan
			</th>
			<th style="text-align:center" rowspan="2" scope="col">Jumlah Tambahan</th>
			<th style="text-align:center" colspan="<?= count($all_decrease_salary_type)*2; ?>" scope="col">Potongan
				Penghasilan
			</th>
			<th style="text-align:center" rowspan="2" scope="col">Jumlah Potongan</th>
			<th style="text-align:center" rowspan="2" scope="col">Jumlah Yang Diterima</th>
		</tr>
		<tr>
			<?php
			foreach ($all_increase_salary_type as $type) {
				?>
				<th style="text-align:center" scope="col"><?= $type["name"]; ?></th>
				<th style="text-align:center" scope="col"></th>
				<?php
			}
			?>

			<?php
			foreach ($all_decrease_salary_type as $type) {
				?>
				<th style="text-align:center" scope="col"><?= $type["name"]; ?></th>
				<th style="text-align:center" scope="col"></th>
				<?php
			}
			?>
		</tr>
		</thead>
		<tbody>
		<?php
		$n = 0;
		$total_gross_salary = 0;
		$total_increase = 0;
		$total_decrease = 0;
		$total_net_salary = 0;
		$arr_total_detail_increase = [];
		foreach ($all_increase_salary_type as $i => $type) {
			$arr_total_detail_increase[$i] = 0;
		}
		$arr_total_detail_decrease = [];
		foreach ($all_decrease_salary_type as $i => $type) {
			$arr_total_detail_decrease[$i] = 0;
		}

		foreach ($salary_report_list as $rlm) {
			$n++;
			$total_gross_salary += $rlm['gross_salary'];
			$total_increase += $rlm['salary_type_increase_total'];
			$total_decrease += $rlm['salary_type_decrease_total'];
			$total_net_salary += $rlm['net_salary'];
			?>
			<tr>
				<td><?php echo $n; ?></td>
				<td><?php echo($rlm['employee_name']) ?></td>
				<td style="text-align:right"><?= number_format($rlm['gross_salary']) ?></td>
				<?php
				foreach ($rlm['salary_type_increase'] as $i => $inc) {
					$arr_total_detail_increase[$i] += $inc['salary_type_amount'];
					?>
					<td style="text-align:right"><?= ($inc['salary_type_amount'] != 0) ? number_format($inc['salary_type_amount']) : "-"; ?></td>
					<td style="text-align:right"><?= ($inc['salary_type_installment'] != 0) ? $inc['salary_type_installment'] : "-"; ?></td>
					<?php
				}
				?>
				<td style="text-align:right"><?= number_format($rlm['salary_type_increase_total']); ?></td>
				<?php
				foreach ($rlm['salary_type_decrease'] as $i => $dec) {
					$arr_total_detail_decrease[$i] += $dec['salary_type_amount'];
					?>
					<td style="text-align:right"><?= ($dec['salary_type_amount'] != 0) ? number_format($dec['salary_type_amount']) : "-"; ?></td>
					<td style="text-align:right"><?= ($dec['salary_type_installment'] != 0) ? $dec['salary_type_installment'] : "-"; ?></td>

					<?php
				}
				?>
				<td style="text-align:right"><?= number_format($rlm['salary_type_decrease_total']); ?></td>
				<td style="text-align:right"><?= number_format($rlm['net_salary']); ?></td>
			</tr>
		<?php } ?>
		<tr>
			<td colspan="2" rowspan="1" style="text-align:center"><strong>Jumlah</strong></td>
			<td style="text-align:right"><strong><?= number_format($total_gross_salary) ?></strong></td>
			<?php
			foreach ($arr_total_detail_increase as $val) {
				?>
				<td style="text-align:right"><strong><?= number_format($val); ?></strong></td>
				<td style="text-align:right"><strong></strong></td>
				<?php
			}
			?>
			<td style="text-align:right"><strong><?= number_format($total_increase) ?></strong></td>
			<?php
			foreach ($arr_total_detail_decrease as $val) {
				?>
				<td style="text-align:right"><strong><?= number_format($val); ?></strong></td>
				<td style="text-align:right"><strong></strong></td>
				<?php
			}
			?>
			<td style="text-align:right"><strong><?= number_format($total_decrease) ?></strong></td>
			<td style="text-align:right"><strong><?= number_format($total_net_salary) ?></strong></td>
		</tr>
		</tbody>
	</table>

	<p>&nbsp;</p>

	<p>&nbsp;</p>

	<table border="0" cellpadding="1" cellspacing="1" style="width:100%">
		<tbody>
		<tr>
			<td style="text-align:center; width:45%">KOPERASI KARYAWAN PELABUHAN</td>
			<td style="text-align:center; width:10%">&nbsp;</td>
			<td style="text-align:center; width:45%"><?php echo 'TANJUNGPANDAN, ' . $date_now; ?></td>
		</tr>
		<tr>
			<td style="text-align:center; width:45%">KETUA</td>
			<td style="text-align:center; width:10%">&nbsp;</td>
			<td style="text-align:center; width:45%">BENDAHARA</td>
		</tr>
		<tr>
			<td style="text-align:center; width:45%"></td>
			<td style="text-align:center; width:10%"></td>
			<td style="text-align:center; width:45%"></td>
		</tr>
		<tr>
			<td style="text-align:center; width:45%"></td>
			<td style="text-align:center; width:10%"></td>
			<td style="text-align:center; width:45%"></td>
		</tr>
		<tr>
			<td style="text-align:center; width:45%"></td>
			<td style="text-align:center; width:10%"></td>
			<td style="text-align:center; width:45%"></td>
		</tr>
		<tr>
			<td style="text-align:center; width:45%"></td>
			<td style="text-align:center; width:10%"></td>
			<td style="text-align:center; width:45%"></td>
		</tr>
		<tr>
			<td style="text-align:center; width:45%"></td>
			<td style="text-align:center; width:10%"></td>
			<td style="text-align:center; width:45%"></td>
		</tr>
		<tr>
			<td style="text-align:center; width:45%"></td>
			<td style="text-align:center; width:10%"></td>
			<td style="text-align:center; width:45%"></td>
		</tr>
		<tr>
			<td style="text-align:center; width:45%"><?php echo empty($employee_mapping->ketua) ? "" : $employee_mapping->ketua; ?></td>
			<td style="text-align:center; width:10%">&nbsp;</td>
			<td style="text-align:center; width:45%"><?php echo empty($employee_mapping->bendahara) ? "" : $employee_mapping->bendahara; ?></td>
		</tr>
		</tbody>
	</table>

</div>

<script type="text/javascript">
	window.onload = function() { window.print(); }
</script>
