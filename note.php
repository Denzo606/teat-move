<?php
require 'db_connect.php';

if (isset($_POST['search'])) {
    // If search button is clicked, perform search based on date range
    $date1 = date("Y-m-d", strtotime($_POST['date1']));
    $date2 = date("Y-m-d", strtotime($_POST['date2']));

    $query = mysqli_query($conn, "SELECT 
        pro_id, 
        SUM(qty) AS total_quantity, 
        SUM(qty * price) AS total_price,
        price,
        create_at
    FROM 
        saleproduct
    WHERE 
        date(create_at) BETWEEN '$date1' AND '$date2'
    GROUP BY 
        pro_id;
    ");
} elseif (isset($_POST['search_option'])) {
    // If search option is selected, determine date range based on the selected option
    $search_option = $_POST['search_option'];
    $date1 = '';
    $date2 = '';

    switch ($search_option) {
        case 'daily':
            $date1 = date("Y-m-d");
            $date2 = date("Y-m-d");
            break;
        case 'weekly':
            $date1 = date("Y-m-d", strtotime('last Monday'));
            $date2 = date("Y-m-d", strtotime('next Sunday'));
            break;
        case 'monthly':
            $date1 = date("Y-m-01");
            $date2 = date("Y-m-t");
            break;
        default:
            // Handle invalid option or default behavior
            $date1 = date("Y-m-d");
            $date2 = date("Y-m-d");
            break;
    }

    // Perform query based on the determined date range
    $query = mysqli_query($conn, "SELECT 
        pro_id, 
        SUM(qty) AS total_quantity, 
        SUM(qty * price) AS total_price,
        price,
        create_at
    FROM 
        saleproduct
    WHERE 
        date(create_at) BETWEEN '$date1' AND '$date2'
    GROUP BY 
        pro_id;
    ");
} else {
    // If neither search nor search option is selected, perform default query
    $query = mysqli_query($conn, "SELECT 
        pro_id, 
        SUM(qty) AS total_quantity, 
        SUM(qty * price) AS total_price,
        price,
        create_at
    FROM 
        saleproduct
    WHERE 
        date(create_at) = CURDATE()
    GROUP BY 
        pro_id;
    ");
}

// Display results
$row = mysqli_num_rows($query);
if ($row > 0) {
    $i = 1;
    while ($fetch = mysqli_fetch_array($query)) {
?>
        <tr>
            <td><?php echo $i++ ?></td>
            <td><?php echo $fetch['pro_id'] ?></td>
            <td><?php echo $fetch['total_quantity'] ?></td>
            <td>$<?php echo number_format($fetch['price'], 2) ?></td>
            <td>$<?php echo number_format($fetch['total_price'], 2) ?></td>
        </tr>
<?php
    }
} else {
    echo '<tr><td colspan="5"><center>Record Not Found</center></td></tr>';
}
?>