<?php 
    require("../connection/connection.php");
    require("source.php");
?>
<?php 
    //Date Range
    if(isset($_POST['subRange'])){
        if(isset($_POST['startDate']) && isset($_POST['endDate'])){
            $start_date_str = $_POST['startDate'];
            $end_date_str = $_POST['endDate'];
            $start_date = DateTime::createFromFormat('Y-m-d', $start_date_str);
            $end_date = DateTime::createFromFormat('Y-m-d', $end_date_str);
    
            if (!$start_date || !$end_date) {
                echo "<h1 style='color:white;background-color: red;text-align:center'>Error: Unable to create reports (Please set the DATE RANGE).<h1>";
                echo"<script>
                        setTimeout(function(){
                            window.location.href='reports.php';
                        }, 1300);
                    </script>";
                exit;
            }
            
            $startDate = $start_date->format('Y-m-d');
            $endDate = $end_date->format('Y-m-d');
        }
        $sqlReports = "SELECT *,SUM(CASE WHEN payment_type = 'cash' THEN total_amount ELSE 0 END) as cash,
                        SUM(CASE WHEN payment_type = 'gcash' THEN total_amount ELSE 0 END) as gcash,
                        SUM(CASE WHEN payment_type = 'bank transfer' THEN total_amount ELSE 0 END) as bank,
                        SUM(total_amount) as totalsales
                        FROM orders WHERE CAST(created_at as DATE) BETWEEN '$startDate' AND '$endDate'";
        $sqlReports = mysqli_query($conn, $sqlReports);
        while ($rowReport = $sqlReports -> fetch_array()) {
            $reportData[] = $rowReport;
        }

        $sqltotalOrder = "SELECT products.product_name, sum(quantity) as totalorders,count(*) as totalsold FROM products INNER JOIN (SELECT product_id, count(*) as orders 
        FROM order_details GROUP BY product_id ORDER BY orders DESC LIMIT 1) as bestseller ON products.product_id = bestseller.product_id
        JOIN order_details
        JOIN orders ON order_details.order_id = orders.order_id WHERE CAST(created_at as DATE) BETWEEN '$startDate' AND '$endDate'";
        $sqltotalOrder = mysqli_query($conn, $sqltotalOrder);
        while($totOrder = $sqltotalOrder -> fetch_array()) {
            $totOrderData[] = $totOrder;
        } 
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Summerhouse Cafe</title>
    <link rel="stylesheet" href="../css/summerStyles.css">
    <link rel="stylesheet" href="../api/datatable.css">
    <link rel="stylesheet" href="../api/fontAwesome.css">
    <script src="../api/datatable.js"></script>
    <script src="../summerJS/summer.js"></script>
    <script src="../api/Jquery.js"></script>
    <style>
        @font-face {
            font-family: "summerGotitalic";
            src: url(../fonts/Gotham-UltraItalic.otf);
        }@font-face{
            font-family: "summerGotlight";
            src: url(../fonts/Gotham-Bold.otf);
        }
        .row{
            display: grid;
            grid-template-columns: 48% 48%;
            column-gap: 2vh;
        }.totSales h4{
            font-family: summerGotitalic;
            font-size: 29px;
        }.row h5{
            font-family: summerGotlight;
        }
    </style>
</head>
<body>
    <header class="p-2 header-style">
            <div class="container">
                <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
                    <a href="reports.php" class="nav-link px-2 text-white"><img src="../images/logo.png" alt="logo" style="height: 90px;width: 90px;border-radius: 50%;object-fit: contain"></a>
                    <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                    <li class="nav-bar mt-2"><a href="admin.php" class="nav-link px-2 text-white">Home</a></li>
                    <li class="nav-bar mt-2"><a href="orders.php" class="nav-link px-2 text-white">Orders</a></li>
                    <li class="nav-bar mt-2"><a href="reports.php" class="nav-link px-2 text-white" id="active">Reports</a></li>
                    <li class="nav-bar mt-2"><a href="products.php" class="nav-link px-2 text-white">Products</a></li>
                    <li class="nav-bar mt-2"><a href="categories.php" class="nav-link px-2 text-white">Categories</a></li>
                    <li class="nav-bar mt-2"><a href="accounts.php" class="nav-link px-2 text-white">Accounts</a></li>
                    </ul>
                    <div class="text-end">
                    <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3" role="search">
                    <span class="text-white">Welcome, <?php echo $_SESSION['displayName']."! "."(".$_SESSION['roleType']." - ".$_SESSION['roleDes'].")" ?></span>
                    <a class="checkOut" href="../logout.php">Logout</a>
                    </div>
                    </form>
                </div>
            </div>
    </header>
    <div class="container mt-5 reports-container">
        <h4 class="mt-3 display-6">Overview Dashboard</h4>
        <div class="input-group mt-3">
            <div class="dropdown">
                <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown">
                <img src="../images/calendar.jpg" style="width: 30px;height: 30px;margin: 10px;" alt="calendar">SELECT DATE
                </button>
                <ul class="dropdown-menu">
                    <form action="" method="post">
                    <li><button type="submit" class="dropdown-item text-center bg-secondary text-white shadow rounded" name="weekly">Weekly</button></li>
                    <li><button type="submit" class="dropdown-item text-center bg-secondary text-white mt-2 shadow rounded" name="monthly">Monthly</button></li>
                    <li><button type="submit" class="dropdown-item text-center bg-secondary text-white mt-2 shadow rounded" name="yearly">Yearly</button></li>
                    </form>
                    <div class="text-center mt-2">
                        <form action="" method="post">
                        <input type="text" class="text-center" placeholder="Start Date" id="startDate" name="startDate">
                        <input class="mt-2 text-center" type="text" placeholder="End Date" id="endDate" name="endDate">
                        <button class="mt-2 mb-2" type="submit" name="subRange">Submit</button>
                        </form>
                    </div>
                    <div id="datePicker" class="d-none" name="datePicker"></div>
                </ul>
            </div>
        </div>
        <div class="row mt-3">
            <div>
            <p class="text-center text-secondary">Previous Day</p>
            <div class="shadow p-3 mb-5 mt-2 bg-body rounded">
                <?php 
                    foreach ($totOrderData as $totOrder) {
                        
                    }
                    foreach ($reportData as $rowReport) {

                    }
                    foreach ($todayData as $rowToday) {

                    }
                    foreach ($todayDatas as $rowTodays) {

                    }
                ?>
                <div class="m-4 p-5 totSales">
                    <h5 class="display-6">Total Sales</h5>
                    <h4 class="text-primary">Php <?php echo number_format($rowReport['totalsales']); ?>.00</h5>
                </div>
                <hr>
                <div class="row col text-center">
                    <h5>Cash sales</h5>
                    <h5>Php <?php echo number_format($rowReport['cash']); ?>.00</h5>
                </div>
                <div class="row col text-center">
                    <h5>Gcash sales</h5>
                    <h5>Php <?php echo number_format($rowReport['gcash']); ?>.00</h5>
                </div>
                <div class="row col text-center">
                    <h5>Online Bank sales</h5>
                    <h5>Php <?php echo number_format($rowReport['bank']); ?>.00</h5>
                </div>
                <hr>
                <div class="row col text-center">
                    <h5>Total orders</h5>
                    <h5><?php echo $totOrder['totalorders']; ?></h5>
                </div>
                <div class="row col text-center">
                    <h5>Total products sold</h5>
                    <h5><?php echo $totOrder['totalsold']; ?></h5>
                </div>
                <div class="row col text-center">
                    <h5>Best Seller</h5>
                    <h5><?php echo $totOrder['product_name']; ?></h5>
                </div>
            </div>
            </div>
            <div>
            <p class="text-center text-secondary">Today</p>
            <div class="shadow p-3 mb-5 mt-2 bg-body rounded">
            <div class="m-4 p-5 totSales">
                    <h5 class="display-6">Total Sales</h5>
                    <h4 class="text-primary">Php <?php echo number_format($rowToday['totalsales']); ?>.00</h5>
                </div>
                <hr>
                <div class="row col text-center">
                    <h5>Cash sales</h5>
                    <h5>Php <?php echo number_format($rowToday['cash']); ?>.00</h5>
                </div>
                <div class="row col text-center">
                    <h5>Gcash sales</h5>
                    <h5>Php <?php echo number_format($rowToday['gcash']); ?>.00</h5>
                </div>
                <div class="row col text-center">
                    <h5>Online Bank sales</h5>
                    <h5>Php <?php echo number_format($rowToday['bank']); ?>.00</h5>
                </div>
                <hr>
                <div class="row col text-center">
                    <h5>Total orders</h5>
                    <h5><?php echo $rowTodays['totalorders']; ?></h5>
                </div>
                <div class="row col text-center">
                    <h5>Total products sold</h5>
                    <h5><?php echo $rowTodays['totalsold']; ?></h5>
                </div>
                <div class="row col text-center">
                    <h5>Best Seller</h5>
                    <h5><?php echo $rowTodays['product_name']; ?></h5>
                </div>
            </div>
            </div>
        </div>
    </div>
    <div class="container" style="display: grid; grid-template-columns: auto auto">
    </div>
    <script>
        $(document).ready(function(){
            $('#startDate').datepicker();
            $('#endDate').datepicker();
            $('#startDate').datepicker("option", "dateFormat", "yy-mm-dd");
            $('#endDate').datepicker("option", "dateFormat", "yy-mm-dd");

            $('#startDate').datepicker({onSelect:function(selectedDate){
                $('#endDate').datepicker("option","minDate",selectedDate);
                }
            });
            $('#endDate').datepicker({onSelect:function(selectedDate){
                $('#startDate').datepicker("option","maxDate",selectedDate);
                }
            });
        });
    </script>
</body>
</html>