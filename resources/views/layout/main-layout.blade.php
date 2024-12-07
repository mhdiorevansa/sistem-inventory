<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="csrf-token" content="{{ csrf_token() }}">

		<title>Sistem Inventory</title>

		<link type="image/x-icon" href="{{ asset('img/logo.png') }}" rel="icon">
		<link href="{{ asset('css/app.css') }}" rel="stylesheet">
		<link href="{{ asset('css/app-dark.css') }}" rel="stylesheet">
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
			integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
		<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css"
			rel="stylesheet"
			integrity="sha512-dPXYcDub/aeb08c63jRq/k6GaKccl256JQy/AnOq7CAnEZ9FzSL9wSbcZkMp4R26vBsMLFYH4kQ67/bbV8XaCQ=="
			crossorigin="anonymous" referrerpolicy="no-referrer" />
		<link href="https://cdn.datatables.net/v/dt/dt-2.1.8/datatables.min.css" rel="stylesheet">
		<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
		<link href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@x.x.x/dist/select2-bootstrap4.min.css"
			rel="stylesheet">
		<script src="https://code.jquery.com/jquery-3.7.1.min.js"
			integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
		<script src="https://cdn.datatables.net/v/dt/dt-2.1.8/datatables.min.js"></script>

		<style>
			.sidebar-wrapper .menu {
				padding: 0 2rem;
				font-weight: 600;
			}

			.sidebar-wrapper .sidebar-header {
				padding: 2rem 2rem 0rem;
				font-size: 2rem;
				font-weight: 700;
			}

			.dt-length {
				display: flex;
				gap: 7px;
				align-items: center;
			}

			.dt-search {
				display: flex;
				gap: 7px;
				align-items: center;
			}

			.dropstart .dropdown-toggle::before {
				display: none;
			}
		</style>
	</head>

	<body>
		<div id="app">
			<div id="sidebar">
				<div class="sidebar-wrapper active">
					<div class="sidebar-header position-relative">
						<div class="d-flex justify-content-between align-items-center">
							<div class="">
								<a href="index.html"><img src="{{ asset('img/logo.png') }}" srcset="{{ asset('img/logo.png') }}"" alt="Logo"
										style="height: 7rem">
								</a>
							</div>
							<div class="theme-toggle d-flex align-items-center mt-2 gap-2">
								<svg class="iconify iconify--system-uicons" role="img" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
									xmlns:xlink="http://www.w3.org/1999/xlink" width="20" height="20" preserveAspectRatio="xMidYMid meet"
									viewBox="0 0 21 21">
									<g fill="none" fill-rule="evenodd" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
										<path
											d="M10.5 14.5c2.219 0 4-1.763 4-3.982a4.003 4.003 0 0 0-4-4.018c-2.219 0-4 1.781-4 4c0 2.219 1.781 4 4 4zM4.136 4.136L5.55 5.55m9.9 9.9l1.414 1.414M1.5 10.5h2m14 0h2M4.135 16.863L5.55 15.45m9.899-9.9l1.414-1.415M10.5 19.5v-2m0-14v-2"
											opacity=".3"></path>
										<g transform="translate(-210 -1)">
											<path d="M220.5 2.5v2m6.5.5l-1.5 1.5"></path>
											<circle cx="220.5" cy="11.5" r="4"></circle>
											<path d="m214 5l1.5 1.5m5 14v-2m6.5-.5l-1.5-1.5M214 18l1.5-1.5m-4-5h2m14 0h2"></path>
										</g>
									</g>
								</svg>
								<div class="form-check form-switch fs-6">
									<input class="form-check-input me-0" id="toggle-dark" type="checkbox" style="cursor: pointer">
									<label class="form-check-label"></label>
								</div>
								<svg class="iconify iconify--mdi" role="img" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
									xmlns:xlink="http://www.w3.org/1999/xlink" width="20" height="20" preserveAspectRatio="xMidYMid meet"
									viewBox="0 0 24 24">
									<path fill="currentColor"
										d="m17.75 4.09l-2.53 1.94l.91 3.06l-2.63-1.81l-2.63 1.81l.91-3.06l-2.53-1.94L12.44 4l1.06-3l1.06 3l3.19.09m3.5 6.91l-1.64 1.25l.59 1.98l-1.7-1.17l-1.7 1.17l.59-1.98L15.75 11l2.06-.05L18.5 9l.69 1.95l2.06.05m-2.28 4.95c.83-.08 1.72 1.1 1.19 1.85c-.32.45-.66.87-1.08 1.27C15.17 23 8.84 23 4.94 19.07c-3.91-3.9-3.91-10.24 0-14.14c.4-.4.82-.76 1.27-1.08c.75-.53 1.93.36 1.85 1.19c-.27 2.86.69 5.83 2.89 8.02a9.96 9.96 0 0 0 8.02 2.89m-1.64 2.02a12.08 12.08 0 0 1-7.8-3.47c-2.17-2.19-3.33-5-3.49-7.82c-2.81 3.14-2.7 7.96.31 10.98c3.02 3.01 7.84 3.12 10.98.31Z">
									</path>
								</svg>
							</div>
							<div class="sidebar-toggler x">
								<a class="sidebar-hide d-xl-none d-block" href="#"><i class="bi bi-x bi-middle"></i></a>
							</div>
						</div>
					</div>
					<div class="sidebar-menu">
						<ul class="menu">
							<li class="sidebar-title">Menu</li>
							<li class="sidebar-item" id="menu-dashboard">
								<a class='sidebar-link' href="/dashboard">
									<i class="bi bi-grid-fill"></i>
									<span>Dashboard</span>
								</a>
							</li>
							<li class="sidebar-item" id="menu-penawaran">
								<a class='sidebar-link' href="/penawaran">
									<i class="bi bi-file-earmark-bar-graph-fill"></i>
									<span>Penawaran</span>
								</a>
							</li>
							<li class="sidebar-item" id="menu-do">
								<a class='sidebar-link' href="/delivery-order">
									<i class="bi bi-truck"></i>
									<span>Delivery Order</span>
								</a>
							</li>
							<li class="sidebar-item" id="menu-invoice">
								<a class='sidebar-link' href="/invoice">
									<i class="bi bi-receipt"></i>
									<span>Invoice</span>
								</a>
							</li>
							<li class="sidebar-item" id="menu-pembelian-barang">
								<a class='sidebar-link' href="/pembelian-barang">
									<i class="bi bi-bag"></i>
									<span>Pembelian Barang</span>
								</a>
							</li>
							<li class="sidebar-item" id="menu-exportsql">
								<a class='sidebar-link' href="/backup-db">
									<i class="bi bi-database-up"></i>
									<span>Backup Database</span>
								</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
			@yield('content')
		</div>

		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
			integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
		</script>
		<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
			integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
		</script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
			integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous">
		</script>
		<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
		<script src="{{ asset('js/dark.js') }}"></script>
		<script src="{{ asset('js/perfect-scrollbar.min.js') }}"></script>
		<script src="{{ asset('js/app.js') }}"></script>
		<script src="{{ asset('js/dashboard.js') }}"></script>
	</body>

</html>
