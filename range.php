<?php
require 'db_connect.php';
if (isset($_POST['search'])) {
	$date1 = date("Y-m-d", strtotime($_POST['date1']));
	$date2 = date("Y-m-d", strtotime($_POST['date2']));
	$query = mysqli_query($conn, "SELECT 
    pro_name, 
    SUM(qty) AS total_quantity, 
    SUM(qty * sp.price) AS total_price,
	sp.price,
    sp.create_at
FROM 
    saleproduct
	sp
	INNER JOIN products p ON sp.pro_id = p.id
WHERE 
    date(sp.create_at) BETWEEN '$date1' AND '$date2'
GROUP BY 
    pro_id;
");
	$row = mysqli_num_rows($query);
	if ($row > 0) {
		$i = 1;
		while ($fetch = mysqli_fetch_array($query)) {

?>
			<tr>
				<td><?php echo $i++ ?></td>
				<td><?php echo $fetch['pro_name'] ?></td>
				<td><?php echo $fetch['total_quantity'] ?></td>
				<td><?php echo $fetch['price'] ?></td>
				<td><?php echo $fetch['total_price'] ?></td>

			</tr>


			<?php
		}
	} else {
		echo '
			<tr>
				<td colspan = "4"><center>Record Not Found</center></td>
			</tr>';
	}
} elseif (isset($_POST['submit_search'])) {
	$search_option = $_POST['search_option'];
	if ($search_option == 'daily') {
		$date1 = date("Y-m-d", strtotime($_POST['date1']));
		$date2 = date("Y-m-d", strtotime($_POST['date2']));
		$query = mysqli_query($conn, "SELECT 
    pro_name, 
    SUM(qty) AS total_quantity, 
    SUM(qty * sp.price) AS total_price,
	sp.price,
    sp.create_at
FROM 
    saleproduct sp
	INNER JOIN products p ON sp.pro_id = p.id
WHERE 
    date(sp.create_at) = CURDATE()
GROUP BY 
    pro_id;
");
		$row = mysqli_num_rows($query);
		if ($row > 0) {
			$i = 1;
			while ($fetch = mysqli_fetch_array($query)) {

			?>
				<tr>
					<td><?php echo $i++ ?></td>
					<td><?php echo $fetch['pro_name'] ?></td>
					<td><?php echo $fetch['total_quantity'] ?></td>
					<td><?php echo $fetch['price'] ?></td>
					<td><?php echo $fetch['total_price'] ?></td>

				</tr>


			<?php
			}
		} else {
			echo '
			<tr>
				<td colspan = "4"><center>Record Not Found</center></td>
			</tr>';
		}
	} elseif ($search_option == 'weekly') {
		$date1 = date("Y-m-d", strtotime($_POST['date1']));
		$date2 = date("Y-m-d", strtotime($_POST['date2']));
		$query = mysqli_query($conn, "SELECT 
    pro_name, 
    SUM(qty) AS total_quantity, 
    SUM(qty * sp.price) AS total_price,
	sp.price,
    sp.create_at
FROM 
    saleproduct
	sp
	INNER JOIN products p ON sp.pro_id = p.id
WHERE 
    sp.create_at >= DATE_SUB(CURDATE(), INTERVAL 6 DAY)
GROUP BY 
    pro_id;");

		$row = mysqli_num_rows($query);
		if ($row > 0) {
			$i = 1;
			while ($fetch = mysqli_fetch_array($query)) {

			?>
				<tr>
					<td><?php echo $i++ ?></td>
					<td><?php echo $fetch['pro_name'] ?></td>
					<td><?php echo $fetch['total_quantity'] ?></td>
					<td><?php echo $fetch['price'] ?></td>
					<td><?php echo $fetch['total_price'] ?></td>

				</tr>


			<?php
			}
		} else {
			echo '
			<tr>
				<td colspan = "4"><center>Record Not Found</center></td>
			</tr>';
		}
	} elseif ($search_option == 'monthly') {
		$date1 = date("Y-m-d", strtotime($_POST['date1']));
		$date2 = date("Y-m-d", strtotime($_POST['date2']));
		$query = mysqli_query($conn, "SELECT 
    pro_name, 
    SUM(qty) AS total_quantity, 
    SUM(qty * sp.price) AS total_price,
	sp.price,
    sp.create_at
FROM 
    saleproduct
	sp
	INNER JOIN products p ON sp.pro_id = p.id
WHERE 
    sp.create_at >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)
GROUP BY 
    pro_id;");

		$row = mysqli_num_rows($query);
		if ($row > 0) {
			$i = 1;
			while ($fetch = mysqli_fetch_array($query)) {

			?>
				<tr>
					<td><?php echo $i++ ?></td>
					<td><?php echo $fetch['pro_name'] ?></td>
					<td><?php echo $fetch['total_quantity'] ?></td>
					<td><?php echo $fetch['price'] ?></td>
					<td><?php echo $fetch['total_price'] ?></td>

				</tr>


			<?php
			}
		} else {
			echo '
			<tr>
				<td colspan = "4"><center>Record Not Found</center></td>
			</tr>';
		}
	} elseif ($search_option == 'term') {
		// Term search logic
		$date1 = date("Y-m-d", strtotime($_POST['date1']));
		$date2 = date("Y-m-d", strtotime($_POST['date2']));
		$query = mysqli_query($conn, "SELECT 
    pro_name, 
    SUM(qty) AS total_quantity, 
    SUM(qty * sp.price) AS total_price,
	sp.price,
    sp.create_at
FROM 
    saleproduct
	sp
	INNER JOIN products p ON sp.pro_id = p.id
WHERE 
    sp.create_at >= DATE_SUB(CURDATE(), INTERVAL 3 MONTH)
GROUP BY 
    pro_id;");

		$row = mysqli_num_rows($query);
		if ($row > 0) {
			$i = 1;
			while ($fetch = mysqli_fetch_array($query)) {

			?>
				<tr>
					<td><?php echo $i++ ?></td>
					<td><?php echo $fetch['pro_name'] ?></td>
					<td><?php echo $fetch['total_quantity'] ?></td>
					<td><?php echo $fetch['price'] ?></td>
					<td><?php echo $fetch['total_price'] ?></td>

				</tr>


			<?php
			}
		} else {
			echo '
			<tr>
				<td colspan = "4"><center>Record Not Found</center></td>
			</tr>';
		}
	} elseif ($search_option == 'semester') {
		// Term search logic
		$date1 = date("Y-m-d", strtotime($_POST['date1']));
		$date2 = date("Y-m-d", strtotime($_POST['date2']));
		$query = mysqli_query($conn, "SELECT 
    pro_name, 
    SUM(qty) AS total_quantity, 
    SUM(qty * sp.price) AS total_price,
	sp.price,
    sp.create_at
FROM 
    saleproduct
	sp
	INNER JOIN products p ON sp.pro_id = p.id
WHERE 
    sp.create_at >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH)
GROUP BY 
    pro_id;");

		$row = mysqli_num_rows($query);
		if ($row > 0) {
			$i = 1;
			while ($fetch = mysqli_fetch_array($query)) {

			?>
				<tr>
					<td><?php echo $i++ ?></td>
					<td><?php echo $fetch['pro_name'] ?></td>
					<td><?php echo $fetch['total_quantity'] ?></td>
					<td><?php echo $fetch['price'] ?></td>
					<td><?php echo $fetch['total_price'] ?></td>

				</tr>


			<?php
			}
		} else {
			echo '
			<tr>
				<td colspan = "4"><center>Record Not Found</center></td>
			</tr>';
		}
	} elseif ($search_option == 'year') {
		// Term search logic
		$date1 = date("Y-m-d", strtotime($_POST['date1']));
		$date2 = date("Y-m-d", strtotime($_POST['date2']));
		$query = mysqli_query($conn, "SELECT 
   pro_name, 
    SUM(qty) AS total_quantity, 
    SUM(qty * sp.price) AS total_price,
	sp.price,
    sp.create_at
FROM 
    saleproduct
	sp
	INNER JOIN products p ON sp.pro_id = p.id
WHERE 
    sp.create_at >= DATE_SUB(CURDATE(), INTERVAL 1 YEAR)
GROUP BY 
    pro_id;");

		$row = mysqli_num_rows($query);
		if ($row > 0) {
			$i = 1;
			while ($fetch = mysqli_fetch_array($query)) {

			?>
				<tr>
					<td><?php echo $i++ ?></td>
					<td><?php echo $fetch['pro_name'] ?></td>
					<td><?php echo $fetch['total_quantity'] ?></td>
					<td><?php echo $fetch['price'] ?></td>
					<td><?php echo $fetch['total_price'] ?></td>

				</tr>


		<?php
			}
		} else {
			echo '
			<tr>
				<td colspan = "4"><center>Record Not Found</center></td>
			</tr>';
		}
	}
} else {
	$query = mysqli_query($conn, "SELECT 
    pro_name, 
    SUM(qty) AS total_quantity, 
    SUM(qty * sp.price) AS total_price,
	sp.price,
    sp.create_at
FROM 
    saleproduct
	sp
	INNER JOIN products p ON sp.pro_id = p.id
	GROUP BY pro_id");
	$i = 1;
	while ($fetch = mysqli_fetch_array($query)) {
		?>
		<tr>
			<td><?php echo $i++ ?></td>
			<td><?php echo $fetch['pro_name'] ?></td>
			<td><?php echo $fetch['total_quantity'] ?></td>
			<td><?php echo $fetch['price'] ?></td>
			<td><?php echo $fetch['total_price'] ?></td>

		</tr>
<?php
	}
}


?>