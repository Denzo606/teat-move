<?php
ob_start();
$action = $_GET['action'];
include 'admin_class.php';
$crud = new Action();
if ($action == 'login') {
	$login = $crud->login();
	if ($login)
		echo $login;
}
if ($action == 'login2') {
	$login = $crud->login2();
	if ($login)
		echo $login;
}
if ($action == 'logout') {
	$logout = $crud->logout();
	if ($logout)
		echo $logout;
}
if ($action == 'logout2') {
	$logout = $crud->logout2();
	if ($logout)
		echo $logout;
}
if ($action == 'save_user') {
	$save = $crud->save_user();
	if ($save)
		echo $save;
}
if ($action == 'delete_user') {
	$save = $crud->delete_user();
	if ($save)
		echo $save;
}
if ($action == 'signup') {
	$save = $crud->signup();
	if ($save)
		echo $save;
}
if ($action == 'update_account') {
	$save = $crud->update_account();
	if ($save)
		echo $save;
}
if ($action == "save_settings") {
	$save = $crud->save_settings();
	if ($save)
		echo $save;
}
if ($action == "save_category") {
	$save = $crud->save_category();
	if ($save)
		echo $save;
}

if ($action == "delete_category") {
	$delete = $crud->delete_category();
	if ($delete)
		echo $delete;
}
if ($action == "save_customer") {
	$save = $crud->save_customer();
	if ($save)
		echo $save;
}
if ($action == "delete_customer") {
	$delete = $crud->delete_customer();
	if ($delete)
		echo $delete;
}
if ($action == "save_sub_category") {
	$save = $crud->save_sub_category();
	if ($save)
		echo $save;
}
if ($action == "delete_sub_category") {
	$delete = $crud->delete_sub_category();
	if ($delete)
		echo $delete;
}
if ($action == "save_product") {
	$save = $crud->save_product();
	if ($save)
		echo $save;
}
if ($action == "delete_product") {
	$delete = $crud->delete_product();
	if ($delete)
		echo $delete;
}

if ($action == "save_order") {
	try {
		// Log the incoming data
		error_log("Save Order Request Data: " . print_r($_POST, true));

		$save = $crud->save_order();

		// Log the response
		error_log("Save Order Response: " . print_r($save, true));

		if ($save) {
			echo $save;
		} else {
			// Log the error
			error_log("Save Order Failed: No response from save_order function");
			echo json_encode(['status' => 'error', 'message' => 'បរាជ័យក្នុងការរក្សាទុកការកម្មង់']);
		}
	} catch (Exception $e) {
		// Log any exceptions
		error_log("Save Order Exception: " . $e->getMessage());
		echo json_encode(['status' => 'error', 'message' => 'បរាជ័យក្នុងការរក្សាទុកការកម្មង់: ' . $e->getMessage()]);
	}
}
if ($action == "delete_order") {
	$delete = $crud->delete_order();
	if ($delete)
		echo $delete;
}

if ($action == 'get_categories') {
	$draw = $_POST['draw'];
	$row = $_POST['start'];
	$rowperpage = $_POST['length'];
	$columnIndex = $_POST['order'][0]['column'] ?? 0;
	$columnName = $_POST['columns'][$columnIndex]['data'] ?? 'cate_name';
	$columnSortOrder = $_POST['order'][0]['dir'] ?? 'asc';
	$searchValue = $_POST['search'] ?? '';

	// Total number of records without filtering
	$totalRecords = $conn->query("SELECT COUNT(*) as count FROM categories")->fetch_assoc()['count'];

	// Total number of records with filtering
	$searchQuery = "SELECT COUNT(*) as count FROM categories WHERE 1=1";
	if (!empty($searchValue)) {
		$searchQuery .= " AND (cate_name LIKE '%$searchValue%' OR descriptions LIKE '%$searchValue%')";
	}
	$totalRecordwithFilter = $conn->query($searchQuery)->fetch_assoc()['count'];

	// Fetch records
	$query = "SELECT * FROM categories WHERE 1=1";
	if (!empty($searchValue)) {
		$query .= " AND (cate_name LIKE '%$searchValue%' OR descriptions LIKE '%$searchValue%')";
	}
	$query .= " ORDER BY $columnName $columnSortOrder LIMIT $row,$rowperpage";

	$records = $conn->query($query);
	$data = array();

	while ($row = $records->fetch_assoc()) {
		$data[] = array(
			"id" => $row['id'],
			"cate_name" => $row['cate_name'],
			"descriptions" => $row['descriptions']
		);
	}

	// Response
	$response = array(
		"draw" => intval($draw),
		"iTotalRecords" => $totalRecords,
		"iTotalDisplayRecords" => $totalRecordwithFilter,
		"aaData" => $data
	);

	echo json_encode($response);
	exit;
}

if ($action == 'get_user') {
	extract($_POST);
	$user = $conn->query("SELECT * FROM users WHERE id = " . $id);
	if ($user->num_rows > 0) {
		$row = $user->fetch_assoc();
		echo json_encode($row);
	} else {
		echo json_encode(['error' => 'User not found']);
	}
}

ob_end_flush();
