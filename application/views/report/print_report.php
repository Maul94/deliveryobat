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

			<th>Tanggal <?= html_escape($dateReport) ?></th>

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

				$reasonText = ($value->cancel_reason !== null && $value->cancel_reason !== '')
					? html_escape(strtolower(rawurldecode($value->cancel_reason)))
					: '';

				echo '<tr>';

				echo '<td>' . (int) $value->nomor . '</td>';

				echo '<td style="text-align: left;">' . html_escape($value->receiver_name) . ' ' . ($reasonText !== '' ? "<i><sub>(" . $reasonText . ")</i></sub>" : "") . '</td>';

				echo '<td>' . html_escape($value->status) . '</td>';

				echo '<td>' . html_escape($value->distance) . ' Km</td>';

				echo '<td>' . number_format((float) $value->ongkir, 0, ",", ".") . '</td>';

				echo '<td>' . number_format((float) $value->total, 0, ",", ".") . '</td>';

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