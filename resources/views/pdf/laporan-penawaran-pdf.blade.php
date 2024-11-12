<!DOCTYPE html>
<html lang="en">

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<title>Laporan Penawaran</title>
		<style>
			table {
				width: 100%;
				border-collapse: collapse;
			}

			table,
			th,
			td {
				border: 1px solid black;
				padding: 8px;
				text-align: left;
			}
		</style>
	</head>

	<body>
		<h3>Laporan Penawaran : {{ $dateFilter }}</h3>
		<table>
			<thead>
				<tr>
					<th>No</th>
					<th>Item</th>
					<th>Qty</th>
					<th>Belanja</th>
					<th>Ongkir</th>
					<th>Total</th>
					<th>Net</th>
					<th>Penawaran</th>
					<th>Untung</th>
					<th>Untung Belanja</th>
					<th>Ariba</th>
				</tr>
			</thead>
			<tbody>
				@if (empty($penawaran) || $penawaran->isEmpty())
					<tr>
						<td style="text-align: center;" colspan="11">Data tidak tersedia</td>
					</tr>
				@else
					@foreach ($penawaran as $item)
						<tr>
							<td>{{ $loop->iteration }}</td>
							<td>{{ $item->nama_item }}</td>
							<td>{{ $item->qty }}</td>
							<td>{{ number_format($item->belanja, 0, ',', '.') }}</td>
							<td>{{ number_format($item->ongkir, 0, ',', '.') }}</td>
							<td>{{ number_format($item->total, 0, ',', '.') }}</td>
							<td>{{ number_format($item->net, 0, ',', '.') }}</td>
							<td>{{ number_format($item->penawaran, 0, ',', '.') }}</td>
							<td>{{ number_format($item->untung, 0, ',', '.') }}</td>
							<td>{{ number_format($item->untung_belanja, 0, ',', '.') }}</td>
							<td>{{ number_format($item->ariba, 0, ',', '.') }}</td>
						</tr>
					@endforeach
				@endif
			</tbody>

		</table>
	</body>

</html>
