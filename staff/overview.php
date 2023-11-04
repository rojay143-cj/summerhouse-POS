<?php 
    include("../connection/connection.php");
    include("../cart.php");

?>

<?php
    $username = $_SESSION['userId'];
    $today = date('y-m-d', time());
    $sqlgetOrder = "SELECT * FROM order_details JOIN products ON order_details.product_id = products.product_id 
    JOIN orders ON orders.order_id = order_details.order_id WHERE orders.user_id = $username AND CAST(created_at as DATE) = '$today'";
    $orderResult = mysqli_query($conn, $sqlgetOrder);
        while($rowOrder = $orderResult -> fetch_assoc()){
            $orderData[] = $rowOrder;
        }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Overview</title>
    <link rel="stylesheet" href="../css/myStyle.css">
    <link rel="stylesheet" href="../api/datatable.css">
    <script src="../api/datatable.js"></script>
</head>
<body>
    <header class="p-3 header-style">
        <div class="container">
            <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
                <a href="/" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
                <svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap"><use xlink:href="#bootstrap"/></svg>
                </a>
                <a href="staff.php" class="nav-link px-2 text-white"><img src="../images/logo.png" alt="logo" style="height: 90px;width: 90px;border-radius: 50%;object-fit: contain"></a>
                <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                <li class="nav-bar"><a href="staff.php" class="nav-link px-2 text-white">Home</a></li>
                <li class="nav-bar"><a href="" class="nav-link px-2 text-white" id="active">Orders</a></li>
                </ul>


                <div class="text-end">
                <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3" role="search">
                <span class="text-white">Welcome, <?php echo $_SESSION['txtUsername']."! "."(".$_SESSION['roleType']." - ".$_SESSION['roleDes'].")" ?></span>
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
                        <th>Customer Name</th>
                        <th>Product Name</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Sub-Total</th>
                        <th>Payment Method</th>
                        <th>Ordered Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if(isset($orderData)){
                        foreach($orderData as $rowOrder){
                            $date = $rowOrder['created_at'];
                        
                    ?>
                    <tr>
                        <td><?php echo $rowOrder['customer_name']; ?></td>
                        <td><?php echo $rowOrder['product_name']; ?></td>
                        <td><?php echo $rowOrder['price']; ?></td>
                        <td><?php echo $rowOrder['quantity']; ?></td>
                        <td><?php echo $rowOrder['subtotal']; ?></td>
                        <td><?php echo $rowOrder['payment_type']; ?></td>
                        <td><?php echo $rowOrder['created_at']; ?></td>
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