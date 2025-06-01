<!DOCTYPE html>
<html lang="km">
<?php
session_start();
include('./db_connect.php');
ob_start();
$system = $conn->query("SELECT * FROM users limit 1")->fetch_array();
foreach ($system as $k => $v) {
	$_SESSION['system'][$k] = $v;
}
ob_end_flush();
?>

<head>
	<meta charset="utf-8">
	<meta content="width=device-width, initial-scale=1.0" name="viewport">
	<meta name="description" content="ភោជនីយដ្ឋានមរកត - ប្រព័ន្ធគ្រប់គ្រងភោជនីយដ្ឋាន">
	<meta name="author" content="មរកត">

	<title>ភោជនីយដ្ឋានមរកត</title>

	<!-- Add Kantumruy Pro font - exact same as categories.php -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Kantumruy+Pro:ital,wght@0,100..700;1,100..700&display=swap" rel="stylesheet">

	<?php include('./header.php'); ?>
	<?php
	if (isset($_SESSION['login_id']))
		header("location:index.php?page=home");
	?>

</head>
<style>
	/* Base styles */
	* {
		font-family: 'Kantumruy Pro', sans-serif !important;
		-webkit-font-smoothing: antialiased;
		-moz-osx-font-smoothing: grayscale;
	}

	body {
		width: 100%;
		height: calc(100%);
		position: fixed;
		top: 0;
		left: 0;
		background-color: #222222;
		font-size: 20px;
		margin: 0;
		padding: 0;
		overflow-x: hidden;
	}

	/* Ensure Khmer text class is properly applied */
	.khmer-text,
	.text-light,
	.text-center,
	.form-control,
	.btn,
	.alert,
	label,
	.card-title,
	.card-text,
	.form-check-label,
	.input-group-text,
	.alert-danger,
	#btn_login,
	.alert-danger.khmer-text,
	.form-control::placeholder,
	.btn:disabled,
	.brand-image,
	.card-header,
	.card-body,
	.modal-title,
	.modal-body,
	.tooltip-inner {
		font-family: 'Kantumruy Pro', sans-serif !important;
		-webkit-font-smoothing: antialiased;
		-moz-osx-font-smoothing: grayscale;
	}

	/* Alert styling */
	.alert {
		font-size: 16px;
		padding: 15px 20px;
		margin: 0;
		border: none;
		border-radius: 5px;
		animation: slideIn 0.5s ease-out;
		position: fixed;
		top: 20px;
		right: 20px;
		z-index: 9999;
		min-width: 300px;
		max-width: 400px;
		box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
	}

	.alert-success {
		background-color: #28a745;
		color: white;
	}

	.alert-danger {
		background-color: #dc3545;
		color: white;
	}

	@keyframes slideIn {
		from {
			opacity: 0;
			transform: translateX(100%);
		}

		to {
			opacity: 1;
			transform: translateX(0);
		}
	}

	@keyframes slideOut {
		from {
			opacity: 1;
			transform: translateX(0);
		}

		to {
			opacity: 0;
			transform: translateX(100%);
		}
	}

	.alert-dismissible {
		padding-right: 40px;
	}

	.alert .close {
		color: white;
		opacity: 0.8;
		text-shadow: none;
		position: absolute;
		right: 10px;
		top: 50%;
		transform: translateY(-50%);
	}

	.alert .close:hover {
		opacity: 1;
	}

	/* Responsive alert adjustments */
	@media (max-width: 576px) {
		.alert {
			left: 20px;
			right: 20px;
			min-width: auto;
			max-width: none;
		}
	}

	/* Rest of your existing styles... */
	main#main {
		width: 100%;
		height: calc(100%);
		display: flex;
		justify-content: center;
		align-items: center;
	}

	/* Card styling */
	.card {
		background-color: #2a2a2a;
		border: none;
		border-radius: 10px;
		box-shadow: 0 4px 20px rgba(0, 0, 0, 0.4);
		transition: transform 0.3s ease;
	}

	.card:hover {
		transform: translateY(-5px);
	}

	.card-body {
		padding: 2rem;
	}

	/* Form elements styling */
	.form-control {
		font-size: 16px !important;
		background-color: #333333 !important;
		border: none !important;
		color: #ffffff !important;
		padding: 12px 15px;
		transition: all 0.3s ease;
	}

	.form-control:focus {
		box-shadow: 0 0 0 2px rgba(0, 123, 255, 0.25);
		background-color: #404040 !important;
	}

	.form-control::placeholder {
		color: #999;
		font-size: 16px;
		opacity: 1;
	}

	.input-group-text {
		background-color: #333333 !important;
		border: none !important;
		color: #ffffff !important;
		padding: 12px 15px;
	}

	/* Button styling */
	.btn {
		font-size: 18px;
		font-weight: 500;
		padding: 12px 20px;
		transition: all 0.3s ease;
		background-color: #333333 !important;
		border-color: #222222 !important;
	}

	.btn:hover {
		background-color: #404040 !important;
		transform: translateY(-2px);
	}

	/* Checkbox styling */
	.form-check-input {
		width: 18px;
		height: 18px;
		margin-top: 0.3rem;
	}

	.form-check-label {
		font-size: 16px;
		color: #f8f9fa;
		margin-left: 0.5rem;
	}

	/* Responsive adjustments */
	@media (max-width: 768px) {
		.card {
			margin: 1rem;
		}

		.card-body {
			padding: 1.5rem;
		}

		.form-control,
		.input-group-text {
			padding: 10px 12px;
		}

		.btn {
			padding: 10px 15px;
			font-size: 16px;
		}
	}

	/* Loading state */
	.btn:disabled {
		opacity: 0.7;
		cursor: not-allowed;
		transform: none;
	}

	/* Brand image */
	.brand-image {
		max-width: 300px;
		height: auto;
		margin-bottom: 2rem;
		transition: transform 0.3s ease;
	}

	.brand-image:hover {
		transform: scale(1.02);
	}

	/* Additional font-specific styles */
	.form-control::placeholder {
		font-family: 'Kantumruy Pro', sans-serif !important;
		font-size: 16px;
		opacity: 1;
	}

	.alert-danger.khmer-text {
		font-family: 'Kantumruy Pro', sans-serif !important;
		font-size: 16px;
		font-weight: 500;
	}

	#btn_login {
		font-family: 'Kantumruy Pro', sans-serif !important;
		font-weight: 500;
		letter-spacing: 0.5px;
	}

	/* Ensure proper font rendering for Khmer text */
	.khmer-text {
		font-family: 'Kantumruy Pro', sans-serif !important;
		font-weight: 400;
		line-height: 1.5;
		-webkit-font-smoothing: antialiased;
		-moz-osx-font-smoothing: grayscale;
	}

	/* Force font on specific elements that might be overridden */
	.card-header b,
	.alert-danger,
	.form-check-label,
	.input-group-text i,
	.btn i,
	.tooltip-inner {
		font-family: 'Kantumruy Pro', sans-serif !important;
	}

	/* Ensure proper font loading for dynamic content */
	[class*="khmer-text"],
	[class*="text-"] {
		font-family: 'Kantumruy Pro', sans-serif !important;
	}
</style>

<body style="background-color: #222222;">
	<main id="main">
		<div class="container h-100">
			<div id="login-center" class="row justify-content-center">
				<div class="col-md-4">
					<div class="card w-100" style="margin-top: 80px;">
						<div class="card-body">
							<h4 class="text-light text-center mb-5">
								<img src="assets/uploads/brand3.png" alt="ភោជនីយដ្ឋានមរកត" class="brand-image">
							</h4>
							<!-- Hidden logout parameter check -->
							<?php if(isset($_GET['logout']) && $_GET['logout'] == 'success'): ?>
							<div class="alert alert-danger khmer-text alert-dismissible fade show" role="alert" id="logout-alert">
								ចាកចេញពីគណនីបានជោគជ័យ
								<button type="button" class="close" data-dismiss="alert" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<?php endif; ?>
							<form id="login-form" autocomplete="off" style="margin-top: -70px;">
								<div class="form-group">
									<div class="input-group mb-3">
										<div class="input-group-prepend">
											<div class="input-group-text">
												<i class="fa fa-user" aria-hidden="true"></i>
											</div>
										</div>
										<input type="email"
											id="username"
											name="username"
											class="form-control khmer-text"
											placeholder="ឈ្មោះគណនី"
											pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$"
											required
											aria-label="ឈ្មោះគណនី">
									</div>
								</div>
								<div class="form-group">
									<div class="input-group mb-3">
										<div class="input-group-prepend">
											<div class="input-group-text">
												<i class="fa fa-lock" aria-hidden="true"></i>
											</div>
										</div>
										<input type="password"
											id="password"
											name="password"
											class="form-control khmer-text"
											placeholder="ពាក្យសម្ងាត់"
											required
											aria-label="ពាក្យសម្ងាត់">
									</div>
								</div>
								<!-- <div class="form-check py-3">
									<input type="checkbox"
										class="form-check-input"
										id="rememberMe"
										aria-label="ចងចាំខ្ញុំ">
									<label class="form-check-label khmer-text" for="rememberMe">ចងចាំខ្ញុំ</label>
								</div> -->
								<button type="submit" style="margin-top: 10px;"
									class="btn btn-dark khmer-text w-100"
									id="btn_login"
									aria-label="ចូលគណនី">ចូលគណនី</button>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</main>

	<a href="#" class="back-to-top" aria-label="ត្រឡប់ទៅផ្នែកខាងលើ"><i class="icofont-simple-up"></i></a>
</body>

<script>
	$(document).ready(function() {
		// Function to show alert with animation
		function showAlert(message, type = 'danger') {
			const alertHtml = `<div class="alert alert-${type} khmer-text alert-dismissible fade show" role="alert">
				${message}
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>`;

			// Remove any existing alerts
			$('.alert').remove();

			// Add new alert to body instead of form
			$('body').append(alertHtml);

			// Auto dismiss after 5 seconds for success alerts
			if (type === 'success') {
				setTimeout(() => {
					const alert = $('.alert');
					alert.css('animation', 'slideOut 0.5s ease-out forwards');
					setTimeout(() => {
						alert.remove();
					}, 500);
				}, 5000);
			}
		}
		
		// Auto dismiss logout alert after 5 seconds
		if ($('#logout-alert').length) {
			setTimeout(() => {
				const alert = $('#logout-alert');
				alert.css('animation', 'slideOut 0.5s ease-out forwards');
				setTimeout(() => {
					alert.remove();
				}, 500);
			}, 5000);
		}
		// Force Khmer font on dynamically added elements
		function applyKhmerFont() {
			$('.alert-danger, .form-control, .btn, .khmer-text, .text-light, .text-center').css({
				'font-family': "'Kantumruy Pro', sans-serif !important",
				'-webkit-font-smoothing': 'antialiased',
				'-moz-osx-font-smoothing': 'grayscale'
			});
		}

		// Apply font on page load
		applyKhmerFont();

		// Apply font after AJAX calls
		$(document).ajaxComplete(function() {
			applyKhmerFont();
		});

		// Prevent form submission on enter key
		$('#login-form').on('keypress', function(e) {
			if (e.which === 13) {
				e.preventDefault();
				$('#btn_login').click();
			}
		});

		$('#login-form').submit(function(e) {
			e.preventDefault();
			const $btn = $('#btn_login');
			const originalText = $btn.html();

			$btn.prop('disabled', true)
				.html('<i class="fa fa-spinner fa-spin"></i> កំពុងចូលគណនី...');

			$.ajax({
				url: 'ajax.php?action=login',
				method: 'POST',
				data: $(this).serialize(),
				error: err => {
					console.error(err);
					$btn.prop('disabled', false).html(originalText);
					showAlert('មានបញ្ហាក្នុងការភ្ជាប់ទំនាក់ទំនង សូមព្យាយាមម្តងទៀត។');
				},
				success: function(resp) {
					if (resp == 1) {
						showAlert('ចូលគណនីជោគជ័យ! កំពុងចូលទំព័រ...', 'success');
						setTimeout(() => {
							location.href = 'index.php';
						}, 1500);
					} else {
						$btn.prop('disabled', false).html(originalText);
						showAlert('គណនី ឬពាក្យសម្ងាត់មិនត្រឹមត្រូវ');
					}
				}
			});
		});

		// Add loading animation to button
		$('#btn_login').on('click', function() {
			if ($('#login-form').valid()) {
				$(this).html('<i class="fa fa-spinner fa-spin"></i> កំពុងចូលគណនី...');
			}
		});
	});
</script>

</html>