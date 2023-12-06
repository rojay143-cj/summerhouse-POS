<?php 
    include("../connection/connection.php");
    session_start();

?>
<?php
    /* Orders.php Region */
    $username = $_SESSION['userId'];
    $today = date('y-m-d', time());
    if(!isset($orderData)){
        $orderData =[];
    }
    $sqlgetOrder = "SELECT *, orders.created_at,order_details.quantity
    FROM products
    JOIN order_details ON products.product_id = order_details.product_id
    JOIN orders ON order_details.order_id = orders.order_id
    JOIN users ON orders.user_id = users.user_id WHERE orders.user_id = $username AND CAST(created_at as DATE) = '$today' GROUP BY orders.order_id";
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
    <title>ORDERS</title>
    <link rel="stylesheet" href="../admin/mystyle.css">
    <link rel="stylesheet" href="../api/datatable.css">
    <script src="../api/datatable.js"></script>
    <style>
        .trans{
            cursor: pointer;
        }
    </style>
</head>
<body>
    <header class="p-2 header-style">
        <div class="container-fluid">
            <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
                <a href="admin.php" class="nav-link px-2 text-white"><img src="../images/logo.png" alt="logo" style="height: 90px;width: 90px;border-radius: 50%;object-fit: contain"></a>
                <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                <li class="nav-bar mt-2"><a href="staff.php" class="nav-link px-2 text-white">Home</a></li>
                <li class="nav-bar mt-2"><a href="orders.php" class="nav-link px-2" id="active">Orders</a></li>
                </ul>
                <div class="text-end">
                <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3" role="search">
                <span class="text-white">Welcome, <?php echo $_SESSION['displayName']."! "."(".$_SESSION['roleType']." - ".$_SESSION['roleDes'].")" ?></span>
                <a class="btn-log" href="../logout.php">Logout</a>
                </div>
                </form>
            </div>
        </div>
    </header>
    <div class="container-fluid">
    <div class="row">
        <div class="card-body mt-5">
            <h1 class="text-center sunborn">★Transactions</h1>
            <div class="card mt-4 shadow-lg rounded" id="itemlist-wrapper" style="height: 700px; overflow-y: auto;">
            <table class="table table-striped table-borderless mt-5">
                <thead>
                    <tr>
                        <th><h5 class="text-secondary">ORDER NUMBER</th>
                        <th><h5 class="text-secondary">CUSTOMER NAME</th>
                        <th><h5 class="text-secondary">PAYMENT TYPE</th>
                        <th><h5 class="text-secondary">ORDERED ON</th>
                        <th><h5 class="text-secondary">MOBILE NUMBER</th>
                        <th><h5 class="text-secondary"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $orderData = array_reverse($orderData); foreach ($orderData as $rowOrder) { ?>
                        <tr style="font-size: 16px; font-family:verdana;" class="border rounded trans" data-bs-toggle="collapse" data-bs-target="#collapse_<?php echo $rowOrder['order_id']; ?>" data-order-id="<?php echo $rowOrder['order_id']; ?>">
                            <td class="text-primary"><?php echo $rowOrder['order_id']; ?></td>
                            <td><?php echo $rowOrder['customer_name']; ?></td>
                            <td><?php echo $rowOrder['payment_type']; ?></td>
                            <td><?php echo $rowOrder['created_at']; ?></td>
                            <td><?php echo $rowOrder['mobile_num']; ?></td>
                            <td><h3>🔽</h3></td>
                        </tr>
                        <tr>
                            <td colspan="5">
                                <div class="collapse border" id="collapse_<?php echo $rowOrder['order_id']; ?>">
                                    <div class="d-flex justify-content-start flex-wrap">
                                        <?php
                                        $orderId = $rowOrder['order_id'];
                                            $sqlreadAll = "SELECT *, orders.created_at, order_details.quantity
                                                FROM products
                                                JOIN order_details ON products.product_id = order_details.product_id
                                                JOIN orders ON order_details.order_id = orders.order_id
                                                JOIN users ON orders.user_id = users.user_id
                                                WHERE order_details.order_id = '$orderId'";
                                            $sqlreadAll = mysqli_query($conn, $sqlreadAll);
                                            while ($rowread = $sqlreadAll->fetch_assoc()) {
                                                //$readalldata[] = $rowread;
                                                ?>
                                                <div class="card shadow m-2" style="width: 16rem;">
                                                    <img src="<?php echo $rowread['image']; ?>" class="img-thumbnail rounded object-fit-cover" style="height: 140px">
                                                    <div class="card-body">
                                                        <h5 class="card-title text-start"><?php echo $rowread['product_name']; ?></h5>
                                                        <div class="d-inline">
                                                        <ul class="list-group list-group-horizontal">
                                                            <li class="list-group-item w-100"><?php echo $rowread['quantity']; ?><span style="font-size: 10px">QTY</span></li>
                                                            <li class="list-group-item text-end text-primary text-nowrap">Php <span><?php echo $rowread['subtotal']; ?>.00</span></li>
                                                        </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                        <?php $readalldata[] = $rowread;} ?>
                                    </div>
                                    <?php foreach($readalldata as $rowread) {} ?>
                                    <div class="d-inline">
                                        <h2 class="mx-2">Total amount</h2>
                                        <ul class="list-group list-group-horizontal mx-2">
                                            <li class="list-group-item text-primary text-nowrap w-100 mb-3"><h5>Php <?php echo $rowread['total_amount']; ?>.00</h5></li>
                                            <li class="list-group-item text-start text-wrap mb-3 w-75">NOTE: <div><?php echo $rowread['notes']; ?></div></li>
                                        </ul>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            </div>
        </div>
    </div>
</div>
<!--



    <div class="container-fluid mt-5">
        <div class="row table-wrap pt-5 m-5">
            <h1 class="text-center">★Transactions</h1>
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
                            //$date = date_create($rowOrder["created_at"],timezone_open("Asia/Bangkok"));
                            //echo date_format($date,"y-m-d h:m:s")
                    ?>
                    <tr>
                        <td><?php echo $rowOrder['display_name']; ?></td>
                        <td><?php echo $rowOrder['customer_name']; ?></td>
                        <td><?php echo $rowOrder['product_name']; ?></td>
                        <td>₱<?php echo $rowOrder['price']; ?></td>
                        <td><?php echo $rowOrder['quantity']; ?><span style="font-size: 11px;">qty</span></td>
                        <td>₱<?php echo $rowOrder['subtotal']; ?></td>
                        <td><?php echo $rowOrder['payment_type']; ?></td>
                        <td><?php echo $rowOrder['created_at']; ?></td>
                        <td><form action="orders.php?orderId=<?php echo $rowOrder['product_id']; ?>" method="post">
                        <button type="submit" class="btn btn-danger" name="orderDelete">Delete</button></form></td>
                    </tr>
                    <?php }} ?>
                </tbody>
            </table>
        </div>
    </div>
-->
    <script>
        new DataTable('#example');
    </script>
</body>
</html>