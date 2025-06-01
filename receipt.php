<?php
include 'db_connect.php';
$order = $conn->query("SELECT * FROM sale where id = {$_GET['id']}");
foreach ($order->fetch_array() as $k => $v) {
	$$k = $v;
}
// $items = $conn->query("SELECT o.*,p.name FROM order_items o inner join products p on p.id = o.product_id where o.order_id = $id ");
$items = $conn->query("SELECT s.*,p.pro_name FROM saleproduct s INNER JOIN products p ON p.id = s.pro_id WHERE s.sale_id  = $id ");

$payment = $conn->query("SELECT payment
FROM payment
WHERE sale_id = $id
GROUP BY payment;")
?>

<style>
	@media print {
		body {
			width: 100%;
			margin: 0;
			padding: 15px;
		}

		.container-fluid {
			width: 100%;
			max-width: 100%;
			padding: 0;
		}

		.no-print {
			display: none !important;
		}
	}

	.flex {
		display: inline-flex;
		width: 100%;
	}

	.w-50 {
		width: 50%;
	}

	.text-center {
		text-align: center;
	}

	.text-right {
		text-align: right;
	}

	table.wborder {
		width: 100%;
		border-collapse: collapse;
	}

	table.wborder>tbody>tr,
	table.wborder>tbody>tr>td {
		border: 1px solid;
	}

	p {
		margin: unset;
	}

	.receipt-header {
		text-align: center;
		margin-bottom: 20px;
	}

	.receipt-header h2 {
		margin: 0;
		font-size: 24px;
	}

	.receipt-details {
		margin-bottom: 20px;
	}

	.receipt-table {
		width: 100%;
		border-collapse: collapse;
		margin-bottom: 20px;
	}

	.receipt-table th,
	.receipt-table td {
		padding: 8px;
		border-bottom: 1px solid #ddd;
	}

	.receipt-total {
		margin-top: 20px;
		text-align: right;
		font-size: 18px;
		font-weight: bold;
	}
</style>
<div class="container-fluid">
	<div class="receipt-header">
		<h2>Receipt</h2>
		<p>Order #<?php echo $id; ?></p>
	</div>

	<div class="receipt-details">
		<p><strong>Date:</strong> <?php echo date("M d, Y", strtotime($create_at)) ?></p>
	</div>

	<table class="receipt-table">
		<thead>
			<tr>
				<th>QTY</th>
				<th>Item</th>
				<th class="text-right">Price</th>
				<th class="text-right">Amount</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$total = 0;
			while ($row = $items->fetch_assoc()) :
				$amount = $row['price'] * $row['qty'];
				$total += $amount;
			?>
				<tr>
					<td><?php echo $row['qty'] ?></td>
					<td><?php echo $row['pro_name'] ?></td>
					<td class="text-right"><?php echo number_format($row['price'], 2) ?></td>
					<td class="text-right"><?php echo number_format($amount, 2) ?></td>
				</tr>
			<?php endwhile; ?>
		</tbody>
		<tfoot>
			<tr>
				<td colspan="3" class="text-right"><strong>Total:</strong></td>
				<td class="text-right"><strong><?php echo number_format($total, 2) ?></strong></td>
			</tr>
		</tfoot>
	</table>

	<div class="receipt-total">
		<?php
		while ($row = $payment->fetch_assoc()) :
		?>
			<p>Payment: <?php echo number_format($row['payment'], 2) ?></p>
		<?php endwhile; ?>
	</div>

	<div class="text-center" style="margin-top: 30px;">
		<p>Thank you for your purchase!</p>
	</div>
</div>

<script>
	// Automatically trigger print when page loads
	window.onload = function() {
		window.print();
	}
</script>