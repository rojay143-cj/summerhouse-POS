<?php 
    require("../connection/connection.php");
    require("source.php");
?>
<?php 
    if(empty($bestData) || empty($modData)){
        $bestData = [];
        $modData = [];
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Summerhouse Cafe</title>
    <link rel="stylesheet" href="mystyles.css">
    <link rel="stylesheet" href="../api/datatable.css">
    <script src="../api/datatable.js"></script>
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
            grid-template-columns: 100%;
            column-gap: 2vh;
        }.totSales h4{
            font-family: summerGotitalic;
            font-size: 35px;
        }.row h5{
            font-family: summerGotlight;
        }
    </style>
</head>
<body>
    <header class="p-2 header-style">
            <div class="container-fluid">
            <a href="admin.php" class="nav-link px-2 text-white w-25" id="logo1"><img src="../images/logo.png" alt="logo" style="height: 90px;width: 90px;border-radius: 50%;object-fit: contain"></a>
                <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start head-nav">
                <a href="admin.php" class="nav-link px-2 text-white" id="logo2"><img src="../images/logo.png" alt="logo" style="height: 90px;width: 90px;border-radius: 50%;object-fit: contain"></a>
                    <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0" id="nav">
                    <li class="nav-bar mt-2"><a href="admin.php" class="nav-link px-2 text-white">Home</a></li>
                    <li class="nav-bar mt-2"><a href="orders.php" class="nav-link px-2 text-white">Orders</a></li>
                    <li class="nav-bar mt-2"><a href="reports.php" class="nav-link px-2" id="active">Reports</a></li>
                    <li class="nav-bar mt-2"><a href="products.php" class="nav-link px-2 text-white">Products</a></li>
                    <li class="nav-bar mt-2"><a href="categories.php" class="nav-link px-2 text-white">Categories</a></li>
                    <li class="nav-bar mt-2"><a href="accounts.php" class="nav-link px-2 text-white">Accounts</a></li>                    
                    </ul>
                    <div class="text-end">
                    <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3" id="welcome" role="search">
                    <span class="text-white welcome">Welcome, <?php echo $_SESSION['displayName']."! "."(".$_SESSION['roleType']." - ".$_SESSION['roleDes'].")" ?></span>
                    <a class="btn-log" href="../logout.php">Logout</a>
                    </div>
                    </form>
                    <label for="menu-toggle" class="menu-icon fs-1">&#9776;</label>
                    <input type="checkbox" id="menu-toggle">
                </div>
                <div class="dropdown_menu">
                <ul class="dropdown_nav col-12 col-lg-auto me-lg-auto text-center mb-md-0">
                    <li class="nav-bar"><a href="admin.php" class="nav-link px-2 text-white">Home</a></li>
                    <li class="nav-bar mt-4"><a href="orders.php" class="nav-link px-2 text-white">Orders</a></li>
                    <li class="nav-bar mt-4"><a href="reports.php" class="nav-link px-2" id="active">Reports</a></li>
                    <li class="nav-bar mt-4"><a href="products.php" class="nav-link px-2 text-white">Products</a></li>
                    <li class="nav-bar mt-4"><a href="categories.php" class="nav-link px-2 text-white">Categories</a></li>
                    <li class="nav-bar mt-4 mb-4"><a href="accounts.php" class="nav-link px-2 text-white">Accounts</a></li>
                    <span class="text-white">Welcome, <?php echo $_SESSION['displayName']."! "."(".$_SESSION['roleType']." - ".$_SESSION['roleDes'].")" ?></span>
                    <a class="btn fs-6 fw-bold text-white" style="background-color: rgb(255, 128, 0);" href="../logout.php">Logout</a>               
                </ul>
            </div>
            </div>
    </header>
    <div class="container mt-5 reports-container" style="height: 850px">
        <h4 class="mt-3 display-6">★Overview Dashboard</h4>
        <div class="input-group">
            <div class="dropdown">
                <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown">
                <img src="../images/calendar.jpg" style="width: 30px;height: 30px;margin: 10px;" alt="calendar">SELECT DATE
                </button>
                <ul class="dropdown-menu">
                    <form action="" method="post">
                        <span class="input-group-text">Monthly:<input type="month" class="p-2" onchange="this.form.submit()" name="monthly"></span>
                    </form>
                    <form action="" method="post">
                        <span class="input-group-text">
                                Yearly: 
                                <select onchange="this.form.submit()" name="yearly" id="yearly" class="w-100 h-25 text-center p-2 ms-3">
                                <option value="">Select a year</option>
                                <?php 
                                    for($i = 0; $i <= 37;$i++){
                                        $year = date("Y", strtotime("last day of +$i year"));
                                    
                                ?>
                                <option value="<?php echo $year ?>"><?php echo $year ?></option>
                                <?php } ?>
                            </select>
                        </span>
                    </form>
                    <div class="text-center mt-2">
                        <form action="" method="post" class="text-center">
                        <span class="">Custom</span>
                        <br>
                        <input type="text" class="text-center" placeholder="Start Date" id="startDate" name="startDate">
                        <input class="mt-2 text-center" type="text" placeholder="End Date" id="endDate" name="endDate">
                        <br>
                        <button class="mt-2 mb-2 range" type="submit" name="subRange">Submit</button>
                        </form>
                    </div>
                    <!--<div id="datePicker" class="d-none" name="datePicker"></div>-->
                </ul>
            </div>
        </div>
        <div class="row mt-2">
            <div class="previous-wrap">
            <div class="text-secondary text-center p-1 mt-2 mb-2">
                <h5 class="bg-warning text-muted"><?php echo $_SESSION['msgWarning']; ?></h5>
            </div>
            <div class="shadow bg-body rounded prev w-100 text-center">
                <div class="row">
                    <div class="m-2 p-2 totSales col text-nowrap">
                        <h5 class="display-6">Total sales</h5>
                        <h4 class="text-muted">Php <?php echo number_format($rowReport['totalsales']); ?>.00</h4>
                    </div>
                    <div class="totSales">
                        <a data-bs-toggle="modal" href="#exampleModalToggle"><span class="btn btn-danger">View Report</span></a>
                    </div>
                </div>
                <hr>
                <div class="row col text-center">
                    <h5>Cash sales</h5>
                    <h5 class="text-muted">Php <?php echo number_format($rowReport['cash']); ?>.00</h5>
                </div>
                <div class="row col text-center">
                    <h5>Gcash sales</h5>
                    <h5 class="text-muted">Php <?php echo number_format($rowReport['gcash']); ?>.00</h5>
                </div>
                <div class="row col text-center">
                    <h5>Online Bank sales</h5>
                    <h5 class="text-muted">Php <?php echo number_format($rowReport['bank']); ?>.00</h5>
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
                    <h5>✧<?php echo $totOrder['product_name']; ?></h5>
                </div>
            </div>
            </div>
        </div>
    </div>

    <!-- MODAL region -->
    <div class="modal fade" id="exampleModalToggle" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title p-3 text-center w-100" id="exampleModalToggleLabel">★Daily Report</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="reports">
                <div class="container">
                    <div class="row">
                    <h5 class="bg-warning text-muted text-center"><?php echo $_SESSION['msgWarning']; ?></h5>
                       <div>
                       <table class="shadow p-3 mb-5 bg-body rounded table table-striped table-hover">
                            <thead class="">
                                <th>| Order ID |</th>
                                <th>| Quantity |</th>
                                <th>| Order Total |</th>
                                <th>| Payment Method |</th>
                            </thead>
                            <tbody>
                                <?php
                                    foreach ($modData as $rowmodorder){
                                        
                                ?>
                                <tr>
                                    <td>#<?php echo $rowmodorder['order_id']; ?></td>
                                    <td><?php echo $rowmodorder['quantity']; ?></td>
                                    <td>Php <?php echo $rowmodorder['total_amount']; ?></td>
                                    <td><?php echo $rowmodorder['payment_type']; ?></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        <div class="d-flex text-center shadow p-3 mb-5 bg-body rounded w-100">
                            <div class="d-block text-center shadow p-3 mb-5 bg-body rounded w-50">
                                <h5 class="bg-secondary text-white">Total Orders</h5>
                                <h5><?php echo $totOrder['totalorders']; ?></h5>
                            </div>
                            <div class="d-block text-center shadow p-3 mb-5 bg-body rounded w-50">
                                <h5 class="bg-secondary text-white">Total Products Sold</h5>
                                <h5><?php echo $totOrder['totalsold']; ?></h5>
                            </div>
                            <div class="d-block text-center shadow p-3 mb-5 bg-body rounded w-50">
                                <h5 class="bg-secondary text-white">Total Amount</h5>
                                <h5>Php <?php echo number_format($rowReport['totalsales']); ?>.00</h5>
                                <h6>Discount: Php <?php echo $_SESSION['discount']; ?>.00</h6>
                                <h6>VAT: Php <?php echo $_SESSION['vat']; ?>.00</h6>
                            </div>
                        </div>
                       </div>
                        <div class="shadow p-3 bg-body rounded text-center">
                            <div class="text-center ps-5 px-5">
                                <div class="d-block text-center shadow p-3 mb-5 bg-body rounded w-100">
                                    <h5 class="bg-secondary text-white">Total Cash Sales</h5>
                                    <h5>Php <?php echo number_format($rowReport['cash']); ?>.00</h5>
                                </div>
                                <div class="d-block text-center shadow p-3 mb-5 bg-body rounded w-100">
                                <h5 class="bg-secondary text-white">Total GCash Sales</h5>
                                    <h5>Php <?php echo number_format($rowReport['gcash']); ?>.00</h5>
                                </div>
                                <div class="d-block text-center shadow p-3 mb-5 bg-body rounded w-100">
                                    <h5 class="bg-secondary text-white">Total Online Bank Sales</h5>
                                    <h5>Php <?php echo number_format($rowReport['bank']); ?>.00</h5>
                                </div>
                                <div class="d-block text-center shadow p-3 mb-5 bg-body rounded w-100">
                                    <h5 class="bg-secondary text-white">Top Best Sellers</h5>
                                    <?php
                                        foreach($bestData as $rowbestseller){
                                    ?>
                                    <ul class="">
                                        <li class="list-group-item">✧<?php echo $rowbestseller['product_name'] ?></li>
                                    </ul>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button aria-label="Print" id="btn-print" class="btn btn-info p-2 text-white">Print Reports</button>
                <button data-bs-dismiss="modal" aria-label="Close" class="btn btn-secondary p-2 text-white">Close</button>
            </div>
            </div>
        </div>
    </div>

    <script src="../summerJS/summers.js"></script>
</body>
</html>