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

    //Previous Day Sales
    $sqltotalOrder = "SELECT products.product_name, sum(quantity) as totalorders,count(*) as totalsold FROM products INNER JOIN (SELECT product_id, count(*) as orders 
    FROM order_details GROUP BY product_id ORDER BY orders DESC LIMIT 1) as bestseller ON products.product_id = bestseller.product_id
    JOIN order_details
    JOIN orders ON order_details.order_id = orders.order_id WHERE CAST(created_at as DATE) = '$Calendar'";
    $sqltotalOrder = mysqli_query($conn, $sqltotalOrder);
    while($totOrder = $sqltotalOrder -> fetch_array()) {
        $totOrderData[] = $totOrder;
    }


    //WEEKLY
    if(isset($_POST['weekly'])){
            $weekly = date('y-m-d',strtotime('7 days ago'));
            $sqlReports = "SELECT *,SUM(CASE WHEN payment_type = 'cash' THEN total_amount ELSE 0 END) as cash,
            SUM(CASE WHEN payment_type = 'gcash' THEN total_amount ELSE 0 END) as gcash,
            SUM(CASE WHEN payment_type = 'bank transfer' THEN total_amount ELSE 0 END) as bank,
            SUM(total_amount) as totalsales
            FROM orders WHERE CAST(created_at as DATE) >= '$weekly'";
            $sqlReports = mysqli_query($conn, $sqlReports);
            while ($rowReport = $sqlReports -> fetch_array()) {
            $reportData[] = $rowReport;
        }
        $sqltotalOrder = "SELECT products.product_name, sum(quantity) as totalorders,count(*) as totalsold FROM products INNER JOIN (SELECT product_id, count(*) as orders 
            FROM order_details GROUP BY product_id ORDER BY orders DESC LIMIT 1) as bestseller ON products.product_id = bestseller.product_id
            JOIN order_details
            JOIN orders ON order_details.order_id = orders.order_id WHERE CAST(created_at as DATE) >= '$weekly'";
        $sqltotalOrder = mysqli_query($conn, $sqltotalOrder);
        while($totOrder = $sqltotalOrder -> fetch_array()) {
            $totOrderData[] = $totOrder;
        }
    }

        //MONTHLY
        if(isset($_POST['monthly'])){
            $monthly = date('y-m-d',strtotime('31 days ago'));
            $sqlReports = "SELECT *,SUM(CASE WHEN payment_type = 'cash' THEN total_amount ELSE 0 END) as cash,
            SUM(CASE WHEN payment_type = 'gcash' THEN total_amount ELSE 0 END) as gcash,
            SUM(CASE WHEN payment_type = 'bank transfer' THEN total_amount ELSE 0 END) as bank,
            SUM(total_amount) as totalsales
            FROM orders WHERE CAST(created_at as DATE) >= '$monthly'";
            $sqlReports = mysqli_query($conn, $sqlReports);
            while ($rowReport = $sqlReports -> fetch_array()) {
            $reportData[] = $rowReport;
        }
        $sqltotalOrder = "SELECT products.product_name, sum(quantity) as totalorders,count(*) as totalsold FROM products INNER JOIN (SELECT product_id, count(*) as orders 
            FROM order_details GROUP BY product_id ORDER BY orders DESC LIMIT 1) as bestseller ON products.product_id = bestseller.product_id
            JOIN order_details
            JOIN orders ON order_details.order_id = orders.order_id WHERE CAST(created_at as DATE) >= '$monthly'";
        $sqltotalOrder = mysqli_query($conn, $sqltotalOrder);
        while($totOrder = $sqltotalOrder -> fetch_array()) {
            $totOrderData[] = $totOrder;
        }
    }
            //YEARLY
        if(isset($_POST['yearly'])){
            $yearly = date('y-m-d',-1);
            $sqlReports = "SELECT *,SUM(CASE WHEN payment_type = 'cash' THEN total_amount ELSE 0 END) as cash,
            SUM(CASE WHEN payment_type = 'gcash' THEN total_amount ELSE 0 END) as gcash,
            SUM(CASE WHEN payment_type = 'bank transfer' THEN total_amount ELSE 0 END) as bank,
            SUM(total_amount) as totalsales
            FROM orders WHERE CAST(created_at as DATE) >= '$yearly'";
            $sqlReports = mysqli_query($conn, $sqlReports);
            while ($rowReport = $sqlReports -> fetch_array()) {
            $reportData[] = $rowReport;
        }
        $sqltotalOrder = "SELECT products.product_name, sum(quantity) as totalorders,count(*) as totalsold FROM products INNER JOIN (SELECT product_id, count(*) as orders 
            FROM order_details GROUP BY product_id ORDER BY orders DESC LIMIT 1) as bestseller ON products.product_id = bestseller.product_id
            JOIN order_details
            JOIN orders ON order_details.order_id = orders.order_id WHERE CAST(created_at as DATE) >= '$yearly'";
        $sqltotalOrder = mysqli_query($conn, $sqltotalOrder);
        while($totOrder = $sqltotalOrder -> fetch_array()) {
            $totOrderData[] = $totOrder;
        }
    }
?>