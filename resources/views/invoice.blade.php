@extends('layout.main-layout');
@section('content')
	<div id="main">
		<header class="mb-3">
			<a class="burger-btn d-block d-xl-none" href="#">
				<i class="bi bi-justify fs-3"></i>
			</a>
		</header>
		<div class="page-heading">
			<h3 class="mb-3">Invoice</h3>
			<div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
				<div class="d-flex align-items-center mt-3 gap-2">
					<label class="mb-0" for="filter_invoice" style="flex-shrink: 0; min-width: 15px;">Filter Tanggal:</label>
					<input class="form-control" id="filter_invoice" name="filter_invoice" type="date">
				</div>
			</div>
		</div>
		
		<div class="page-content">
			<div class="table-responsive">
				<table class="table table-striped" id="tabel-invoice">
					<thead>
               <tr>
                  <th>No</th>
                  <th>Nomor Invoice</th>
                  <th>Pt Tujuan</th>
                  <th>Cetak Invoice</th>
               </tr>
					</thead>
					<tbody></tbody>
            </table>
			</div>
		</div>
	</div>

	<script>
		let tableInvoice;
		$(document).ready(function() {
			tableInvoice = $('#tabel-invoice').DataTable({
				processing: true,
				serverSide: true,
				searching: true,
				responsive: false,
				ajax: "invoice/get-invoice",
				columns: [{
						data: "DT_RowIndex",
						name: "DT_RowIndex",
						className: 'text-start',
						orderable: false,
						searchable: false,
					},
					{
						data: 'nomor_invoice',
						name: 'surat_jalan.nomor_invoice',
						className: 'text-start',
					},
					{
						data: 'nama_perusahaan',
						name: 'perusahaan.nama_perusahaan',
						className: 'text-start',
						render: function(data, type, row) {
							return row.nama_perusahaan ?? '-';
						}
					},
					{
						"orderable": false,
						"searchable": false,
						"data": null,
						"render": function(data, type, row, meta) {
							return `
							<button class="btn btn-danger" onclick="cetakInvoice('${row.surat_jalan_id}')">Cetak</button>
							`
						},
						className: 'text-center'
					},
				],
			});

			var currentRoute = window.location.pathname;
			if (currentRoute == '/invoice') {
				$('#menu-invoice').addClass('active');
				$('#menu-dashboard', '#menu-do', '#menu-penawaran','#menu-exportsql','#menu-pembelian-barang').removeClass('active');
			}
		});

		$('#filter_invoice').on('change', function() {
			let currentUrl = 'invoice/get-invoice';
			let date = $('#filter_invoice').val();
			let newUrl = currentUrl + "?invoice_filter=" + date;
			tableInvoice.ajax.url(newUrl).load(function() {
				$('[data-kt-menu]').each(function() {
					var menu = new KTMenu(this);
				});
			});
		});

		function cetakInvoice(id) {
			let newUrl = 'invoice/cetak-invoice/' + id;
			window.open(newUrl, '_blank');
		}
	</script>
@endsection
