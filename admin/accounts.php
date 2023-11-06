<?php 
    include("../connection/connection.php");
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Summerhouse Cafe</title>
    <link rel="stylesheet" href="../css/summerStyle.css">
    <link rel="stylesheet" href="../api/datatable.css">
    <script src="../api/datatable.js"></script>
 
</head>
<body>
    <header class="p-2 header-style"">
            <div class="container">
                <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
                    <a href="accounts.php" class="nav-link px-2 text-white"><img src="../images/logo.png" alt="logo" style="height: 90px;width: 90px;border-radius: 50%;object-fit: contain"></a>
                    <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                    <li class="nav-bar mt-2"><a href="admin.php" class="nav-link px-2 text-white">Home</a></li>
                    <li class="nav-bar mt-2"><a href="orders.php" class="nav-link px-2 text-white">Orders</a></li>
                    <li class="nav-bar mt-2"><a href="reports.php" class="nav-link px-2 text-white">Reports</a></li>
                    <li class="nav-bar mt-2"><a href="products.php" class="nav-link px-2 text-white">Products</a></li>
                    <li class="nav-bar mt-2"><a href="categories.php" class="nav-link px-2 text-white">Categories</a></li>
                    <li class="nav-bar mt-2"><a href="" class="nav-link px-2 text-white" id="active">Accounts</a></li>
                    </ul>
                    <div class="text-end">
                    <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3" role="search">
                    <span class="text-white">Welcome, <?php echo $_SESSION['displayName']."! "."(".$_SESSION['roleType']." - ".$_SESSION['roleDes'].")" ?></span>
                    <a class="checkOut" href="../logout.php">Logout</a>
                    </div>
                    </form>
                </div>
            </div>
    </header>
</body>
</html>