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
			<button class="btn btn-primary d-flex align-items-start gap-2" id="button-modal-tmbh-invoice" type="button">
				<span>Tambah Data</span>
			</button>
			<div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
				<div class="d-flex align-items-center mt-3 gap-2">
					<label class="mb-0" for="filter_invoice" style="flex-shrink: 0; min-width: 15px;">Filter Tanggal:</label>
					<input class="form-control" id="filter_invoice" name="filter_invoice" type="date">
				</div>
			</div>
		</div>
		<div class="page-content">
			<div class="table-responsive">
				<table class="table-striped table" id="tabel-invoice">
					<thead>
						<tr>
							<th>No</th>
							<th>Nomor Invoice</th>
							<th>Pt Tujuan</th>
							<th>Cetak Invoice</th>
							<th>Aksi</th>
						</tr>
					</thead>
					<tbody></tbody>
				</table>
			</div>
		</div>
		{{-- modal add --}}
		<div class="modal fade" id="modalAddInv" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog"
			aria-labelledby="modal_addLabel" aria-hidden="true" tabindex="-1">
			<div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg">
				<div class="modal-content px-2">
					<div class="modal-header">
						<h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah Invoice</h1>
						<button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
					</div>
					<div class="modal-body">
						<form id="add-inv">
							@csrf
							<div class="mb-3">
								<label class="mb-1" for="">Ambil Nomor Invoice</label>
								<select id="nomor-invoice" name="nomor_invoice">
									<option value="">Pilih Nomor Invoice</option>
								</select>
							</div>
							<div class="mb-3">
								<label class="mb-1" for="">Tujuan Perusahaan</label>
								<select id="tujuan-perusahaan" name="perusahaan_id">
									<option value="">Pilih Nomor Invoice</option>
								</select>
							</div>
							<div class="mb-3">
								<label class="mb-1" for="">Pilih DO</label>
								<div class="bg-warning-subtle rounded p-3" id="warning-pilih-inv">Pilih Nomor Invoice, dan Perusahaan Terlebih
									Dahulu</div>
								<div class="accordion" id="accordionDO">
									<!-- Accordion items akan ditambahkan di sini melalui JavaScript -->
								</div>
							</div>
							<button class="btn btn-primary align-items-center d-flex mt-3 gap-2" id="button-add-inv" type="submit">
								<span>Tambah Data</span>
							</button>
						</form>
					</div>
				</div>
			</div>
		</div>
		{{-- modal edit --}}
		<div class="modal fade" id="modalEditInv" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog"
			aria-labelledby="modal_addLabel" aria-hidden="true" tabindex="-1">
			<div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg">
				<div class="modal-content px-2">
					<div class="modal-header">
						<h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Invoice</h1>
						<button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
					</div>
					<div class="modal-body">
						<form id="edit-inv">
							@csrf
							<input id="invoice-id-edit" name="id" type="hidden">
							<div class="mb-3">
								<label class="mb-1" for="">Ambil Nomor Invoice</label>
								<select id="nomor-invoice-edit" name="nomor_invoice">
									<option value="">Pilih Nomor Invoice</option>
								</select>
							</div>
							<div class="mb-3">
								<label class="mb-1" for="">Tujuan Perusahaan</label>
								<select id="tujuan-perusahaan-edit" name="perusahaan_id">
									<option value="">Pilih Nomor Invoice</option>
								</select>
							</div>
							<div class="mb-3">
								<label class="mb-1" for="">Pilih DO</label>
								<div class="accordion" id="accordionDOEdit">
									<!-- Accordion items akan ditambahkan di sini melalui JavaScript -->
								</div>
							</div>
							<button class="btn btn-primary align-items-center d-flex mt-3 gap-2" id="button-edit-inv" type="submit">
								<span>Edit Data</span>
							</button>
						</form>
					</div>
				</div>
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
						name: 'nomor_invoice',
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
							<button class="btn btn-danger" onclick="cetakInvoice('${row.id_invoice}')">Cetak</button>
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
										<a class="text-black w-100 text-decoration-none d-block" title="edit data" href="javascript:void(0);" onclick="editDataInv('${row.id_invoice}')">
											Edit
										</a>
									</li>
									<li><a class="text-danger w-100 text-decoration-none d-block" title="hapus data" href="javascript:void(0);" onclick="deleteDataInv('${row.id_invoice}')">Hapus</a></li>
								</ul>
							</div>`;
							return html;
						},
						className: 'text-center'
					}
				],
			});

			var currentRoute = window.location.pathname;
			if (currentRoute == '/invoice') {
				$('#menu-invoice').addClass('active');
				$('#menu-dashboard', '#menu-do', '#menu-penawaran', '#menu-exportsql', '#menu-pembelian-barang')
					.removeClass('active');
			}
		});

		$('#button-modal-tmbh-invoice').on('click', function() {
			$('#modalAddInv').modal('show');
		});

		$('#nomor-invoice').select2({
			dropdownParent: $('#modalAddInv'),
			theme: 'bootstrap4',
			ajax: {
				url: "invoice/list-invoice",
				dataType: 'json',
				delay: 250,
				data: function(params) {
					return {
						search: params.term || ''
					};
				},
				processResults: function(data) {
					return {
						results: data.data.map((noInv) => ({
							id: noInv.id,
							text: noInv.nomor_invoice
						}))
					};
				},
				cache: true
			},
			placeholder: 'Pilih Nomor Invoice',
			minimumInputLength: 0
		});

		$('#nomor-invoice-edit').select2({
			dropdownParent: $('#modalEditInv'),
			theme: 'bootstrap4',
			ajax: {
				url: "invoice/list-invoice",
				dataType: 'json',
				delay: 250,
				data: function(params) {
					return {
						search: params.term || ''
					};
				},
				processResults: function(data) {
					return {
						results: data.data.map((noInv) => ({
							id: noInv.id,
							text: noInv.nomor_invoice
						}))
					};
				},
				cache: true
			},
			placeholder: 'Pilih Nomor Invoice',
			minimumInputLength: 0
		});

		$('#tujuan-perusahaan').select2({
			dropdownParent: $('#modalAddInv'),
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

		$('#tujuan-perusahaan-edit').select2({
			dropdownParent: $('#modalEditInv'),
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

		$('#nomor-invoice, #tujuan-perusahaan').on('change', function() {
			const nomorInvoice = $('#nomor-invoice').val();
			const tujuanPerusahaan = $('#tujuan-perusahaan').val();
			if (nomorInvoice && tujuanPerusahaan) {
				$('#warning-pilih-inv').addClass('d-none');
				$.ajax({
					url: `/invoice/list-do/`,
					method: 'GET',
					success: function(data) {
						renderAccordion(data);
					},
					error: function(err) {
						console.error(err);
						alert('Gagal memuat data delivery order!');
					}
				});
			}
		});

		function renderAccordion(data) {
			const $accordionContainer = $('#accordionDO');
			$accordionContainer.empty();
			data.forEach((doItem, index) => {
				const accordionId = `collapse-${index}`;
				const $accordionItem = $(`
            <div class="accordion-item">
               <h2 class="accordion-header">
                  <button class="accordion-button flex ${index === 0 ? '' : 'collapsed'}" 
                        type="button" 
                        data-bs-toggle="collapse" 
                        data-bs-target="#${accordionId}" 
                        aria-expanded="${index === 0}" 
                        aria-controls="${accordionId}" 
                        data-id="${doItem.id}">
                        <input type="checkbox" class="form-check-input me-2" data-id="${doItem.id}">
                        <span>${doItem.nomor_surat_jalan} | Nomor PO : ${doItem.id}</span>
                  </button>
               </h2>
               <div id="${accordionId}" 
                  class="accordion-collapse collapse ${index === 0 ? 'show' : ''}" 
                  data-bs-parent="#accordionDO">
						<div class="accordion-body">
							${renderItems(doItem.items)}
						</div>
               </div>
            </div>`);
				$accordionContainer.append($accordionItem);
			});
		}

		function renderItems(items) {
			if (!items || items.length === 0) {
				return '<p>Tidak ada item untuk nomor DO ini.</p>';
			}
			const $table = $('<table class="table table-bordered"></table>');
			const $thead = $(`
			<thead>
					<tr>
						<th>Kode Barang</th>
						<th>Nama Barang</th>
						<th>Harga Barang</th>
						<th>Satuan</th>
						<th>Jumlah</th>
						<th>Keterangan</th>
					</tr>
			</thead>`);
			const $tbody = $('<tbody></tbody>');
			items.forEach(item => {
				const $row = $(`
            <tr>
               <td>${item.kode_barang}</td>
               <td>${item.nama_barang}</td>
					<td>${"Rp. " + item.harga_barang.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")}</td>
               <td>${item.satuan}</td>
               <td>${item.jumlah_barang}</td>
               <td>${item.keterangan || '-'}</td>
            </tr>`);
				$tbody.append($row);
			});
			$table.append($thead).append($tbody);
			return $('<div class="table-responsive"></div>').append($table).prop('outerHTML');
		}

		$('#add-inv').on('submit', function(e) {
			e.preventDefault();
			$('#button-add-inv').attr('disabled', true);
			let nomorInvoice = $('#nomor-invoice option:selected').text();
			let tujuanPerusahaan = $('#tujuan-perusahaan option:selected').val();
			let doIdList = [];
			$('#accordionDO .form-check-input:checked').each(function() {
				let doId = $(this).data('id');
				if (doId) {
					doIdList.push(doId);
				}
			});
			if (doIdList.length === 0) {
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
					icon: "warning",
					title: "Pilih minimal satu DO untuk membuat invoice.",
				});
				$('#button-add-inv').attr('disabled', false);
				return;
			}
			let formData = new FormData();
			formData.append('nomor_invoice', nomorInvoice);
			formData.append('perusahaan_id', tujuanPerusahaan);
			doIdList.forEach(doId => formData.append('do_id[]', doId));
			console.log('Data yang akan dikirim:', formData);
			$.ajax({
				headers: {
					"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
				},
				cache: false,
				contentType: false,
				processData: false,
				url: '/invoice/create-invoice',
				method: 'POST',
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
						$('#nomor-invoice').val('').trigger('change');
						$('#accordionDO').find('.form-check-input:checked').prop('checked', false);
						$('#accordionDO').find('.collapse').removeClass('show');
						$('#accordionDO .accordion-button').addClass('collapsed');
						$('#modalAddInv').modal('hide');
						$('.modal-backdrop.fade.show').remove();
						$('#add-inv')[0].reset();
						tableInvoice.ajax.reload(null, false);
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
				error: function(xhr) {
					console.error(xhr.responseJSON);
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
						title: "Terjadi kesalahan saat membuat invoice.",
					});
				},
				complete: function() {
					$('#button-add-inv').attr('disabled', false);
				}
			});
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

		function editDataInv(invoiceId) {
			$.ajax({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				url: `/invoice/edit-invoice/${invoiceId}`,
				method: 'GET',
				dataType: 'json',
				success: function(response) {
					let data = response.data;
					let inv = data[0];
					let newOptionPerusahaan = new Option(inv.nama_perusahaan, inv.id_perusahaan, true, true);
					let newOptionNomorInvoice = new Option(inv.nomor_invoice, inv.nomor_invoice, true, true);
					$('#invoice-id-edit').val(inv.id_invoice);
					$('#tujuan-perusahaan-edit').append(newOptionPerusahaan).trigger('change');
					$('#nomor-invoice-edit').append(newOptionNomorInvoice).trigger('change');
					renderAccordionEdit(data);
					$('#modalEditInv').modal('show');
				},
				error: function(err) {
					console.error(err);
					alert('Gagal memuat data invoice!');
				}
			});
		}

		function renderAccordionEdit(data) {
			const $accordionContainer = $('#accordionDOEdit');
			$accordionContainer.empty();
			data.forEach((doItem, index) => {
				const accordionId = `collapse-${index}`;
				const $accordionItem = $(`
            <div class="accordion-item">
               <h2 class="accordion-header">
                  <button class="accordion-button flex ${index === 0 ? '' : 'collapsed'}" 
                        type="button" 
                        data-bs-toggle="collapse" 
                        data-bs-target="#${accordionId}" 
                        aria-expanded="${index === 0}" 
                        aria-controls="${accordionId}" 
                        data-id="${doItem.id_surat_jalan}">
                        <input type="checkbox" class="form-check-input me-2" data-id="${doItem.id_surat_jalan}" ${doItem.do_id ? 'checked' : ''}>
                        <span>${doItem.nomor_surat_jalan} | Nomor PO : ${doItem.nomor_po}</span>
                  </button>
               </h2>
               <div id="${accordionId}" 
                  class="accordion-collapse collapse ${index === 0 ? 'show' : ''}" 
                  data-bs-parent="#accordionDOEdit">
						<div class="accordion-body">
							${renderItemsEdit(doItem.items)}
						</div>
               </div>
            </div>`);
				$accordionContainer.append($accordionItem);
			});
		}

		function renderItemsEdit(items) {
			if (!items || items.length === 0) {
				return '<p>Tidak ada item untuk nomor DO ini.</p>';
			}
			const $table = $('<table class="table table-bordered"></table>');
			const $thead = $(`
			<thead>
					<tr>
						<th>Kode Barang</th>
						<th>Nama Barang</th>
						<th>Harga Barang</th>
						<th>Satuan</th>
						<th>Jumlah</th>
						<th>Keterangan</th>
					</tr>
			</thead>`);
			const $tbody = $('<tbody></tbody>');
			items.forEach(item => {
				const $row = $(`
            <tr>
               <td>${item.kode_barang}</td>
               <td>${item.nama_barang}</td>
               <td>${"Rp. " + item.harga_barang.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")}</td>
               <td>${item.satuan}</td>
               <td>${item.jumlah_barang}</td>
               <td>${item.keterangan || '-'}</td>
            </tr>`);
				$tbody.append($row);
			});
			$table.append($thead).append($tbody);
			return $('<div class="table-responsive"></div>').append($table).prop('outerHTML');
		}

		$('#edit-inv').on('submit', function(e) {
			e.preventDefault();
			var id = $('#invoice-id-edit').val();
			$('#button-edit-inv').attr('disabled', true);
			let nomorInvoice = $('#nomor-invoice-edit option:selected').text();
			let tujuanPerusahaan = $('#tujuan-perusahaan-edit option:selected').val();
			let doIdList = [];
			$('#accordionDOEdit .form-check-input:checked').each(function() {
				let doId = $(this).data('id');
				if (doId) {
					doIdList.push(doId);
				}
			});
			if (doIdList.length === 0) {
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
					icon: "warning",
					title: "Pilih minimal satu DO untuk membuat invoice.",
				});
				$('#button-edit-inv').attr('disabled', false);
				return;
			}
			var formdata = new FormData();
			formdata.append('_method', 'PUT');
			formdata.append('nomor_invoice', nomorInvoice);
			formdata.append('perusahaan_id', tujuanPerusahaan);
			doIdList.forEach(doId => formdata.append('do_id[]', doId));
			console.log(doIdList);
			$.ajax({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				cache: false,
				contentType: false,
				processData: false,
				method: 'POST',
				url: "invoice/update-invoice/" + id,
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
						$('#nomor-invoice-edit').val('').trigger('change');
						$('#accordionDOEdit').find('.form-check-input:checked').prop('checked', false);
						$('#accordionDOEdit').find('.collapse').removeClass('show');
						$('#accordionDOEdit .accordion-button').addClass('collapsed');
						$('#modalEditInv').modal('hide');
						$('.modal-backdrop.fade.show').remove();
						$('#edit-inv')[0].reset();
						tableInvoice.ajax.reload(null, false);
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
						text: "Ada kesalahan",
					});
				},
				complete: function() {
					$('#button-edit-inv').attr('disabled', false);
				}
			});
		});

		function deleteDataInv(id) {
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
						url: "invoice/delete-invoice/" + id,
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
								tableInvoice.ajax.reload(null, false);
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

		function cetakInvoice(id) {
			let newUrl = 'invoice/cetak-invoice/' + id;
			window.open(newUrl, '_blank');
		}

		function formatNumber(input) {
			var inputVal = input.value.replace(/[^,\d]/g, '');
			var numberString = inputVal.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
			input.value = numberString;
		}

		$('#modalAddInv, #modalEditInv').on('hidden.bs.modal', function() {
			$('body').css('overflow', 'auto');
		});
		$('#modalAddInv, #modalEditInv').on('shown.bs.modal', function() {
			$('body').css('overflow', 'hidden');
		});
	</script>
@endsection
