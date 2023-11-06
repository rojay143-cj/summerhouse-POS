<?php 
    include("../connection/connection.php");
    include("source.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Summerhouse Cafe</title>
    <link rel="stylesheet" href="../css/summerStyle.css">
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
                    <li class="nav-bar mt-2"><a href="" class="nav-link px-2 text-white" id="active">Reports</a></li>
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
    <div class="container mt-5">
        <h4>Overview Dashboard</h4>
        <form method="POST" class="input-group mt-3">
            <div class="dropdown">
                <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown">
                <img src="../images/calendar.jpg" style="width: 30px;height: 30px;margin: 10px;" alt="calendar">SELECT DATE
                </button>
                <ul class="dropdown-menu">
                    <li><button type="submit" class="dropdown-item text-center" name="weekly">Weekly</button></li>
                    <li><button type="submit" class="dropdown-item text-center" name="monthly">Monthly</button></li>
                    <li><button type="submit" class="dropdown-item text-center" name="yearly">Yearly</button></li>
                    <div id="datePicker" name="datePicker"></div>
                </ul>
            </div>
        </form>
        <div class="row mt-3">
            <div>
            <p class="text-center">Previous Day</p>
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
            <p class="text-center">Today</p>
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
</body>
</html>