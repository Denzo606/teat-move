<?php
include("db_connect.php");
// $query = mysqli_query($conn, "CALL countCategories();");
// $cat = mysqli_fetch_row($query);
$fetch_query = mysqli_query($conn, "select count(*) as Total from categories");
$cat = mysqli_fetch_row($fetch_query);

$fetch_query = mysqli_query($conn, "select count(*) as Total from products");
$pro = mysqli_fetch_row($fetch_query);

$fetch_query = mysqli_query($conn, "select count(*) as Total from users");
$user = mysqli_fetch_row($fetch_query);

$fetch_query = mysqli_query($conn, "select count(*) as Total from sub_categories");
$sub = mysqli_fetch_row($fetch_query);
?>
<?php
$con  = mysqli_connect("localhost", "root", "", "sale");
if (!$con) {
    echo "Problem in database connection! Contact administrator!";
} else {
    // Fetch sales data for all months of the year
    $sql = "SELECT MONTH(create_at) AS Month, SUM(payment) AS TotalSales FROM payment GROUP BY MONTH(create_at)";
    $result = mysqli_query($con, $sql);
    $chart_data = "";

    // Initialize array to store sales data for each month
    $months = [];
    $sales = [];

    // Generate an array containing names of all months in Khmer
    $all_months = [
        1 => 'មករា',
        2 => 'កុម្ភៈ',
        3 => 'មីនា',
        4 => 'មេសា',
        5 => 'ឧសភា',
        6 => 'មិថុនា',
        7 => 'កក្កដា',
        8 => 'សីហា',
        9 => 'កញ្ញា',
        10 => 'តុលា',
        11 => 'វិច្ឆិកា',
        12 => 'ធ្នូ'
    ];

    // Initialize sales data for all months to 0
    foreach ($all_months as $month_number => $month_name) {
        $months[] = $month_name;
        $sales[] = 0;
    }

    // Fetch sales data from the database and populate the sales array
    while ($row = mysqli_fetch_array($result)) {
        $month_number = $row['Month'];
        $sales[$month_number - 1] = $row['TotalSales'];
    }
}
?>
<?php
$con  = mysqli_connect("localhost", "root", "", "sale");
if (!$con) {
    echo "Problem in database connection! Contact administrator!";
} else {
    // Fetch sales data grouped into four terms of three months each
    $sql = "SELECT 
                YEAR(create_at) AS Year,
                CONCAT(
                    'Term 1 (Jan-Mar)',
                    'Term 2 (Apr-Jun)',
                    'Term 3 (Jul-Sep)',
                    'Term 4 (Oct-Dec)'
                ) AS Term,
                SUM(CASE WHEN MONTH(create_at) BETWEEN 1 AND 3 THEN payment ELSE 0 END) AS Term1Sales,
                SUM(CASE WHEN MONTH(create_at) BETWEEN 4 AND 6 THEN payment ELSE 0 END) AS Term2Sales,
                SUM(CASE WHEN MONTH(create_at) BETWEEN 7 AND 9 THEN payment ELSE 0 END) AS Term3Sales,
                SUM(CASE WHEN MONTH(create_at) BETWEEN 10 AND 12 THEN payment ELSE 0 END) AS Term4Sales
            FROM payment 
            GROUP BY YEAR(create_at)";

    $result = mysqli_query($con, $sql);
    $chart_data = "";

    // Initialize arrays to store sales data for each term
    $years = [];
    $term1Sales = [];
    $term2Sales = [];
    $term3Sales = [];
    $term4Sales = [];

    // Fetch sales data from the database and populate the arrays
    while ($row = mysqli_fetch_array($result)) {
        $years[] = $row['Year'];
        $term1Sales[] = $row['Term1Sales'];
        $term2Sales[] = $row['Term2Sales'];
        $term3Sales[] = $row['Term3Sales'];
        $term4Sales[] = $row['Term4Sales'];
    }
}
?>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sale";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to fetch data from the database
$sql = "SELECT pro_id, COUNT(qty) AS qty
FROM saleproduct sl
INNER JOIN products p ON sl.pro_id = p.id
WHERE date(sl.create_at) = CURDATE()
GROUP BY pro_id;";
$result = $conn->query($sql);

// Fetch data and store it in an array
$salesData = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Get product name for display
        $productQuery = "SELECT pro_name FROM products WHERE id = " . $row['pro_id'];
        $productResult = $conn->query($productQuery);
        $productName = $productResult->fetch_assoc()['pro_name'];
        $salesData[] = array($productName, (int)$row['qty']);
    }
}

// Close connection
// $conn->close();
?>

<script type="text/javascript">
    google.charts.load('current', {
        'packages': ['corechart']
    });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ['ទំនិញ', 'ចំនួនលក់'],
            <?php
            // Output each data entry
            foreach ($salesData as $entry) {
                echo "['{$entry[0]}', {$entry[1]}],";
            }
            ?>
        ]);

        var options = {
            title: 'លក់ថ្ងៃនេះ',
            fontName: 'Kantumruy Pro',
            titleTextStyle: {
                fontName: 'Kantumruy Pro',
                fontSize: 16,
                bold: true
            },
            legend: {
                textStyle: {
                    fontName: 'Kantumruy Pro',
                    fontSize: 16
                }
            },
            tooltip: {
                text: 'value',
                textStyle: {
                    fontName: 'Kantumruy Pro',
                    fontSize: 16
                }
            },
            pieSliceText: 'value',
            pieSliceTextStyle: {
                fontName: 'Kantumruy Pro',
                fontSize: 16,
                bold: true
            }
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
    }
</script>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Kantumruy+Pro:ital,wght@0,100..700;1,100..700&display=swap" rel="stylesheet">

<style>
    body {
        font-family: 'Kantumruy Pro', sans-serif;
        font-size: 16px;
        /* Adjusting font size for better fit */
    }

    .khmer-text {
        font-family: 'Kantumruy Pro', sans-serif !important;
    }

    .card-header {
        font-family: 'Kantumruy Pro', sans-serif;
        font-size: 1.25rem;
        /* Adjusted font size */
        font-weight: 600;
    }

    /* Styles for table headers and data */
    .table thead th,
    .table tbody td {
        font-family: 'Kantumruy Pro', sans-serif;
        border: none;
        padding: 0.75rem 1rem;
    }
    
    .table thead th {
        border-bottom: 1px solid #e0e0e0;
        font-weight: 600;
    }
    
    .table tbody tr {
        border-bottom: 1px solid #f5f5f5;
    }
    
    .table-borderless tbody tr:last-child {
        border-bottom: none;
    }
    
    .table-hover tbody tr:hover {
        background-color: rgba(89, 105, 255, 0.05);
    }

    span.float-right.summary_icon {
        font-size: 3rem;
        position: absolute;
        right: 1rem;
        top: 0;
        max-width: calc(100%) !important;
    }

    .imgs {
        margin: .5em;
        max-width: calc(100%);
        max-height: calc(100%);
    }

    .imgs img {
        max-width: calc(100%);
        max-height: calc(100%);
        cursor: pointer;
    }

    #imagesCarousel,
    #imagesCarousel .carousel-inner,
    #imagesCarousel .carousel-item {
        height: 60vh !important;
        background: black;
    }

    #imagesCarousel .carousel-item.active {
        display: flex !important;
    }

    #imagesCarousel .carousel-item-next {
        display: flex !important;
    }

    #imagesCarousel .carousel-item img {
        margin: auto;
    }

    #imagesCarousel img {
        width: auto !important;
        height: auto !important;
        max-height: calc(100%) !important;
        max-width: calc(100%) !important;
    }

    /* New Dashboard Box Styles */
    .dashcard .card {
        transition: all 0.3s ease;
        border-radius: 15px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        height: 100%;
    }

    .dashcard .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
    }

    .dashcard .card-body {
        padding: 1.5rem;
    }

    .dashcard .card h4 {
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 1rem;
        color: #2c3e50;
        font-family: 'Kantumruy Pro', sans-serif;
    }

    .dashcard .card h3 {
        font-size: 2rem;
        font-weight: 700;
        margin: 0;
        color: #34495e;
        font-family: 'Kantumruy Pro', sans-serif;
    }

    .dashcard .theme-circle {
        position: relative;
        overflow: hidden;
    }

    .dashcard .theme-circle::before {
        content: '';
        position: absolute;
        width: 100px;
        height: 100px;
        border-radius: 50%;
        opacity: 0.1;
        right: -20px;
        bottom: -20px;
    }

    .dashcard .circle-primary::before {
        background-color: #5969ff;
    }

    .dashcard .circle-secondary::before {
        background-color: #ff407b;
    }

    .dashcard .circle-success::before {
        background-color: #25d5f2;
    }

    .dashcard .circle-info::before {
        background-color: #ffc750;
    }

    .dashcard .mb-3 {
        margin-bottom: 1.5rem !important;
    }

    @media (max-width: 768px) {
        .dashcard .col-md-3 {
            margin-bottom: 1rem;
        }
    }
</style>

<div class="containe-fluid" style="margin-top: 100px;">
    <div class="row mt-3 ml-3 mr-3 dashcard">
        <div class="col-md-3 mb-3">
            <div class="card bg-white border-0 circle-primary theme-circle">
                <div class="card-body">
                    <h4 class="text-dark khmer-text">ប្រភេទ</h4>
                    <div class="mt-3">
                        <div class="d-flex align-items-center">
                            <span class="text-dark khmer-text">
                                <h3><?php echo $cat[0]; ?></h3>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card bg-white border-0 circle-secondary theme-circle">
                <div class="card-body">
                    <h4 class="text-dark khmer-text">ប្រភេទតាមផ្នែក</h4>
                    <div class="mt-3">
                        <div class="d-flex align-items-center">
                            <span class="text-dark khmer-text">
                                <h3><?php echo $sub[0]; ?></h3>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card bg-white border-0 circle-success theme-circle">
                <div class="card-body">
                    <h4 class="text-dark khmer-text">ផលិតផល</h4>
                    <div class="mt-3">
                        <div class="d-flex align-items-center">
                            <span class="text-dark khmer-text">
                                <h3><?php echo $pro[0] ?></h3>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card bg-white border-0 circle-info theme-circle">
                <div class="card-body">
                    <h4 class="text-dark khmer-text">អ្នកប្រើប្រាស់</h4>
                    <div class="mt-3">
                        <div class="d-flex align-items-center">
                            <span class="text-dark khmer-text">
                                <h3><?php echo $user[0] ?></h3>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<hr>

<div class="container-fluid">
  
    <div class="row ml-2 mr-3">
        <div class="col-md-6 pr-4">
            <div class="card border-0">
                <div class="card-body p-4">
                    <div class="khmer-text mb-3">តម្លៃលក់ប្រចាំខែ</div>
                    <div style="height: 350px;">
                        <canvas id="chartjs_month"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 pl-4">
            <div class="card border-0">
                <div class="card-body p-4">
                    <div class="khmer-text mb-3">លក់ថ្ងៃនេះ</div>
                    <div style="height: 350px;">
                        <div id="piechart" style="width: 100%; height: 100%;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<br><br>
    
    <div class="row ml-2 mr-3">
        <div class="col-md-6 pr-4">
            <div class="card">
                <div class="card-header khmer-text">
                    <b>ទំនិញដែរលក់ដាច់ជាងគេទាំង១០</b>
                </div>
                <div class="card-body">
                    <table class="table table-hover table-borderless">
                        <thead>
                            <tr class="khmer-text">
                                <th class="text-center" style="width: 15%">ល.រ</th>
                                <th style="width: 55%">ទំនិញ</th>
                                <th class="text-center" style="width: 30%">ចំនួន</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $order = $conn->query("SELECT pro_name, SUM(qty) as total_sale, (@row_number:=@row_number + 1) AS row_num FROM saleproduct sp INNER JOIN products p ON sp.pro_id = p.id, (SELECT @row_number:=0) AS r GROUP BY pro_id ORDER BY total_sale DESC LIMIT 10; ");
                            while ($row = $order->fetch_assoc()) :
                            ?>
                                <tr class="khmer-text">
                                    <td class="text-center" style="width: 15%">
                                        <?php echo $row['row_num'] ?>
                                    </td>
                                    <td style="width: 55%">
                                        <?php echo $row['pro_name'] ?>
                                    </td>
                                    <td class="text-center" style="width: 30%">
                                        <?php echo number_format($row['total_sale']) ?>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-6 pl-4">
            <div class="card">
                <div class="card-header khmer-text">
                    <b>ទំនិញដែរលក់មិនសូវដាច់ជាងគេទាំង១០</b>
                </div>
                <div class="card-body">
                    <table class="table table-hover table-borderless">
                        <thead>
                            <tr class="khmer-text">
                                <th class="text-center" style="width: 15%">ល.រ</th>
                                <th style="width: 55%">ទំនិញ</th>
                                <th class="text-center" style="width: 30%">ចំនួន</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $order = $conn->query("SELECT pro_name, SUM(qty) as total_sale, (@row_number:=@row_number + 1) AS row_num FROM saleproduct sp INNER JOIN products p ON sp.pro_id = p.id, (SELECT @row_number:=0) AS r GROUP BY pro_id ORDER BY total_sale ASC LIMIT 10; ");
                            while ($row = $order->fetch_assoc()) :
                            ?>
                                <tr class="khmer-text">
                                    <td class="text-center" style="width: 15%">
                                        <?php echo $row['row_num'] ?>
                                    </td>
                                    <td style="width: 55%">
                                        <?php echo $row['pro_name'] ?>
                                    </td>
                                    <td class="text-center" style="width: 30%">
                                        <?php echo number_format($row['total_sale']) ?>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $('#manage-records').submit(function(e) {
        e.preventDefault()
        start_load()
        $.ajax({
            url: 'ajax.php?action=save_track',
            data: new FormData($(this)[0]),
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            type: 'POST',
            success: function(resp) {
                resp = JSON.parse(resp)
                if (resp.status == 1) {
                    alert_toast("Data successfully saved", 'success')
                    setTimeout(function() {
                        location.reload()
                    }, 800)

                }

            }
        })
    })
    $('#tracking_id').on('keypress', function(e) {
        if (e.which == 13) {
            get_person()
        }
    })
    $('#check').on('click', function(e) {
        get_person()
    })

    function get_person() {
        start_load()
        $.ajax({
            url: 'ajax.php?action=get_pdetails',
            method: "POST",
            data: {
                tracking_id: $('#tracking_id').val()
            },
            success: function(resp) {
                if (resp) {
                    resp = JSON.parse(resp)
                    if (resp.status == 1) {
                        $('#name').html(resp.name)
                        $('#address').html(resp.address)
                        $('[name="person_id"]').val(resp.id)
                        $('#details').show()
                        end_load()

                    } else if (resp.status == 2) {
                        alert_toast("Unknow tracking id.", 'danger');
                        end_load();
                    }
                }
            }
        })
    }
</script>
<script src="//code.jquery.com/jquery-1.9.1.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
<script type="text/javascript">
    var ctx = document.getElementById("chartjs_month").getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($months); ?>,
            datasets: [{
                label: 'តម្លៃលក់',
                backgroundColor: [
                    "#5969ff",
                    "#ff407b",
                    "#25d5f2",
                    "#ffc750",
                    "#2ec551",
                    "#7040fa",
                    "#ff004e"
                ],
                data: <?php echo json_encode($sales); ?>,
                skipNull: true, // Skip null values
                spanGaps: true // Connect points across null values
            }]
        },
        options: {
            defaultFontFamily: "'Kantumruy Pro', sans-serif",
            title: {
                display: true,
                text: 'តម្លៃលក់ប្រចាំខែ',
                fontFamily: "'Kantumruy Pro', sans-serif",
                fontSize: 16
            },
            tooltips: {
                callbacks: {
                    label: function(tooltipItem, data) {
                        if (tooltipItem.yLabel === null || tooltipItem.yLabel === undefined) {
                            return null;
                        }
                        var label = data.datasets[tooltipItem.datasetIndex].label || '';
                        label += ': $' + tooltipItem.yLabel.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
                        return label;
                    }
                },
                titleFontFamily: "'Kantumruy Pro', sans-serif",
                bodyFontFamily: "'Kantumruy Pro', sans-serif",
                titleFontSize: 16,
                bodyFontSize: 16
            },
            legend: {
                display: true,
                position: 'bottom',
                labels: {
                    fontColor: '#71748d',
                    fontFamily: "'Kantumruy Pro', sans-serif",
                    fontSize: 16,
                    padding: 20
                }
            },
            scales: {
                xAxes: [{
                    ticks: {
                        fontFamily: "'Kantumruy Pro', sans-serif",
                        fontSize: 14,
                        fontStyle: 'normal'
                    }
                }],
                yAxes: [{
                    ticks: {
                        fontFamily: "'Kantumruy Pro', sans-serif",
                        fontSize: 13,
                        callback: function(value, index, values) {
                            return '$' + value.toLocaleString(); // Format currency with comma separator
                        }
                    }
                }]
            }
        }
    });
</script>

<script type="text/javascript">
    var ctx_today = document.getElementById("chartjs_today").getContext('2d');
    var todayChart = new Chart(ctx_today, {
        type: 'bar',
        data: {
            labels: <?php
                    $today_sales = array();
                    $today_query = $conn->query("SELECT pro_name, SUM(qty) as total_qty 
                    FROM saleproduct sp 
                    INNER JOIN products p ON sp.pro_id = p.id 
                    WHERE DATE(sp.create_at) = CURDATE() 
                    GROUP BY pro_id 
                    ORDER BY total_qty DESC 
                    LIMIT 5");
                    $labels = array();
                    $data = array();
                    while ($row = $today_query->fetch_assoc()) {
                        $labels[] = $row['pro_name'];
                        $data[] = $row['total_qty'];
                    }
                    echo json_encode($labels);
                    ?>,
            datasets: [{
                label: 'ចំនួនលក់',
                backgroundColor: "#5969ff",
                data: <?php echo json_encode($data); ?>,
            }]
        },
        options: {
            defaultFontFamily: "'Kantumruy Pro', sans-serif",
            title: {
                display: true,
                text: 'ចំនួនលក់ថ្ងៃនេះ',
                fontFamily: "'Kantumruy Pro', sans-serif",
                fontSize: 16
            },
            tooltips: {
                titleFontFamily: "'Kantumruy Pro', sans-serif",
                bodyFontFamily: "'Kantumruy Pro', sans-serif",
                titleFontSize: 16,
                bodyFontSize: 16
            },
            legend: {
                display: true,
                position: 'bottom',
                labels: {
                    fontColor: '#71748d',
                    fontFamily: "'Kantumruy Pro', sans-serif",
                    fontSize: 16,
                    padding: 20
                }
            },
            scales: {
                xAxes: [{
                    ticks: {
                        fontFamily: "'Kantumruy Pro', sans-serif",
                        fontSize: 14,
                        fontStyle: 'bold'
                    }
                }],
                yAxes: [{
                    ticks: {
                        fontFamily: "'Kantumruy Pro', sans-serif",
                        fontSize: 13,
                        beginAtZero: true,
                        callback: function(value) {
                            return value.toLocaleString();
                        }
                    }
                }]
            }
        }
    });
</script>