<?php
    session_start();
    /* products.php Region */
    $_SESSION['prodWarning'] = "";
    if($_SESSION['txtUsername'] == ""){
        header("location: ../logout.php");
    }
    if(isset($_GET['prodid'])){
        $prodId = $_GET['prodid'];
    }else{
        $prodId = "";
    }
    $sqlprod = "SELECT * FROM products JOIN categories ON products.category_id = categories.category_id";
    $resultprod = mysqli_query($conn, $sqlprod);
    while ($rowprod = mysqli_fetch_array($resultprod)) {
        $data[] = $rowprod;
    }
    if(isset($_POST["btn-delete"])){
        //products delete
        $sqlproductsDelete = "DELETE FROM products WHERE product_id = '$prodId'";
        $sqlproductsDelete = mysqli_query( $conn, $sqlproductsDelete);
        $_SESSION['prodWarning']="<h3 class='text-white bg-danger text-center p-2 m-2'>Product successfully removed in database!</h3>";

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
        //image upload
        $img_name = $_FILES['prodImage']['name'];
        $tmp_img_name = $_FILES['prodImage']['tmp_name'];
        $folder ='../images/categories/Other/';
        $location = $folder.$img_name;
        if(file_exists($location)){
            $_SESSION['prodWarning']="<h3 class='text-white bg-danger text-center p-2 m-2'>Invalid product image</h3>";
        }else{
            move_uploaded_file($tmp_img_name, $folder.$img_name);
        }
        //
        $sqlprodCheck = "SELECT * FROM products WHERE product_name = '$prodName'";
        $sqlprodCheck = mysqli_query($conn, $sqlprodCheck);
        if(mysqli_num_rows($sqlprodCheck) === 0){
            $sqlinsertProd = "INSERT INTO products (product_name, price, category_id, image) VALUES ('$prodName', '$prodPrice','$prodCat','$location')";
            $sqlinsertProd = mysqli_query( $conn, $sqlinsertProd);
            $_SESSION['prodWarning']="<h3 class='text-white bg-success text-center p-2 m-2'>Product added successfully</h3>";
        }else{
            $_SESSION['prodWarning']="<h3 class='text-white bg-danger text-center p-2 m-2'>This product exist already in Database!</h3>";
        }
    }
    if(isset($_POST["modSave"])){
        $modtxtprodname = $_POST["modtxtprodname"];
        $modtxtprice = $_POST["modtxtprice"];
        $modtxtcat = $_POST["modtxtcat"];
        //image MODAL upload
        $img_name = $_FILES['modprodImage']['name'];
        $tmp_img_name = $_FILES['modprodImage']['tmp_name'];
        $folder ='../images/categories/Other/';
        $updatedDate = date('y-m-d h-m-s',time());
        $location = $folder.$img_name;
        if(file_exists($location)){
            $_SESSION['prodWarning']="<h3 class='text-white bg-danger text-center p-2 m-2'>Invalid product image</h3>";
        }else{
            move_uploaded_file($tmp_img_name, $folder.$img_name);
        }
        $sqlupdateProd = "UPDATE products SET product_name = '$modtxtprodname',price = '$modtxtprice',category_id = '$modtxtcat', image = '$location', prod_updated_at = '$updatedDate' WHERE product_id = '$prodId'";
        $sqlupdateProd = mysqli_query( $conn, $sqlupdateProd);
        $_SESSION['prodWarning'] ="<h3 class='text-white bg-success text-center p-2 m-2'>Product updated successfully</h3>";
    }
?>

<?php
    /* Orders.php Region */
    if(!isset($orderData)){
        $orderData =[];
    }
    $sqlgetOrder = "SELECT *, orders.created_at,order_details.quantity
    FROM products
    JOIN order_details ON products.product_id = order_details.product_id
    JOIN orders ON order_details.order_id = orders.order_id
    JOIN users ON orders.user_id = users.user_id GROUP BY orders.order_id";
    $orderResult = mysqli_query($conn, $sqlgetOrder);
        while($rowOrder = $orderResult -> fetch_assoc()){
            $orderData[] = $rowOrder;
            $_SESSION['discount'] = $rowOrder['discount'];
            $_SESSION['vat'] = $rowOrder['vat'];
        }
?>

<?php
    //Monthly Region
    $_SESSION['msgWarning'] = "Please pick a date to view the sales reports";
    if(isset($_POST['monthly'])){
        $monthly = $_POST['monthly'];
        $first = new DateTime($monthly.'-01');
        $last = new DateTime($first->format('y-m-t'));

        $firstmonth = $first->format('y-m-d');
        $lastmonth = $last->format('y-m-d');
        if($_SESSION['msgWarning'] = "Please pick a date to view the sales reports"){
            
            $_SESSION['msgWarning'] = "Sales for the month of: ".date('F Y', strtotime($lastmonth));
        }
        $sqlReports = "SELECT *,SUM(CASE WHEN payment_type = 'cash' THEN total_amount ELSE 0 END) as cash,
            SUM(CASE WHEN payment_type = 'gcash' THEN total_amount ELSE 0 END) as gcash,
            SUM(CASE WHEN payment_type = 'bank transfer' THEN total_amount ELSE 0 END) as bank,
            SUM(total_amount) as totalsales
            FROM orders WHERE CAST(created_at as DATE) BETWEEN '$firstmonth' AND '$lastmonth'";
            $sqlReports = mysqli_query($conn, $sqlReports);
            while ($rowReport = $sqlReports -> fetch_array()) {
            $reportData[] = $rowReport;
            }
        $sqltotalOrder = "SELECT products.product_name, sum(quantity) as totalorders,count(*) as totalsold FROM products INNER JOIN (SELECT product_id, count(*) as orders 
            FROM order_details GROUP BY product_id ORDER BY orders DESC LIMIT 1) as bestseller ON products.product_id = bestseller.product_id
            JOIN order_details
            JOIN orders ON order_details.order_id = orders.order_id WHERE CAST(created_at as DATE) BETWEEN '$firstmonth' AND '$lastmonth'";
            $sqltotalOrder = mysqli_query($conn, $sqltotalOrder);
            while($totOrder = $sqltotalOrder -> fetch_array()) {
            $totOrderData[] = $totOrder;
        }
        $sqlmodorder = "SELECT *, orders.order_id, sum(quantity) as quantity FROM orders
                    INNER JOIN order_details ON orders.order_id = order_details.order_id WHERE CAST(orders.created_at as DATE) BETWEEN '$firstmonth' AND '$lastmonth' GROUP BY orders.order_id";
                    $sqlmodorder = mysqli_query($conn, $sqlmodorder);
                    while ($rowmodorder = mysqli_fetch_array($sqlmodorder)){
                        $modData[] = $rowmodorder;
            }
            $sqlbestseller = "SELECT products.product_id, products.product_name, SUM(order_details.quantity) AS productsales
                              FROM order_details
                              JOIN orders ON order_details.order_id = orders.order_id
                              JOIN products ON order_details.product_id = products.product_id
                              WHERE DATE(orders.created_at) BETWEEN '$firstmonth' AND '$lastmonth'
                              GROUP BY products.product_id
                              ORDER BY productsales DESC
                              LIMIT 3";
            
            $result = mysqli_query($conn, $sqlbestseller);
            
            while ($rowbestseller = mysqli_fetch_array($result)) {
                $bestData[] = $rowbestseller;

            }
    }
?>

<?php
    //YEARLY
    if(isset($_POST['yearly'])){
        $yearly = $_POST['yearly'];
            $first = new DateTime($yearly.'-01-01');
            $last = new DateTime($yearly.'-12-31');

            $firstyear = $first->format('y-m-d');
            $lastyear = $last->format('y-m-d');
            $sqlReports = "SELECT *,SUM(CASE WHEN payment_type = 'cash' THEN total_amount ELSE 0 END) as cash,
                SUM(CASE WHEN payment_type = 'gcash' THEN total_amount ELSE 0 END) as gcash,
                SUM(CASE WHEN payment_type = 'bank transfer' THEN total_amount ELSE 0 END) as bank,
                SUM(total_amount) as totalsales
                FROM orders WHERE CAST(created_at as DATE) BETWEEN '$firstyear' AND '$lastyear'";
                $sqlReports = mysqli_query($conn, $sqlReports);
                while ($rowReport = $sqlReports -> fetch_array()) {
                $reportData[] = $rowReport;
                }
            $sqltotalOrder = "SELECT products.product_name, sum(quantity) as totalorders,count(*) as totalsold FROM products INNER JOIN (SELECT product_id, count(*) as orders 
            FROM order_details GROUP BY product_id ORDER BY orders DESC LIMIT 1) as bestseller ON products.product_id = bestseller.product_id
            JOIN order_details
            JOIN orders ON order_details.order_id = orders.order_id WHERE CAST(created_at as DATE) BETWEEN '$firstyear' AND '$lastyear'";
            $sqltotalOrder = mysqli_query($conn, $sqltotalOrder);
            while($totOrder = $sqltotalOrder -> fetch_array()) {
            $totOrderData[] = $totOrder;
        }
            $sqlmodorder = "SELECT *, orders.order_id, sum(quantity) as quantity FROM orders
                    INNER JOIN order_details ON orders.order_id = order_details.order_id WHERE CAST(orders.created_at as DATE) BETWEEN '$firstyear' AND '$lastyear' GROUP BY orders.order_id";
                    $sqlmodorder = mysqli_query($conn, $sqlmodorder);
                    while ($rowmodorder = mysqli_fetch_array($sqlmodorder)){
                        $modData[] = $rowmodorder;
            }
            $sqlbestseller = "SELECT products.product_id, products.product_name, SUM(order_details.quantity) AS productsales
                              FROM order_details
                              JOIN orders ON order_details.order_id = orders.order_id
                              JOIN products ON order_details.product_id = products.product_id
                              WHERE DATE(orders.created_at) BETWEEN '$firstyear' AND '$lastyear'
                              GROUP BY products.product_id
                              ORDER BY productsales DESC
                              LIMIT 3";
            
            $result = mysqli_query($conn, $sqlbestseller);
            
            while ($rowbestseller = mysqli_fetch_array($result)) {
                $bestData[] = $rowbestseller;

            }
            if($_SESSION['msgWarning'] == "Please pick a date to view the sales reports"){
                $_SESSION['msgWarning'] = "Sales for the year: ".date('Y', strtotime($lastyear));
            }
    }
?>
<?php 
    //Date Range
    if(isset($_POST['subRange'])){
        if(isset($_POST['startDate']) && isset($_POST['endDate'])){
            $start_date_str = $_POST['startDate'];
            $end_date_str = $_POST['endDate'];
            $start_date = DateTime::createFromFormat('Y-m-d', $start_date_str);
            $end_date = DateTime::createFromFormat('Y-m-d', $end_date_str);
    
            if (!$start_date || !$end_date) {
                echo "<h1 style='color:white;background-color: red;text-align:center'>Error: Unable to create reports (Please set the DATE RANGE).<h1>";
                echo"<script>
                        setTimeout(function(){
                            window.location.href='reports.php';
                        }, 1300);
                    </script>";
                exit;
            }
            
            $startDate = $start_date->format('Y-m-d');
            $endDate = $end_date->format('Y-m-d');
            $_SESSION['msgWarning'] = "Range from: ". $startDate ." to ". $endDate ;
        }
        $sqlReports = "SELECT *,SUM(CASE WHEN payment_type = 'cash' THEN total_amount ELSE 0 END) as cash,
                        SUM(CASE WHEN payment_type = 'gcash' THEN total_amount ELSE 0 END) as gcash,
                        SUM(CASE WHEN payment_type = 'bank transfer' THEN total_amount ELSE 0 END) as bank,
                        SUM(total_amount) as totalsales
                        FROM orders WHERE CAST(created_at as DATE) BETWEEN '$startDate' AND '$endDate'";
        $sqlReports = mysqli_query($conn, $sqlReports);
        while ($rowReport = $sqlReports -> fetch_array()) {
            $reportData[] = $rowReport;
        }

        $sqltotalOrder = "SELECT products.product_name, sum(quantity) as totalorders,count(*) as totalsold FROM products INNER JOIN (SELECT product_id, count(*) as orders 
        FROM order_details GROUP BY product_id ORDER BY orders DESC LIMIT 1) as bestseller ON products.product_id = bestseller.product_id
        JOIN order_details
        JOIN orders ON order_details.order_id = orders.order_id WHERE CAST(created_at as DATE) BETWEEN '$startDate' AND '$endDate'";
        $sqltotalOrder = mysqli_query($conn, $sqltotalOrder);
        while($totOrder = $sqltotalOrder -> fetch_array()) {
            $totOrderData[] = $totOrder;
        }
        $sqlmodorder = "SELECT *, orders.order_id, sum(quantity) as quantity FROM orders
                    INNER JOIN order_details ON orders.order_id = order_details.order_id WHERE CAST(orders.created_at as DATE) BETWEEN '$startDate' AND '$endDate' GROUP BY orders.order_id";
                    $sqlmodorder = mysqli_query($conn, $sqlmodorder);
                    while ($rowmodorder = mysqli_fetch_array($sqlmodorder)){
                        $modData[] = $rowmodorder;
            }
            $sqlbestseller = "SELECT products.product_id, products.product_name, SUM(order_details.quantity) AS productsales
                              FROM order_details
                              JOIN orders ON order_details.order_id = orders.order_id
                              JOIN products ON order_details.product_id = products.product_id
                              WHERE DATE(orders.created_at) BETWEEN '$startDate' AND '$endDate'
                              GROUP BY products.product_id
                              ORDER BY productsales DESC
                              LIMIT 3";
            
            $result = mysqli_query($conn, $sqlbestseller);
            
            while ($rowbestseller = mysqli_fetch_array($result)) {
                $bestData[] = $rowbestseller;
            }
    }
?>

<?php
    //Set undefined values in SELECTION DATES
    if(isset($_POST["monthly"]) || isset($_POST["yearly"]) || isset($_POST["subRange"])){
        foreach ($totOrderData as $totOrder) {}
        foreach ($reportData as $rowReport) {}
    }else{
        $reportData = [];
        $totOrderData = [];
        $rowbestseller = [];
        $rowmodorder = [];
        $bestData = [];
        $modData = [];
        $totOrder = [];
        $rowReport = [];
        $rowReport['cash'] =0;
        $rowReport['gcash'] =0;
        $rowReport['bank'] =0;
        $rowReport['totalsales'] =0;
        $totOrder['totalorders']=0;
        $totOrder['totalsold']=0;
        $totOrder['product_name']="";
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
                $_SESSION['catMessage'] = "<h3 class='text-center text-white bg-success'>Category added successfully<h3>";
            }

        }else{
            $_SESSION['catMessage'] = "<h3 class='text-center text-white bg-danger'>Category is already exist!<h3>";
        }
    }else{
        $_SESSION['catMessage'] = "";
    }
    
    if(isset($_POST["deleteCat"])){
        $getId = $_GET['id'];
        $sqlcatDel = "DELETE FROM categories WHERE category_id = $getId";
        $sqlcatDel = mysqli_query($conn, $sqlcatDel);
        //header("location: categories.php");
        $_SESSION['catMessage'] = "<h3 class='text-center text-white bg-danger'>Category deleted successfully!<h3>";
    }
    if(isset($_POST["catSave"])){
        $getId = $_GET['id'];
        $modalcatName = $_POST['modalcatName'];
        $updateDate = date('y-m-d h-m-s',time());
            $sqlCat = "UPDATE categories SET category_name = '$modalcatName', updated_at = '$updateDate' WHERE category_id = $getId";
            $sqlCat = mysqli_query($conn, $sqlCat);
            $_SESSION['modcatMessage'] = "<h3 class='text-center text-success text-white bg-success'>Updated successfulyy<h3>";
        }else{
            $_SESSION['modcatMessage'] = "";
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

    //Send Data to OTP page
    $_SESSION["accMessage"] = "";
    require '../vendor/autoload.php';

    use Vonage\Client;
    use Vonage\Client\Credentials\Basic;
    if(isset($_POST["addAcc"])){
        $accRole = mysqli_real_escape_string($conn, $_POST["accRole"]);
        $accUsername = mysqli_real_escape_string($conn, $_POST["accUsername"]);
        $sqlCheckUsername = "SELECT COUNT(*) as count FROM users WHERE username = '$accUsername'";
        $resultCheckUsername = mysqli_query($conn, $sqlCheckUsername);
        if ($resultCheckUsername) {
            $row = mysqli_fetch_assoc($resultCheckUsername);
            $count = $row['count'];
    
            if ($count > 0) {
                $_SESSION['accMessage'] = "<h1 class='text-center text-white bg-danger'>Username already exists. Please choose a different username<h1>";
            } else {
                $accRole = $_POST["accRole"];
                $accUsername = $_POST["accUsername"];
                $accPassword = $_POST["accPassword"];
                $accNickname = $_POST["accNickname"];
                $otpNumber = $_POST["otpNumber"];
                $accbirthdate = $_POST["accBirthdate"];
                $accAge = $_POST["accAge"];
                $accGender = $_POST["accGender"];

                $apiKey = '5232a88f';
                $apiSecret = 'PEPLMV9flkl3mGZl';
                $fromNumber = '+639061008410';
                $toNumber = $otpNumber;

                $otp = mt_rand(1000, 9999);

                $message = "Your OTP is: $otp";
                $currentotp = $otp;

                try {
                    $basic = new Basic($apiKey, $apiSecret);
                    $client = new Client($basic);

                    $response = $client->message()->send([
                        'to' => $toNumber,
                        'from' => $fromNumber,
                        'text' => $message
                    ]);

                    if ($response['messages'][0]['status'] == 0) {
                        echo "OTP sent successfully!";
                        $_SESSION['otp'] = $currentotp;
                    } else {
                        echo "Failed to send OTP. Error: " . $response['messages'][0]['error-text'];
                    }
                } catch (\Exception $e) {
                    echo "Error: " . $e->getMessage();
                }
                header("location: verify.php");
                $_SESSION['user'] = array($accRole, $accUsername, $accPassword, $otpNumber, $accNickname, $accbirthdate, $accAge, $accGender);
            }
        }
    }
    //DELETE ACCOUNT
    if(isset($_POST["deleteAcc"])){
        $getId = $_GET['userId'];
        //products delete
        $sqlaccDelete = "DELETE FROM users WHERE user_id = $getId";
        $sqlaccDelete = mysqli_query( $conn, $sqlaccDelete);
        $_SESSION['accMessage'] = "<h1 class='text-center text-white bg-danger'>Account deleted successfully!<h1>";
    }
?>
<?php
    //Modal UPDATE'S RECORDS
    if(isset($_POST["modaddAcc"])){
        $userId = $_GET['userId'];
        $modaccRole = $_POST["modaccRole"];
        $modaccUsername = $_POST["modaccUsername"];
        $modaccPassword = $_POST["modaccPassword"];
        $modotpNumber = $_POST["modotpNumber"];
        $updateDate = date('y-m-d h-m-s',time());
        $modaccNickname = $_POST["modaccNickname"];
        $modaccBirthdate = $_POST["modaccBirthdate"];
        $modaccAge = $_POST["modaccAge"];
        $modaccGender = $_POST["modaccGender"];
            $sqlaccUpdate = "UPDATE users SET role_id = '$modaccRole', username = '$modaccUsername', password = '$modaccPassword', mobile_num= '$modotpNumber', display_name = '$modaccNickname', birthdate = '$modaccBirthdate',age = '$modaccAge', gender = '$modaccGender', updated_at = '$updateDate' WHERE user_id = '$userId'";
            $sqlaccUpdate = mysqli_query($conn, $sqlaccUpdate);
            $_SESSION['accMessage'] = "<h1 class='text-center text-white bg-success'>Account updated successfully<h1>";
        }
?>