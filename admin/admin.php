<?php 
    require("../connection/connection.php");
    require('../cart.php');


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Summerhouse Cafe</title>
    <link rel="stylesheet" href="../api/fontawesome.css">
    <link rel="stylesheet" href="mystyles.css">
    <link rel="stylesheet" href="../api/bootstrap.min.css">
    <script src="../api/Jquery.js"></script>
    <script src="../api/bootstrap.min.js"></script>
    
</head>
<body>
        <header class="p-2 header-style">
            <div class="container-fluid">
            <a href="admin.php" class="nav-link px-2 text-white w-25" id="logo1"><img src="../images/logo.png" alt="logo" style="height: 90px;width: 90px;border-radius: 50%;object-fit: contain"></a>
                <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start head-nav">
                <a href="admin.php" class="nav-link px-2 text-white" id="logo2"><img src="../images/logo.png" alt="logo" style="height: 90px;width: 90px;border-radius: 50%;object-fit: contain"></a>
                    <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0" id="nav">
                    <li class="nav-bar mt-2"><a href="admin.php" class="nav-link px-2" id="active">Home</a></li>
                    <li class="nav-bar mt-2"><a href="orders.php" class="nav-link px-2 text-white">Orders</a></li>
                    <li class="nav-bar mt-2"><a href="reports.php" class="nav-link px-2 text-white">Reports</a></li>
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
                    <li class="nav-bar"><a href="admin.php" class="nav-link px-2" id="active">Home</a></li>
                    <li class="nav-bar mt-4"><a href="orders.php" class="nav-link px-2 text-white">Orders</a></li>
                    <li class="nav-bar mt-4"><a href="reports.php" class="nav-link px-2 text-white">Reports</a></li>
                    <li class="nav-bar mt-4"><a href="products.php" class="nav-link px-2 text-white">Products</a></li>
                    <li class="nav-bar mt-4"><a href="categories.php" class="nav-link px-2 text-white">Categories</a></li>
                    <li class="nav-bar mt-4 mb-4"><a href="accounts.php" class="nav-link px-2 text-white">Accounts</a></li>
                    <span class="text-white">Welcome, <?php echo $_SESSION['displayName']."! "."(".$_SESSION['roleType']." - ".$_SESSION['roleDes'].")" ?></span>
                    <a class="btn fs-6 fw-bold text-white" style="background-color: rgb(255, 128, 0);" href="../logout.php">Logout</a>               
                </ul>
            </div>
            </div>
        </header>
        <div class="container-fluid">
        <div class="row">
        <div class="col-sm-7" id="main">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="POST" class="mt-5">
                <div class="input-group w-100 text-end">
                    <div class="w-auto text-start">
                        <select class="form-select" aria-label="Default select example" id="categoryId" name="categoryId" onchange="this.form.submit();">
                            <option value="" class="btn btn-secondary dropdown-toggle" style="background-color: rgb(255, 128, 0);">All Categories</option>
                            <?php
                            foreach ($categories as $category) {
                            ?>
                                <option value="<?php echo $category['category_id']; ?>" class="btn btn-light dropdown-toggle"><?php echo $category['category_name']; ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="flex-grow-1 text end">
                        <input type="text" class="text-center h-100 rounded border-secondary" id="search" onkeydown="return event.key != 'Enter';" class="form-control w-25" placeholder="Search..." aria-label="Search" aria-describedby="basic-addon2">
                    </div>
                </div>
            </form>

            <div class="card cards mt-4 shadow-lg rounded" id="itemlist-wrapper" style="height: 890px; overflow-y: auto;">
                <div class="card text-wrap" id="item-list" style="max-height: 100%; overflow-y: auto;">
                    <?php
                        foreach ($data as $row) {
                            if($row['prod_stat'] == 1){
                                echo'
                                    <script>
                                        $(document).ready(function(){
                                            $("#disabled").html("Disabled");
                                        })
                                ';
                            }
                    ?>
                        <form action="admin.php?id=<?php echo  $row['product_id']; ?>" method="POST">
                            <div class="card mt-2 ms-2 shadow-lg rounded" style="width: 250px; height: 300px;">
                                <img class="card-img-top rounded-bottom img-thumbnail h-50 object-fit-cover" src="<?php echo $row['image']; ?>">
                                <div class="card-body" style="font-size: 15px; line-height:3px">
                                    <h6 class="card-title"><?php echo $row['product_name']; ?></h6>
                                    <p class="mt-2">Php <?php echo $row['price']; ?></p>
                                    <div class="mt-2 text-wrap">
                                        <input type="number" name="txtQuan" class="text-center rounded-pill w-100" min="0" value="1" required>
                                        <button class="btn btn-primary rounded-pill w-100 mt-2" style="height: 30px; font-size: 12px;" name="addList">Add to list</button>
                                        <h6 id="disabled"></h6>
                                    </div>
                                </div>
                            </div>
                        </form>
                    <?php
                        echo '</script>';
                        }
                    ?>
                </div>
            </div>
        </div>
        <div class="col-sm" id="list">
            <div class="card mt-4" id="list-list">
            <span class="mt-4 border-top-0 shadow p-3 mb-5 bg-white rounded" id="orderlist">
                <h1 class="ms-4 sunborn">★Order List</h1>
                <p class="medium text-secondary ms-4 mb-4">Employee: <?php echo $_SESSION['txtUsername']; ?></p>
                <hr>
                    <?php
                        $grandTotal = 0;
                        $totalQuan = 0;
                        foreach($_SESSION['cart'] as $key => $Quan){
                            $sqlFood = "SELECT * FROM products WHERE product_id = $key";
                            $sqlFood = mysqli_query($conn, $sqlFood);
                            while($foodRow = $sqlFood -> fetch_array()){
                                    $grandTotal += $foodRow['price'] * $Quan;
                                    $totalQuan = $totalQuan + $Quan;
                                    $_SESSION['grandtotal'] = $grandTotal;
                                    $_SESSION['totalQuan'] = $totalQuan;
                                
                    ?>
                    <ul class="list-group mt-3">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <h6 class="text-wrap w-75"><?php echo $foodRow['product_name'];  ?>
                            Php<?php echo $foodRow['price']; ?></h6>
                            <span>
                            <form action="admin.php?id=<?php echo $key; ?>" method="post" style="text-align: right;">
                            <button type="submit" class="border-0" name="btn-minus"><img src="../images/dash-circle-fill.svg" style="width: 30px"></button>
                            <input type="number" class="text-center small w-25" value="<?php echo $Quan ?>"></span>
                            <button type="submit" class="border-0" name="btn-plus"><img src="../images/circle-plus-solid.svg" style="width: 30px;"></button>
                            <button type="submit" class="border-0" name="btn-remove"><img width="30px" height="30px" src="../images/trash.svg" alt="trash"/></button>
                        </form>
                            </span>
                        </li>
                    </ul>

                    <?php
                        }}
                    ?>
                    <div class="totalFoot border-0 mt-5">
                            <h3 class="mt-5">Total </h3>
                            <h3 class="text-end text-success mt-5">Php <?php echo number_format($grandTotal); ?></h3>
                    </div>
                    <form method="post">
                        <button name="checkOut" type="button" id="checkOut" class="btn btn-success w-100" style="font-size: 20px" data-bs-toggle="modal" data-bs-target="#myModal">Order</button>
                    </form>
                </div>
                <div class="card shadow p-3 mb-5 bg-white rounded">
                    <h1 class="text-center text-secondary"><?php echo $_SESSION['msg']; ?></h1>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content modalMain fs-6" style="width: 650px;font-family: sans-serif;">
                    <div class="modal-header">
                        <h4 class="modal-title display-7 w-100 text-center">Order Confirmation</h4>
                    </div>
                    <div class="modal-body">
                        <table class="orderList">
                            <tr>
                                <th class="orderList">PRODUCT</th>
                                <th class="orderList">QUANTITY</th>
                                <th class="orderList">SUBTOTAL</th>
                            </tr>
                            <?php
                                foreach($_SESSION['cart'] as $key => $Quan){
                                    $sqlFood = "SELECT * FROM products WHERE product_id = $key";
                                    $sqlFood = mysqli_query($conn, $sqlFood);
                                    while($foodRow = $sqlFood -> fetch_array()){
                                        $_SESSION['food'] = $foodRow['price'];
            
                            ?>
                            <tr>
                                <td class="orderList"><?php echo $foodRow['product_name'] ?></td>
                                <td class="orderList"><?php echo $Quan ?></td>
                                <td class="orderList">₱<?php echo number_format($foodRow['price'] * $Quan) ?></td>
                            </tr>
                            <?php }} ?>
                        </table>
                    </div>
                        <div class="totalFoot">
                            <div class="totalText">Total: </div>
                            <div class="total"><?php echo "Php ".number_format($grandTotal); ?></div>
                            <input type="hidden" class="totals" value="<?php echo $grandTotal; ?>">
                        </div>
                        <h5 class="error text-danger text-center"></h5>
                            <div class="modal-footer">
                                <select class="payType" id="payType">
                                    <option value="" selected>Payment Type</option>
                                    <option value="Cash">Cash</option>
                                    <option value="GCash">GCash</option>
                                    <option value="Bank Transfer">Bank Transfer</option>
                                </select>
                                <input type="text" class="placeText" id="txtCus" placeholder="Customer Name" required>
                                <input type="number" class="placeText" id="txtPayamount" placeholder="Payment Amount" required>
                                <input type="text" class="placeText" minlength="13" maxlength="13" id="txtmobnumber" value="+63" placeholder="Mobile number (+639*********)" required>
                                <textarea class="placeText txtArea" id="txtNote" placeholder="Notes(Optional)"></textarea>
                            </div>
                            <div class="modal-footer">
                                <button type="button" id="viewSummary" class="text-white btn btn-success">Check Out</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CANCEL</button>
                            </div>
                        </div>
                </div>
        </div>

        <!-- Summary Modal (data-bs-toggle="modal" data-bs-target="#summaryModal") -->
        <div class="modal fade" id="summaryModal" tabindex="-1" aria-labelledby="summaryModalLabel" aria-hidden="true">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content modalMain fs-6 p-2" style="width: 650px;font-family: sans-serif;">
                    <div class="modal-header">
                        <h4 class="modal-title w-100 text-center display-7">Order Details</h4>
                    </div>
                    <div class="card ms-2 border-0">
                    <form action="" method="post">
                        <h4 class="w-100">Customer: <input type="text" name="txtCus" id="txtCus1" class="border-0 bg-white"></h4>
                        <h4 class="w-100">Mobile Number: <input type="text" name="txtmobnumber" id="txtmobnumber1" class="border-0 bg-white"></h4>
                        <h4 class="w-100">Payment Method: 
                            <select name="payType" id="payType1" class="border-0" style="-webkit-appearance: none;">
                                <option value="Cash">Cash</option>
                                <option value="GCash">GCash</option>
                                <option value="Bank Transfer">Bank Transfer</option>
                            </select>
                        </h4>
                        <h4 class="w-100">Reference Number: <input type="text" name="txtrefnum" id="txtrefnum1" class="border-0 bg-white"></h4>
                        <h4 class="w-100">Amount Tendered: <input type="text" name="txtPayamount" id="txtPayamount1" class="border-0 bg-white"></h4>
                        <textarea class="placeText txtArea" style="width: 98%;" name="txtNote" id="txtNote1" placeholder="Customer Notes Here!"></textarea>
                    </div>
                    <div class="modal-body mt-5">
                        <table class="orderList">
                            <tr>
                                <th class="orderList">PRODUCT</th>
                                <th class="orderList">QUANTITY</th>
                                <th class="orderList">SUBTOTAL</th>
                            </tr>
                            <?php
                            foreach ($_SESSION['cart'] as $key => $Quan) {
                                $sqlFood = "SELECT * FROM products WHERE product_id = $key";
                                $sqlFood = mysqli_query($conn, $sqlFood);
                                while ($foodRow = $sqlFood->fetch_array()) {
                                    $_SESSION['food'] = $foodRow['price'];
                                    ?>
                                    <tr>
                                        <td class="orderList"><?php echo $foodRow['product_name'] ?></td>
                                        <td class="orderList"><?php echo $Quan ?></td>
                                        <td class="orderList">₱<?php echo number_format($foodRow['price'] * $Quan) ?></td>
                                    </tr>
                                <?php }
                            } ?>
                        </table>
                    </div>
                    <div class="totalFoot">
                        <div class="totalText">Total: </div>
                        <div class="total"><?php echo "Php " . number_format($grandTotal); ?></div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="placeOrder" id="placeOrder" class="btn btn-success">PLACE ORDER</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CANCEL</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        <script src="../summerJS/summers.js"></script>
</body>
</html>