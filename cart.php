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
        }
    }else{
        $_SESSION['cart'] = array();
    }//get the food id & validate the product if it's set
?>
<?php
    //↓↓↓↓↓↓↓↓↓↓↓↓↓↓ Ordering and Listing Product via Session ↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑
    $txtUserId = $_SESSION['userId'];
    if(isset($_POST['placeOrder'])){
        if(!empty($_POST['payType']) && !empty($_POST['txtCus']) && !empty($_POST['txtPayamount'])){
            $payType = $_POST['payType'];
            $txtCus = $_POST['txtCus'];
            $txtPayamount = $_POST['txtPayamount'];
            $txtNote = $_POST['txtNote'];
            $grandtotal = $_SESSION['grandtotal'];
            $totalQuan = $_SESSION['totalQuan'];
            if($txtPayamount < $grandtotal){
                echo '<script>
                        alert("ERROR: Invalid Payment Amount");
                    </script>';
            }else{
                $sqlOrders = "INSERT INTO orders (user_id, total_amount, customer_name, payment_type, amount_tendered, change_amount, notes) 
                VALUES ((SELECT user_id FROM users WHERE user_id = $txtUserId),$grandtotal, '$txtCus', '$payType', '$txtPayamount',$txtPayamount - $grandtotal, '$txtNote')";
                $sqlOrders = mysqli_query($conn,$sqlOrders);
                //Insert to Order_details
                foreach($_SESSION['cart'] as $k => $Q){
                    $sqldetails = "SELECT * FROM orders";
                    $sqldetails = mysqli_query($conn, $sqldetails);
                     while($details = $sqldetails -> fetch_assoc()){
                        $currentId = $details['order_id'];
                    }
                    $sqlInsertOrder = "INSERT INTO order_details (order_id, product_id, quantity, subtotal) 
                    VALUES ((SELECT order_id FROM orders WHERE order_id = $currentId),(SELECT product_id FROM products WHERE product_id = $k),'$Q',(SELECT price FROM products WHERE product_id = $k)*$Q)";
                    $sqlInsertOrder = mysqli_query($conn, $sqlInsertOrder);
                }
                $_SESSION['cart'] = array();
                echo '<script>
                        alert("Sucess: Orders has been Placed");
                    </script>';
            }
        }
        else{
            echo '<script>
                    alert("ERROR: Please Fill-up the form");
                </script>';
        }
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