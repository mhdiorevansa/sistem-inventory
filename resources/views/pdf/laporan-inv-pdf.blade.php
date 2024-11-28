<!DOCTYPE html>
<html lang="en">

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<title>Cetak Invoice</title>
		<style type="text/css">
			.page-red-border {
				border: 5px solid red;
				padding: 10px;
			}

			.page-black-border {
				border: 5px solid black;
				padding: 10px;
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

			table {
				table-layout: fixed;
				width: 100%;
			}

			td {
				word-wrap: break-word;
				word-break: break-word;
				white-space: normal;
				page-break-inside: avoid;
			}

			th {
				page-break-inside: avoid;
			}
		</style>
	</head>

	<body style="margin: 0.3in;">
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
		<p style="padding-top: 8pt;padding-left: 5pt;text-indent: 0pt;line-height: 107%;text-align: left;">Alamat :
			{{ ucwords(strtolower($data->alamat)) }}
		</p>
		<h2 style="padding-top: 8pt;text-align: center;"> INVOICE</h2>
		<p style="text-align: center;">{{ $data->nomor_invoice }}</p>
		<p style="text-indent: 0pt;text-align: left;"><br /></p>
		<table style="border-collapse: collapse;" cellspacing="0">
			<tr style="height:22pt">
				<td
					style="width:68pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
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
				@foreach ($manyData as $item)
					<tr style="height:27pt;page-break-inside: avoid;">
						<td
							style="width:68pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
							<p class="s3" style="padding-left: 5pt;text-indent: 0pt;text-align: left;">{{ $item->nomor_po }}</p>
						</td>
						<td
							style="width:145pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
							<p class="s3" style="padding-left: 5pt;text-indent: 0pt;text-align: left;">{{ $item->nama_barang }}</p>
						</td>
						<td
							style="width:62pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
							<p class="s3" style="padding-left: 5pt;text-indent: 0pt;text-align: left;">{{ $item->jumlah_barang }}
								{{ strtoupper($item->satuan) }}</p>
						</td>
						<td
							style="width:91pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:none;border-bottom-width:0pt;border-right-style:solid;border-right-width:1pt">
							<p class="s3" style="padding-left: 5pt;text-indent: 0pt;text-align: left;">
								{{ 'Rp. ' . number_format($item->harga_barang, 0, ',', '.') }}</p>
						</td>
						@if ($loop->first)
							<td
								style="width:91pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:none;border-bottom-width:0pt;border-right-style:solid;border-right-width:1pt;">
								<p class="s3" style="padding-left: 5pt;text-indent: 0pt;text-align: left;">
									{{ 'Rp. ' . number_format($totalHargaBarang, 0, ',', '.') }}
								</p>
							</td>
						@else
							<td
								style="width:91pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt;">
							</td>
						@endif

					</tr>
				@endforeach
			</tbody>
			<tfoot>
				<tr style="height:22pt;">
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
				<tr style="height:22pt">
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
		<p style="padding-top: 9pt;text-indent: 0pt;text-align: left;"><br /></p>
		<div style="border:2.5pt solid #000000;min-height:74.2pt;width:216.0pt;">
			<p class="s5" style="padding-top: 3pt;padding-left: 7pt;text-indent: 0pt;line-height: 106%;text-align: left;">
				Mohon untuk mengirimkan pembayaran melalui Bank :</p>
			<p class="s5" style="padding-top: 8pt;padding-left: 7pt;text-indent: 0pt;line-height: 106%;text-align: left;">
				BANK
				MANDIRI : 108-001704835-7 A/N : PT.KAISAR SINAR SAMUDERA</p>
		</div>
		<div style="margin-top: -100pt">
			<p style="padding-left: 258pt;line-height: 170%;text-align: left;">Pangkalan Kerinci, {{ $currentDate }} <br> PT.
				KAISAR SINAR SAMUDERA</p>
		</div>
		<p style="text-indent: 0pt;text-align: left; margin-top: 60pt"><br /></p>
		<p id="amba" style="padding-left: 320pt;text-indent: -29pt;line-height: 170%;text-align: left;"><u>Raiza elena
				oktaviana</u>
			<br>
			Direktur
		</p>

		{{-- <script type="text/php">
        if ( isset($pdf) ) {
            $x = 50;
            $y = 18;
            $text = "{PAGE_NUM} of {PAGE_COUNT}";
            $font = $fontMetrics->get_font("helvetica", "bold");
            $size = 6;
            $color = array(255,0,0);
            $word_space = 0.0;
            $char_space = 0.0;
            $angle = 0.0; 
            $pdf->page_text($x, $y, $text, $font, $size, $color, $word_space, $char_space, $angle);
        }
    </script> --}}
	</body>

</html>
