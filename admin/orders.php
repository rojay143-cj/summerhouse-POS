<?php 
    require("../connection/connection.php");
    require("source.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ORDERS</title>
    <link rel="stylesheet" href="mystyle.css">
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
                <li class="nav-bar mt-2"><a href="admin.php" class="nav-link px-2 text-white">Home</a></li>
                <li class="nav-bar mt-2"><a href="" class="nav-link px-2" id="active">Orders</a></li>
                <li class="nav-bar mt-2"><a href="reports.php" class="nav-link px-2 text-white">Reports</a></li>
                <li class="nav-bar mt-2"><a href="products.php" class="nav-link px-2 text-white">Products</a></li>
                <li class="nav-bar mt-2"><a href="categories.php" class="nav-link px-2 text-white">Categories</a></li>
                <li class="nav-bar mt-2"><a href="accounts.php" class="nav-link px-2 text-white">Accounts</a></li>
                <li class="nav-bar mt-2"><a href="SMS.php" class="nav-link px-2 text-white">Send SMS</a></li>
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
            <h1 class="text-center">★Transactions</h1>
            <div class="card mt-4 shadow-lg rounded" id="itemlist-wrapper" style="height: 700px; overflow-y: auto;">
            <table class="table table-striped table-borderless mt-5">
                <thead>
                    <tr>
                        <th><h5 class="text-secondary">ORDER NUMBER</th>
                        <th><h5 class="text-secondary">CUSTOMER NAME</th>
                        <th><h5 class="text-secondary">PAYMENT TYPE</th>
                        <th><h5 class="text-secondary">ORDERED ON</th>
                        <th><h5 class="text-secondary">ORDER STATUS</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $orderData = array_reverse($orderData); foreach ($orderData as $rowOrder) { ?>
                        <tr style="font-size: 16px; font-family:verdana;" class="border rounded trans" data-bs-toggle="collapse" data-bs-target="#collapse_<?php echo $rowOrder['order_id']; ?>" data-order-id="<?php echo $rowOrder['order_id']; ?>">
                            <td class="text-primary"><?php echo $rowOrder['order_id']; ?></td>
                            <td><?php echo $rowOrder['customer_name']; ?></td>
                            <td><?php echo $rowOrder['payment_type']; ?></td>
                            <td><?php echo $rowOrder['created_at']; ?></td>
                            <td><form action="orders.php?orderId=<?php echo $rowOrder['order_id']; ?>" method="post">
                                    <select name="status" class="p-1" onchange="this.form.submit()">
                                        <option value=""><?php echo $rowOrder['order_stat']; ?></option>
                                        <option value="Pending">Pending</option>
                                        <option value="Completed">Completed</option>
                                        <option value="Cancelled">Cancelled</option>
                                    </select>
                                </form>
                                <?php
                                    if(isset($_POST['status'])){
                                        $orderId = $_GET['orderId'];
                                        $status = $_POST['status'];
                                        $sqlStatus = "UPDATE orders SET order_stat = '$status' WHERE order_id = '$orderId'";
                                        $sqlStatus = mysqli_query($conn, $sqlStatus);
                                        header('location: orders.php');
                                    }
                                ?>
                            </td>
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
                                            <li class="list-group-item text-end text-nowrap text-white mb-3">
                                                <form action="receipt.php?orderId=<?php echo $rowOrder['order_id']; ?>" method="post" target="_blank">
                                                    <button type="submit" class="btn btn-info text-white">View receipt</button>
                                                </form>
                                            </li>
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
    <script>
        new DataTable('#example');
    </script>
</body>
</html>