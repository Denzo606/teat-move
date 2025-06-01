<?php
require 'db_connect.php';

if (isset($_POST['search'])) {
    $date1 = date("Y-m-d", strtotime($_POST['date1']));
    $date2 = date("Y-m-d", strtotime($_POST['date2']));

    $query = mysqli_query($conn, "SELECT SUM(price * qty) FROM saleproduct WHERE date(create_at) BETWEEN '$date1' AND '$date2'");

    if ($query) {
        $totalRow = mysqli_fetch_row($query);

        // Check if the result is not empty or NULL
        if ($totalRow !== false) {
            // If the total sum is NULL, treat it as 0
            $totalPrice = ($totalRow[0] !== null) ? $totalRow[0] : 0;

            // Use $totalPrice as needed, for example, display it or perform further actions.
            echo "$" . number_format($totalPrice, 2);
        } else {
            echo "No data found for the specified date range.";
        }
    } else {
        echo "Error executing the query: " . mysqli_error($conn);
    }
} elseif (isset($_POST['submit_search'])) {
    $search_option = $_POST['search_option'];
    if ($search_option == "daily") {
        $query = mysqli_query($conn, "SELECT SUM(price * qty) FROM saleproduct WHERE date(create_at) = curdate()");

        if ($query) {
            $totalRow = mysqli_fetch_row($query);

            // Check if the result is not empty or NULL
            if ($totalRow !== false) {
                // If the total sum is NULL, treat it as 0
                $totalPrice = ($totalRow[0] !== null) ? $totalRow[0] : 0;

                // Use $totalPrice as needed, for example, display it or perform further actions.
                echo "$" . number_format($totalPrice, 2);
            } else {
                echo "No data found for today.";
            }
        } else {
            echo "Error executing the query: " . mysqli_error($conn);
        }
    } elseif ($search_option == 'weekly') {
        $query = mysqli_query($conn, "SELECT SUM(price * qty) FROM saleproduct WHERE date(create_at) >= DATE_SUB(CURDATE(), INTERVAL 6 DAY)");

        if ($query) {
            $totalRow = mysqli_fetch_row($query);

            // Check if the result is not empty or NULL
            if ($totalRow !== false) {
                // If the total sum is NULL, treat it as 0
                $totalPrice = ($totalRow[0] !== null) ? $totalRow[0] : 0;

                // Use $totalPrice as needed, for example, display it or perform further actions.
                echo "$" . number_format($totalPrice, 2);
            } else {
                echo "No data found for today.";
            }
        } else {
            echo "Error executing the query: " . mysqli_error($conn);
        }
    } elseif ($search_option == "monthly") {
        $query = mysqli_query($conn, "SELECT SUM(price * qty) FROM saleproduct WHERE date(create_at) >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)");

        if ($query) {
            $totalRow = mysqli_fetch_row($query);

            // Check if the result is not empty or NULL
            if ($totalRow !== false) {
                // If the total sum is NULL, treat it as 0
                $totalPrice = ($totalRow[0] !== null) ? $totalRow[0] : 0;

                // Use $totalPrice as needed, for example, display it or perform further actions.
                echo "$" . number_format($totalPrice, 2);
            } else {
                echo "No data found for today.";
            }
        } else {
            echo "Error executing the query: " . mysqli_error($conn);
        }
    } elseif ($search_option == "term") {
        $query = mysqli_query($conn, "SELECT SUM(price * qty) FROM saleproduct WHERE date(create_at) >= DATE_SUB(CURDATE(), INTERVAL 3 MONTH)");

        if ($query) {
            $totalRow = mysqli_fetch_row($query);

            // Check if the result is not empty or NULL
            if ($totalRow !== false) {
                // If the total sum is NULL, treat it as 0
                $totalPrice = ($totalRow[0] !== null) ? $totalRow[0] : 0;

                // Use $totalPrice as needed, for example, display it or perform further actions.
                echo "$" . number_format($totalPrice, 2);
            } else {
                echo "No data found for today.";
            }
        } else {
            echo "Error executing the query: " . mysqli_error($conn);
        }
    } elseif ($search_option == "semester") {
        $query = mysqli_query($conn, "SELECT SUM(price * qty) FROM saleproduct WHERE date(create_at) >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH)");

        if ($query) {
            $totalRow = mysqli_fetch_row($query);

            // Check if the result is not empty or NULL
            if ($totalRow !== false) {
                // If the total sum is NULL, treat it as 0
                $totalPrice = ($totalRow[0] !== null) ? $totalRow[0] : 0;

                // Use $totalPrice as needed, for example, display it or perform further actions.
                echo "$" . number_format($totalPrice, 2);
            } else {
                echo "No data found for today.";
            }
        } else {
            echo "Error executing the query: " . mysqli_error($conn);
        }
    } elseif ($search_option == 'year') {
        $query = mysqli_query($conn, "SELECT SUM(price * qty) FROM saleproduct WHERE date(create_at) >= DATE_SUB(CURDATE(), INTERVAL 1 YEAR)");

        if ($query) {
            $totalRow = mysqli_fetch_row($query);

            // Check if the result is not empty or NULL
            if ($totalRow !== false) {
                // If the total sum is NULL, treat it as 0
                $totalPrice = ($totalRow[0] !== null) ? $totalRow[0] : 0;

                // Use $totalPrice as needed, for example, display it or perform further actions.
                echo "$" . number_format($totalPrice, 2);
            } else {
                echo "No data found for today.";
            }
        } else {
            echo "Error executing the query: " . mysqli_error($conn);
        }
    }
} else {
    $query = mysqli_query($conn, "SELECT SUM(price * qty) FROM saleproduct ");

    if ($query) {
        $totalRow = mysqli_fetch_row($query);

        // Check if the result is not empty or NULL
        if ($totalRow !== false) {
            // If the total sum is NULL, treat it as 0
            $totalPrice = ($totalRow[0] !== null) ? $totalRow[0] : 0;

            // Use $totalPrice as needed, for example, display it or perform further actions.
            echo "<h4>$" . number_format($totalPrice, 2) . "</h4>";
        } else {
            echo "No data found.";
        }
    } else {
        echo "Error executing the query: " . mysqli_error($conn);
    }
}
