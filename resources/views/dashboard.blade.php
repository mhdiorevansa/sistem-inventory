@extends('layout.main-layout');
@section('content')
	<div id="main">
		<header class="mb-3">
			<a class="burger-btn d-block d-xl-none" href="#">
				<i class="bi bi-justify fs-3"></i>
			</a>
		</header>
		<div class="page-heading">
			<h3>Dashboard</h3>
		</div>
		<div class="page-content">
			<section class="row">
				<div class="col-12">
					<div class="row">
						<div class="col-6">
							<div class="card">
								<div class="card-body py-4-5 px-4">
									<div class="row">
										<div class="col-md-12">
											<h5 class="font-semibold" id="title-pemasukan">Total Pemasukan Bulan Ini</h5>
											<h5 class="mb-0 font-bold" id="total-pemasukan">Rp. {{ number_format($totalPemasukan, 0, ',', '.') }}
											</h5>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-6">
							<div class="card">
								<div class="card-body py-4-5 px-4">
									<div class="row">
										<div class="col-md-12">
											<h5 class="font-semibold" id="title-pengeluaran">Total Pengeluaran Bulan Ini</h5>
											<h5 class="mb-0 font-bold" id="total-pengeluaran">Rp. {{ number_format($totalPengeluaran, 0, ',', '.') }}
											</h5>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-12">
							<div
								class="card {{ $untungRugi < 0 ? 'bg-danger-subtle' : ($untungRugi === 0 ? 'bg-secondary-subtle' : 'bg-success-subtle') }}"
								id="card-untungrugi">
								<div class="card-body py-4-5 px-4">
									<div class="row">
										<div class="col-md-12">
											<h5 class="font-semibold" id="title-untungrugi">
												{{ $untungRugi < 0 ? 'Perusahaan Mengalami Kerugian' : ($untungRugi === 0 ? 'Perusahaan Tidak Ada Keuntungan atau Kerugian' : 'Perusahaan Memiliki Keuntungan') }}
											</h5>
											<h5 class="mb-0 font-bold" id="total-untungrugi">Rp. {{ number_format($untungRugi, 0, ',', '.') }}
											</h5>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-12">
							<div class="card">
								<div class="card-header d-flex justify-content-between pt-4">
									<h4 id="statistik-title">Data Statistik Bulan Ini</h4>
									<div class="dropdown-center">
										<button class="dropdown-toggle border-0 bg-transparent p-0" data-bs-toggle="dropdown" type="button"
											aria-expanded="false">
											<svg class="feather feather-filter" xmlns="http://www.w3.org/2000/svg" width="21" height="21"
												viewBox="0 0 21 21" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round"
												stroke-linejoin="round">
												<polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon>
											</svg>
										</button>
										<ul class="dropdown-menu">
											<li><a class="dropdown-item" href="javascript:void(0)" onclick="filterChartTotalPenjualan('this-month')">Bulan
													Ini</a></li>
											<li><a class="dropdown-item" href="javascript:void(0)" onclick="filterChartTotalPenjualan('last-month')">Bulan
													Lalu</a></li>
										</ul>
									</div>
								</div>
								<div class="card-body">
									<canvas id="lineChart" width="400" height="180"></canvas>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>
		</div>
	</div>

	<script>
		let lineChart;
		$(document).ready(function() {
			const ctx = document.getElementById('lineChart').getContext('2d');
			lineChart = new Chart(ctx, {
				type: 'line',
				data: {
					labels: @json($days),
					datasets: [{
							label: 'Pemasukan',
							data: @json($dailyDataPemasukan),
							borderColor: 'rgba(75, 192, 192, 1)',
							backgroundColor: 'rgba(75, 192, 192, 0.2)',
							borderWidth: 2,
							fill: false,
							// tension: 0.4
						},
						{
							label: 'Pengeluaran',
							data: @json($dailyDataPengeluaran),
							borderColor: 'rgba(255, 99, 132, 1)',
							backgroundColor: 'rgba(255, 99, 132, 0.2)',
							borderWidth: 2,
							fill: false,
							// tension: 0.4
						}
					]
				},
				options: {
					responsive: true,
					plugins: {
						legend: {
							display: true,
						},
					},
					scales: {
						x: {
							beginAtZero: true
						},
						y: {
							beginAtZero: true,
						}
					}
				}
			});

			var currentRoute = window.location.pathname;
			if (currentRoute == '/dashboard') {
				$('#menu-dashboard').addClass('active');
				$('#menu-penawaran', '#menu-do', '#menu-invoice', '#menu-exportsql', '#menu-pembelian-barang')
					.removeClass('active');
			}
		});

		function filterChartTotalPenjualan(month) {
			$.ajax({
				url: 'dashboard/filter-chart',
				type: "GET",
				data: {
					month: month
				},
				success: function(response) {
					if (response.status === 'success') {
						lineChart.data.labels = response.days;
						lineChart.data.datasets[0].data = response.dailyDataPemasukan;
						lineChart.data.datasets[1].data = response.dailyDataPengeluaran;
						lineChart.update();
						const untungRugi = response.untungRugi;
						const cardElement = $('#card-untungrugi');
						const titleElement = $('#title-untungrugi');
						const totalElement = $('#total-untungrugi');
						if (untungRugi < 0) {
							cardElement.removeClass('bg-success-subtle bg-secondary-subtle').addClass(
								'bg-danger-subtle');
							titleElement.text('Perusahaan Mengalami Kerugian');
						} else if (untungRugi === 0) {
							cardElement.removeClass('bg-danger-subtle bg-success-subtle').addClass(
								'bg-secondary-subtle');
							titleElement.text('Perusahaan Tidak Ada Keuntungan atau Kerugian');
						} else {
							cardElement.removeClass('bg-danger-subtle bg-secondary-subtle').addClass(
								'bg-success-subtle');
							titleElement.text('Perusahaan Memiliki Keuntungan');
						}
						totalElement.text(
							`Rp. ${Math.abs(untungRugi).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")}`);
						let titleStatistik = "Data Statistik";
						let titlePemasukan = "Total Pemasukan Bulan Ini";
						let titlePengeluaran = "Total Pengeluaran Bulan Ini";
						if (month == 'this-month') {
							titleStatistik = "Data Statistik Bulan ini";
							titlePemasukan = "Total Pemasukan Bulan Ini";
							titlePengeluaran = "Total Pengeluaran Bulan Lalu";
						} else {
							titleStatistik = "Data Statistik Bulan Lalu";
							titlePemasukan = "Total Pemasukan Bulan Lalu";
							titlePengeluaran = "Total Pengeluaran Bulan lalu";
						}
						$('#statistik-title').text(titleStatistik);
						$('#title-pemasukan').text(titlePemasukan);
						$('#title-pengeluaran').text(titlePengeluaran);
						$('#total-pemasukan').text(
							`Rp. ${response.totalPemasukan.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")}`)
						$('#total-pengeluaran').text(
							`Rp. ${response.totalPengeluaran.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")}`
						)
					} else {
						console.log(response.message);
					}
				},
				error: function(xhr) {
					console.error("Error fetching filtered data:", xhr);
				}
			});
		}
	</script>
@endsection
