@extends('layout.main-layout');
@section('content')
	<div id="main">
		<header class="mb-3">
			<a class="burger-btn d-block d-xl-none" href="#">
				<i class="bi bi-justify fs-3"></i>
			</a>
		</header>
		<div class="page-heading">
			<h3 class="mb-3">Pembelian Barang</h3>
			<div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
				<div class="d-flex gap-2">
					<button class="btn btn-primary d-flex align-items-center gap-2" id="button-modal-tmbh-pembelian" type="button">
						<span>Tambah Data</span>
					</button>
					<button class="btn btn-danger d-flex align-items-center gap-2" type="button" onclick="exportPDF()">
						<span>Export PDF</span>
					</button>
				</div>
				<div class="d-flex align-items-center mt-3 gap-2">
					<label class="mb-0" for="filter_pembelian" style="flex-shrink: 0; min-width: 15px;">Filter Tanggal:</label>
					<input class="form-control" id="filter_pembelian" name="filter_pembelian" type="date">
				</div>
			</div>
		</div>
		{{-- modal add --}}
		<div class="modal fade" id="modalAddPembelian" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog"
			aria-labelledby="modal_addLabel" aria-hidden="true" tabindex="-1">
			<div class="modal-dialog modal-dialog-centered modal-md">
				<div class="modal-content px-2">
					<div class="modal-header">
						<h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah Pembelian Barang</h1>
						<button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
					</div>
					<div class="modal-body">
						<form id="tambah-pembelian">
							@csrf
							<div class="mb-3">
								<label class="form-label" for="nama_item">Nama Barang<span class="text-danger">*</span></label>
								<input class="form-control" id="nama_item" name="nama_item" type="text">
							</div>
							<div class="mb-3">
								<label class="form-label" for="qty">QTY<span class="text-danger">*</span></label>
								<input class="form-control" id="qty" name="qty" type="number">
							</div>
							<div class="mb-3">
								<label class="form-label" for="satuan">Satuan<span class="text-danger">*</span></label>
								<input class="form-control" id="satuan" name="satuan" type="text">
							</div>
							<div class="mb-3">
								<label class="form-label" for="harga_item">Harga Barang<span class="text-danger">*</span></label>
								<input class="form-control" id="harga_item" name="harga_item" type="text"
									oninput="return formatNumber(this, event)">
							</div>
							<button class="btn btn-primary align-items-center d-flex gap-2" id="button-tambah-pembelian" type="submit">
								<span>Tambah Data</span>
							</button>
						</form>
					</div>
				</div>
			</div>
		</div>
		{{-- modal edit --}}
		<div class="modal fade" id="modalEditPembelian" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog"
			aria-labelledby="modal_addLabel" aria-hidden="true" tabindex="-1">
			<div class="modal-dialog modal-dialog-centered modal-md">
				<div class="modal-content px-2">
					<div class="modal-header">
						<h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Pembelian Barang</h1>
						<button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
					</div>
					<div class="modal-body">
						<form id="edit-pembelian">
							@csrf
							<input id="id_edit" name="id" type="hidden">
							<div class="mb-3">
								<label class="form-label" for="nama_item">Nama Barang<span class="text-danger">*</span></label>
								<input class="form-control" id="nama_item_edit" name="nama_item" type="text">
							</div>
							<div class="mb-3">
								<label class="form-label" for="qty">QTY<span class="text-danger">*</span></label>
								<input class="form-control" id="qty_edit" name="qty" type="number">
							</div>
							<div class="mb-3">
								<label class="form-label" for="satuan">Satuan<span class="text-danger">*</span></label>
								<input class="form-control" id="satuan_edit" name="satuan" type="text">
							</div>
							<div class="mb-3">
								<label class="form-label" for="harga_item">Harga Barang<span class="text-danger">*</span></label>
								<input class="form-control" id="harga_item_edit" name="harga_item" type="text"
									oninput="return formatNumber(this, event)">
							</div>
							<button class="btn btn-primary align-items-center d-flex gap-2" id="button-edit-pembelian" type="submit">
								<span>Edit Data</span>
							</button>
						</form>
					</div>
				</div>
			</div>
		</div>
		<div class="page-content">
			<div class="table-responsive">
				<table class="table-striped table" id="pembelian-table">
					<thead>
						<tr>
							<th>no</th>
							<th>item</th>
							<th>qty</th>
							<th>satuan</th>
							<th>harga</th>
							<th>total</th>
							<th>Aksi</th>
						</tr>
					</thead>
					<tbody></tbody>
				</table>
			</div>
		</div>
	</div>

	<script>
		let tablePembelian;
		$(document).ready(function() {
			tablePembelian = $('#pembelian-table').DataTable({
				processing: true,
				serverSide: true,
				searching: true,
				responsive: false,
				ajax: "pembelian-barang/get-data-pembelian",
				columns: [{
						data: "DT_RowIndex",
						name: "DT_RowIndex",
						className: 'text-start',
						orderable: false,
						searchable: false,
					},
					{
						data: 'nama_item',
						name: 'nama_item',
						className: 'text-start',
					},
					{
						data: 'qty',
						name: 'qty',
						className: 'text-start',
					},
					{
						data: 'satuan',
						name: 'satuan',
						className: 'text-start',
					},
					{
						data: 'harga_item',
						name: 'harga_item',
						className: 'text-start',
						render: function(data, type, row) {
							return data.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
						}
					},
					{
						data: 'total',
						name: 'total',
						"searchable": false,
						className: 'text-start',
						render: function(data, type, row) {
							if (!data) return '0';
							const rounded = Math.round(parseFloat(data) * 100) /
							100;
							return rounded.toLocaleString('id-ID', {
								minimumFractionDigits: 0,
								maximumFractionDigits: 2
							});
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

			var currentRoute = window.location.pathname;
			if (currentRoute == '/pembelian-barang') {
				$('#menu-pembelian-barang').addClass('active');
				$('#menu-dashboard', '#menu-do', '#menu-invoice', '#menu-exportsql', '#menu-penawaran').removeClass(
					'active');
			}
		})

		$('#button-modal-tmbh-pembelian').on('click', function() {
			$('#modalAddPembelian').modal('show');
		})

		$('#tambah-pembelian').on('submit', function(e) {
			e.preventDefault();
			$('#button-tambah-pembelian').attr('disabled', true);
			let formData = new FormData(this);
			formData.append('harga_item', $("#harga_item").val().replace(/[^0-9,]/g, '').replace(',', '.'));
			$.ajax({
				headers: {
					"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
				},
				cache: false,
				contentType: false,
				processData: false,
				method: "POST",
				url: "pembelian-barang/create-data-pembelian",
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
						$('#modalAddPembelian').modal('hide');
						$('.modal-backdrop.fade.show').remove();
						$('#tambah-pembelian')[0].reset();
						tablePembelian.ajax.reload(null, false);
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
					$('#button-tambah-pembelian').attr('disabled', false);
				}
			});
		});

		$('#filter_pembelian').on('change', function() {
			let currentUrl = 'pembelian-barang/get-data-pembelian';
			let date = $('#filter_pembelian').val();
			let newUrl = currentUrl + '?pembelian_filter=' + date;
			tablePembelian.ajax.url(newUrl).load(function() {
				$('[data-kt-menu]').each(function() {
					var menu = new KTMenu(this);
				});
			});
		});

		function formatNumber(input) {
			var inputVal = input.value.replace(/[^,\d]/g, '');
			var numberString = inputVal.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
			input.value = numberString;
		}

		function editData(id) {
			$.ajax({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				type: "GET",
				url: "pembelian-barang/edit-data-pembelian/" + id,
				dataType: 'json',
				success: function(response) {
					if (response.status == "success") {
						var data = response.data;
						$("#id_edit").val(id);
						$("#nama_item_edit").val(data.nama_item);
						$("#qty_edit").val(data.qty);
						$("#satuan_edit").val(data.satuan);
						$("#harga_item_edit").val(new Intl.NumberFormat('id-ID').format(data.harga_item));
						$("#modalEditPembelian").modal("show");
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

		$("#edit-pembelian").submit(function(e) {
			e.preventDefault();
			var id = $("#id_edit").val();
			$('#button-edit-pembelian').attr('disabled', true);
			var formdata = new FormData(this);
			formdata.append('_method', 'PUT');
			formdata.append('harga_item', $("#harga_item_edit").val().replace(/[^0-9,]/g, '').replace(',', '.'));
			$.ajax({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				cache: false,
				contentType: false,
				processData: false,
				method: 'POST',
				url: "pembelian-barang/update-data-pembelian/" + id,
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
						$('#modalEditPembelian').modal('hide');
						$('.modal-backdrop.fade.show').remove();
						$('#edit-pembelian')[0].reset();
						tablePembelian.ajax.reload(null, false);
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
					$('#button-edit-pembelian').attr('disabled', false);
				}
			});
		});

		function deleteData(id) {
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
						url: "pembelian-barang/delete-data-pembelian/" + id,
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
								tablePembelian.ajax.reload(null, false);
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

		function exportPDF() {
			let date = $('#filter_pembelian').val();
			let newUrl = 'pembelian-barang/export-pdf?pembelian_filter=' + date;
			window.open(newUrl, '_blank');
		}

		$('#modalAddPembelian, #modalEditPembelian').on('hidden.bs.modal', function() {
			$('body').css('overflow', 'auto');
		});
		$('#modalAddPembelian, #modalEditPembelian').on('shown.bs.modal', function() {
			$('body').css('overflow', 'hidden');
		});
	</script>
@endsection
