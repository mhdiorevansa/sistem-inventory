@extends('layout.main-layout');
@section('content')
	<div id="main">
		<header class="mb-3">
			<a class="burger-btn d-block d-xl-none" href="#">
				<i class="bi bi-justify fs-3"></i>
			</a>
		</header>
		<div class="page-heading">
			<h3>Profile Statistics</h3>
		</div>
		<div class="page-content">
			<section class="row">
				<div class="col-12">
					<div class="row">
						<div class="col-12 col-lg-3 col-md-6">
							<div class="card">
								<div class="card-body py-4-5 px-4">
									<div class="row">
										<div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
											<h6 class="text-muted font-semibold">Profile Views</h6>
											<h6 class="mb-0 font-extrabold">112.000</h6>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-6 col-lg-3 col-md-6">
							<div class="card">
								<div class="card-body py-4-5 px-4">
									<div class="row">
										<div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
											<h6 class="text-muted font-semibold">Followers</h6>
											<h6 class="mb-0 font-extrabold">183.000</h6>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-6 col-lg-3 col-md-6">
							<div class="card">
								<div class="card-body py-4-5 px-4">
									<div class="row">
										<div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
											<h6 class="text-muted font-semibold">Following</h6>
											<h6 class="mb-0 font-extrabold">80.000</h6>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-6 col-lg-3 col-md-6">
							<div class="card">
								<div class="card-body py-4-5 px-4">
									<div class="row">
										<div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
											<h6 class="text-muted font-semibold">Saved Post</h6>
											<h6 class="mb-0 font-extrabold">112</h6>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-12">
							<div class="card">
								<div class="card-header">
									<h4>Profile Visit</h4>
								</div>
								<div class="card-body">
									<div id="chart-profile-visit"></div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>
		</div>
	</div>

	<script>
		$(document).ready(function() {
			var currentRoute = window.location.pathname;
			if (currentRoute == '/') {
				$('#menu-dashboard').addClass('active');
				$('#menu-penawaran', '#menu-do').removeClass('active');
			}
		});
	</script>
@endsection
