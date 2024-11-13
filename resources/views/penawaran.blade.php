@extends('layout.main-layout');
@section('content')
	<div id="main">
		<div class="page-heading">
			<h3 class="mb-3">Penawaran Harga</h3>
			<div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
				<div class="d-flex gap-2">
					<button class="btn btn-primary d-flex align-items-center gap-2" id="button-modal-tmbh-penawaran" type="button">
						<span>Tambah Data</span>
					</button>
					<button class="btn btn-danger d-flex align-items-center gap-2" type="button" onclick="exportPDF()">
						<span>Export PDF</span>
					</button>
				</div>
				<div class="d-flex align-items-center mt-3 gap-2">
					<label class="mb-0" for="filter_penawaran" style="flex-shrink: 0; min-width: 15px;">Filter Tanggal:</label>
					<input class="form-control" id="filter_penawaran" name="filter_penawaran" type="date">
				</div>
			</div>
		</div>
		<!-- Modal Add -->
		<div class="modal fade" id="modalAddPenawaran" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog"
			aria-labelledby="modal_addLabel" aria-hidden="true" tabindex="-1">
			<div class="modal-dialog modal-dialog-centered modal-md">
				<div class="modal-content px-2">
					<div class="modal-header">
						<h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah Barang</h1>
						<button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
					</div>
					<div class="modal-body">
						<form id="tambah-penawaran">
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
								<label class="form-label" for="belanja">Belanja<span class="text-danger">*</span></label>
								<input class="form-control" id="belanja" name="belanja" type="text"
									oninput="return formatNumber(this, event)">
							</div>
							<div class="mb-3">
								<label class="form-label" for="ongkir">Ongkir<span class="text-danger">*</span></label>
								<input class="form-control" id="ongkir" name="ongkir" type="text"
									oninput="return formatNumber(this, event)">
							</div>
							<button class="btn btn-primary align-items-center d-flex gap-2" id="button-tambah-penawaran" type="submit">
								<span>Tambah Data</span>
							</button>
						</form>
					</div>
				</div>
			</div>
		</div>
		{{-- Modal Edit --}}
		<div class="modal fade" id="modalEditPenawaran" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog"
			aria-labelledby="modal_editLabel" aria-hidden="true" tabindex="-1">
			<div class="modal-dialog modal-dialog-centered modal-md">
				<div class="modal-content px-2">
					<div class="modal-header">
						<h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Barang</h1>
						<button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
					</div>
					<div class="modal-body">
						<form id="edit-penawaran">
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
								<label class="form-label" for="belanja">Belanja<span class="text-danger">*</span></label>
								<input class="form-control" id="belanja_edit" name="belanja" type="text"
									oninput="return formatNumber(this, event)">
							</div>
							<div class="mb-3">
								<label class="form-label" for="ongkir">Ongkir<span class="text-danger">*</span></label>
								<input class="form-control" id="ongkir_edit" name="ongkir" type="text"
									oninput="return formatNumber(this, event)">
							</div>
							<button class="btn btn-primary align-items-center d-flex gap-2" id="button-edit-penawaran" type="submit">
								<span>Edit Data</span>
							</button>
						</form>
					</div>
				</div>
			</div>
		</div>
		<div class="page-content">
			<div class="table-responsive">
				<table class="table-striped table" id="penawaran-table">
					<thead>
						<tr>
							<th>no</th>
							<th>item</th>
							<th>qty</th>
							<th>belanja</th>
							<th>ongkir</th>
							<th>total</th>
							<th>net</th>
							<th>10%</th>
							<th>penawaran</th>
							<th>untung</th>
							<th>untung belanja</th>
							<th>ariba</th>
							<th>Aksi</th>
						</tr>
					</thead>
					<tbody></tbody>
				</table>
			</div>
		</div>
	</div>

	<script>
		$(document).ready(function() {
			let tablePenawaran = $('#penawaran-table').DataTable({
				processing: true,
				serverSide: true,
				searching: true,
				responsive: false,
				ajax: "penawaran/get-penawaran",
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
						data: 'belanja',
						name: 'belanja',
						className: 'text-start',
						render: function(data, type, row) {
							return data.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
						}
					},
					{
						data: 'ongkir',
						name: 'ongkir',
						className: 'text-start',
						render: function(data, type, row) {
							return data.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
						}
					},
					{
						data: 'total',
						name: 'total',
						className: 'text-start',
						render: function(data, type, row) {
							return data.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
						}
					},
					{
						data: 'net',
						name: 'net',
						className: 'text-start',
						render: function(data, type, row) {
							return data.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
						}
					},
					{
						data: '10%',
						name: '10%',
						className: 'text-start',
						render: function(data, type, row) {
							return data.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
						}
					},
					{
						data: 'penawaran',
						name: 'penawaran',
						className: 'text-start',
						render: function(data, type, row) {
							return data.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
						}
					},
					{
						data: 'untung',
						name: 'untung',
						className: 'text-start',
						render: function(data, type, row) {
							return data.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
						}
					},
					{
						data: 'untung_belanja',
						name: 'untung_belanja',
						className: 'text-start',
						render: function(data, type, row) {
							return data.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
						}
					},
					{
						"data": null,
						"name": "ariba",
						render: function(data, type, row, meta) {
							var ariba = row.ariba !== null ? row.ariba.toString().replace(
								/\B(?=(\d{3})+(?!\d))/g,
								".") : '0';
							return '<div class="input-group" style="width:100px">' +
								'<input type="text" class="form-control form-control-sm ariba-input" value="' +
								ariba + '" data-id="' + row.id + '" data-original="' + ariba +
								'" oninput="return formatNumber(this, event)">' +
								'<button class="btn btn-sm btn-outline-secondary" type="button" onclick="submitAriba(' +
								row.id + ')" id="button-submit-ariba-' + row.id + '">' +
								'<i class="bi bi-check-lg"></i>' +
								'</button>' +
								'</div>';
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
			if (currentRoute == '/penawaran') {
				$('#menu-penawaran').addClass('active');
				$('#menu-dashboard', '#menu-do').removeClass('active');
			}
		});

		function submitAriba(id) {
			var aribaInput = $('#button-submit-ariba-' + id).siblings('.ariba-input');
			var aribaValue = parseInt(aribaInput.val().replace(/[^\d]/g, ''));
			editAriba(id, aribaValue);
		}

		function editAriba(id, ariba) {
			$.ajax({
				url: 'penawaran/update-ariba',
				type: 'POST',
				data: {
					id: id,
					ariba: ariba,
					_token: '{{ csrf_token() }}'
				},
				success: function(response) {
					if (response.status === "success") {
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
						tablePenawaran.ajax.reload(null, false);
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
				error: function() {
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
						title: "terjadi kesalahan saat mengedit ariba",
					});
				}
			});
		}

		$('#button-modal-tmbh-penawaran').on('click', function() {
			$('#modalAddPenawaran').modal('show');
		})

		$('#tambah-penawaran').on('submit', function(e) {
			e.preventDefault();
			$('#button-tambah-penawaran').attr('disabled', true);
			let formData = new FormData(this);
			formData.append('belanja', $("#belanja").val().replace(/\D/g, ''));
			formData.append('ongkir', $("#ongkir").val().replace(/\D/g, ''));
			$.ajax({
				headers: {
					"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
				},
				cache: false,
				contentType: false,
				processData: false,
				method: "POST",
				url: "penawaran/create-penawaran",
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
						$('#modalAddPenawaran').modal('hide');
						$('.modal-backdrop.fade.show').remove();
						$('#tambah-penawaran')[0].reset();
						tablePenawaran.ajax.reload(null, false);
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
					$('#button-tambah-penawaran').attr('disabled', false);
				}
			});
		});

		$('#filter_penawaran').on('change', function() {
			let currentUrl = 'penawaran/get-penawaran';
			let date = $('#filter_penawaran').val();
			let newUrl = currentUrl + '?penawaran_filter=' + date;
			console.log(newUrl);
			tablePenawaran.ajax.url(newUrl).load(function() {
				$('[data-kt-menu]').each(function() {
					var menu = new KTMenu(this);
				});
			});
		});

		function exportPDF() {
			let date = $('#filter_penawaran').val();
			let newUrl = 'penawaran/export-pdf?penawaran_filter=' + date;
			window.open(newUrl, '_blank');
		}

		function editData(id) {
			$.ajax({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				type: "GET",
				url: "penawaran/edit-penawaran/" + id,
				dataType: 'json',
				success: function(response) {
					if (response.status == "success") {
						var data = response.data;
						$("#id_edit").val(id);
						$("#nama_item_edit").val(data.nama_item);
						$("#qty_edit").val(data.qty);
						$("#belanja_edit").val(new Intl.NumberFormat('id-ID').format(data.belanja));
						$("#ongkir_edit").val(new Intl.NumberFormat('id-ID').format(data.ongkir));
						$("#modalEditPenawaran").modal("show");
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

		$("#edit-penawaran").submit(function(e) {
			e.preventDefault();
			var id = $("#id_edit").val();
			$('#button-edit-penawaran').attr('disabled', true);
			var formdata = new FormData(this);
			formdata.append('_method', 'PUT');
			formdata.append('belanja', $("#belanja_edit").val().replace(/\D/g, ''));
			formdata.append('ongkir', $("#ongkir_edit").val().replace(/\D/g, ''));
			$.ajax({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				cache: false,
				contentType: false,
				processData: false,
				method: 'POST',
				url: "penawaran/update-penawaran/" + id,
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
						$('#modalEditPenawaran').modal('hide');
						$('.modal-backdrop.fade.show').remove();
						$('#edit-penawaran')[0].reset();
						tablePenawaran.ajax.reload(null, false);
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
					$('#button-edit-penawaran').attr('disabled', false);
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
						url: "penawaran/delete-penawaran/" + id,
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
								tablePenawaran.ajax.reload(null, false);
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

		$('#modalAddPenawaran, #modalEditPenawaran').on('hidden.bs.modal', function() {
			$('body').css('overflow', 'auto');
		});
		$('#modalAddPenawaran, #modalEditPenawaran').on('shown.bs.modal', function() {
			$('body').css('overflow', 'hidden');
		});
	</script>
@endsection
