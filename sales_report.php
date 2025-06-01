<?php
include 'db_connect.php';
$month = isset($_GET['month']) ? $_GET['month'] : date('Y-m');
?>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Kantumruy+Pro:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>
    body, .card, .card_body, .table, .form-control, .btn, select, label, th, td {
        font-family: 'Kantumruy Pro', sans-serif !important;
    }
    
    .card {
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05) !important;
        border: none !important;
        border-radius: 8px !important;
    }
    
    .card_body {
        padding: 1.5rem !important;
    }
    
    .table {
        border: none !important;
        margin-bottom: 0 !important;
    }
    
    .table th {
        background-color: #f8f9fa !important;
        color: #495057 !important;
        font-weight: 600 !important;
        border-bottom: 2px solid #dee2e6 !important;
        border-top: none !important;
        padding: 12px 15px !important;
    }
    
    .table td {
        border-color: #f2f2f2 !important;
        padding: 12px 15px !important;
        vertical-align: middle !important;
    }
    
    .form-control, .form-select {
        border-radius: 4px !important;
        border-color: #dee2e6 !important;
        padding: 8px 12px !important;
    }
    
    .form-control:focus, .form-select:focus {
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.15) !important;
        border-color: #80bdff !important;
    }
    
    .btn-primary {
        background-color: #2c3e50 !important;
        border-color: #2c3e50 !important;
    }
    
    .btn-primary:hover {
        background-color: #1e2b37 !important;
        border-color: #1e2b37 !important;
    }
    
    .btn-success {
        background-color: #28a745 !important;
        border-color: #28a745 !important;
    }
    
    .btn-success:hover {
        background-color: #218838 !important;
        border-color: #1e7e34 !important;
    }
    
    .form-inline {
        display: flex !important;
        flex-wrap: wrap !important;
        align-items: center !important;
        gap: 10px !important;
    }
    
    label {
        margin-bottom: 0 !important;
        margin-right: 5px !important;
        font-weight: 500 !important;
    }
    
    hr {
        margin: 1.5rem 0 !important;
        opacity: 0.1 !important;
    }
    
    .text-right {
        text-align: right !important;
    }
    
    /* Print Styles */
    @media print {
        body {
            background-color: white !important;
            font-size: 12pt !important;
        }
        
        .container-fluid {
            width: 100% !important;
            padding: 0 !important;
            margin: 0 !important;
        }
        
        .card {
            box-shadow: none !important;
            border: none !important;
            margin: 0 !important;
        }
        
        .card_body {
            padding: 0 !important;
        }
        
        .no-print, .btn, .form-inline, hr {
            display: none !important;
        }
        
        .table {
            width: 100% !important;
            border-collapse: collapse !important;
        }
        
        .table th {
            background-color: #f8f9fa !important;
            color: #000 !important;
            border: 1px solid #dee2e6 !important;
            font-weight: bold !important;
        }
        
        .table td {
            border: 1px solid #dee2e6 !important;
        }
        
        .print-header {
            text-align: center !important;
            margin-bottom: 20px !important;
            padding-bottom: 10px !important;
            border-bottom: 1px solid #dee2e6 !important;
        }
        
        .print-header h1 {
            font-size: 18pt !important;
            font-weight: bold !important;
            margin-bottom: 5px !important;
        }
        
        .print-header p {
            font-size: 10pt !important;
            margin: 0 !important;
        }
        
        .print-footer {
            text-align: center !important;
            margin-top: 20px !important;
            padding-top: 10px !important;
            border-top: 1px solid #dee2e6 !important;
            font-size: 9pt !important;
        }
    }
</style>

<div class="container-fluid" style="padding: 20px;">
    <div class="col-lg-12">
        <div class="card" style="margin-top: 60px;">
            <div class="card_body">
                <h4 class="mb-4">របាយការណ៍ការលក់</h4>
                <div class="row justify-content-center">
                    <form class="form-inline" method="POST" action="">
                        <label id="lb_date">កាលបរិច្ឆេទ:</label>
                        <input type="date" class="form-control" placeholder="ចាប់ផ្តើម" name="date1" id="date1" value="<?php echo isset($_POST['date1']) ? $_POST['date1'] : '' ?>" />
                        <label id="lb_to">ដល់</label>
                        <input type="date" class="form-control" placeholder="បញ្ចប់" name="date2" id="date2" value="<?php echo isset($_POST['date2']) ? $_POST['date2'] : '' ?>" />

                        <button name="search" class="btn btn-primary ml-2" id="search">ស្វែងរក</button>

                        <input type="hidden" name="daily" value="1">
                        <!-- Select dropdown for search options -->
                        <select name="search_option" class="form-select form-select-sm ml-2 mr-2" id="search_option">
                            <option value="daily">ប្រចាំថ្ងៃ</option>
                            <option value="weekly">ប្រចាំសប្តាហ៍</option>
                            <option value="monthly">ប្រចាំខែ</option>
                            <option value="term">ប្រចាំវគ្គ</option>
                            <option value="semester">ប្រចាំសមester្តិក</option>
                            <option value="year">ប្រចាំឆ្នាំ</option>
                        </select>
                        <button type="submit" name="submit_search" class="btn btn-primary">ស្វែងរក</button>
                    </form>

                </div>
                <hr>
                <div class="col-md-12">
                    <table class="table table-bordered" id='report-list'>
                        <thead>
                            <tr>
                                <th>ល.រ</th>
                                <th class="">ឈ្មោះផលិតផល</th>
                                <th class="">បរិមាណ</th>
                                <th class="">តម្លៃឯកតា</th>
                                <th class="">ចំនួនទឹកប្រាក់</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php include "range.php" ?>
                            <tr>
                                <th colspan="4" class="text-right border-bottom">សរុប</th>
                                <th class="text-right border-bottom"><?php include "total.php" ?></th>
                                <!-- <th class="text-right"><?php echo number_format($total, 2) ?></th> -->
                            </tr>
                        </tbody>

                    </table>
                    <hr>
                    <div class="col-md-12 mb-4 mt-4">
                        <div class="text-center">
                            <button class="btn btn-success px-4 py-2" type="button" id="print"><i class="fa fa-print mr-2"></i> បោះពុម្ព</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<noscript>
    <style>
        table#report-list {
            width: 100%;
            border-collapse: collapse;
        }

        table#report-list,
        table#report-list td,
        table#report-list th {
            border: 1px solid black;
            /* Specify the color you want */
            padding: 8px;
            text-align: center;
        }

        p {
            margin: unset;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }
    </style>
</noscript>

<script>
    $('#month').change(function() {
        location.replace('index.php?page=sales_report&month=' + $(this).val())
    })
    $('#print').click(function() {
        var _c = $('#report-list').clone();
        var ns = $('noscript').clone();
        ns.append(_c);
        var nw = window.open('', '_blank', 'width=900,height=600');
        
        // Create a more professional print layout
        var printContent = `
            <div class="print-header">
                <h1>របាយការណ៍ការលក់</h1>
                <p>កាលបរិច្ឆេទ: ${$('#date1').val() || '---'} ដល់ ${$('#date2').val() || '---'}</p>
                <p>ប្រភេទរបាយការណ៍: ${$('#search_option option:selected').text() || 'ប្រចាំខែ'}</p>
            </div>
            ${ns.html()}
            <div class="print-footer">
                <p>បានបោះពុម្ពនៅថ្ងៃទី ${new Date().toLocaleDateString('km-KH')}</p>
            </div>
        `;

        nw.document.write(`
            <!DOCTYPE html>
            <html>
            <head>
                <title>របាយការណ៍ការលក់</title>
                <meta charset="UTF-8">
                <link href="https://fonts.googleapis.com/css2?family=Kantumruy+Pro:wght@400;500;600;700&display=swap" rel="stylesheet">
                <style>
                    body {
                        font-family: 'Kantumruy Pro', sans-serif;
                        margin: 0;
                        padding: 20px;
                        background-color: white;
                    }
                    table {
                        width: 100%;
                        border-collapse: collapse;
                        margin-bottom: 20px;
                    }
                    table, th, td {
                        border: 1px solid #dee2e6;
                    }
                    th, td {
                        padding: 8px 12px;
                        text-align: left;
                    }
                    th {
                        background-color: #f8f9fa;
                        font-weight: 600;
                    }
                    .print-header {
                        text-align: center;
                        margin-bottom: 20px;
                        padding-bottom: 10px;
                        border-bottom: 1px solid #dee2e6;
                    }
                    .print-header h1 {
                        font-size: 18pt;
                        margin: 0 0 10px 0;
                    }
                    .print-header p {
                        margin: 5px 0;
                        font-size: 10pt;
                    }
                    .print-footer {
                        text-align: center;
                        margin-top: 20px;
                        padding-top: 10px;
                        border-top: 1px solid #dee2e6;
                        font-size: 9pt;
                    }
                    .text-right {
                        text-align: right;
                    }
                    .text-center {
                        text-align: center;
                    }
                </style>
            </head>
            <body>
                ${printContent}
            </body>
            </html>
        `);

        nw.document.close();
        nw.focus();

        // Wait for fonts to load before printing
        setTimeout(() => {
            nw.print();
            setTimeout(() => {
                nw.close();
            }, 500);
        }, 500);
    })
</script>
<script>
    $(document).ready(function() {
        // Assuming you're using PHP to determine the pre-selected option
        var selectedOption = "<?php echo isset($_POST['search_option']) ? $_POST['search_option'] : ''; ?>";

        if (selectedOption !== '') {
            $('#search_option').val(selectedOption);
        }
    });
</script>