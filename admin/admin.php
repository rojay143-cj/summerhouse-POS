<?php 
    include("../connection/connection.php");
    include('../cart.php');


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Summerhouse Cafe</title>
    <link rel="stylesheet" href="../css/myStyle.css">
    <link rel="stylesheet" href="../api/datatable.css">
    <script src="../api/datatable.js"></script>
    
</head>
<body>
        <header class="p-3 header-style"">
            <div class="container">
                <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
                    <a href="/" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
                    <svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap"><use xlink:href="#bootstrap"/></svg>
                    </a>
                    <a href="admin.php" class="nav-link px-2 text-white"><img src="../images/logo.png" alt="logo" style="height: 90px;width: 90px;border-radius: 50%;object-fit: contain"></a>
                    <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                    <li class="nav-bar"><a href="" class="nav-link px-2 text-white" id="active">Home</a></li>
                    <li class="nav-bar"><a href="orders.php" class="nav-link px-2 text-white">Orders</a></li>
                    <li class="nav-bar"><a href="reports.php" class="nav-link px-2 text-white">Reports</a></li>
                    <li class="nav-bar"><a href="products.php" class="nav-link px-2 text-white">Products</a></li>
                    <li class="nav-bar"><a href="categories.php" class="nav-link px-2 text-white">Categories</a></li>
                    <li class="nav-bar"><a href="accounts.php" class="nav-link px-2 text-white">Accounts</a></li>
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
        <div class="container" id="order">
        <div class="row">
        <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="POST" class="mt-5">
                <select class="dropdown" name="categoryId" onchange="this.form.submit();">
                <option value="" class="btn btn-secondary dropdown-toggle" style="background-color: rgb(255, 128, 0);">Choose Categories...</option>
                <?php
                    foreach($categories as $category){
                ?>
                    <option value="<?php echo $category['category_id']; ?>" class="btn btn-secondary dropdown-toggle"><?php echo $category['category_name']; ?></option>
                <?php 
                    }
                    
                ?>
                </select>
        </form>
            <div class="col-sm sidebar-left">
                <?php
                    foreach($data as $row){
                ?>
            <form action="admin.php?id=<?php echo  $row['product_id']; ?>" method="POST">
                    <div class="food-container">
                        <div><img style="height: 150px;width: 250px; object-fit: cover;" src="<?php echo $row['image']; ?>"></div>
                        <div style="color: #fff;"><?php echo $row['product_name']; ?></div>
                        <div>₱<?php echo $row['price']; ?></div>
                        <div><input type="number" name="txtQuan" min="0" value="1" required></div>
                        <div><button name="addList">Add to list</button></div>
                    </div>
            </form>
                <?php
                    }
                ?>
        </div>
        <div class="col-sm sidebar-right">
            <header class="wrap mt-2">
                <h1>Order List</h1>
                <p style="font-size: 24px;">Employee: <?php echo $_SESSION['txtUsername']; ?></p>
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
                    <div class="food-wrap">
                        <div>
                            <p><?php echo $foodRow['product_name'];  ?>
                           ₱<?php echo $foodRow['price']; ?></p>
                        </div>
                        <form action="admin.php?id=<?php echo $key; ?>" method="post" style="text-align: right;">
                            <button type="submit" name="btn-minus">-</button>
                            <span style="margin-right: 10px;margin-left: 10px;"><?php echo $Quan ?></span>
                            <button type="submit" name="btn-plus">+</button>
                        </form>
                    </div>
                    <?php
                        }}
                    ?>
                    <div>
                        <h4>Total: ₱<?php echo number_format($grandTotal);?> </h4>
                        <br>
                        <p> <?php echo $_SESSION['msg']; ?></p>
                    </div>
                    <form method="post"><div><button name="checkOut" type="button" class="checkOut" data-bs-toggle="modal" data-bs-target="#myModal">Check Out</button></div></form>
                </header>
        </div>

                <!-- Modal -->
                <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" style="font-size: 20px">Order Confirmation</h4>
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
                            <div class="totalText">Total: <?php  ?></div>
                            <div class="total">₱<?php echo " ".number_format($grandTotal); ?></div>
                        </div>
                            <div class="modal-footer">
                                <form action="" method="post">
                                <select name="payType" class="payType">
                                    <option value="" selected>Payment Type</option>
                                    <option value="Cash">Cash</option>
                                    <option value="GCash">GCash</option>
                                    <option value="Bank Transfer">Bank Transfer</option>
                                </select>
                                <input type="text" class="placeText" name="txtCus" id="" placeholder="Customer Name" required>
                                <input type="text" class="placeText" name="txtPayamount" id="" placeholder="Payment Amount" required>
                                <textarea class="placeText txtArea" name="txtNote" placeholder="Notes(Optional)"></textarea>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" name="placeOrder" id="placeOrder" class="btn btn-success">PLACE ORDER</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CANCEL</button>
                            </div>
                            </form>
                        </div>

                </div>
                </div>

    <script src="js/js.js"></script>
</body>
</html>