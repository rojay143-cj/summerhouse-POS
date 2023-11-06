<?php 
    include("../connection/connection.php");
    include("source.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Overview</title>
    <link rel="stylesheet" href="../css/summerStyle.css">
    <link rel="stylesheet" href="../api/datatable.css">
    <script src="../api/datatable.js"></script>
</head>
<body>
    <header class="p-2 header-style">
        <div class="container">
            <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
                <a href="orders.php" class="nav-link px-2 text-white"><img src="../images/logo.png" alt="logo" style="height: 90px;width: 90px;border-radius: 50%;object-fit: contain"></a>
                <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                <li class="nav-bar mt-2"><a href="admin.php" class="nav-link px-2 text-white">Home</a></li>
                <li class="nav-bar mt-2"><a href="" class="nav-link px-2 text-white" id="active">Orders</a></li>
                <li class="nav-bar mt-2"><a href="reports.php" class="nav-link px-2 text-white">Reports</a></li>
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
        <div class="row table-wrap pt-5">
            <table id="example" class="table table-striped" style="width:100%">
                <thead>
                    <tr>
                        <th>Ordered By</th>
                        <th>Customer Name</th>
                        <th>Product Name</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Sub-Total</th>
                        <th>Payment Method</th>
                        <th>Ordered Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if(isset($orderData)){
                        foreach($orderData as $rowOrder){
                            $date = $rowOrder['created_at'];
                        
                    ?>
                    <tr>
                        <td><?php echo $rowOrder['display_name']; ?></td>
                        <td><?php echo $rowOrder['customer_name']; ?></td>
                        <td><?php echo $rowOrder['product_name']; ?></td>
                        <td><?php echo $rowOrder['price']; ?></td>
                        <td><?php echo $rowOrder['quantity']; ?></td>
                        <td><?php echo $rowOrder['subtotal']; ?></td>
                        <td><?php echo $rowOrder['payment_type']; ?></td>
                        <td><?php echo date('y-m-d h:m',strtotime($rowOrder['created_at'])); ?></td>
                        <td><form action="orders.php?id=<?php echo $rowOrder['product_id']; ?>" method="post"><button type="submit" class="btn btn-danger" name="btn-delete">Delete</button></form></td>
                    </tr>
                    <?php }} ?>
                </tbody>
            </table>
        </div>
    </div>
    
    <script>
        new DataTable('#example');
    </script>
</body>
</html>