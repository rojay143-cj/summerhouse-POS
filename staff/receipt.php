<?php 
    require("../connection/connection.php");
    require("../admin/source.php");

?>

<?php 
    $orderId = $_GET['orderId'];
    $sqlreceipt = "SELECT *, orders.created_at,order_details.quantity
    FROM products
    JOIN order_details ON products.product_id = order_details.product_id
    JOIN orders ON order_details.order_id = orders.order_id
    JOIN users ON orders.user_id = users.user_id WHERE orders.order_id = '$orderId'";
    $sqlreceipt = mysqli_query($conn, $sqlreceipt);
    while($receiptrow = $sqlreceipt ->fetch_assoc()){
        $receiptData[] = $receiptrow;
    }
?>
<?php
    foreach($receiptData as $receiptrow){

    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Summerhouse Cafe</title>
    <link rel="stylesheet" href="mystyle.css">
    <link rel="stylesheet" href="../api/datatable.css">
    <script src="../api/datatable.js"></script>
    <style>
        .wrapper{
            line-height: 0.5;
        }
    </style>
</head>
<body>
    <div class="container-fluid" id="container">
        <div class="row">
            <div class="head-div text-center mb-5">
                <a href="admin.php" class="nav-link px-2 text-white"><img src="../images/logo.png" alt="logo" style="height: 120px;width: 120px;border-radius: 50%;object-fit: contain"></a>
                <h1>The Summerhouse Cafe</h1>
            <div class="text-center wrapper">
                <p>2F Gloriana Bella Building South Poblacion, Valencia, Negros Oriental</p>
                <p>Phone: +63 929 099 5773</p>
                <p>+63 905 288 0939</p>
            </div>
            </div>
            <div class="head-foot text-start mt-5 mb-5">
                <div class="card border-0">
                    <h5>Receipt No. <?php echo $receiptrow['order_id']; ?></h5>
                    <h5>Date: <?php echo $receiptrow['created_at']; ?></h5>
                    <h5>Customer Name: <?php echo $receiptrow['customer_name']; ?></h5>
                    <h5>Payment Method: <?php echo $receiptrow['payment_type']; ?></h5>
                    <h5>Reference Number: <?php echo $receiptrow['ref_num']; ?></h5>
                    <h5>Contact #: <?php echo $receiptrow['contact_num']; ?></h5>
                    <h5>Status: <span class="bg-secondary text-white p-2 rounded" style="font-size: 15px;"><?php echo $receiptrow['order_stat']; ?></span></h5>
                    <button class="btn btn-info mt-2 text-white" style="width: 120px;" id="receipt">Print Receipt</button>
                </div>
            </div>
            <hr>
            <hr>
            <table class="text-center mb-5">
                <thead>
                    <tr>
                        <th>QTY</th>
                        <th>ITEM</th>
                        <th>PRODUCT PRICE</th>
                        <th>TOTAL</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    foreach($receiptData as $receiptrow){
                ?>
                    <tr>
                        <td><?php echo $receiptrow['quantity']; ?></td>
                        <td><?php echo $receiptrow['product_name']; ?></td>
                        <td>Php <?php echo $receiptrow['price']; ?>.00</td>
                        <td>Php <?php echo $receiptrow['subtotal']; ?>.00</td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
            <div class="row text-center mt-5">
                <div class="col-sm">
                    <h6>ORDER TOTAL: </h6>
                    <h6>CASH TENDERED: </h6>
                    <h6>Change: </h6>
                    <h6>VAT: </h6>
                    <h6>Discount: </h6>
                </div>
                <div class="col-sm">
                    <h6>Php <?php echo $receiptrow['total_amount']; ?>.00</h6>
                    <h6>Php <?php echo $receiptrow['amount_tendered']; ?>.00</h6>
                    <h6>Php <?php echo $receiptrow['change_amount']; ?>.00</h6>
                    <h6>Php <?php echo $receiptrow['vat']; ?>.00</h6>
                    <h6>Php <?php echo $receiptrow['discount']; ?>.00</h6>
                </div>
            </div>
            <hr>
            <hr>
            <div class="mb-5 text-center" style="line-height: 0.5">
                <p>Thank you, please come</p>
                <p>again!</p>
            </div>
            <div class="mt-5 text-center">
                <p>This serves as your temporary receipt.</p>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function(){
            $('#receipt').on("click",function(){
                $(this).hide();
                window.print();
            })
        })
    </script>
</body>
</html>