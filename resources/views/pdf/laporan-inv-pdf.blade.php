<!DOCTYPE html>
<html lang="en">

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<title>Cetak Invoice</title>
		<style type="text/css">
			body {
				margin: 1cm;
			}

			h1 {
				color: black;
				font-family: "Times New Roman", serif;
				font-style: normal;
				font-weight: bold;
				text-decoration: none;
				font-size: 18pt;
			}

			h4 {
				color: black;
				font-family: "Times New Roman", serif;
				font-style: normal;
				font-weight: bold;
				text-decoration: none;
				font-size: 9pt;
			}

			.s1 {
				color: black;
				font-family: "Times New Roman", serif;
				font-style: normal;
				font-weight: bold;
				text-decoration: none;
				font-size: 8pt;
			}

			h3 {
				color: black;
				font-family: "Times New Roman", serif;
				font-style: normal;
				font-weight: bold;
				text-decoration: underline;
				font-size: 10pt;
			}

			p {
				color: black;
				font-family: "Times New Roman", serif;
				font-style: normal;
				font-weight: normal;
				text-decoration: none;
				font-size: 11pt;
				margin: 0pt;
			}

			h2 {
				color: black;
				font-family: "Times New Roman", serif;
				font-style: normal;
				font-weight: bold;
				text-decoration: underline;
				font-size: 14pt;
			}

			.s2 {
				color: black;
				font-family: "Times New Roman", serif;
				font-style: normal;
				font-weight: bold;
				text-decoration: none;
				font-size: 11pt;
			}

			.s3 {
				color: black;
				font-family: "Times New Roman", serif;
				font-style: normal;
				font-weight: normal;
				text-decoration: none;
				font-size: 11pt;
			}

			.s4 {
				color: black;
				font-family: "Times New Roman", serif;
				font-style: italic;
				font-weight: bold;
				text-decoration: none;
				font-size: 11pt;
			}

			.s5 {
				color: black;
				font-family: "Times New Roman", serif;
				font-style: normal;
				font-weight: normal;
				text-decoration: none;
				font-size: 10pt;
			}

			/* table {
				table-layout: fixed;
				width: 100%;
			} */
			td {
				word-wrap: break-word;
				word-break: break-word;
				white-space: normal;
			}

			table tbody tr:nth-child(9),
			table tbody tr:nth-child(24),
			table tbody tr:nth-child(39),
			table tbody tr:nth-child(54),
			table tbody tr:nth-child(69),
			table tbody tr:nth-child(84),
			table tbody tr:nth-child(99) {
				border-bottom: 1px solid black;
			}

			table tbody tr:nth-child(10),
			table tbody tr:nth-child(25),
			table tbody tr:nth-child(40),
			table tbody tr:nth-child(55),
			table tbody tr:nth-child(70),
			table tbody tr:nth-child(85),
			table tbody tr:nth-child(100) {
				border-top: 1px solid black;
			}
		</style>
	</head>

	<body style="position: relative;">
		<h1 style="text-align: center;">PT. KAISAR SINAR SAMUDERA</h1>
		<div style="line-height: 160%;text-align: center;margin-top: -18pt;">
			<h4>KO. PERMATA
				ARBERS BLOCK C NO.22 KELURAHAN PANGKALAN KERINCI TIMUR
				<br>
				KECAMATAN PANGKALAN KERINCI KABUPATEN PELALAWAN 28381
				<br>
				<span class="s1" style="padding-right: 0pt;text-indent: 0pt;text-align: center;"><a
						href="mailto:PT.KAISARSINARSAMUDERA@GMAIL.COM"
						style=" color: black; font-family:&quot;Times New Roman&quot;, serif; font-style: normal; font-weight: bold; text-decoration: none; font-size: 8pt;"
						target="_blank">EMAIL : </a>
					<span
						style="margin-right: 7pt; color: black; font-family:&quot;Times New Roman&quot;, serif; font-style: normal; font-weight: bold; text-decoration: underline; font-size: 8pt;">PT.KAISARSINARSAMUDERA@GMAIL.COM</span>
					NO TELEPHON : 082388396727</span>
			</h4>
		</div>
		<h3 style="margin-top: -4pt;text-align: center;">BADAN HUKUM NOMOR AHU-0042317.AH.01.01.TAHUN 2018 TANGGAL : 06
			SEPTEMBER 2018</h3>
		<p style="padding-top: 8pt;padding-left: 5pt;text-indent: 0pt;text-align: left;">Kepada Yth.</p>
		<p style="padding-top: 8pt;padding-left: 5pt;text-indent: 0pt;text-align: left; ">
			{{ strtoupper($data->nama_perusahaan) }}</p>
		<p style="padding-top: 8pt;padding-left: 5pt;text-indent: 0pt;line-height: 107%;text-align: left; margin-bottom: ">
			Alamat :
			{{ $data->alamat }}
		</p>
		<h2 style="padding-top: 8pt;text-align: center;"> INVOICE</h2>
		<p style="text-align: center;">{{ $data->nomor_invoice }}</p>
		<p style="text-indent: 0pt;text-align: left;"><br /></p>
		@php
			$poCounts = [];
			foreach ($manyData as $item) {
			    $poCounts[$item->nomor_po] = isset($poCounts[$item->nomor_po]) ? $poCounts[$item->nomor_po] + 1 : 1;
			}
		@endphp
		<table style="border-collapse: collapse;border-spacing: 0;width: 100%;" cellspacing="0">
			<tr>
				<td
					style="width:60pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
					<p class="s2" style="padding-left: 5pt;text-indent: 0pt;text-align: left;">Po Number</p>
				</td>
				<td
					style="width:145pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
					<p class="s2" style="padding-left: 5pt;text-indent: 0pt;text-align: left;">Description</p>
				</td>
				<td
					style="width:62pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
					<p class="s2" style="padding-left: 5pt;text-indent: 0pt;text-align: left;">Quantity</p>
				</td>
				<td
					style="width:91pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
					<p class="s2" style="padding-left: 5pt;text-indent: 0pt;text-align: left;">Harga</p>
				</td>
				<td
					style="width:81pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
					<p class="s2" style="padding-left: 5pt;text-indent: 0pt;text-align: left;">Grand Total</p>
				</td>
			</tr>
			<tbody>
				@foreach ($manyData as $index => $item)
					<tr>
						@if ($loop->index == 0 || $item->nomor_po != $manyData[$loop->index - 1]->nomor_po)
							<td
								style="height: 60px; width:60pt; border-left:solid 1pt; border-right:solid 1pt; border-top:solid 1pt; border-bottom:none;">
								<p class="s3" style="padding-left: 5pt; text-indent: 0pt; text-align: left;">
									{{ $item->nomor_po }}
								</p>
							</td>
						@elseif ($loop->last || $item->nomor_po != $manyData[$loop->index + 1]->nomor_po)
							<td
								style="height: 60px; width:60pt; border-left:solid 1pt; border-right:solid 1pt; border-top:none; border-bottom:solid 1pt;">
								<p class="s3" style="padding-left: 5pt; text-indent: 0pt; text-align: left;"></p>
							</td>
						@else
							<td
								style="height: 60px; width:60pt; border-left:solid 1pt; border-right:solid 1pt; border-top:none; border-bottom:none;">
								<p class="s3" style="padding-left: 5pt; text-indent: 0pt; text-align: left;"></p>
							</td>
						@endif
						<td style="width:145pt; border:solid 1pt;">
							<p class="s3" style="padding-left: 5pt; text-indent: 0pt; text-align: left;">
								{{ $item->nama_barang }}
							</p>
						</td>
						<td style="width:62pt; border:solid 1pt;">
							<p class="s3" style="padding-left: 5pt; text-indent: 0pt; text-align: left;">
								{{ $item->jumlah_barang }} {{ strtoupper($item->satuan) }}
							</p>
						</td>
						<td style="width:91pt;border:solid 1pt;">
							<p class="s3" style="padding-left: 5pt; text-indent: 0pt; text-align: left;">
								{{ 'Rp. ' . number_format($item->jumlah_barang * $item->harga_barang, 0, ',', '.') }},-
							</p>
						</td>
						@php
							$totalPerPo = $manyData
							    ->where('nomor_po', $item->nomor_po)
							    ->sum(fn($item) => $item->jumlah_barang * $item->harga_barang);
						@endphp
						@if ($loop->first || $item->nomor_po != $manyData[$loop->index - 1]->nomor_po)
							<td style="width:91pt;border-top:solid 1pt; border-right:solid 1pt;">
								<p class="s3" style="padding-left: 5pt; text-indent: 0pt; text-align: left;">
									{{ 'Rp. ' . number_format($totalPerPo, 0, ',', '.') }},-
								</p>
							</td>
						@else 
							<td style="width:91pt;border-right:solid 1pt;">
								<p class="s3" style="padding-left: 5pt; text-indent: 0pt; text-align: left;">
								</p>
							</td>
						@endif
					</tr>
				@endforeach
			</tbody>
			<tfoot>
				<tr>
					<td
						style="width:240pt;border-top:1pt solid; border-left:1pt solid; border-bottom:1pt solid; border-right:0pt solid; text-align: left; padding-left: 5pt;"
						colspan="3">
						<p class="s2" style="text-indent: 0pt;">Total Keseluruhan:</p>
					</td>
					<td
						style="width:240pt;border-top:1pt solid; border-bottom:1pt solid; border-right:1pt solid; text-align: right; padding-right: 5pt;"
						colspan="2">
						<p class="s2" style="text-indent: 0pt;">
							{{ 'Rp. ' . number_format($totalHargaBarang, 0, ',', '.') }},-
						</p>
					</td>
				</tr>
				<tr>
					<td
						style="width:68pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
						<p class="s4" style="padding-left: 5pt;text-indent: 0pt;text-align: left;">Terbilang</p>
					</td>
					<td
						style="width:412pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt"
						colspan="4">
						<p class="s4" style="padding-left: 5pt;text-indent: 0pt;text-align: left;">{{ $angkaTerbilang }}</p>
					</td>
				</tr>
			</tfoot>
		</table>
		<p style="padding-top: 9pt;"><br /></p>
		<div style="page-break-inside: avoid;">
			<div style="min-height: 74.2pt; width: 216.0pt; display: inline-block; border: 2.5pt solid #000000; padding: 10px;">
				<p class="s5"
					style="padding-top: 3pt; padding-left: 7pt; text-indent: 0pt; line-height: 106%; text-align: left;">
					Mohon untuk mengirimkan pembayaran melalui Bank :
				</p>
				<p class="s5"
					style="padding-top: 8pt; padding-left: 7pt; text-indent: 0pt; line-height: 106%; text-align: left;">
					BANK MANDIRI : 108-001704835-7 A/N : PT.KAISAR SINAR SAMUDERA
				</p>
			</div>
			<div style="margin-top: -100pt;">
				<p style="padding-left: 258pt; line-height: 170%; text-align: left;">
					Pangkalan Kerinci, {{ $currentDate }} <br> PT. KAISAR SINAR SAMUDERA
				</p>
				<p style="text-indent: 0pt; text-align: left; margin-top: 40pt"><br /></p>
				<p style="padding-left: 320pt; text-indent: -29pt; line-height: 170%; text-align: left;">
					<u>Raiza elena oktaviana</u> <br> Direktur
				</p>
			</div>
		</div>
	</body>

</html>
