<?php
    session_start();
    /* Orders.php Region */
    if($_SESSION['txtUsername'] == ""){
        header("location: ../logout.php");
    }
    $sqlprod = "SELECT * FROM products JOIN categories ON products.category_id = categories.category_id";
    $resultprod = mysqli_query($conn, $sqlprod);
    while ($rowprod = mysqli_fetch_array($resultprod)) {
        $data[] = $rowprod;
    }
    if(isset($_POST["btn-delete"])){
        $getId = $_GET['id'];
        $sqlDelete = "DELETE FROM order_details WHERE product_id = $getId";
        $sqlDelete = mysqli_query( $conn, $sqlDelete);
    }
?>
<?php
    /* Products.php Region */
    $sqlgetOrder = "SELECT * FROM order_details
    JOIN products ON order_details.product_id = products.product_id
    JOIN orders ON order_details.order_id = orders.order_id
    JOIN users ON orders.user_id = users.user_id";
    $orderResult = mysqli_query($conn, $sqlgetOrder);
        while($rowOrder = $orderResult -> fetch_assoc()){
            $orderData[] = $rowOrder;
        }
?>

<?php
    /* Reports.php Region */
/*
    if(isset($_GET['date'])){
        $Calendar = $_GET['date'];
    }else{
        $Calendar = date('Y-m-d',strtotime('yesterday'));
    }
    $sqlReports = "SELECT *,SUM(CASE WHEN payment_type = 'cash' THEN total_amount ELSE 0 END) as cash,
                    SUM(CASE WHEN payment_type = 'gcash' THEN total_amount ELSE 0 END) as gcash,
                    SUM(CASE WHEN payment_type = 'bank transfer' THEN total_amount ELSE 0 END) as bank,
                    SUM(total_amount) as totalsales
                    FROM orders WHERE CAST(created_at as DATE) = '$Calendar'";
    $sqlReports = mysqli_query($conn, $sqlReports);
    while ($rowReport = $sqlReports -> fetch_array()) {
        $reportData[] = $rowReport;
    }
*/
    //Total Sales
    if(isset($_GET['date'])){
        $Calendar = $_GET['date'];
    }else{
        $Calendar = date('Y-m-d',strtotime('yesterday'));
    }
    $sqlReports = "SELECT *,SUM(CASE WHEN payment_type = 'cash' THEN total_amount ELSE 0 END) as cash,
                    SUM(CASE WHEN payment_type = 'gcash' THEN total_amount ELSE 0 END) as gcash,
                    SUM(CASE WHEN payment_type = 'bank transfer' THEN total_amount ELSE 0 END) as bank,
                    SUM(total_amount) as totalsales
                    FROM orders WHERE CAST(created_at as DATE) = '$Calendar'";
    $sqlReports = mysqli_query($conn, $sqlReports);
    while ($rowReport = $sqlReports -> fetch_array()) {
        $reportData[] = $rowReport;
    }

    //Total orders
    $sqltotalOrder = "SELECT count(*) as ordercount, sum(quantity) FROM order_details 
    JOIN products ON order_details.product_id = products.product_id
    JOIN orders ON order_details.order_id = orders.order_id WHERE CAST(created_at as DATE) = '$Calendar'";
    $sqltotalOrder = mysqli_query($conn, $sqltotalOrder);
    while($totOrder = $sqltotalOrder -> fetch_array()) {
        $totOrderData[] = $totOrder;
    }
?>