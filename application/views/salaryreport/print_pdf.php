<head>
	<style>
		th, td {
			padding: 1px;
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
	<title>Print Slip Gaji</title>
</head>

<body>

<table border="0" cellpadding="1" cellspacing="0" style="width:100%">
	<tbody>
	<tr align="left">
		<td align="center" style="width:15%">
			<img align="left" src="<?php echo base_url(); ?>assets/images/logo-kop.png" alt="" width="75%">
		</td>
		<td style="width:75%"><strong>KOPERASI KARYAWAN PELABUHAN <br>TANJUNGPANDAN</strong></td>
	</tr>
	</tbody>
</table>

<h4 style="text-align:center"><strong>SLIP GAJI<br/>
		Bulan : <?php echo $salary_report_detail['salary_report_month']; ?> <br/>
		Nama Pekerja : <?php echo $salary_report_detail['employee_name']; ?> <br/>
		Status Pekerja : <?php
		if ($salary_report_detail['employee_status'] == 1) {
			$employee_status = 'Aktif';
		} else {
			$employee_status = 'Tidak Aktif';
		}
		echo $employee_status;
		?>
	</strong></h4>

<table align="center" border="0" cellpadding="1" cellspacing="1" style="width:100%">
	<tbody>
	<tr>
		<td colspan="3"><span style="font-size:12px"><strong>Penghasilan :</strong></span></td>
	</tr>
	<tr>
		<td style="text-align:center; width:3%"><span style="font-size:12px">1</span></td>
		<td style="width:25%"><span style="font-size:12px">Gaji</span></td>
		<td style="text-align:right"><span
					style="font-size:12px">Rp. <?php echo number_format($salary_report_detail['gross_salary']); ?> ,-</span>
		</td>
	</tr>
	<?php
	$n = 1;
	foreach ($salary_report_detail['salary_type_increase'] as $sr) {
		$n++;
		?>

		<tr>
			<td style="text-align:center; width:3%"><span style="font-size:12px"><?php echo $n; ?></span></td>
			<td style="width:25%"><span style="font-size:12px"><?php echo $sr['name']; ?></span></td>
			<td style="text-align:right"><span
						style="font-size:12px">Rp. <?php echo number_format($sr['salary_type_amount']); ?> ,-</span>
			</td>
		</tr>
	<?php } ?>
	<tr>
		<td style="text-align:center">&nbsp;</td>
		<td style="width:25%">&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td style="text-align:center">&nbsp;</td>
		<td style="width:25%"><strong><span style="font-size:12px">Total Penghasilan Bruto</span></strong></td>
		<td style="text-align:right"><span
					style="font-size:12px"><strong>Rp. <?php echo number_format($salary_report_detail['gross_salary'] + $salary_report_detail['salary_type_increase_total']); ?> ,-</strong></span>
		</td>
	</tr>
	</tbody>
</table>

<hr/>

<table align="center" border="0" cellpadding="1" cellspacing="1" style="width:100%">
	<tbody>
	<tr>
		<td colspan="3"><span style="font-size:12px"><strong>Potongan :</strong></span></td>
	</tr>
	<?php
	$n = 0;
	foreach ($salary_report_detail['salary_type_decrease'] as $sr) {
		$n++;
		?>
		<tr>
			<td style="text-align:center; width:3%"><span style="font-size:12px"><?php echo $n; ?></span></td>
			<td style="width:25%"><span style="font-size:12px"><?php echo $sr['name']; ?></span></td>
			<td style="text-align:right"><span
						style="font-size:12px">Rp. <?php echo number_format($sr['salary_type_amount']); ?> ,-</span>
		</tr>
	<?php } ?>
	<tr>
		<td style="text-align:center">&nbsp;</td>
		<td style="width:25%">&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td style="text-align:center">&nbsp;</td>
		<td style="width:25%"><strong><span style="font-size:12px">Total Potongan</span></strong></td>
		<td style="text-align:right"><span
					style="font-size:12px"><strong>Rp. <?php echo number_format($salary_report_detail['salary_type_decrease_total']); ?> ,-</strong></span>
		</td>
	</tr>
	<tr>
		<td style="text-align:center">&nbsp;</td>
		<td style="width:25%"><strong><span style="font-size:12px">Penghasilan Bersih</span></strong></td>
		<td style="text-align:right"><span
					style="font-size:12px"><strong>Rp. <?php echo number_format($salary_report_detail['gross_salary'] + $salary_report_detail['salary_type_increase_total'] - $salary_report_detail['salary_type_decrease_total']); ?> ,-</strong></span>
		</td>
	</tr>
	</tbody>
</table>

<p>&nbsp;</p>

<table border="0" cellpadding="1" cellspacing="1" style="width:100%">
	<tbody>
	<tr>
		<td style="width:70%">&nbsp;</td>
		<td style="text-align:center"><strong>Tanjungpandan, <?php echo $salary_report_detail['date_now']; ?></strong>
		</td>
	</tr>
	<tr>
		<td style="width:70%">&nbsp;</td>
		<td style="text-align:center"><strong>Ketua</strong></td>
	</tr>
	<tr>
		<td style="width:70%">&nbsp;</td>
		<td style="text-align:center">&nbsp;</td>
	</tr>
	<tr>
		<td style="width:70%">&nbsp;</td>
		<td style="text-align:center">&nbsp;</td>
	</tr>
	<tr>
		<td style="width:70%">&nbsp;</td>
		<td style="text-align:center">&nbsp;</td>
	</tr>
	<tr>
		<td style="width:70%">&nbsp;</td>
		<td style="text-align:center"><strong><?php echo $salary_report_detail['employee_mapping']->ketua; ?></strong>
		</td>
	</tr>
	</tbody>
</table>

<p>&nbsp;</p>


</body>

<script type="text/javascript">
	window.onload = function () {
		window.print();
	}
</script>
