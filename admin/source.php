<?php
    session_start();
    /* products.php Region */
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
        //products delete
        $sqlproductsDelete = "DELETE FROM products WHERE product_id = $getId";
        $sqlproductsDelete = mysqli_query( $conn, $sqlproductsDelete);
        header("location: products.php");

    }

    //products.php - get categories
    $categorySql = "SELECT * FROM categories";
    $categoryResults = mysqli_query($conn, $categorySql);
    if($categoryResults -> num_rows > 0){
        while($rows = $categoryResults -> fetch_array()){
            $categories[] = $rows;
        }
    }
    if(isset($_POST["addProd"])){
        $prodName = $_POST["prodName"];
        $prodPrice = $_POST["prodPrice"];
        $prodCat = $_POST["prodCat"];
        $sqlprodCheck = "SELECT * FROM products WHERE product_name = '$prodName'";
        $sqlprodCheck = mysqli_query($conn, $sqlprodCheck);
        if(mysqli_num_rows($sqlprodCheck) === 0){
            $sqlinsertProd = "INSERT INTO products (product_name, price, category_id) VALUES ('$prodName', '$prodPrice','$prodCat')";
            $sqlinsertProd = mysqli_query( $conn, $sqlinsertProd);
        }else{
            echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                alert('Invalid Product name!');
             });
            </script>";
        }
    }
?>

<?php
    /* Orders.php Region */

    $sqlgetOrder = "SELECT *, orders.created_at
    FROM products
    JOIN order_details ON products.product_id = order_details.product_id
    JOIN orders ON order_details.order_id = orders.order_id
    JOIN users ON orders.user_id = users.user_id";
    $orderResult = mysqli_query($conn, $sqlgetOrder);
        while($rowOrder = $orderResult -> fetch_assoc()){
            $orderData[] = $rowOrder;
        }

    if(isset($_POST["orderDelete"])){
        $getId = $_GET['orderId'];
        //orders.php delete
        $sqlorderDelete = "DELETE FROM order_details WHERE product_id = $getId";
        $sqlorderDelete = mysqli_query( $conn, $sqlorderDelete);
        header("location: orders.php");
    }
?>

<?php
    /* Reports.php Region */
    //Previous DAy
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

    $today = date("y-m-d",strtotime("today"));
    $sqlReports = "SELECT *,SUM(CASE WHEN payment_type = 'cash' THEN total_amount ELSE 0 END) as cash,
    SUM(CASE WHEN payment_type = 'gcash' THEN total_amount ELSE 0 END) as gcash,
    SUM(CASE WHEN payment_type = 'bank transfer' THEN total_amount ELSE 0 END) as bank,
    SUM(total_amount) as totalsales
    FROM orders WHERE CAST(created_at as DATE) = '$today'";
    $sqlReports = mysqli_query($conn, $sqlReports);
    while ($rowToday = $sqlReports -> fetch_array()) {
    $todayData[] = $rowToday;
    }

    //Previous Day Sales
    $sqltotalOrder = "SELECT products.product_name, sum(quantity) as totalorders,count(*) as totalsold FROM products INNER JOIN (SELECT product_id, count(*) as orders 
    FROM order_details GROUP BY product_id ORDER BY orders DESC LIMIT 1) as bestseller ON products.product_id = bestseller.product_id
    JOIN order_details
    JOIN orders ON order_details.order_id = orders.order_id WHERE CAST(created_at as DATE) = '$today'";
    $sqltotalOrder = mysqli_query($conn, $sqltotalOrder);
    while($rowTodays = $sqltotalOrder -> fetch_array()) {
    $todayDatas[] = $rowTodays;
}
?>

<?php 
    //Categories.php Region

    if(isset($_POST["addCat"])){
        $catName = $_POST['catName'];
        $sqlcatCheck = "SELECT * FROM categories WHERE category_name = '$catName'";
        $sqlcatCheck = mysqli_query($conn, $sqlcatCheck);
        if(mysqli_num_rows($sqlcatCheck) === 0){
            $sqlCat = "INSERT INTO categories (category_name) VALUES ('$catName')";
            $sqlCat = mysqli_query($conn, $sqlCat);
            if($_SESSION['catMessage'] == ""){
                $_SESSION['catMessage'] = "<h3 class='text-center text-success'>Category added successfully<h3>";
            }

        }else{
            $_SESSION['catMessage'] = "<h3 class='text-center text-danger'>Category is already exist!<h3>";
        }
    }else{
        $_SESSION['catMessage'] = "";
    }
    
    if(isset($_POST["deleteCat"])){
        $getId = $_GET['id'];
        $sqlcatDel = "DELETE FROM categories WHERE category_id = $getId";
        $sqlcatDel = mysqli_query($conn, $sqlcatDel);
        header("location: categories.php");
    }if(isset($_POST["catSave"])){
        $getId = $_GET['id'];
        $modalcatName = $_POST['modalcatName'];
        $sqlcatCheck = "SELECT * FROM categories WHERE category_name = '$modalcatName'";
        $sqlcatCheck = mysqli_query($conn, $sqlcatCheck);
        if(mysqli_num_rows($sqlcatCheck) === 0){
            $modalcatName = $_POST["modalcatName"];
            $sqlCat = "UPDATE categories SET category_name = '$modalcatName' WHERE category_id = $getId";
            $sqlCat = mysqli_query($conn, $sqlCat);
            if($_SESSION['modcatMessage'] == ""){
                $_SESSION['modcatMessage'] = "<h3 class='text-center text-success'>Updated successfulyy<h3>";
            }
        }else{
            $_SESSION["modcatMessage"] = "<h3 class='text-center text-danger'>Invalid Category Name!<h3>";
        }
    }else{
        $_SESSION["modcatMessage"] = "";
    }
?>

<?php 
    //Account.php region
    //Fetch data from db
    $sqlAccount = "SELECT * FROM users JOIN roles ON users.role_id = roles.role_id";
    $sqlAccount = mysqli_query($conn, $sqlAccount);
    while($accRow = $sqlAccount->fetch_assoc()){
        $accData[] = $accRow;
    }
    $sqlRole = "SELECT * FROM roles";
    $sqlRole = mysqli_query($conn, $sqlRole);
    while($roleRow = $sqlRole->fetch_assoc()){
        $roleData[] = $roleRow;
    }

    //insert date
    if(isset($_POST["addAcc"])){
        $accRole = $_POST["accRole"];
        $accUsername = $_POST["accUsername"];
        $accPassword = $_POST["accPassword"];
        $accNickname = $_POST["accNickname"];
        $accbirthdate = $_POST["accBirthdate"];
        $accAge = $_POST["accAge"];
        $accGender = $_POST["accGender"];
        $sqlcheckAcc = "SELECT * FROM users WHERE username = '$accUsername'";
        $sqlcheckAcc = mysqli_query($conn, $sqlcheckAcc);
        if(mysqli_num_rows($sqlcheckAcc) === 0){
            $sqlinsertAcc = "INSERT INTO users (role_id, username, password, display_name, birthdate, age, gender)
            VALUES ((SELECT role_id FROM roles WHERE role_id = $accRole), '$accUsername', '$accPassword', '$accNickname', '$accbirthdate','$accAge','$accGender')";
            $sqlinsertAcc = mysqli_query($conn, $sqlinsertAcc);
            if($_SESSION['accMessage'] == ""){
                $_SESSION['accMessage'] = "<h1 class='text-center text-white bg-success'>Account has been added successfully</h1>";
            }
        }else{
            $_SESSION['accMessage'] = "<h1 class='text-center text-white bg-danger'>Account is already exist!<h1>";
        }
    }else{
        $_SESSION['accMessage'] = "";
    }if(isset($_POST["deleteAcc"])){
        $getId = $_GET['userId'];
        //products delete
        $sqlaccDelete = "DELETE FROM users WHERE user_id = $getId";
        $sqlaccDelete = mysqli_query( $conn, $sqlaccDelete);
        header("location: accounts.php");
    }
?>
<?php
    if(isset($_POST["modaddAcc"])){
        $userId = $_GET['userId'];
        $modaccRole = $_POST["modaccRole"];
        $modaccUsername = $_POST["modaccUsername"];
        $modaccPassword = $_POST["modaccPassword"];
        $modaccNickname = $_POST["modaccNickname"];
        $modaccBirthdate = $_POST["modaccBirthdate"];
        $modaccAge = $_POST["modaccAge"];
        $modaccGender = $_POST["modaccGender"];
        $sqlmodcheckAcc = "SELECT * FROM users WHERE username = '$modaccUsername'";
        $sqlmodcheckAcc = mysqli_query($conn, $sqlmodcheckAcc);
        if(mysqli_num_rows($sqlmodcheckAcc) === 0){
            $sqlaccUpdate = "UPDATE users SET role_id = '$modaccRole', username = '$modaccUsername', password = '$modaccPassword', display_name = '$modaccNickname', birthdate = '$modaccBirthdate',age = '$modaccAge', gender = '$modaccGender' WHERE user_id = '$userId'";
            $sqlaccUpdate = mysqli_query($conn, $sqlaccUpdate);
            $_SESSION['modaccMessage'] = "<h1 class='text-center text-white bg-success'>Account updated successfully<h1>";
        }else{
            $_SESSION['modaccMessage'] = "<h1 class='text-center text-white bg-danger'>Invalid account username!<h1>";
        }
        }else{
        $_SESSION["modaccMessage"] = "";
    }
?>