@extends('layout.main-layout')
@section('content')
	<div id="main">
		<header class="mb-3">
			<a class="burger-btn d-block d-xl-none" href="#">
				<i class="bi bi-justify fs-3"></i>
			</a>
		</header>
		<div class="page-heading">
			<h3 class="mb-3">Delivery Order</h3>
			<hr>
			<h4 class="mb-3">Daftar Perusahaan</h4>
			<button class="btn btn-primary d-flex align-items-start gap-2" id="button-modal-tmbh-perusahaan" type="button">
				<span>Tambah Data</span>
			</button>
		</div>
		{{-- modal add perusahaan --}}
		<div class="modal fade" id="modalAddPerusahaan" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog"
			aria-labelledby="modal_addLabel" aria-hidden="true" tabindex="-1">
			<div class="modal-dialog modal-dialog-centered modal-md">
				<div class="modal-content px-2">
					<div class="modal-header">
						<h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah Perusahaan</h1>
						<button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
					</div>
					<div class="modal-body">
						<form id="tambah-perusahaan">
							@csrf
							<div class="mb-3">
								<label class="form-label" for="nama_perusahaan">Nama Perusahaan<span class="text-danger">*</span></label>
								<input class="form-control" id="nama_perusahaan" name="nama_perusahaan" type="text">
							</div>
							<div class="mb-3">
								<label class="form-label" for="alamat">Alamat</label>
								<input class="form-control" id="alamat" name="alamat" type="text">
							</div>
							<div class="mb-3">
								<label class="form-label" for="no_hp">No HP</label>
								<input class="form-control" id="no_hp" name="no_hp" type="number">
							</div>
							<div class="mb-3">
								<label class="form-label" for="npwp">NPWP</label>
								<input class="form-control" id="npwp" name="npwp" type="text">
							</div>
							<button class="btn btn-primary align-items-center d-flex gap-2" id="button-tambah-perusahaan" type="submit">
								<span>Tambah Data</span>
							</button>
						</form>
					</div>
				</div>
			</div>
		</div>
		{{-- modal edit perusahaan --}}
		<div class="modal fade" id="modalEditPerusahaan" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog"
			aria-labelledby="modal_addLabel" aria-hidden="true" tabindex="-1">
			<div class="modal-dialog modal-dialog-centered modal-md">
				<div class="modal-content px-2">
					<div class="modal-header">
						<h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Perusahaan</h1>
						<button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
					</div>
					<div class="modal-body">
						<form id="edit-perusahaan">
							@csrf
							<input id="id_edit_perusahaan" name="id" type="hidden">
							<div class="mb-3">
								<label class="form-label" for="nama_perusahaan">Nama Perusahaan<span class="text-danger">*</span></label>
								<input class="form-control" id="nama_perusahaan_edit" name="nama_perusahaan" type="text">
							</div>
							<div class="mb-3">
								<label class="form-label" for="alamat">Alamat</label>
								<input class="form-control" id="alamat_edit" name="alamat" type="text">
							</div>
							<div class="mb-3">
								<label class="form-label" for="no_hp">No HP</label>
								<input class="form-control" id="no_hp_edit" name="no_hp" type="number">
							</div>
							<div class="mb-3">
								<label class="form-label" for="npwp">NPWP</label>
								<input class="form-control" id="npwp_edit" name="npwp" type="text">
							</div>
							<button class="btn btn-primary align-items-center d-flex gap-2" id="button-edit-perusahaan" type="submit">
								<span>Edit Data</span>
							</button>
						</form>
					</div>
				</div>
			</div>
		</div>
		<div class="page-content">
			<div class="table-responsive mb-3">
				<table class="table-striped table" id="perusahaan-table">
					<thead>
						<tr>
							<th>No</th>
							<th>Nama PT</th>
							<th>Alamat</th>
							<th>No HP</th>
							<th>NPWP</th>
							<th>Aksi</th>
						</tr>
					</thead>
					<tbody></tbody>
				</table>
			</div>
			<h4 class="mb-3 mt-4 md:mt-0">Daftar Do</h4>
			<div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
				<button class="btn btn-primary d-flex align-items-start md:mb-4 gap-2" id="button-modal-tmbh-do" type="button">
					<span>Tambah Data</span>
				</button>
				<div class="d-flex align-items-center mt-3 gap-2">
					<label class="mb-0" for="filter_do" style="flex-shrink: 0; min-width: 15px;">Filter Tanggal:</label>
					<input class="form-control" id="filter_do" name="filter_do" type="date">
				</div>
			</div>
			<div class="table-responsive mb-3">
				<table class="table-striped table" id="do-table">
					<thead>
						<tr>
							<th>No</th>
							<th>Nomor Surat Jalan</th>
							<th>Nomor Invoice</th>
							<th>PT Tujuan</th>
							<th>Cetak DO</th>
							<th>Aksi</th>
						</tr>
					</thead>
					<tbody></tbody>
				</table>
			</div>
			{{-- modal add delivery order --}}
			<div class="modal fade" id="modalAddDo" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog"
				aria-labelledby="modal_addLabel" aria-hidden="true" tabindex="-1">
				<div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-xl">
					<div class="modal-content px-2">
						<div class="modal-header">
							<h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah DO</h1>
							<button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
						</div>
						<div class="modal-body">
							<form id="tambah-do">
								@csrf
								<div class="mb-3">
									<label class="form-label" for="nama-perusahaan">Nama Perusahaan<span class="text-danger">*</span></label>
									<select id="nama-perusahaan" name="perusahaan_id">
										<option value="">Pilih Perusahaan</option>
									</select>
								</div>
								<div id="input-container">
									<div class="row mb-3">
										<div class="col-md-2 col-6 mb-md-0 mb-2">
											<label class="form-label" for="kode_barang">Kode</label>
											<input class="form-control" name="kode_barang[]" type="number">
										</div>
										<div class="col-md-2 col-6 mb-md-0 mb-2">
											<label class="form-label" for="nama_barang">Nama Barang</label>
											<input class="form-control" name="nama_barang[]" type="text">
										</div>
										<div class="col-md-2 col-6 mb-md-0 mb-2">
											<label class="form-label" for="add_harga_barang">Harga Barang</label>
											<input class="form-control" id="add_harga_barang" name="harga_barang[]" type="text"
												oninput="return formatNumber(this, event)">
										</div>
										<div class="col-md-2 col-6 mb-md-0 mb-2">
											<label class="form-label" for="satuan">Satuan</label>
											<input class="form-control" name="satuan[]" type="text">
										</div>
										<div class="col-md-2 col-6 mb-md-0 mb-2">
											<label class="form-label" for="jumlah_barang">Qty</label>
											<input class="form-control" name="jumlah_barang[]" type="number">
										</div>
										<div class="col-md-2 col-6 mb-md-0 mb-2">
											<label class="form-label" for="keterangan">Keterangan</label>
											<input class="form-control" name="keterangan[]" type="text">
										</div>
									</div>
								</div>
								<div class="col-12 d-flex justify-content-end my-2 gap-3">
									<a class="text-primary text-decoration-none" id="add-row" href="javascript:void(0)">+
										Tambah baris</a>
								</div>
								<hr>
								<div class="row mb-3">
									<div class="col-md-4 col-6 mb-2">
										<label class="form-label" for="nomor_surat_jalan">No Surat Jalan</label>
										<input class="form-control" id="nomor-surat-jalan" name="nomor_surat_jalan" type="text">
									</div>
									<div class="col-md-4 col-6 mb-2">
										<label class="form-label" for="nomor_invoice">Nomor Invoice</label>
										<input class="form-control" id="nomor-surat-invoice" name="nomor_invoice" type="text">
									</div>
									<div class="col-md-4 col-6 mb-2">
										<label class="form-label" for="tanggal">Tanggal</label>
										<input class="form-control" name="tanggal" type="date">
									</div>
									<div class="col-md-4 col-6 mb-2">
										<label class="form-label" for="nomor_po">No PO</label>
										<input class="form-control" name="nomor_po" type="number">
									</div>
									<div class="col-md-4 col-6 mb-2">
										<label class="form-label" for="transportasi_kirim">Dikirim Dengan</label>
										<input class="form-control" name="transportasi_kirim" type="text">
									</div>
									<div class="col-md-4 col-6 mb-2">
										<label class="form-label" for="nomor_polisi">Nomor Polisi</label>
										<input class="form-control" name="nomor_polisi" type="text">
									</div>
								</div>
								<button class="btn btn-primary align-items-center d-flex gap-2" id="button-tambah-do" type="submit">
									<span>Tambah Data</span>
								</button>
							</form>
						</div>
					</div>
				</div>
			</div>
			{{-- modal edit do --}}
			<div class="modal fade" id="modalEditDo" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog"
				aria-labelledby="modal_addLabel" aria-hidden="true" tabindex="-1">
				<div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-xl">
					<div class="modal-content px-2">
						<div class="modal-header">
							<h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Deliver Order</h1>
							<button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
						</div>
						<div class="modal-body">
							<form id="edit-do">
								@csrf
								<input id="id_edit_surat_jalan" name="id" type="hidden">
								<div class="mb-3">
									<label class="form-label" for="nama-perusahaan">Nama Perusahaan<span class="text-danger">*</span></label>
									<select id="perusahaan_id_edit" name="perusahaan_id">
										<option value="">Pilih Perusahaan</option>
									</select>
								</div>
								<div id="input-container-edit">
									{{-- konten edit do --}}
								</div>
								<div class="col-12 d-flex justify-content-end my-2 gap-3">
									<a class="text-primary text-decoration-none" id="add-row-edit" href="javascript:void(0)">+
										Tambah
										baris</a>
								</div>
								<hr>
								<div class="row mb-3">
									<div class="col-4 mb-2">
										<label class="form-label" for="nomor_surat_jalan">No Surat Jalan</label>
										<input class="form-control" id="nomor-surat-jalan-edit" name="nomor_surat_jalan" type="text">
									</div>
									<div class="col-4 mb-2">
										<label class="form-label" for="nomor_invoice">Nomor Invoice</label>
										<input class="form-control" id="nomor-surat-invoice-edit" name="nomor_invoice" type="text">
									</div>
									<div class="col-4 mb-2">
										<label class="form-label" for="tanggal">Tanggal</label>
										<input class="form-control" id="tanggal_edit" name="tanggal" type="date">
									</div>
									<div class="col-4 mb-2">
										<label class="form-label" for="nomor_po">No PO</label>
										<input class="form-control" id="nomor_po_edit" name="nomor_po" type="number">
									</div>
									<div class="col-4 mb-2">
										<label class="form-label" for="transportasi_kirim">Dikirim Dengan</label>
										<input class="form-control" id="transportasi_kirim_edit" name="transportasi_kirim" type="text">
									</div>
									<div class="col-4 mb-2">
										<label class="form-label" for="nomor_polisi">Nomor Polisi</label>
										<input class="form-control" id="nomor_polisi_edit" name="nomor_polisi" type="text">
									</div>
								</div>
								<button class="btn btn-primary align-items-center d-flex gap-2" id="button-edit-do" type="submit">
									<span>Edit Data</span>
								</button>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<script>
		let tablePerusahaan;
		let tableDo;
		$(document).ready(function() {
			tablePerusahaan = $('#perusahaan-table').DataTable({
				processing: true,
				serverSide: true,
				searching: true,
				responsive: false,
				ajax: "delivery-order/get-perusahaan",
				columns: [{
						data: "DT_RowIndex",
						name: "DT_RowIndex",
						className: 'text-start',
						orderable: false,
						searchable: false,
					},
					{
						data: 'nama_perusahaan',
						name: 'nama_perusahaan',
						className: 'text-start',
					},
					{
						data: 'alamat',
						name: 'alamat',
						className: 'text-start',
						render: function(data, type, row) {
							const alamat = row.alamat ??
								'';
							return alamat.length > 70 ? alamat.substring(0, 70) + '...' : alamat ||
								'-';
						}
					},
					{
						data: 'no_hp',
						name: 'no_hp',
						className: 'text-start',
						render: function(data, type, row) {
							return row.no_hp ?? '-';
						}
					},
					{
						data: 'npwp',
						name: 'npwp',
						className: 'text-start',
						render: function(data, type, row) {
							return row.npwp ?? '-';
						}
					},
					{
						"orderable": false,
						"searchable": false,
						"data": null,
						"render": function(data, type, row, meta) {
							var html = `
							<div class="dropstart">
								<button type="button" class="dropdown-toggle border-0 bg-transparent" data-bs-toggle="dropdown" aria-expanded="false">
									<i class="bi bi-three-dots"></i>
								</button>
								<ul class="dropdown-menu py-2 px-3">
									<li class="mb-2"">
										<a class="text-black w-100 text-decoration-none d-block" title="edit data" href="javascript:void(0);" onclick="editDataPerusahaan('${row.id}')">
											Edit
										</a>
									</li>
									<li><a class="text-danger w-100 text-decoration-none d-block" title="hapus data" href="javascript:void(0);" onclick="deleteDataPerusahaan('${row.id}')">Hapus</a></li>
								</ul>
							</div>`;
							return html;
						},
						className: 'text-center'
					}

				],
				"initComplete": function(settings, json) {
					$('[data-kt-menu]').each(function() {
						var menu = new KTMenu(this);
					});
				},
				columnDefs: [{
					responsivePriority: 1,
					targets: [0, -1],
				}],
			});

			tableDo = $('#do-table').DataTable({
				processing: true,
				serverSide: true,
				searching: true,
				responsive: false,
				ajax: "delivery-order/get-do",
				columns: [{
						data: "DT_RowIndex",
						name: "DT_RowIndex",
						className: 'text-start',
						orderable: false,
						searchable: false,
					},
					{
						data: 'nomor_surat_jalan',
						name: 'surat_jalan.nomor_surat_jalan',
						className: 'text-start',
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
							return data ?? '-';
						}
					},
					{
						"orderable": false,
						"searchable": false,
						"data": null,
						"render": function(data, type, row, meta) {
							return `
							<button class="btn btn-danger" onclick="cetakDo('${row.surat_jalan_id}')">Cetak</button>
							`
						},
						className: 'text-center'
					},
					{
						"orderable": false,
						"searchable": false,
						"data": null,
						"render": function(data, type, row, meta) {
							var html = `
							<div class="dropstart">
								<button type="button" class="dropdown-toggle border-0 bg-transparent" data-bs-toggle="dropdown" aria-expanded="false">
									<i class="bi bi-three-dots"></i>
								</button>
								<ul class="dropdown-menu py-2 px-3">
									<li class="mb-2"">
										<a class="text-black w-100 text-decoration-none d-block" title="edit data" href="javascript:void(0);" onclick="editDataDo('${row.surat_jalan_id}')">
											Edit
										</a>
									</li>
									<li><a class="text-danger w-100 text-decoration-none d-block" title="hapus data" href="javascript:void(0);" onclick="deleteDataDo('${row.surat_jalan_id}')">Hapus</a></li>
								</ul>
							</div>`;
							return html;
						},
						className: 'text-center'
					}
				],
				"initComplete": function(settings, json) {
					$('[data-kt-menu]').each(function() {
						var menu = new KTMenu(this);
					});
				},
				columnDefs: [{
					responsivePriority: 1,
					targets: [0, -1],
				}],
			});

			$.ajax({
				url: "delivery-order/no-surat-jalan",
				type: 'GET',
				success: function(response) {
					$('#nomor-surat-jalan').val(response.data);
				},
				error: function(xhr, status, error) {
					console.log('Terjadi kesalahan: ' + error);
				}
			});

			$.ajax({
				url: "delivery-order/no-surat-inv",
				type: 'GET',
				success: function(response) {
					$('#nomor-surat-invoice').val(response.data);
				},
				error: function(xhr, status, error) {
					console.log('Terjadi kesalahan: ' + error);
				}
			});

			var currentRoute = window.location.pathname;
			if (currentRoute == '/delivery-order') {
				$('#menu-do').addClass('active');
				$('#menu-penawaran', '#menu-dashboard', '#menu-invoice', '#menu-exportsql', '#menu-pembelian-barang')
					.removeClass('active');
			}
		});

		$('#filter_do').on('change', function() {
			let currentUrl = 'delivery-order/get-do';
			let date = $('#filter_do').val();
			let newUrl = currentUrl + "?do_filter=" + date;
			tableDo.ajax.url(newUrl).load(function() {
				$('[data-kt-menu]').each(function() {
					var menu = new KTMenu(this);
				});
			});
		});

		function cetakDo(id) {
			let newUrl = 'delivery-order/cetak-do/' + id;
			window.open(newUrl, '_blank');
		}

		$('#button-modal-tmbh-perusahaan').on('click', function() {
			$('#modalAddPerusahaan').modal('show');
		});

		$('#tambah-perusahaan').on('submit', function(e) {
			e.preventDefault();
			$('#button-tambah-perusahaan').attr('disabled', true);
			let formData = new FormData(this);
			$.ajax({
				headers: {
					"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
				},
				cache: false,
				contentType: false,
				processData: false,
				method: "POST",
				url: "delivery-order/create-perusahaan",
				data: formData,
				dataType: "json",
				success: function(response) {
					if (response.status == 'success') {
						const Toast = Swal.mixin({
							toast: true,
							position: "top-end",
							showConfirmButton: false,
							timer: 2000,
							timerProgressBar: true,
							didOpen: (toast) => {
								toast.onmouseenter = Swal.stopTimer;
								toast.onmouseleave = Swal.resumeTimer;
							},
						});
						Toast.fire({
							icon: "success",
							title: response.message,
						});
						$('#modalAddPerusahaan').modal('hide');
						$('.modal-backdrop.fade.show').remove();
						$('#tambah-perusahaan')[0].reset();
						tablePerusahaan.ajax.reload(null, false);
					} else {
						const Toast = Swal.mixin({
							toast: true,
							position: "top-end",
							showConfirmButton: false,
							timer: 2000,
							timerProgressBar: true,
							didOpen: (toast) => {
								toast.onmouseenter = Swal.stopTimer;
								toast.onmouseleave = Swal.resumeTimer;
							},
						});
						Toast.fire({
							icon: "error",
							title: response.message,
						});
					}
				},
				error: function(response) {
					errorAjaxResponse(response);
				},
				complete: function() {
					$('#button-tambah-perusahaan').attr('disabled', false);
				}
			})
		});

		$('#button-modal-tmbh-do').on('click', function() {
			$('#modalAddDo').modal('show');
		});

		$('#nama-perusahaan').select2({
			dropdownParent: $('#modalAddDo'),
			theme: 'bootstrap4',
			ajax: {
				url: "delivery-order/list-perusahaan",
				dataType: 'json',
				delay: 250,
				data: function(params) {
					return {
						search: params.term || ''
					};
				},
				processResults: function(data) {
					return {
						results: data.data.map((company) => ({
							id: company.id,
							text: company.nama_perusahaan
						}))
					};
				},
				cache: true
			},
			placeholder: 'Pilih Perusahaan',
			minimumInputLength: 0
		});

		// Konfigurasi untuk modal Edit
		$('#perusahaan_id_edit').select2({
			dropdownParent: $('#modalEditDo'),
			theme: 'bootstrap4',
			ajax: {
				url: "delivery-order/list-perusahaan",
				dataType: 'json',
				delay: 250,
				data: function(params) {
					return {
						search: params.term || ''
					};
				},
				processResults: function(data) {
					return {
						results: data.data.map((company) => ({
							id: company.id,
							text: company.nama_perusahaan
						}))
					};
				},
				cache: true
			},
			placeholder: 'Pilih Perusahaan',
			minimumInputLength: 0
		});

		$('#add-row').on('click', function() {
			const newRow = `
			<div class="row mb-3">
					<div class="col-md-2 col-6 mb-2 mb-md-0">
						<label class="form-label" for="kode_barang">Kode</label>
						<input class="form-control" name="kode_barang[]" id="kode_barang" type="number">
					</div>
					<div class="col-md-2 col-6 mb-2 mb-md-0">
						<label class="form-label" for="nama_barang">Nama Barang</label>
						<input class="form-control" name="nama_barang[]" id="nama_barang" type="text">
					</div>
					<div class="col-md-2 col-6 mb-md-0 mb-2">
						<label class="form-label" for="harga_barang">Harga Barang</label>
						<input class="form-control" id="harga_barang_add_row" name="harga_barang[]" type="text" oninput="return formatNumber(this, event)">
					</div>
					<div class="col-md-2 col-6 mb-2 mb-md-0">
						<label class="form-label" for="satuan">Satuan</label>
						<input class="form-control" name="satuan[]" id="satuan" type="text">
					</div>
					<div class="col-md-2 col-6 mb-2 mb-md-0">
						<label class="form-label" for="jumlah_barang">Qty</label>
						<input class="form-control" name="jumlah_barang[]" id="jumlah_barang" type="number">
					</div>
					<div class="col-md-2 col-12 mb-2 mb-md-0">
						<label class="form-label" for="keterangan">Keterangan</label>
						<input class="form-control" name="keterangan[]" id="keterangan" type="text">
					</div>
					<div class="col-12 mt-2 text-start">
						<a class="text-danger text-decoration-none remove-row" href="javascript:void(0)">- Hapus baris</a>
					</div>
			</div>`;
			$('#input-container').append(newRow);
		});

		$('#add-row-edit').on('click', function() {
			const newRow = `
			<div class="row mb-3">
					<div class="col-md-2 col-6 mb-2 mb-md-0">
						<label class="form-label" for="kode_barang">Kode</label>
						<input class="form-control" name="kode_barang[]" id="kode_barang_edit" type="number">
					</div>
					<div class="col-md-2 col-6 mb-2 mb-md-0">
						<label class="form-label" for="nama_barang">Nama Barang</label>
						<input class="form-control" name="nama_barang[]" id="nama_barang_edit" type="text">
					</div>
					<div class="col-md-2 col-6 mb-md-0 mb-2">
						<label class="form-label" for="harga_barang">Harga Barang</label>
						<input class="form-control" id="harga_barang_edit_add_row" name="harga_barang[]" type="text" oninput="return formatNumber(this, event)">
					</div>
					<div class="col-md-2 col-6 mb-2 mb-md-0">
						<label class="form-label" for="satuan">Satuan</label>
						<input class="form-control" name="satuan[]" id="satuan_edit" type="text">
					</div>
					<div class="col-md-2 col-6 mb-2 mb-md-0">
						<label class="form-label" for="jumlah_barang">Qty</label>
						<input class="form-control" name="jumlah_barang[]" id="jumlah_barang_edit" type="number">
					</div>
					<div class="col-md-2 col-12 mb-2 mb-md-0">
						<label class="form-label" for="keterangan">Keterangan</label>
						<input class="form-control" name="keterangan[]" id="keterangan_edit" type="text">
					</div>
					<div class="col-12 mt-2 text-start">
						<a class="text-danger text-decoration-none remove-row" href="javascript:void(0)">- Hapus baris</a>
					</div>
			</div>`;
			$('#input-container-edit').append(newRow);
		});

		$('#input-container').on('click', '.remove-row', function() {
			$(this).closest('.row').remove();
		});

		$('#input-container-edit').on('click', '.remove-row', function() {
			$(this).closest('.row').remove();
		});

		// $('#nama-perusahaan').on('select2:select', function(e) {
		// 	let data = e.params.data.id;
		// 	console.log(data)
		// });

		function editDataPerusahaan(id) {
			$.ajax({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				type: "GET",
				url: "delivery-order/edit-perusahaan/" + id,
				dataType: 'json',
				success: function(response) {
					if (response.status == "success") {
						var data = response.data;
						$("#id_edit_perusahaan").val(id);
						$("#nama_perusahaan_edit").val(data.nama_perusahaan);
						$("#alamat_edit").val(data.alamat);
						$("#no_hp_edit").val(data.no_hp);
						$("#npwp_edit").val(data.npwp);
						$("#modalEditPerusahaan").modal("show");
					} else {
						const Toast = Swal.mixin({
							toast: true,
							position: "top-end",
							showConfirmButton: false,
							timer: 2000,
							timerProgressBar: true,
							didOpen: (toast) => {
								toast.onmouseenter = Swal.stopTimer;
								toast.onmouseleave = Swal.resumeTimer;
							},
						});
						Toast.fire({
							icon: "error",
							title: "Gagal!",
						});
					}
				},
				error: function(response) {
					errorAjaxResponse(response);
				}
			});
		}

		$('#edit-perusahaan').on('submit', function(e) {
			e.preventDefault();
			var id = $("#id_edit_perusahaan").val();
			$('#button-edit-perusahaan').attr('disabled', true);
			var formdata = new FormData(this);
			formdata.append('_method', 'PUT');
			$.ajax({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				cache: false,
				contentType: false,
				processData: false,
				method: 'POST',
				url: "delivery-order/update-perusahaan/" + id,
				data: formdata,
				dataType: 'json',
				success: function(response) {
					if (response.status == 'success') {
						const Toast = Swal.mixin({
							toast: true,
							position: "top-end",
							showConfirmButton: false,
							timer: 2000,
							timerProgressBar: true,
							didOpen: (toast) => {
								toast.onmouseenter = Swal.stopTimer;
								toast.onmouseleave = Swal.resumeTimer;
							},
						});
						Toast.fire({
							icon: "success",
							title: response.message,
						});
						$('#modalEditPerusahaan').modal('hide');
						$('.modal-backdrop.fade.show').remove();
						$('#edit-perusahaan')[0].reset();
						tablePerusahaan.ajax.reload(null, false);
						tableDo.ajax.reload(null, false);
					} else {
						const Toast = Swal.mixin({
							toast: true,
							position: "top-end",
							showConfirmButton: false,
							timer: 2000,
							timerProgressBar: true,
							didOpen: (toast) => {
								toast.onmouseenter = Swal.stopTimer;
								toast.onmouseleave = Swal.resumeTimer;
							},
						});
						Toast.fire({
							icon: "error",
							title: response.message,
						});
					}
				},
				error: function(response) {
					errorAjaxResponse(response);
				},
				complete: function() {
					$('#button-edit-perusahaan').attr('disabled', false);
				}
			});
		});

		function deleteDataPerusahaan(id) {
			swal.fire({
				title: 'Apakah anda yakin??',
				text: "Anda tidak dapat mengembalikan ini !!",
				icon: "warning",
				showCancelButton: true,
				confirmButtonText: 'Hapus!',
				cancelButtonText: 'Batal',
				customClass: {
					confirmButton: 'btn btn-danger me-3',
					cancelButton: 'btn btn-secondary'
				},
				buttonsStyling: false
			}).then(function(result) {
				if (result.value) {
					$.ajax({
						headers: {
							'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
						},
						type: "POST",
						url: "delivery-order/delete-perusahaan/" + id,
						data: {
							_method: 'DELETE'
						},
						success: function(response) {
							if (response.status == "success") {
								const Toast = Swal.mixin({
									toast: true,
									position: "top-end",
									showConfirmButton: false,
									timer: 2000,
									timerProgressBar: true,
									didOpen: (toast) => {
										toast.onmouseenter = Swal.stopTimer;
										toast.onmouseleave = Swal.resumeTimer;
									},
								});
								Toast.fire({
									icon: "success",
									title: response.message,
								});
								tablePerusahaan.ajax.reload(null, false);
								tableDo.ajax.reload(null, false);
							} else {
								const Toast = Swal.mixin({
									toast: true,
									position: "top-end",
									showConfirmButton: false,
									timer: 2000,
									timerProgressBar: true,
									didOpen: (toast) => {
										toast.onmouseenter = Swal.stopTimer;
										toast.onmouseleave = Swal.resumeTimer;
									},
								});
								Toast.fire({
									icon: "error",
									title: response.message,
								});
							}
						},
						error: function(response) {
							errorAjaxResponse(response);
						}
					});
				}
			});
		}

		function updateNomorSurat() {
			$.ajax({
				url: "delivery-order/no-surat-jalan",
				type: 'GET',
				success: function(response) {
					$('#nomor-surat-jalan').val(response.data);
				},
				error: function(xhr, status, error) {
					console.log('Terjadi kesalahan: ' + error);
				}
			});

			$.ajax({
				url: "delivery-order/no-surat-inv",
				type: 'GET',
				success: function(response) {
					$('#nomor-surat-invoice').val(response.data);
				},
				error: function(xhr, status, error) {
					console.log('Terjadi kesalahan: ' + error);
				}
			});
		}

		$('#tambah-do').on('submit', function(e) {
			e.preventDefault();
			$('#button-tambah-do').attr('disabled', true);
			let formData = new FormData(this);
			$.ajax({
				headers: {
					"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
				},
				cache: false,
				contentType: false,
				processData: false,
				method: "POST",
				url: "delivery-order/create-do",
				data: formData,
				dataType: "json",
				success: function(response) {
					if (response.status == 'success') {
						const Toast = Swal.mixin({
							toast: true,
							position: "top-end",
							showConfirmButton: false,
							timer: 2000,
							timerProgressBar: true,
							didOpen: (toast) => {
								toast.onmouseenter = Swal.stopTimer;
								toast.onmouseleave = Swal.resumeTimer;
							},
						});
						Toast.fire({
							icon: "success",
							title: response.message,
						});
						$('#modalAddDo').modal('hide');
						$('.modal-backdrop.fade.show').remove();
						$('#tambah-do')[0].reset();
						tableDo.ajax.reload(null, false);
						updateNomorSurat();
					} else {
						const Toast = Swal.mixin({
							toast: true,
							position: "top-end",
							showConfirmButton: false,
							timer: 2000,
							timerProgressBar: true,
							didOpen: (toast) => {
								toast.onmouseenter = Swal.stopTimer;
								toast.onmouseleave = Swal.resumeTimer;
							},
						});
						Toast.fire({
							icon: "error",
							title: response.message,
						});
					}
				},
				error: function(response) {
					const Toast = Swal.mixin({
						toast: true,
						position: "top-end",
						showConfirmButton: false,
						timer: 2000,
						timerProgressBar: true,
						didOpen: (toast) => {
							toast.onmouseenter = Swal.stopTimer;
							toast.onmouseleave = Swal.resumeTimer;
						},
					});
					Toast.fire({
						icon: "error",
						text: "Terjadi kesalahan",
					});
				},
				complete: function() {
					$('#button-tambah-do').attr('disabled', false);
				}
			});
		});

		function editDataDo(id) {
			$.ajax({
				url: `/delivery-order/edit-do/${id}`,
				type: 'GET',
				success: function(response) {
					if (response.status === 'success') {
						let data = response.data;
						if (data.length > 0) {
							let item = data[0];
							$('#id_edit_surat_jalan').val(item.id);
							$('#nomor-surat-jalan-edit').val(item.nomor_surat_jalan);
							$('#nomor-surat-invoice-edit').val(item.nomor_invoice);
							$('#tanggal_edit').val(item.tanggal);
							$('#nomor_po_edit').val(item.nomor_po);
							$('#transportasi_kirim_edit').val(item.transportasi_kirim);
							$('#nomor_polisi_edit').val(item.nomor_polisi);
							let option = new Option(item.nama_perusahaan, item.perusahaan_id, true, true);
							$('#perusahaan_id_edit').append(option).trigger('change');
							$('#perusahaan_id_edit').val(item.perusahaan_id);
							$('#input-container-edit').empty();
							data.forEach((itemData) => {
								$('#input-container-edit').append(`
                           <div class="row mb-3">
                              <div class="col-md-2 col-6 mb-md-0 mb-2">
                                 <label class="form-label">Kode</label>
                                 <input class="form-control" name="kode_barang[]" type="number" value="${itemData.kode_barang}">
                              </div>
                              <div class="col-md-2 col-6 mb-md-0 mb-2">
                                 <label class="form-label">Nama Barang</label>
                                 <input class="form-control" name="nama_barang[]" type="text" value="${itemData.nama_barang}">
                              </div>
										<div class="col-md-2 col-6 mb-md-0 mb-2">
											<label class="form-label" for="harga_barang">Harga Barang</label>
											<input class="form-control" id="harga_barang_edit" name="harga_barang[]" type="text"
												oninput="return formatNumber(this, event)" value="${(itemData.harga_barang || 0).toLocaleString('id-ID')}">
										</div>
                              <div class="col-md-2 col-6 mb-md-0 mb-2">
                                 <label class="form-label">Satuan</label>
                                 <input class="form-control" name="satuan[]" type="text" value="${itemData.satuan}">
                              </div>
                              <div class="col-md-2 col-6 mb-md-0 mb-2">
                                 <label class="form-label">Qty</label>
                                 <input class="form-control" name="jumlah_barang[]" type="number" value="${itemData.jumlah_barang}">
                              </div>
                              <div class="col-md-2 col-12 mb-md-0 mb-2">
                                 <label class="form-label">Keterangan</label>
                                 <input class="form-control" name="keterangan[]" type="text" value="${itemData.keterangan ?? ''}">
                              </div>
										${$('#input-container-edit .row').length > 0 ? `
											<div class="col-12 mt-2 text-start">
												<a class="text-danger text-decoration-none remove-row" href="javascript:void(0)">- Hapus Baris</a>
											</div>` : ''}
                           </div>
                        `);
							});
							$('#modalEditDo').modal('show');
						} else {
							alert("Data tidak ditemukan");
						}
					} else {
						alert(response.message);
					}
				},
				error: function(xhr) {
					console.error("Terjadi kesalahan saat mengambil data:", xhr.responseText);
					alert("Terjadi kesalahan saat mengambil data. Silakan coba lagi.");
				}
			});
		}

		$('#edit-do').on('submit', function(e) {
			e.preventDefault();
			var id = $("#id_edit_surat_jalan").val();
			$('#button-edit-do').attr('disabled', true);
			var formdata = new FormData(this);
			formdata.append('_method', 'PUT');
			$.ajax({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				cache: false,
				contentType: false,
				processData: false,
				method: 'POST',
				url: "delivery-order/update-do/" + id,
				data: formdata,
				dataType: 'json',
				success: function(response) {
					if (response.status === 'success') {
						const Toast = Swal.mixin({
							toast: true,
							position: "top-end",
							showConfirmButton: false,
							timer: 2000,
							timerProgressBar: true,
							didOpen: (toast) => {
								toast.onmouseenter = Swal.stopTimer;
								toast.onmouseleave = Swal.resumeTimer;
							},
						});
						Toast.fire({
							icon: "success",
							title: response.message,
						});
						$('#modalEditDo').modal('hide');
						$('.modal-backdrop.fade.show').remove();
						$('#edit-do')[0].reset();
						$('#perusahaan_id_edit').val(null).trigger('change');
						tableDo.ajax.reload(null, false);
					} else {
						const Toast = Swal.mixin({
							toast: true,
							position: "top-end",
							showConfirmButton: false,
							timer: 2000,
							timerProgressBar: true,
							didOpen: (toast) => {
								toast.onmouseenter = Swal.stopTimer;
								toast.onmouseleave = Swal.resumeTimer;
							},
						});
						Toast.fire({
							icon: "error",
							title: response.message,
						});
					}
				},
				error: function(response) {
					const Toast = Swal.mixin({
						toast: true,
						position: "top-end",
						showConfirmButton: false,
						timer: 2000,
						timerProgressBar: true,
						didOpen: (toast) => {
							toast.onmouseenter = Swal.stopTimer;
							toast.onmouseleave = Swal.resumeTimer;
						},
					});
					Toast.fire({
						icon: "error",
						text: "Lengkapi data",
					});
				},
				complete: function() {
					$('#button-edit-do').attr('disabled', false);
				}
			});
		});

		function deleteDataDo(id) {
			swal.fire({
				title: 'Apakah anda yakin??',
				text: "Anda tidak dapat mengembalikan ini !!",
				icon: "warning",
				showCancelButton: true,
				confirmButtonText: 'Hapus!',
				cancelButtonText: 'Batal',
				customClass: {
					confirmButton: 'btn btn-danger me-3',
					cancelButton: 'btn btn-secondary'
				},
				buttonsStyling: false
			}).then(function(result) {
				if (result.value) {
					$.ajax({
						headers: {
							'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
						},
						type: "POST",
						url: "delivery-order/delete-do/" + id,
						data: {
							_method: 'DELETE'
						},
						success: function(response) {
							if (response.status == "success") {
								const Toast = Swal.mixin({
									toast: true,
									position: "top-end",
									showConfirmButton: false,
									timer: 2000,
									timerProgressBar: true,
									didOpen: (toast) => {
										toast.onmouseenter = Swal.stopTimer;
										toast.onmouseleave = Swal.resumeTimer;
									},
								});
								Toast.fire({
									icon: "success",
									title: response.message,
								});
								tableDo.ajax.reload(null, false);
							} else {
								const Toast = Swal.mixin({
									toast: true,
									position: "top-end",
									showConfirmButton: false,
									timer: 2000,
									timerProgressBar: true,
									didOpen: (toast) => {
										toast.onmouseenter = Swal.stopTimer;
										toast.onmouseleave = Swal.resumeTimer;
									},
								});
								Toast.fire({
									icon: "error",
									title: response.message,
								});
							}
						},
						error: function(response) {
							errorAjaxResponse(response);
						}
					});
				}
			});
		}

		function formatNumber(input) {
			var inputVal = input.value.replace(/[^,\d]/g, '');
			var numberString = inputVal.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
			input.value = numberString;
		}

		$('#modalAddPerusahaan, #modalAddDo, #modalEditPerusahaan, #modalEditDo').on('hidden.bs.modal', function() {
			$('body').css('overflow', 'auto');
		});
		$('#modalAddPerusahaan, #modalAddDo, #modalEditPerusahaan, #modalEditDo').on('shown.bs.modal', function() {
			$('body').css('overflow', 'hidden');
		});
	</script>
@endsection
