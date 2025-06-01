<?php
session_start();
ini_set('display_errors', 1);
class Action
{
	private $db;

	public function __construct()
	{
		ob_start();
		include 'db_connect.php';

		$this->db = $conn;
	}
	function __destruct()
	{
		$this->db->close();
		ob_end_flush();
	}

	function login()
	{
		extract($_POST);
		$qry = $this->db->query("SELECT * FROM users where username = '" . $username . "' and password = '" . md5($password) . "' ");
		if ($qry->num_rows > 0) {
			foreach ($qry->fetch_array() as $key => $value) {
				if ($key != 'passwors' && !is_numeric($key))
					$_SESSION['login_' . $key] = $value;
			}
			return 1;
		} else {
			return 3;
		}
	}
	function login2()
	{

		extract($_POST);
		$qry = $this->db->query("SELECT * FROM complainants where email = '" . $email . "' and password = '" . md5($password) . "' ");
		if ($qry->num_rows > 0) {
			foreach ($qry->fetch_array() as $key => $value) {
				if ($key != 'passwors' && !is_numeric($key))
					$_SESSION['login_' . $key] = $value;
			}
			return 1;
		} else {
			return 3;
		}
	}
	function logout()
	{
		session_destroy();
		foreach ($_SESSION as $key => $value) {
			unset($_SESSION[$key]);
		}
		header("location:login.php?logout=success");
	}
	function logout2()
	{
		session_destroy();
		foreach ($_SESSION as $key => $value) {
			unset($_SESSION[$key]);
		}
		header("location:../index.php");
	}

	function save_user()
	{
		extract($_POST);
		// Check if an image was uploaded
		if (!empty($_FILES['image']['name'])) {
			$target_dir = "assets/uploads/";
			$image_name = $_FILES["image"]["name"];
			$image_tmp = $_FILES["image"]["tmp_name"];

			// Generate a new name for the image file
			$image_extension = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));
			$new_image_name =  uniqid() . '.' . $image_extension;
			$target_file = $target_dir . $new_image_name;

			// Move uploaded image to the target directory
			if (move_uploaded_file($image_tmp, $target_file)) {
				// Image uploaded successfully

				// Building user data
				$data = " id = '$id' ";

				$data = " full_name = '$full_name' ";
				$data .= ", username = '$username' ";
				$data .= ", address = '$address'";
				$data .= ", phone_number = '$phone_number'";
				if (!empty($password))
					$data .= ", password = '" . md5($password) . "' ";
				$data .= ", type = '$type' ";
				$data .= ", image = '$new_image_name' "; // Storing new image name in the database
			} else {
				// Failed to upload image
				// Handle the error or return an error code
				return 0;
			}
		} else {
			// No image uploaded
			// Handle this case as per your application's requirements
			// You might want to set a default image or handle it in another way
			$data = " id = '$id' ";
			$data = " full_name = '$full_name' ";
			$data .= ", username = '$username' ";
			$data .= ", address = '$address'";
			$data .= ", phone_number = '$phone_number'";
			if (!empty($password))
				$data .= ", password = '" . md5($password) . "' ";
			$data .= ", type = '$type' ";
			if (empty($image))
				$data .= ", image = 'default.png' ";
		}
		$check = $this->db->query("SELECT * FROM users where username ='$username' " . (!empty($id) ? " and id != {$id} " : ''))->num_rows;
		if ($check > 0) {
			return 2;
			exit;
		}

		if (empty($id)) {
			$save = $this->db->query("INSERT INTO users SET " . $data);
		} else {
			$save = $this->db->query("UPDATE users SET " . $data . " WHERE id = " . $id);
			if ($save && !empty($image)) {
				$image_path = "assets/uploads/" . $image;
				if (file_exists($image_path)) {
					unlink($image_path);
				}
			}
		}


		if ($save) {
			return 1; // Success
		} else {
			return 0; // Failure
		}
	}
	function delete_user()
	{
		extract($_POST);
		$delete = $this->db->query("DELETE FROM users where id = " . $id);
		if ($delete)
			return 1;
	}
	function signup()
	{
		extract($_POST);
		$data = " name = '$name' ";
		$data .= ", email = '$email' ";
		$data .= ", address = '$address' ";
		$data .= ", contact = '$contact' ";
		$data .= ", password = '" . md5($password) . "' ";
		$chk = $this->db->query("SELECT * from complainants where email ='$email' " . (!empty($id) ? " and id != '$id' " : ''))->num_rows;
		if ($chk > 0) {
			return 3;
			exit;
		}
		if (empty($id))
			$save = $this->db->query("INSERT INTO complainants set $data");
		else
			$save = $this->db->query("UPDATE complainants set $data where id=$id ");
		if ($save) {
			if (empty($id))
				$id = $this->db->insert_id;
			$qry = $this->db->query("SELECT * FROM complainants where id = $id ");
			if ($qry->num_rows > 0) {
				foreach ($qry->fetch_array() as $key => $value) {
					if ($key != 'password' && !is_numeric($key))
						$_SESSION['login_' . $key] = $value;
				}
				return 1;
			} else {
				return 3;
			}
		}
	}
	function update_account()
	{
		extract($_POST);
		$data = " name = '" . $firstname . ' ' . $lastname . "' ";
		$data .= ", username = '$email' ";
		if (!empty($password))
			$data .= ", password = '" . md5($password) . "' ";
		$chk = $this->db->query("SELECT * FROM users where username = '$email' and id != '{$_SESSION['login_id']}' ")->num_rows;
		if ($chk > 0) {
			return 2;
			exit;
		}
		$save = $this->db->query("UPDATE users set $data where id = '{$_SESSION['login_id']}' ");
		if ($save) {
			$data = '';
			foreach ($_POST as $k => $v) {
				if ($k == 'password')
					continue;
				if (empty($data) && !is_numeric($k))
					$data = " $k = '$v' ";
				else
					$data .= ", $k = '$v' ";
			}
			if ($_FILES['img']['tmp_name'] != '') {
				$fname = strtotime(date('y-m-d H:i')) . '_' . $_FILES['img']['name'];
				$move = move_uploaded_file($_FILES['img']['tmp_name'], 'assets/uploads/' . $fname);
				$data .= ", avatar = '$fname' ";
			}
			$save_alumni = $this->db->query("UPDATE alumnus_bio set $data where id = '{$_SESSION['bio']['id']}' ");
			if ($data) {
				foreach ($_SESSION as $key => $value) {
					unset($_SESSION[$key]);
				}
				$login = $this->login2();
				if ($login)
					return 1;
			}
		}
	}

	function save_settings()
	{
		extract($_POST);
		$data = " name = '" . str_replace("'", "&#x2019;", $name) . "' ";
		$data .= ", email = '$email' ";
		$data .= ", contact = '$contact' ";
		$data .= ", about_content = '" . htmlentities(str_replace("'", "&#x2019;", $about)) . "' ";
		if ($_FILES['img']['tmp_name'] != '') {
			$fname = strtotime(date('y-m-d H:i')) . '_' . $_FILES['img']['name'];
			$move = move_uploaded_file($_FILES['img']['tmp_name'], 'assets/uploads/' . $fname);
			$data .= ", cover_img = '$fname' ";
		}

		// echo "INSERT INTO system_settings set ".$data;
		$chk = $this->db->query("SELECT * FROM system_settings");
		if ($chk->num_rows > 0) {
			$save = $this->db->query("UPDATE system_settings set " . $data);
		} else {
			$save = $this->db->query("INSERT INTO system_settings set " . $data);
		}
		if ($save) {
			$query = $this->db->query("SELECT * FROM system_settings limit 1")->fetch_array();
			foreach ($query as $key => $value) {
				if (!is_numeric($key))
					$_SESSION['system'][$key] = $value;
			}

			return 1;
		}
	}
	function save_category()
	{
		extract($_POST);
		// Building user data
		$data = "id = $id	";
		$data = " cate_name = '$cate_name' ";


		$check = $this->db->query("SELECT * FROM categories where cate_name ='$cate_name' " . (!empty($id) ? " and id != {$id} " : ''))->num_rows;
		if ($check > 0) {
			return 2;
			exit;
		}

		if (empty($id)) {
			// $save = $this->db->query("INSERT INTO users SET " . $data);
			$save = $this->db->query("INSERT INTO categories set $data");
		} else {
			$save = $this->db->query("UPDATE categories set $data where id = $id");
		}

		if ($save)
			return 1;
	}
	function delete_category()
	{
		extract($_POST);
		$delete = $this->db->query("DELETE FROM categories where id = " . $id);
		if ($delete) {
			return 1;
		}
	}
	// save sub category
	function save_sub_category()
	{
		extract($_POST);
		// Building data string
		$data = "";
		if (empty($id)) {
			$data = " category_id = '$category_id' ";
			$data .= ", sub_cate = '$sub_cate' ";
		} else {
			$data = " category_id = '$category_id' ";
			$data .= ", sub_cate = '$sub_cate' ";
		}

		$check = $this->db->query("SELECT * FROM sub_categories where sub_cate ='$sub_cate' " . (!empty($id) ? " and id != {$id} " : ''))->num_rows;
		if ($check > 0) {
			return 2;
			exit;
		}

		if (empty($id)) {
			$save = $this->db->query("INSERT INTO sub_categories SET " . $data);
		} else {
			$save = $this->db->query("UPDATE sub_categories SET " . $data . " WHERE id = " . $id);
		}

		if ($save)
			return 1;
	}
	function delete_sub_category()
	{
		extract($_POST);
		$delete = $this->db->query("DELETE FROM sub_categories where id = " . $id);
		if ($delete) {
			return 1;
		}
	}
	function save_product()
	{
		extract($_POST);
		// Initialize data string
		$data = "";

		// Check if an image was uploaded
		if (!empty($_FILES['image']['name'])) {
			$target_dir = "assets/uploads/";
			$image_name = $_FILES["image"]["name"];
			$image_tmp = $_FILES["image"]["tmp_name"];

			// Generate a new name for the image file
			$image_extension = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));
			$new_image_name =  uniqid() . '.' . $image_extension;
			$target_file = $target_dir . $new_image_name;

			// Move uploaded image to the target directory
			if (move_uploaded_file($image_tmp, $target_file)) {
				// Image uploaded successfully
				$data .= " image = '$new_image_name' ";
			} else {
				return 0;
			}
		} else if (empty($id)) {
			// No image uploaded for new product, use default
			$data .= " image = 'default.png' ";
		}

		// Add other product data
		if (!empty($data)) {
			$data .= ", ";
		}
		$data .= " sub_id = '$sub_id' ";
		$data .= ", pro_name = '$pro_name' ";
		$data .= ", price = '$price' ";

		if (empty($id)) {
			$save = $this->db->query("INSERT INTO products set $data");

			// $save = $this->db->query("INSERT INTO products SET " . $data);
		} else {
			$save = $this->db->query("UPDATE products SET " . $data . " WHERE id = " . $id);
			if ($save && !empty($image)) {
				$image_path = "assets/uploads/" . $image;
				if (file_exists($image_path)) {
					unlink($image_path);
				}
			}
		}

		if ($save) {
			return 1; // Success
		} else {
			return 0; // Failure
		}
	}


	function delete_product()
	{
		extract($_POST);

		// First get the image filename before deleting the record
		$product = $this->db->query("SELECT image FROM products WHERE id = " . $id);
		$img = '';
		if ($product->num_rows > 0) {
			$img = $product->fetch_array()['image'];
		}

		// Delete the product record
		$delete = $this->db->query("DELETE FROM products where id = " . $id);

		// If delete successful and we have an image, delete the image file
		if ($delete && !empty($img) && $img != 'default.png') {
			$image_path = "assets/uploads/" . $img;
			if (file_exists($image_path)) {
				unlink($image_path);
			}
		}

		if ($delete) {
			return 1;
		}
		return 0;
	}
	function save_order()
	{
		try {
			extract($_POST);

			// Log the extracted data
			error_log("Save Order - Extracted POST data: " . print_r($_POST, true));

			if (!isset($_SESSION['login_id'])) {
				throw new Exception("User not logged in");
			}

			$user_id = $_SESSION['login_id'];
			error_log("Save Order - User ID: " . $user_id);

			// Start transaction
			$this->db->begin_transaction();
			error_log("Save Order - Transaction started");

			// 1. Save main order
			$data = " user_id = '" . $this->db->real_escape_string($user_id) . "' ";
			if (isset($sale_date)) {
				$data .= ", sale_date = '" . $this->db->real_escape_string($sale_date) . "' ";
			}
			if (isset($customer) && !empty($customer)) {
				$data .= ", customer_id = '" . $this->db->real_escape_string($customer) . "' ";
			}

			error_log("Save Order - Order data: " . $data);

			if (empty($id)) {
				$save = $this->db->query("INSERT INTO sale set $data");
				if (!$save) {
					throw new Exception("Failed to create order: " . $this->db->error);
				}
				$id = $this->db->insert_id;
				error_log("Save Order - New order created with ID: " . $id);
			} else {
				$save = $this->db->query("UPDATE sale set $data where id = " . intval($id));
				if (!$save) {
					throw new Exception("Failed to update order: " . $this->db->error);
				}
				error_log("Save Order - Order updated: " . $id);
			}

			// 2. Save order items
			if ($save && isset($item_id) && is_array($item_id)) {
				error_log("Save Order - Processing " . count($item_id) . " items");

				// Delete removed items
				$ids = array_filter($item_id);
				if (!empty($ids)) {
					$ids_str = implode(',', array_map('intval', $ids));
					$delete = $this->db->query("DELETE FROM saleproduct where sale_id = " . intval($id) . " and id not in ($ids_str)");
					if (!$delete) {
						throw new Exception("Failed to remove old items: " . $this->db->error);
					}
					error_log("Save Order - Removed old items");
				}

				// Insert/Update items
				foreach ($item_id as $k => $v) {
					if (!isset($pro_id[$k]) || !isset($price[$k]) || !isset($qty[$k])) {
						throw new Exception("Missing required item data at index $k");
					}

					$data = " sale_id = " . intval($id) . " ";
					$data .= ", pro_id = '" . $this->db->real_escape_string($pro_id[$k]) . "' ";
					$data .= ", price = '" . $this->db->real_escape_string($price[$k]) . "' ";
					$data .= ", qty = '" . $this->db->real_escape_string($qty[$k]) . "' ";

					error_log("Save Order - Processing item: " . print_r([
						'item_id' => $v,
						'pro_id' => $pro_id[$k],
						'price' => $price[$k],
						'qty' => $qty[$k]
					], true));

					if (empty($v)) {
						$insert = $this->db->query("INSERT INTO saleproduct set $data");
						if (!$insert) {
							throw new Exception("Failed to add item: " . $this->db->error);
						}
					} else {
						$update = $this->db->query("UPDATE saleproduct set $data where id = " . intval($v));
						if (!$update) {
							throw new Exception("Failed to update item: " . $this->db->error);
						}
					}
				}
			}

			// 3. Save payment information
			if ($save && isset($total_amount) && isset($method)) {
				error_log("Save Order - Processing payment: " . print_r([
					'total_amount' => $total_amount,
					'method' => $method,
					'customer' => $customer ?? null
				], true));

				// Delete old payment records
				$delete = $this->db->query("DELETE FROM payment where sale_id = " . intval($id));
				if (!$delete) {
					throw new Exception("Failed to remove old payment records: " . $this->db->error);
				}

				// Insert new payment record
				$payment_data = " sale_id = " . intval($id) . " ";
				$payment_data .= ", payment = '" . $this->db->real_escape_string($total_amount) . "' ";
				$payment_data .= ", method = '" . $this->db->real_escape_string($method) . "' ";
				$payment_data .= ", discount = '" . (isset($discount) ? intval($discount) : 0) . "' ";

				// Get sale date from the sale table and include it in payment
				$sale_date_query = $this->db->query("SELECT sale_date FROM sale WHERE id = " . intval($id));
				if ($sale_date_query && $sale_date_query->num_rows > 0) {
					$sale_date_row = $sale_date_query->fetch_assoc();
					if (!empty($sale_date_row['sale_date'])) {
						$payment_data .= ", create_at = '" . $sale_date_row['sale_date'] . " " . date('H:i:s') . "' ";
					}
				}

				$insert_payment = $this->db->query("INSERT INTO payment set $payment_data");
				if (!$insert_payment) {
					throw new Exception("Failed to save payment: " . $this->db->error);
				}
				error_log("Save Order - Payment saved successfully");
			}

			// If everything succeeded, commit the transaction
			$this->db->commit();
			error_log("Save Order - Transaction committed successfully");
			return $id;
		} catch (Exception $e) {
			// If any error occurred, rollback the transaction
			$this->db->rollback();
			error_log("Save Order Error: " . $e->getMessage());
			error_log("Save Order Error Trace: " . $e->getTraceAsString());
			return 0;
		}
	}
	function delete_order()
	{
		extract($_POST);
		$delete = $this->db->query("DELETE FROM orders where id = " . $id);
		$delete2 = $this->db->query("DELETE FROM order_items where order_id = " . $id);
		if ($delete) {
			return 1;
		}
	}

	function save_customer()
	{
		extract($_POST);
		// Building user data
		$data = " cus_name = '$cus_name' ";
		$data .= ", cus_phone = '$cus_phone'";
		$data .= ", address = '$address' ";

		if (empty($id)) {
			$save = $this->db->query("INSERT INTO `customer` set $data");
		} else {
			$save = $this->db->query("UPDATE `customer` set $data where id = $id");
		}

		if ($save) {
			return 1; // Indicates successful insert or update
		} else {
			return 0; // Indicates insert or update failure
		}
	}

	function delete_customer()
	{
		extract($_POST);
		$delete = $this->db->query("DELETE FROM `customer` where id = " . $id);
		if ($delete) {
			return 1;
		}
	}
}
