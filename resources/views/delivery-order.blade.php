@extends('layout.main-layout')
@section('content')
	<div id="main">
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
		<div class="page-content">
			<div class="table-responsive mb-3">
				<table class="table-striped table" id="perusahaan-table">
					<thead>
						<tr>
							<th>no</th>
							<th>nama pt</th>
							<th>alamat</th>
							<th>no hp</th>
							<th>npwp</th>
							<th>aksi</th>
						</tr>
					</thead>
					<tbody></tbody>
				</table>
			</div>
			<h4 class="mb-3">Daftar Delivery Order</h4>
			<button class="btn btn-primary d-flex align-items-start gap-2" id="button-modal-tmbh-do" type="button">
				<span>Tambah Data</span>
			</button>
			{{-- modal add delivery order --}}
			<div class="modal fade" id="modalAddDo" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog"
				aria-labelledby="modal_addLabel" aria-hidden="true" tabindex="-1">
				<div class="modal-dialog modal-dialog-centered modal-xl">
					<div class="modal-content px-2">
						<div class="modal-header">
							<h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah Deliver Order</h1>
							<button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
						</div>
						<div class="modal-body">
							<form id="tambah-do">
								@csrf
								<div class="mb-3">
									<label class="form-label" for="nama-perusahaan">Nama Perusahaan<span class="text-danger">*</span></label>
									<select id="nama-perusahaan">
										<option value="">Pilih Perusahaan</option>
									</select>
								</div>
								<div id="input-container">
									<div class="row mb-3">
										<div class="col-3">
											<label class="form-label" for="kode_barang">Kode</label>
											<input class="form-control" name="kode_barang[]" type="number">
										</div>
										<div class="col-3">
											<label class="form-label" for="nama_barang">Nama Barang</label>
											<input class="form-control" name="nama_barang[]" type="text">
										</div>
										<div class="col-2">
											<label class="form-label" for="satuan_barang">Satuan</label>
											<input class="form-control" name="satuan_barang[]" type="text">
										</div>
										<div class="col-2">
											<label class="form-label" for="qty_barang">Qty</label>
											<input class="form-control" name="qty_barang[]" type="number">
										</div>
										<div class="col-2">
											<label class="form-label" for="keterangan">Keterangan</label>
											<input class="form-control" name="keterangan[]" type="text">
										</div>
									</div>
								</div>
								<div class="col-12 d-flex justify-content-end my-2 gap-3">
									<a class="text-primary text-decoration-none" id="add-row" href="javascript:void(0)">+
										Tambah
										baris</a>
								</div>
								<button class="btn btn-primary align-items-center d-flex gap-2" id="button-tambah-perusahaan" type="submit">
									<span>Tambah Data</span>
								</button>
							</form>
						</div>

					</div>
				</div>
			</div>
		</div>
	</div>

	<script>
		let tableDo = $('#perusahaan-table').DataTable({
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
						return row.alamat ?? '-';
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
						return row.no_hp ?? '-';
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
										<a class="text-black w-100 text-decoration-none d-block" title="edit data" href="javascript:void(0);" onclick="editData('${row.id}')">
											Edit
										</a>
									</li>
									<li><a class="text-danger w-100 text-decoration-none d-block" title="hapus data" href="javascript:void(0);" onclick="deleteData('${row.id}')">Hapus</a></li>
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

		$('#add-row').on('click', function() {
			const newRow = `
			<div class="row mb-3">
					<div class="col-3">
						<label class="form-label" for="kode_barang">Kode</label>
						<input class="form-control" name="kode_barang[]" type="number">
					</div>
					<div class="col-3">
						<label class="form-label" for="nama_barang">Nama Barang</label>
						<input class="form-control" name="nama_barang[]" type="text">
					</div>
					<div class="col-2">
						<label class="form-label" for="satuan_barang">Satuan</label>
						<input class="form-control" name="satuan_barang[]" type="text">
					</div>
					<div class="col-2">
						<label class="form-label" for="qty_barang">Qty</label>
						<input class="form-control" name="qty_barang[]" type="number">
					</div>
					<div class="col-2">
						<label class="form-label" for="keterangan">Keterangan</label>
						<input class="form-control" name="keterangan[]" type="text">
					</div>
					<div class="col-12 mt-2 text-start">
						<a class="text-danger text-decoration-none remove-row" href="javascript:void(0)">- Hapus baris</a>
					</div>
			</div>`;
			$('#input-container').append(newRow);
		});

		$('#input-container').on('click', '.remove-row', function() {
			$(this).closest('.row').remove();
		});


		// $('#nama-perusahaan').on('select2:select', function(e) {
		// 	let data = e.params.data.id;
		// 	console.log(data)
		// });

		var currentRoute = window.location.pathname;
		if (currentRoute == '/delivery-order') {
			$('#menu-do').addClass('active');
			$('#menu-penawaran', '#menu-dashboard').removeClass('active');
		}

		$('#modalAddPerusahaan').on('hidden.bs.modal', function() {
			$('body').css('overflow', 'auto');
		});
		$('#modalAddPerusahaan').on('shown.bs.modal', function() {
			$('body').css('overflow', 'hidden');
		});
	</script>
@endsection
