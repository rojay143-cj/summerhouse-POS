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
    <link rel="stylesheet" href="mystyle.css">
    <link rel="stylesheet" href="../api/bootstrap.min.css">
    <script src="../api/Jquery.js"></script>
    <script src="../api/bootstrap.min.js"></script>
</head>
<body>
        <header class="p-2 header-style">
            <div class="container-fluid">
                <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start head-nav">
                    <a href="admin.php" class="nav-link px-2 text-white"><img src="../images/logo.png" alt="logo" style="height: 90px;width: 90px;border-radius: 50%;object-fit: contain"></a>
                    <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                    <li class="nav-bar mt-2"><a href="admin.php" class="nav-link px-2" style="color: orange">Home</a></li>
                    <li class="nav-bar mt-2"><a href="orders.php" class="nav-link px-2 text-white">Orders</a></li>
                    <li class="nav-bar mt-2"><a href="reports.php" class="nav-link px-2 text-white">Reports</a></li>
                    <li class="nav-bar mt-2"><a href="products.php" class="nav-link px-2 text-white">Products</a></li>
                    <li class="nav-bar mt-2"><a href="categories.php" class="nav-link px-2 text-white">Categories</a></li>
                    <li class="nav-bar mt-2"><a href="accounts.php" class="nav-link px-2 text-white">Accounts</a></li>
                    <li class="nav-bar mt-2"><a href="SMS.php" class="nav-link px-2 text-white">Send SMS</a></li>
                    </ul>
                    <div class="text-end">
                    <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3" role="search">
                    <span class="text-white welcome">Welcome, <?php echo $_SESSION['displayName']."! "."(".$_SESSION['roleType']." - ".$_SESSION['roleDes'].")" ?></span>
                    <a class="btn-log" href="../logout.php">Logout</a>
                    </div>
                    </form>
                </div>
            </div>
        </header>
        <div class="container-fluid">
        <div class="row">
        <div class="col-sm-7">
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

            <div class="card mt-4 shadow-lg rounded" id="itemlist-wrapper" style="height: 890px; overflow-y: auto;">
                <div class="card text-wrap" id="item-list" style="max-height: 100%; overflow-y: auto;">
                    <?php
                        foreach ($data as $row) {
                    ?>
                        <form action="admin.php?id=<?php echo  $row['product_id']; ?>" method="POST">
                            <div class="card mt-2 ms-2 shadow-lg rounded" style="width: 250px; height: 300px;">
                                <img class="card-img-top rounded-bottom img-thumbnail h-50 object-fit-cover" src="<?php echo $row['image']; ?>">
                                <div class="card-body" style="font-size: 15px; line-height:3px">
                                    <h6 class="card-title"><?php echo $row['product_name']; ?></h6>
                                    <p class="mt-2">₱<?php echo $row['price']; ?></p>
                                    <div class="mt-2 text-wrap">
                                        <input type="number" name="txtQuan" class="text-center rounded-pill w-100" min="0" value="1" required>
                                        <button class="btn btn-primary rounded-pill w-100 mt-2" style="height: 30px; font-size: 12px;" name="addList">Add to list</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    <?php
                        }
                    ?>
                </div>
            </div>
        </div>
        <div class="col-sm-6" id="list">
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
                            ₱<?php echo $foodRow['price']; ?></h6>
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
                        <button name="checkOut" type="button" id="checkOut" class="btn btn-success w-100" style="font-size: 20px" data-bs-toggle="modal" data-bs-target="#myModal">Check Out</button>
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
                    <div class="modal-content modalMain fs-6" style="width: 550px;font-family: sans-serif;">
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
                        <h1 class="error text-danger text-center"></h1>
                            <div class="modal-footer">
                                <form action="" method="post">
                                <select name="payType" class="payType">
                                    <option value="" selected>Payment Type</option>
                                    <option value="Cash">Cash</option>
                                    <option value="GCash">GCash</option>
                                    <option value="Bank Transfer">Bank Transfer</option>
                                </select>
                                <input type="text" class="placeText" name="txtCus" id="" placeholder="Customer Name" required>
                                <input type="text" class="placeText" name="txtPayamount" id="payamount" placeholder="Payment Amount" required>
                                <input type="text" class="placeText" name="txtmobnumber" minlength="13" maxlength="13" id="mobnumber" placeholder="Mobile number (+639*********)" required>
                                <textarea class="placeText txtArea" name="txtNote" placeholder="Notes(Optional)"></textarea>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-info text-white" style="font-size: 20px" data-bs-toggle="modal" data-bs-target="#summaryModal">View Summary</button>
                                <button type="submit" name="placeOrder" id="placeOrder" class="btn btn-success">PLACE ORDER</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CANCEL</button>
                            </div>
                            </form>
                        </div>
                </div>
        </div>

        <!-- Summary Modal -->
        <div class="modal fade" id="summaryModal" tabindex="-1" aria-labelledby="summaryModalLabel" aria-hidden="true">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content modalMain fs-6">
                    <div class="modal-header">
                        <h4 class="modal-title" style="font-size: 20px">Order Summary</h4>
                    </div>
                    <div class="modal-body">
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
                </div>
            </div>
        </div>






    
    <script>
        $(document).ready(function () {
            $("#search").on("input", function () {
                var searchTerm = $(this).val().toLowerCase();
                var $cards = $("#item-list .card");

                $cards.each(function () {
                    var productDetails = $(this).text().toLowerCase();
                    var matchesSearchTerm = productDetails.includes(searchTerm) || searchTerm === "";
                    $(this).toggle(matchesSearchTerm);
                });
            });
            $("#item-list").on("click", "button[name='addList']", function () {
                $(this).closest('form').submit();
            });
        });
    </script>

    <script>
        $(document).ready(function(){
            var grndTotal = $('.totals').val();
            $('#payamount').on("change",function(){
                var payamount = $('#payamount').val();
                if(payamount >= grndTotal){
                    //$(this).css({'color': 'black'});
                    $('.error').html("");
                }else{
                    //$(this).css({'color': 'red'});
                    $('.error').html("Invalid Payment Amount");
                }
            });
        })
    </script>
</body>
</html>