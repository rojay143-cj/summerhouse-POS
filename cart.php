<?php
    session_start();
    if(!(isset($_SESSION['cart']))){
        $_SESSION['cart'] = array();
    }//check cart if it's set in the browser
    if(isset($_GET['id'])){
        $getId = $_GET['id'];
        if(isset($_POST['txtQuan'])){
            $txtQuan = $_POST['txtQuan'];
        }else{
            $txtQuan="";
        }
        if($txtQuan > 0 && filter_var($txtQuan, FILTER_VALIDATE_INT)){
            if(isset($_SESSION['cart'][$getId])){
                $_SESSION['cart'][$getId] += $txtQuan;
            }else{
                $_SESSION['cart'][$getId] = $txtQuan;
            }
        }
        if(isset($_POST['btn-minus'])){
            $_SESSION['cart'][$getId] -= 1;
            if($_SESSION['cart'][$getId] <= 0){
                unset($_SESSION['cart'][$getId]);
            }
        }if(isset($_POST['btn-plus'])){
            $_SESSION['cart'][$getId] += 1;
        }if(isset($_POST['btn-remove'])){
            unset($_SESSION['cart'][$getId]);
        }
    }else{
        //$_SESSION['cart'] = array();
    }//get the food id & validate the product if it's set
?>

<?php
    //↓↓↓↓↓↓↓↓↓↓↓↓↓↓ Ordering and Listing Product via Session ↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑
    $txtUserId = $_SESSION['userId'];
    if(isset($_POST['placeOrder'])){
        if(!empty($_POST['payType']) && !empty($_POST['txtCus']) && !empty($_POST['txtPayamount'])){
            $payType = $_POST['payType'];
            $txtCus = $_POST['txtCus'];
            $txtmobnumber = $_POST['txtmobnumber'];
            $txtPayamount = $_POST['txtPayamount'];
            $txtNote = $_POST['txtNote'];
            $grandtotal = $_SESSION['grandtotal'];
            $totalQuan = $_SESSION['totalQuan'];
            if($txtPayamount < $grandtotal){
                $_SESSION['msg'] = "<h5 class='text-danger'>Sorry, Invalid payment amount!</h5>";
            }else{
                $sqlOrders = "INSERT INTO orders (user_id, total_amount, customer_name, mobile_num, payment_type, amount_tendered, change_amount, notes,order_stat) 
                VALUES ((SELECT user_id FROM users WHERE user_id = $txtUserId),$grandtotal, '$txtCus', '$txtmobnumber', '$payType', '$txtPayamount',$txtPayamount - $grandtotal, '$txtNote','Processing')";
                $sqlOrders = mysqli_query($conn,$sqlOrders);
                //Insert to Order_details
                foreach($_SESSION['cart'] as $k => $Q){
                    $sqldetails = "SELECT * FROM orders";
                    $sqldetails = mysqli_query($conn, $sqldetails);
                     while($details = $sqldetails -> fetch_assoc()){
                        $currentId = $details['order_id'];
                        $_SESSION['orderid'] = $details['order_id'];
                        $_SESSION['customer'] = $details['customer_name'];
                        $_SESSION['pay'] = $details['amount_tendered'];
                        $_SESSION['total'] = $details['total_amount'];
                        $_SESSION['change'] = $details['change_amount'];
                        $_SESSION['mobile'] = $details['mobile_num'];
                        $_SESSION['date'] = $details['created_at'];
                        $_SESSION['type'] = $details['payment_type'];
                        $_SESSION['discount'] = $details['discount'];
                        $_SESSION['vat'] = $details['vat'];
                    }
                    $sqlInsertOrder = "INSERT INTO order_details (order_id, product_id, quantity, subtotal) 
                    VALUES ((SELECT order_id FROM orders WHERE order_id = $currentId),(SELECT product_id FROM products WHERE product_id = $k),'$Q',(SELECT price FROM products WHERE product_id = $k)*$Q)";
                    $sqlInsertOrder = mysqli_query($conn, $sqlInsertOrder);
                    $sqlorderdetails = "SELECT * FROM order_details JOIN products ON order_details.product_id = products.product_id";
                    $sqlorderdetails = mysqli_query($conn, $sqlorderdetails);
                    while($orderdetails = $sqlorderdetails -> fetch_assoc()){
                        $_SESSION['products'] = $orderdetails['product_name'];
                    }
                }
                $_SESSION['cart'] = array();
                if(($_SESSION['msg'] == "Empty")){
                    $_SESSION['msg'] = "<h5 class='text-white bg-warning text-center mb-4'>Sucess: Order/s has been Placed</h5>".
                    "<p class='text-secondary text-start'>Order ID: #".$_SESSION['orderid']."</p>".
                    "<p class='text-secondary text-start'>Ordered By: ".$_SESSION['customer']."</p>".
                    "<p class='text-secondary text-start'>Amount Tendered: Php ".$_SESSION['pay']."</p>".
                    "<p class='text-secondary text-start'>Total Paid: Php ".$_SESSION['total']."</p>".
                    "<p class='text-secondary text-start'>Change: Php ".$_SESSION['change']."</p>".
                    "<p class='text-secondary text-start'>Date: ".$_SESSION['date']."</p>".
                    "<p class='text-secondary text-start'>Mobile No.: ".$_SESSION['mobile']."</p>".
                    "<p class='text-secondary text-start'>Payment method: ".$_SESSION['type']."</p>".
                    "<p class='text-secondary text-start'>Discount: ".$_SESSION['discount']."</p>".
                    "<p class='text-secondary text-start'>VAT: ".$_SESSION['vat']."</p>";
                }
            }
        }
        else{
            $_SESSION['msg'] = "<h5 class='text-danger'>Order cancelled: Fill-up all the form</h5>";
        }
    }else{
        $_SESSION['msg'] = "Empty";
    }
    //END REGION ↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑
?>
<?php
//category region
if(isset($_POST['categoryId'])) {
    
    $categoryId = $_POST['categoryId'];
    
    $sql = "SELECT products.product_id, products.product_name, products.price, products.image, categories.category_id 
    FROM products JOIN categories ON categories.category_id = products.category_id WHERE categories.category_id = $categoryId";
    
    $result = mysqli_query($conn, $sql);
    
} else {

    $getProducts = "SELECT * FROM products";

    $result = mysqli_query($conn, $getProducts);

}

if($result -> num_rows > 0){
    while($rows = $result -> fetch_assoc()){
        $data[] = $rows;
    }
}
?>

<?php
    $categorySql = "SELECT * FROM categories";
    $categoryResults = mysqli_query($conn, $categorySql);
    if($categoryResults -> num_rows > 0){
        while($rows = $categoryResults -> fetch_assoc()){
            $categories[] = $rows;
        }
    }
    if(($_SESSION['txtUsername'] == "")){
        header('location: ../logout.php');
        
    }
?>

<?php 
    $sqlOrdertable = "SELECT * FROM orders";
    $sqlOrdertable = mysqli_query($conn, $sqlOrdertable);
    while($orderTable = $sqlOrdertable -> fetch_assoc()){
        $ordertableData[] = $orderTable;
    }
?>