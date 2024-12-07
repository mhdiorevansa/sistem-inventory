@extends('layout.main-layout')
@section('content')
    <div id="main">
		<header class="mb-3">
			<a class="burger-btn d-block d-xl-none" href="#">
				<i class="bi bi-justify fs-3"></i>
			</a>
		</header>
		<div class="page-heading">
			<h3>Backup Database</h3>
		</div>
		<div class="page-content">
			<section class="row">
				<div class="col-12 bg-warning-subtle px-3 py-4 rounded-3">
					<h4>
                  <i class="bi bi-exclamation-triangle"></i>
                  <span>Peringatan</span>
               </h4>
               <p class="text-justify">Backup database harus dilakukan secara rutin untuk menghindari kehilangan data yang penting. Pastikan Anda memiliki akses ke folder tempat Anda akan menyimpan backup database. Jika Anda tidak memiliki akses ke folder tersebut, maka Anda tidak dapat melakukan backup database.</p>
               <a href="/backup-db/backup" target="_blank" class="btn btn-primary" id="backup-db">Backup Database</a>
				</div>
			</section>
		</div>
	</div>

   <script>
      $(document).ready(function() {
         var currentRoute = window.location.pathname;
			if (currentRoute == '/backup-db') {
				$('#menu-exportsql').addClass('active');
				$('#menu-penawaran', '#menu-do', '#menu-invoice', '#menu-dashboard', '#menu-pembelian-barang')
					.removeClass('active');
			}
      });

      // $('#backup-db').on('click', function(e) {
      //    e.preventDefault();
      //    $('#backup-db').attr('disabled', true);
      //    $.ajax({
      //       url: '/backup-db/backup',
      //       method: 'GET',
      //       success: function(response) {
      //          if(response.status === 'success') {
      //             const Toast = Swal.mixin({
		// 					toast: true,
		// 					position: "top-end",
		// 					showConfirmButton: false,
		// 					timer: 2000,
		// 					timerProgressBar: true,
		// 					didOpen: (toast) => {
		// 						toast.onmouseenter = Swal.stopTimer;
		// 						toast.onmouseleave = Swal.resumeTimer;
		// 					},
		// 				});
		// 				Toast.fire({
		// 					icon: "success",
		// 					title: response.message,
		// 				});
      //          } else {
      //             const Toast = Swal.mixin({
		// 					toast: true,
		// 					position: "top-end",
		// 					showConfirmButton: false,
		// 					timer: 2000,
		// 					timerProgressBar: true,
		// 					didOpen: (toast) => {
		// 						toast.onmouseenter = Swal.stopTimer;
		// 						toast.onmouseleave = Swal.resumeTimer;
		// 					},
		// 				});
		// 				Toast.fire({
		// 					icon: "error",
		// 					title: response.message,
		// 				});
      //          }
      //       },
      //       error: function(xhr) {
		// 			console.error(xhr.responseJSON);
		// 			const Toast = Swal.mixin({
		// 				toast: true,
		// 				position: "top-end",
		// 				showConfirmButton: false,
		// 				timer: 2000,
		// 				timerProgressBar: true,
		// 				didOpen: (toast) => {
		// 					toast.onmouseenter = Swal.stopTimer;
		// 					toast.onmouseleave = Swal.resumeTimer;
		// 				},
		// 			});
		// 			Toast.fire({
		// 				icon: "error",
		// 				title: "Terjadi kesalahan saat backup database.",
		// 			});
		// 		},
      //       complete: function() {
		// 			$('#backup-db').attr('disabled', false);
		// 		}
      //    })
      // });
   </script>
@endsection