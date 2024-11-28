<!DOCTYPE html
	PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ms" lang="ms">

	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Cetak DO</title>
		<meta name="author" content="azril habib" />
		<style type="text/css">
			* {
				margin: 0;
				padding: 0;
				text-indent: 0;
			}

			.s1 {
				color: black;
				font-family: Calibri, sans-serif;
				font-style: normal;
				font-weight: bold;
				text-decoration: none;
				font-size: 14px;
			}

			.s2 {
				color: black;
				font-family: Calibri, sans-serif;
				font-style: normal;
				font-weight: normal;
				text-decoration: none;
				font-size: 11px;
			}

			.s3 {
				color: black;
				font-family: Calibri, sans-serif;
				font-style: normal;
				font-weight: normal;
				text-decoration: none;
				font-size: 12px;
			}

			.s4 {
				color: black;
				font-family: Arial, sans-serif;
				font-style: normal;
				font-weight: normal;
				text-decoration: none;
				font-size: 12px;
			}

			.s5 {
				color: black;
				font-family: Calibri, sans-serif;
				font-style: normal;
				font-weight: normal;
				text-decoration: none;
				font-size: 12px;
			}

			p {
				color: black;
				font-family: Calibri, sans-serif;
				font-style: normal;
				font-weight: bold;
				text-decoration: none;
				font-size: 14pt;
				margin: 0pt;
			}

			.s6 {
				color: black;
				font-family: Calibri, sans-serif;
				font-style: normal;
				font-weight: normal;
				text-decoration: underline;
				font-size: 11pt;
			}

			.s7 {
				color: black;
				font-family: Calibri, sans-serif;
				font-style: normal;
				font-weight: normal;
				text-decoration: none;
				font-size: 9pt;
			}

			/* .table-do {
				vertical-align: top;
				overflow: visible;
				table-layout: fixed;
				width: 100%;
			} */

			td {
				word-wrap: break-word;
				word-break: break-word;
				white-space: normal;
			}
		</style>
	</head>

	<body style="margin: 1cm 2cm;">
		<div style="display: table; width: 100%;">
			<div style="display: table-cell; width: 60%; vertical-align: top;">
				<table style="border-collapse:collapse; width: 100%;" cellspacing="0">
					<tr style="height:14pt">
						<td>
							<p class="s1" style="text-indent: 0pt; text-align: left;margin-bottom: 5pt;">
								PT. KAISAR SINAR SAMUDERA
							</p>
						</td>
					</tr>
					<tr style="height:15pt">
						<td>
							<p class="s2" style="text-indent: 0pt; text-align: left; margin-bottom: 1pt">
								KO. Permata Arbes Blok C No.22 Kelurahan Pangkalan Kerinci Timur
							</p>
						</td>
					</tr>
					<tr style="height:16pt">
						<td>
							<p class="s2" style="text-indent: 0pt; text-align: left;margin-bottom: 1pt">
								Kecamatan Pangkalan Kerinci, Kabupaten Pelalawan 28381
							</p>
						</td>
					</tr>
					<tr style="height:15pt">
						<td>
							<p class="s2" style="text-indent: 0pt; text-align: left;">
								Telp. 082388396727 No. NPWP 86.058.331.9-222.000
							</p>
						</td>
					</tr>
				</table>
				<table style="border-collapse:collapse;margin-top: 17pt;" cellspacing="0">
					<tr style="height:15pt">
						<td
							style="width:400pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-right-style:solid;border-right-width:1pt">
							<p class="s3" style="padding-left: 10pt;text-indent: 0pt;line-height: 0pt;text-align: left; margin-top:15pt">
								Kepada :</p>
						</td>
					</tr>
					<tr style="height:16pt">
						<td
							style="width:400pt;border-left-style:solid;border-left-width:1pt;border-right-style:solid;border-right-width:1pt">
							<p class="s4" style="padding-left: 52pt;text-indent: 0pt;text-align: left;line-height: 15pt;">
								{{ $data->nama_perusahaan }}
							</p>
						</td>
					</tr>
					<tr style="height:43pt">
						<td
							style="width:400pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
							<p class="s3"
								style="padding-left: 52pt;text-indent: 0pt;line-height: 15pt;text-align: left;margin-bottom:15pt; margin-right: 6pt">
								{{ $data->alamat ?? '-' }}</p>
						</td>
					</tr>
				</table>
			</div>
			<div style="display: table-cell; width: 40%; vertical-align: top;">
				<p class="s1" style="padding-top: 0; padding-left: 0pt; padding-bottom: 5pt; text-indent: 0pt; text-align: left; font-weight: bold;">
					SURAT JALAN
				</p>
				<table style="width: 100%; border-collapse: collapse; font-size: 11px">
					<tr>
						<td style="width: 40%; font-weight: bold; padding: 1pt 0pt;">Nomor Surat Jalan</td>
						<td style="width: 5%; text-align: center; padding: 1pt 0pt;">:</td>
						<td style="width: 55%; padding: 1pt 0pt;">{{ $data->nomor_surat_jalan }}</td>
					</tr>
					<tr>
						<td style="font-weight: bold; padding: 1pt 0pt;">Nomor Invoice</td>
						<td style="text-align: center; padding: 1pt 0pt;">:</td>
						<td style="padding: 1pt 0pt;">{{ $data->nomor_invoice }}</td>
					</tr>
					<tr>
						<td style="font-weight: bold; padding: 1pt 0pt;">Tanggal</td>
						<td style="text-align: center; padding: 1pt 0pt;">:</td>
						<td style="padding: 1pt 0pt;">{{ date('d-m-Y', strtotime($data->tanggal)) }}</td>
					</tr>
					<tr>
						<td style="font-weight: bold; padding: 1pt 0pt;">Nomor PO</td>
						<td style="text-align: center; padding: 1pt 0pt;">:</td>
						<td style="padding: 1pt 0pt;">{{ $data->nomor_po }}</td>
					</tr>
					<tr>
						<td style="font-weight: bold; padding: 1pt 0pt;">Dikirim Dengan</td>
						<td style="text-align: center; padding: 1pt 0pt;">:</td>
						<td style="padding: 1pt 0pt;">{{ $data->transportasi_kirim }}</td>
					</tr>
					<tr>
						<td style="font-weight: bold; padding: 1pt 0pt;">No. Polisi</td>
						<td style="text-align: center; padding: 1pt 0pt;">:</td>
						<td style="padding: 1pt 0pt;">{{ $data->nomor_polisi }}</td>
					</tr>
				</table>
			</div>
		</div>
		<table style="border-collapse:collapse; margin-top: 30pt" cellspacing="0">
			<tr style="height:16pt">
				<td
					style="width:52pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt"
					rowspan="2">
					<p class="s3" style="padding-top: 6pt;padding-left: 0pt;text-indent: 0pt;text-align: center;">No</p>
				</td>
				<td
					style="width:76pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-right-style:solid;border-right-width:1pt">
					<p class="s3" style="padding-left: 2pt;text-indent: 0pt;line-height: 14pt;text-align: center;">Kode</p>
				</td>
				<td
					style="width:145pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt"
					rowspan="2">
					<p class="s3" style="padding-top: 6pt;padding-left: 43pt;text-indent: 0pt;text-align: left;">Nama Barang</p>
				</td>
				<td
					style="width:52pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt"
					rowspan="2">
					<p class="s3" style="padding-top: 6pt;padding-left: 0pt;text-indent: 0pt;text-align: center;">Satuan</p>
				</td>
				<td
					style="width:75pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-right-style:solid;border-right-width:1pt">
					<p class="s3"
						style="padding-left: 0pt;padding-right: 0pt;text-indent: 0pt;line-height: 14pt;text-align: center;">
						Jumlah</p>
				</td>
				<td
					style="width:76pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt"
					rowspan="2">
					<p class="s3" style="padding-top: 6pt;padding-left: 0pt;text-indent: 0pt;text-align: center;">Keterangan</p>
				</td>
			</tr>
			<tr style="height:14pt">
				<td
					style="width:76pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
					<p class="s3" style="padding-left: 2pt;text-indent: 0pt;line-height: 12pt;text-align: center;">Barang</p>
				</td>
				<td
					style="width:75pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
					<p class="s3" style="padding-left: 2pt;text-indent: 0pt;line-height: 12pt;text-align: center;">Barang</p>
				</td>
			</tr>
			@foreach ($manyData as $item)
				<tr style="height:15pt">
					<td
						style="width:52pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
						<p class="s5" style="padding-left: 2pt;text-indent: 0pt;line-height: 13pt;text-align: center;">
							{{ $loop->iteration }}</p>
					</td>
					<td
						style="width:76pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
						<p class="s5" style="padding-left: 0pt;text-indent: 0pt;line-height: 13pt;text-align: center;">
							{{ $item->kode_barang }}</p>
					</td>
					<td
						style="width:145pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
						<p class="s5" style="padding-left: 2pt;text-indent: 0pt;line-height: 13pt;text-align: left;">
							{{ $item->nama_barang }}</p>
					</td>
					<td
						style="width:52pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
						<p class="s5" style="padding-left: 16pt;text-indent: 0pt;line-height: 13pt;text-align: left;">
							{{ $item->satuan }}</p>
					</td>
					<td
						style="width:75pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
						<p class="s5" style="padding-left: 2pt;text-indent: 0pt;line-height: 13pt;text-align: center;">
							{{ $item->jumlah_barang }}</p>
					</td>
					<td
						style="width:75pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
						<p class="s5" style="padding-left: 2pt;text-indent: 0pt;line-height: 13pt;text-align: center;">
							{{ $item->keterangan ?? '-' }}</p>
					</td>
				</tr>
			@endforeach

		</table>
		<p style="padding-top: 3pt;text-indent: 0pt;text-align: left;"><br /></p>
		<div>
			<table style="width:calc(100% - 100pt); margin:20pt 0pt; border-collapse:collapse;" cellspacing="0">
				<tr>
					<!-- Kolom untuk Tabel "Tanda Terima" -->
					<td style="width:50%; vertical-align:top; text-align:left; padding-right:10pt;">
						<table style="border-collapse:collapse; width:auto;border: 1px solid black;" cellspacing="0">
							<tr style="border-bottom: 1px solid black;">
								<td style="width:77pt;">
									<p class="s3" style="text-indent: 0pt;text-align: center;">Tanda
										Terima</p>
								</td>
							</tr>
							<tr>
								<td style="width:77pt;">
									<p class="s3" style="text-indent: 0pt;line-height: 14pt;text-align: center; margin-top: 40pt">(...................)</p>
								</td>
							</tr>
						</table>
					</td>

					<!-- Kolom untuk Tabel "Direktur" -->
					<td style="width:50%; vertical-align:top; text-align:right; padding-left:10pt;">
						<table style="border-collapse:collapse; width:auto;border: 1px solid black;" cellspacing="0">
							<tr style="border-bottom: 1px solid black;">
								<td style="width:77pt;">
									<p class="s3" style="text-indent: 0pt;line-height: 13pt;text-align: center;">Direktur
									</p>
								</td>
							</tr>
							<tr>
								<td style="width:77pt;margin-top:20pt;">
									<p class="s3" style="text-indent: 0pt;line-height: 14pt;text-align: center;margin-top: 40pt;">(Raiza Elena)</p>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>

	</body>

</html>
