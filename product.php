<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Kantumruy+Pro:ital,wght@0,100..700;1,100..700&display=swap" rel="stylesheet">

<style>
	body {
		font-family: 'Kantumruy Pro', sans-serif;
		font-size: 20px;
	}

	.khmer-text {
		font-family: 'Kantumruy Pro', sans-serif !important;
	}

	.card-header {
		font-size: 20px;
		font-weight: 500;
	}

	/* Specific column alignments */
	.table th:nth-child(1),
	/* Number column */
	.table td:nth-child(1) {
		text-align: center;
		width: 80px;
	}

	/* Hover effect on rows */
	.table tbody tr:hover td {
		background-color: #f8f9fa;
		transition: background-color 0.2s ease;
	}

	/* Make the table more compact */
	.card-body {
		padding: 1.25rem;
	}

	.table td,
	.table th {
		padding: 0.75rem;
	}

	/* Modern DataTables Styling */
	.dataTables_wrapper .dataTables_length select {
		padding: 5px 10px;
		border: 1px solid #ddd;
		border-radius: 4px;
		background-color: white;
		font-family: 'Kantumruy Pro', sans-serif;
	}

	.dataTables_wrapper .dataTables_filter input {
		padding: 5px 10px;
		border: 1px solid #ddd;
		border-radius: 4px;
		margin-left: 5px;
		font-family: 'Kantumruy Pro', sans-serif;
	}

	.dataTables_wrapper .dataTables_info {
		padding: 10px 0;
		font-family: 'Kantumruy Pro', sans-serif;
		color: #666;
	}

	.dataTables_wrapper .dataTables_paginate {
		padding: 10px 0;
	}

	.dataTables_wrapper .dataTables_paginate .paginate_button {
		padding: 5px 10px;
		margin: 0 2px;
		border: 1px solid #ddd;
		border-radius: 4px;
		background: white;
		color: #333 !important;
		cursor: pointer;
		transition: all 0.3s ease;
	}

	.dataTables_wrapper .dataTables_paginate .paginate_button:hover {
		background: #007bff !important;
		color: white !important;
		border-color: #007bff;
	}

	.dataTables_wrapper .dataTables_paginate .paginate_button.current {
		background: #007bff !important;
		color: white !important;
		border-color: #007bff;
	}

	.dataTables_wrapper .dataTables_paginate .paginate_button.disabled {
		color: #999 !important;
		cursor: not-allowed;
	}

	/* Make the controls more compact */
	.dataTables_wrapper .row {
		margin: 0;
		padding: 10px 0;
	}

	.dataTables_wrapper .col-sm-12 {
		padding: 0;
	}

	/* Style the search label */
	.dataTables_wrapper .dataTables_filter label {
		font-family: 'Kantumruy Pro', sans-serif;
		color: #666;
	}

	/* Style the length label */
	.dataTables_wrapper .dataTables_length label {
		font-family: 'Kantumruy Pro', sans-serif;
		color: #666;
	}

	/* Hide info section */
	.dataTables_info {
		display: none !important;
	}

	/* Update pagination button styles for icons */
	.dataTables_wrapper .dataTables_paginate .paginate_button {
		padding: 5px 12px;
		margin: 0 2px;
		border: 1px solid #ddd;
		border-radius: 4px;
		background: white;
		color: #333 !important;
		cursor: pointer;
		transition: all 0.3s ease;
		min-width: 32px;
		text-align: center;
	}

	.dataTables_wrapper .dataTables_paginate .paginate_button i {
		font-size: 14px;
		line-height: 1;
	}

	/* Hide the "Showing X to Y of Z entries" text */
	.dataTables_wrapper .dataTables_info {
		display: none !important;
	}

	/* Add placeholder styling */
	.dataTables_wrapper .dataTables_filter input::placeholder {
		color: #999;
		font-style: italic;
		font-family: 'Kantumruy Pro', sans-serif !important;
	}

	/* Ensure search input uses Khmer font */
	.dataTables_wrapper .dataTables_filter input,
	.dataTables_wrapper .dataTables_filter input.khmer-text {
		font-family: 'Kantumruy Pro', sans-serif !important;
		font-size: 16px !important;
		-webkit-font-smoothing: antialiased;
		-moz-osx-font-smoothing: grayscale;
	}

	/* Override any potential conflicting styles */
	.dataTables_filter input[type="search"] {
		font-family: 'Kantumruy Pro', sans-serif !important;
	}

	/* Toast styling for different operations */
	#alert_toast .toast-body {
		font-size: 18px;
		font-weight: bold;
		padding: 15px;
		font-family: 'Kantumruy Pro', sans-serif;
	}

	#alert_toast {
		max-width: 400px;
	}

	/* Custom toast colors for different operations */
	#alert_toast.create-success {
		background-color: #28a745 !important;
	}

	#alert_toast.edit-success {
		background-color: #ffc107 !important;
	}

	#alert_toast.delete-success {
		background-color: #dc3545 !important;
	}

	/* Toast text color */
	#alert_toast .toast-body {
		color: white !important;
	}

	/* Confirmation modal styling */
	#confirm_modal .modal-body {
		font-size: 18px;
		font-family: 'Kantumruy Pro', sans-serif;
		padding: 20px;
	}

	#confirm_modal .modal-title {
		font-size: 20px;
		font-weight: bold;
		font-family: 'Kantumruy Pro', sans-serif;
	}

	#confirm_modal .btn {
		font-size: 16px;
		font-family: 'Kantumruy Pro', sans-serif;
		padding: 8px 20px;
	}

	/* Table styling */
	.table {
		border-collapse: separate;
		border-spacing: 0;
		width: 100%;
	}

	.table thead th {
		background-color: #f8f9fa;
		color: #495057;
		font-weight: 500;
		font-size: 18px;
		padding: 12px 15px;
		border-bottom: 2px solid #dee2e6;
		text-align: left;
	}

	.table tbody td {
		padding: 12px 15px;
		vertical-align: middle;
		border-bottom: 1px solid #e9ecef;
		color: #6c757d;
		background-color: #ffffff;
	}

	/* Hover effect on rows */
	.table tbody tr:hover td {
		background-color: #f8f9fa;
		transition: background-color 0.2s ease;
	}

	/* Make the table more compact */
	.card-body {
		padding: 1.25rem;
	}

	.table td,
	.table th {
		padding: 0.75rem;
	}

	/* Container for icons */
	td center a,
	.new_product {
		display: inline-block;
		width: 40px;
		height: 40px;
		background-color: #f1f1f1;
		border-radius: 50%;
		text-align: center;
		line-height: 40px;
		font-size: 18px;
		transition: all 0.3s ease;
		color: #555;
	}

	/* Icon hover effect */
	td center a:hover,
	.new_product:hover {
		background-color: #007bff;
		color: white;
		transform: scale(1.1);
	}

	/* Specific styles for the edit icon */
	td center a.edit_product {
		background-color: #ffec3d;
	}

	/* Specific styles for the delete icon */
	td center a.delete_product {
		background-color: #f44336;
	}

	/* Specific styles for the new product icon */
	.new_product {
		background-color: #28a745;
		color: white;
	}

	/* Tooltips - modern look */
	.tooltip-inner {
		background-color: #333;
		color: #fff;
		font-size: 14px;
		border-radius: 4px;
		padding: 8px;
		font-family: 'Kantumruy Pro', sans-serif;
	}

	.tooltip-arrow {
		border-top-color: #333;
	}
</style>
<div class="container-fluid" style="margin-top: -60px;">
	<div class="row">
		<div class="col-lg-12 mb-10">
		</div>
	</div>
	<br>
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header khmer-text d-flex justify-content-between align-items-center">
				<b>បញ្ជីទំនិញ</b>
				<a href="javascript:void(0)" class="new_product" id="new_product" data-toggle="tooltip" title="ទំនិញថ្មី">
					<i class="fa fa-plus"></i>
				</a>
			</div>
			<div class="card-body">
				<table class="table table-hover" id="product-list">
					<thead>
						<tr class="khmer-text">
							<th>ល.រ</th>
							<th>រូបភាព</th>
							<th>ប្រភេទទំនិញរង</th>
							<th>ឈ្មោះទំនិញ</th>
							<th>តម្លៃ</th>
							<!-- <th>បង្កើតនៅ</th>
							<th>កែប្រែនៅ</th> -->
							<th>សកម្មភាព</th>
						</tr>
					</thead>
					<tbody>
						<?php
						include 'db_connect.php';
						// Instead of using the stored procedure, create a direct query to join with sub_categories
						$products = $conn->query("SELECT p.*, s.sub_cate FROM products p 
							LEFT JOIN sub_categories s ON p.sub_id = s.id 
							ORDER BY p.id DESC");
						$i = 1;
						while ($row = $products->fetch_assoc()) :
						?>
							<tr class="khmer-text">
								<td class="text-center">
									<?php echo $i++ ?>
								</td>
								<td>
									<?php
									$image_path = 'assets/uploads/' . $row['image'];
									if (file_exists($image_path) && !empty($row['image'])) {
										// Display the image if it exists
										echo '<img src="' . $image_path . '" alt="User Image" style="max-width: 60px; max-height: 60px; border-radius: 5px;">';
									} else {
										// If the image doesn't exist or the filename is empty, show a placeholder or default image
										echo '<span class="text-muted">គ្មានរូបភាព</span>';
									}
									?>
								</td>
								<td>
									<?php echo !empty($row['sub_cate']) ? $row['sub_cate'] : '<span class="text-muted">(មិនមាន)</span>'; ?>
								</td>
								<td>
									<?php echo $row['pro_name'] ?>
								</td>
								<td>
									<?php echo $row['price'] ?>
								</td>
								<td>
									<center>
										<!-- Edit Icon with Tooltip -->
										<a href="javascript:void(0)" class="edit_product" data-id='<?php echo $row['id']; ?>' data-toggle="tooltip" title="កែប្រែ">
											<i class="fa fa-edit"></i>
										</a>
										<!-- Delete Icon with Tooltip -->
										<a href="javascript:void(0)" class="delete_product" data-id='<?php echo $row['id']; ?>' data-toggle="tooltip" title="លុប">
											<i class="fa fa-trash-alt"></i>
										</a>
									</center>
								</td>
							</tr>
						<?php endwhile; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>

</div>
<script>
	$(function() {
		$('#product-list').dataTable({
			language: {
				search: "",
				searchPlaceholder: "ស្វែងរកទំនិញ...",
				lengthMenu: " _MENU_ ",
				info: "",
				infoEmpty: "",
				infoFiltered: "",
				paginate: {
					first: '<i class="fa fa-angle-double-left"></i>',
					last: '<i class="fa fa-angle-double-right"></i>',
					next: '<i class="fa fa-angle-right"></i>',
					previous: '<i class="fa fa-angle-left"></i>'
				}
			},
			initComplete: function() {
				// Force Khmer font on search input after table initialization
				$('.dataTables_filter input').addClass('khmer-text');
			}
		});

		$('#new_product').click(function() {
			uni_modal('ទំនិញថ្មី', 'manage_product.php')
		});

		$('.edit_product').click(function() {
			uni_modal('កែប្រែទំនិញ', 'manage_product.php?id=' + $(this).attr('data-id'))
		});

		$('.delete_product').click(function() {
			_conf("តើអ្នកប្រាកដជាចង់លុបទំនិញនេះមែនទេ?", "delete_product", [$(this).attr('data-id')])
		});
	});

	function delete_product($id) {
		start_load()
		$.ajax({
			url: 'ajax.php?action=delete_product',
			method: 'POST',
			data: {
				id: $id
			},
			success: function(resp) {
				if (resp == 1) {
					$('#alert_toast').removeClass('bg-success create-success edit-success').addClass('delete-success');
					alert_toast("ទិន្នន័យត្រូវបានលុបដោយជោគជ័យ", 'success')
					setTimeout(function() {
						location.reload()
					}, 1500)
				}
			}
		});
	}

	// Add these new functions to handle edit and create success
	function edit_success() {
		$('#alert_toast').removeClass('bg-success create-success delete-success').addClass('edit-success');
		alert_toast("ទិន្នន័យត្រូវបានកែប្រែដោយជោគជ័យ", 'success')
	}

	function create_success() {
		$('#alert_toast').removeClass('bg-success edit-success delete-success').addClass('create-success');
		alert_toast("ទិន្នន័យបានរក្សាទុកដោយជោគជ័យ", 'success')
	}
</script>

<style>
	/* Container for icons */
	td center a,
	.new_product {
		display: inline-block;
		width: 40px;
		height: 40px;
		background-color: #f1f1f1;
		border-radius: 50%;
		text-align: center;
		line-height: 40px;
		font-size: 18px;
		transition: all 0.3s ease;
		color: #555;
	}

	/* Icon hover effect */
	td center a:hover,
	.new_product:hover {
		background-color: #007bff;
		color: white;
		transform: scale(1.1);
	}

	/* Specific styles for the edit icon */
	td center a.edit_product {
		background-color: #ffec3d;
	}

	/* Specific styles for the delete icon */
	td center a.delete_product {
		background-color: #f44336;
	}

	/* Specific styles for the new product icon */
	.new_product {
		background-color: #28a745;
		color: white;
	}

	/* Tooltips - modern look */
	.tooltip-inner {
		background-color: #333;
		color: #fff;
		font-size: 14px;
		border-radius: 4px;
		padding: 8px;
		font-family: 'Kantumruy Pro', sans-serif;
	}

	.tooltip-arrow {
		border-top-color: #333;
	}
</style>

<script>
	// Initialize Bootstrap tooltips
	$(document).ready(function() {
		$('[data-toggle="tooltip"]').tooltip();
	});
</script>