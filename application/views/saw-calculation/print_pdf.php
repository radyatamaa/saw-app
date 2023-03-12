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
	<title>Print Hasil Penilaian Kandidat</title>
</head>

<body>

<table border="0" cellpadding="1" cellspacing="1" style="width:500px">
	<tbody>
	<tr>
		<td rowspan="3"><img src="<?php echo base_url(); ?>assets/image/code.png" alt="" height="80"></td>
		<td>
			<table>
				<tr>
					<td><strong>PROGRAMMER FINTECH</strong></td>
				</tr>
				<tr>
					<td><strong>SIMPLE ADDITIVE WEIGHTING</strong></td>
				</tr>
			</table>
		</td>
	</tr>
	</tbody>
</table>

<h3 style="text-align:center"><strong>HASIL PENILAIAN PROGRAMMER FINTECH<br/>
		Periode : <?php echo empty($period->name) ? "" : $period->name; ?> <br/>
	</strong></h3>
<hr/>
<br>
<h3>Berikut ini hasil penilaian berdasarkan kriteria yang sudah dilakukan untuk
	periode <?php echo empty($period->name) ? "" : $period->name; ?> :</h3>
<table align="center" border="0" cellpadding="1" cellspacing="1" style="width:100%">
	<tbody>
	<tr>
		<td colspan="3"><span style="font-size:20px"><strong>List Kandidat :</strong></span></td>
	</tr>
	<?php
	$n = 0;
	foreach ($alternative_value_detail as $alternative) {
		$n++;
		?>

		<tr>
			<td style="text-align:center; width:3%"><span style="font-size:20px"><?php echo $n . '. '; ?></span></td>
			<td style="width:50%"><span style="font-size:20px"><?php echo $alternative['alternative_name']; ?></span>
			</td>
			<td style="width:50%"><span
						style="font-size:20px">Rank : <?php echo $alternative['rank']; ?></span></td>
		</tr>
	<?php } ?>
	</tbody>
</table>
<p>&nbsp;</p>

<table border="0" cellpadding="1" cellspacing="1" style="width:100%">
	<tbody>
	<tr>
		<td style="width:70%">&nbsp;</td>
		<td style="text-align:center"><strong>Hormat Kami,</strong></td>
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
		<td style="text-align:center"><strong>Backend Manager</strong>
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
