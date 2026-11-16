<!DOCTYPE html>

<html>

<head>

	<meta charset="utf-8">

	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title></title>
    <link rel="icon" type="image/x-icon" href="<?= config_item('assets'); ?>img/favicon/favicon.ico" />

	<style type="text/css">
		.report th {

			padding-top: 5px;

			padding-bottom: 5px;

		}

		.report th,
		.report td {

			border: 1px solid black;

		}



		table {

			border-collapse: collapse;

		}



		body {

			font-family: sans-serif;

		}
	</style>

</head>

<body>

	<?php

	// var_dump($resultReport);

	?>



	<table width="100%" border="0" style="margin-bottom: 50px;">

		<tr>

			<th>LAPORAN PENDAPATAN</th>

		</tr>

		<tr>

			<th>Tanggal <?= $dateReport ?></th>

		</tr>

	</table>



	<table width="100%" class="report">

		<thead>

			<tr>

				<th>No</th>

				<th>NAMA</th>

				<th>STATUS</th>

				<th>JARAK</th>

				<th>ONGKIR</th>

				<th>TOTAL</th>

			</tr>

		</thead>

		<tbody style="text-align: center;">

			<?php

			$total = 0;

			foreach ($resultReport as $key => $value) {

				echo '<tr>';

				echo '<td>' . $value->nomor . '</td>';

				echo '<td style="text-align: left;">' . $value->receiver_name . ' ' . ($value->cancel_reason != "" ? "<i><sub>(" . urldecode(strtolower($value->cancel_reason)) . ")</i></sub>" : "") . '</td>';

				echo '<td>' . $value->status . '</td>';

				echo '<td>' . $value->distance . ' Km</td>';

				echo '<td>' . number_format($value->ongkir, 0, ",", ".") . '</td>';

				echo '<td>' . number_format($value->total, 0, ",", ".") . '</td>';

				echo '</tr>';

				$total = $total + $value->total;
			}

			?>

			<tr>

				<td style="text-align: right; padding-right: 10px;" colspan="5"><strong>Total</strong></td>

				<td><strong><?= number_format($total, 0, ",", ".") ?></strong></td>

			</tr>

		</tbody>

	</table>



</body>

</html>