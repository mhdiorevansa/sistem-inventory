<!DOCTYPE html>
<html lang="en">

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<title>Laporan Pembelian</title>
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
			td {
				word-wrap: break-word;
				word-break: break-word;
				white-space: normal;
			}
		</style>
	</head>

	<body style="margin: 1cm;">
		<h3>Laporan Pembelian : {{ $dateFilter }}</h3>
		<table style="border-collapse: collapse;">
			<thead>
				<tr>
					<th>No</th>
					<th>Item</th>
					<th>Qty</th>
					<th>Satuan</th>
					<th>Harga</th>
					<th>Total</th>
				</tr>
			</thead>
			<tbody>
				@if (empty($pembelian) || $pembelian->isEmpty())
					<tr>
						<td style="text-align: center" colspan="6">Data tidak tersedia</td>
					</tr>
				@else
					@foreach ($pembelian as $item)
						<tr>
							<td>{{ $loop->iteration }}</td>
							<td>{{ $item->nama_item }}</td>
							<td>{{ $item->qty }}</td>
                     <td>{{ $item->satuan }}</td>
							<td>{{ number_format($item->harga_item, 0, ',', '.') }}</td>
							<td>{{ number_format($item->total, 0, ',', '.') }}</td>
						</tr>
					@endforeach
				@endif
            <tr>
               <th colspan="6" style="border-top: 1px solid black;">Grand Total : Rp. {{ number_format($pembelian->sum('total'), 0, ',', '.') }}</th>
            </tr>
			</tbody>
		</table>
	</body>

</html>
