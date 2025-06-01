<?php
include('db_connect.php');
session_start();
if (isset($_GET['id'])) {
	$user = $conn->query("SELECT * FROM users where id =" . $_GET['id']);
	foreach ($user->fetch_array() as $k => $v) {
		$meta[$k] = $v;
	}
}
?>
<div class="container-fluid">
	<div id="msg"></div>

	<form id="manage-user" enctype="multipart/form-data">
		<input type="hidden" name="id" value="<?php echo isset($meta['id']) ? $meta['id'] : '' ?>">
		
		<div class="row">
			<div class="col-md-6" style="margin-top: 30px;">
				<div class="form-group">
					<label for="full_name" class="khmer-text">
						<span style="color: red;">*</span> ឈ្មោះពេញ
					</label>
					<input type="text" name="full_name" id="full_name" class="form-control khmer-text" value="<?php echo isset($meta['full_name']) ? $meta['full_name'] : '' ?>" required>
				</div>
			</div>
			<div class="col-md-6" style="margin-top: 30px;">
				<div class="form-group">
					<label for="address" class="khmer-text">
						<span style="color: red;">*</span> អាសយដ្ឋាន
					</label>
					<input type="text" name="address" id="address" class="form-control khmer-text" value="<?php echo isset($meta['address']) ? $meta['address'] : '' ?>" required autocomplete="off">
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-6" style="margin-top: 30px;">
				<div class="form-group">
					<label for="phone_number" class="khmer-text">
						<span style="color: red;">*</span> លេខទូរស័ព្ទ
					</label>
					<input type="text" name="phone_number" id="phone_number" class="form-control khmer-text" value="<?php echo isset($meta['phone_number']) ? $meta['phone_number'] : '' ?>" required autocomplete="off">
				</div>
			</div>
			<div class="col-md-6" style="margin-top: 30px;">
				<div class="form-group">
					<label for="email" class="khmer-text">
						<span style="color: red;">*</span> អ៊ីមែល
					</label>
					<input type="text" name="username" id="username" class="form-control khmer-text" value="<?php echo isset($meta['username']) ? $meta['username'] : '' ?>" required autocomplete="off">
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-6" style="margin-top: 30px;">
				<div class="form-group">
					<label for="password" class="khmer-text">
						<span style="color: red;">*</span> លេខសម្ងាត់
					</label>
					<input type="password" name="password" id="password" class="form-control khmer-text" value="" autocomplete="off">
					<?php if (isset($meta['id'])) : ?>
						<small class="khmer-text"><i>ទុកទំនេរនេះបើអ្នកមិនចង់ផ្លាស់ប្តូរលេខសម្ងាត់ទេ។</i></small>
					<?php endif; ?>
				</div>
			</div>
			<?php if (isset($meta['type']) && $meta['type'] == 4) : ?>
				<input type="hidden" name="type" value="3">
			<?php else : ?>
				<?php if (!isset($_GET['mtype'])) : ?>
					<div class="col-md-6" style="margin-top: 30px;">
						<div class="form-group">
							<label for="type" class="khmer-text">
								<span style="color: red;">*</span> តួនាទី
							</label>
							<select name="type" id="type" class="custom-select khmer-text">
								<option value="1" <?php echo isset($meta['type']) && $meta['type'] == 1 ? 'selected' : '' ?>>អ្នកគ្រប់គ្រង</option>
								<option value="2" <?php echo isset($meta['type']) && $meta['type'] == 2 ? 'selected' : '' ?>>អ្នកលក់</option>
								<option value="3" <?php echo isset($meta['type']) && $meta['type'] == 3 ? 'selected' : '' ?>>អ្នកគ្រប់គ្រង</option>
							</select>
						</div>
					</div>
				<?php endif; ?>
			<?php endif; ?>
		</div>

		<div class="row">
			<div class="col-md-6" style="margin-top: 30px;">
				<div class="form-group">
					<label for="image" class="khmer-text">
						<span style="color: red;">*</span> រូបភាព
					</label>
					<input class="form-control" name="old_image" type="hidden" value="<?php echo isset($meta['image']) ? $meta['image'] : '' ?>">
					<input type="file" id="image" name="image" onchange="showimg();" class="form-control-file" accept="image/*" value="<?php echo isset($meta['image']) ? $meta['image'] : '' ?>">
					<div class="mt-2">
						<img src="assets/uploads/<?php echo isset($meta['image']) ? $meta['image'] : 'default_avatar.jpg' ?>" id="picture" name="picture" width="100px" height="100px" class="rounded-circle border">
					</div>
				</div>
			</div>
		</div>
	</form>
</div>
<script>
	$('#manage-user').submit(function(e) {
		e.preventDefault();
		start_load();

		var formData = new FormData(this);
		if ($('#image')[0].files[0]) {
			formData.append('image', $('#image')[0].files[0]); // Append the image file to the form data
		}

		$.ajax({
			url: 'ajax.php?action=save_user',
			method: 'POST',
			data: formData,
			processData: false,
			contentType: false,
			success: function(resp) {
				if (resp == 1) {
					// Check if this is an edit or create operation
					if ($('[name="id"]').val() > 0) {
						// Edit operation
						try {
							// Call parent window's edit_success function if it exists
							if (window.parent && typeof window.parent.edit_success === 'function') {
								window.parent.edit_success();
							} else {
								$('#alert_toast').removeClass('bg-success create-success delete-success').addClass('edit-success');
								alert_toast("ទិន្នន័យត្រូវបានកែប្រែដោយជោគជ័យ", 'success');
							}
						} catch (e) {
							// Fallback if parent function call fails
							alert_toast("ទិន្នន័យត្រូវបានកែប្រែដោយជោគជ័យ", 'success');
						}
					} else {
						// Create operation
						try {
							// Call parent window's create_success function if it exists
							if (window.parent && typeof window.parent.create_success === 'function') {
								window.parent.create_success();
							} else {
								$('#alert_toast').removeClass('bg-success edit-success delete-success').addClass('create-success');
								alert_toast("ទិន្នន័យបានរក្សាទុកដោយជោគជ័យ", 'success');
							}
						} catch (e) {
							// Fallback if parent function call fails
							alert_toast("ទិន្នន័យបានរក្សាទុកដោយជោគជ័យ", 'success');
						}
					}

					setTimeout(function() {
						location.reload();
					}, 1500);
				} else {
					$('#msg').html('<div class="alert alert-danger khmer-text">អ៊ីមែលនេះមានរួចហើយ</div>');
					end_load();
				}
			},
			error: function(xhr, status, error) {
				$('#msg').html('<div class="alert alert-danger khmer-text">មានបញ្ហា: ' + error + '</div>');
				end_load();
			}
		});
	});
</script>
<script type="text/javascript">
	function showimg() {
		// Display Image preview when file is selected
		var input = document.getElementById("image");
		if (input.files && input.files[0]) {
			var fReader = new FileReader();
			fReader.readAsDataURL(input.files[0]);
			fReader.onloadend = function(event) {
				var img = document.getElementById("picture");
				img.src = event.target.result;
			}
		}
	}

	// Initialize tooltips if any exist on this page
	$(document).ready(function() {
		$('[data-toggle="tooltip"]').tooltip();
	});
</script>

<style>
	/* Form styling */
	.form-group label {
		font-weight: 600;
		color: #555;
	}

	/* Required field indicator */
	.form-group label span {
		margin-right: 4px;
	}

	/* Image preview container */
	.mt-2 img {
		object-fit: cover;
		border: 3px solid #f8f9fa;
		box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
		transition: all 0.3s ease;
	}

	/* Alert styling */
	.alert {
		border-radius: 8px;
		padding: 12px 15px;
	}

	/* Khmer text class */
	.khmer-text {
		font-family: 'Kantumruy Pro', sans-serif;
	}
</style>