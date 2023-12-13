<?php 
    require("../connection/connection.php");
    require("source.php");
?>
<?php
    if (isset($_GET['prodid'])) {
        $prodid = $_GET['prodid'];
    } else {
        $prodid = 0;
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $chkProd = isset($_POST['chkProd']) ? 1 : 0;

        $sqlprodStat = "UPDATE products SET prod_stat = '$chkProd' WHERE product_id = '$prodid'";
        $result = mysqli_query($conn, $sqlprodStat);
        //header("location: products.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Summerhouse Cafe</title>
    <link rel="stylesheet" href="mystyles.css">
    <link rel="stylesheet" href="../api/datatable.css">
    <script src="../api/datatable.js"></script>
    <style>
        #container{
            display: grid;
            grid-template-columns: auto auto;
            column-gap: 20px;
        }
        .flow{
            overflow-y: scroll;
            max-height: 800px;
        }
    </style>
</head>
<body>
    <header class="p-2 header-style">
            <div class="container-fluid">
            <a href="admin.php" class="nav-link px-2 text-white w-25" id="logo1"><img src="../images/logo.png" alt="logo" style="height: 90px;width: 90px;border-radius: 50%;object-fit: contain"></a>
                <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start head-nav">
                <a href="admin.php" class="nav-link px-2 text-white" id="logo2"><img src="../images/logo.png" alt="logo" style="height: 90px;width: 90px;border-radius: 50%;object-fit: contain"></a>
                    <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0" id="nav">
                    <li class="nav-bar mt-2"><a href="admin.php" class="nav-link px-2 text-white">Home</a></li>
                    <li class="nav-bar mt-2"><a href="orders.php" class="nav-link px-2 text-white">Orders</a></li>
                    <li class="nav-bar mt-2"><a href="reports.php" class="nav-link px-2 text-white">Reports</a></li>
                    <li class="nav-bar mt-2"><a href="products.php" class="nav-link px-2" id="active">Products</a></li>
                    <li class="nav-bar mt-2"><a href="categories.php" class="nav-link px-2 text-white">Categories</a></li>
                    <li class="nav-bar mt-2"><a href="accounts.php" class="nav-link px-2 text-white">Accounts</a></li>                    
                    </ul>
                    <div class="text-end">
                    <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3" id="welcome" role="search">
                    <span class="text-white welcome">Welcome, <?php echo $_SESSION['displayName']."! "."(".$_SESSION['roleType']." - ".$_SESSION['roleDes'].")" ?></span>
                    <a class="btn-log" href="../logout.php">Logout</a>
                    </div>
                    </form>
                    <label for="menu-toggle" class="menu-icon fs-1">&#9776;</label>
                    <input type="checkbox" id="menu-toggle">
                </div>
                <div class="dropdown_menu">
                <ul class="dropdown_nav col-12 col-lg-auto me-lg-auto text-center mb-md-0">
                    <li class="nav-bar"><a href="admin.php" class="nav-link px-2 text-white">Home</a></li>
                    <li class="nav-bar mt-4"><a href="orders.php" class="nav-link px-2 text-white">Orders</a></li>
                    <li class="nav-bar mt-4"><a href="reports.php" class="nav-link px-2 text-white">Reports</a></li>
                    <li class="nav-bar mt-4"><a href="products.php" class="nav-link px-2" id="active">Products</a></li>
                    <li class="nav-bar mt-4"><a href="categories.php" class="nav-link px-2 text-white">Categories</a></li>
                    <li class="nav-bar mt-4 mb-4"><a href="accounts.php" class="nav-link px-2 text-white">Accounts</a></li>
                    <span class="text-white">Welcome, <?php echo $_SESSION['displayName']."! "."(".$_SESSION['roleType']." - ".$_SESSION['roleDes'].")" ?></span>
                    <a class="btn fs-6 fw-bold text-white" style="background-color: rgb(255, 128, 0);" href="../logout.php">Logout</a>               
                </ul>
            </div>
            </div>
    </header>
    <h3><?php echo $_SESSION['prodWarning']; ?></h3>
    <div class="container-fluid mt-5" id="container">
        <div class="flow shadow p-3 mb-5 bg-body rounded">
            <table id="example" class="table table-striped" style="width:100%">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Category</th>
                        <th>Date Product Created</th>
                        <th>Last Update</th>
                        <th>Actions</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                        <?php
                            foreach($data as $rowprod){ 
                        ?>
                    <tr>
                        <td><img src="<?php echo $rowprod['image']; ?>" style="height: 150px;width: 250px; object-fit: cover;border-radius: 10px;"></td>
                        <td width="5%"><?php echo $rowprod['product_name']; ?></td>
                        <td><?php echo $rowprod['price']; ?></td>
                        <td><?php echo $rowprod['category_name']; ?></td>
                        <td><?php echo $rowprod['prod_created_at']; ?></td>
                        <td><?php echo $rowprod['prod_updated_at']; ?></td>
                        <form action="products.php?prodid=<?php echo $rowprod['product_id']; ?>" method="post"><td>
                        <button type="submit" name="btn-edit" class="btn btn-secondary">Edit</button>
                        <button type="submit" class="btn btn-danger" name="btn-delete">Delete</button></td>
                        <td><span class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" value="checked" class="disable"
                        <?php echo ($rowprod['prod_stat'] == 1) ? 'checked' : ''; ?> name="chkProd" id="flexSwitchCheckDefault" onchange="this.form.submit()">
                        <label class="form-check-label" for="flexSwitchCheckDefault">Disable</label>
                        </span></td></form>
                    </tr>
                        <?php 
                            }
                        ?>
                </tbody>
            </table>
            </div>
            <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="POST" enctype="multipart/form-data">
                <div class="shadow p-3 mb-5 bg-body rounded">
                <h4 class="text-center sunborn">★Add Products</h4>
                <div>
                <select class="form-select form-select-lg" name="prodCat">
                    <option class="text-secondary">Select Category</option>
                    <?php
                        foreach($categories as $rows){
                             
                    ?>
                    <option class="" value="<?php echo $rows['category_id']; ?>"><?php echo $rows['category_name']; ?></option>
                    <?php } ?>
                </select>
                <div class="input-group mt-3">
                    <span class="input-group-text">Product Name</span>
                    <input type="text" class="form-control"  name="prodName" required>
                </div>
                <div class="input-group mt-3">
                    <span class="input-group-text">Php</span>
                    <input type="text" class="form-control" placeholder="Price"  name="prodPrice" required>
                </div>
                <div class="input-group mt-3">
                    <input class="form-control" type="file" id="formFileMultiple" name="prodImage" multiple required>
                </div>
                <div class="d-grid gap-2 mt-4">
                    <button class="btn btn-primary" type="submit" name="addProd">Add Products</button>
                </div>
                </div>
            </form>
        </div>
            <!-- Modal HERE -->
        <?php 
            if(isset($_POST['btn-edit'])){
                echo'
                <script>
                    $(document).ready(function(){
                        $("#exampleModal").modal("show");
                    });
                </script>
                ';
                    $sqlgetproducts = "SELECT * FROM products WHERE product_id = '$prodId'";
                    $sqlgetproducts = mysqli_query($conn, $sqlgetproducts);
                    while($prodrow = mysqli_fetch_array($sqlgetproducts)){
                        $prodData[] = $prodrow;
                    }
                }
        ?>
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <form action="" method="post" enctype="multipart/form-data">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Product</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                            <div class="modal-body">
                                <?php foreach($prodData as $prodrow){} ?>
                            <img src="<?php echo $prodrow['image'] ?>" style="height: 250px;width: 100%; object-fit: cover;">
                            <select class="form-select form-select-lg" name="modtxtcat">
                                <option>Select Category</option>
                                <?php
                                    foreach($categories as $rows){
                                        
                                ?>
                                    <option value="<?php echo $rows['category_id']; ?>"><?php echo $rows['category_name']; ?></option>
                                <?php
                                    }
                                ?>
                            </select>
                            <div class="input-group mt-3">
                                <span class="input-group-text">Product Name</span>
                                <input type="text" name="modtxtprodname" class="form-control" required>
                            </div>
                            <div class="input-group mt-3">
                                <span class="input-group-text">Php</span>
                                <input type="text" name="modtxtprice" class="form-control" placeholder="Price" required>
                            </div>
                            <div class="input-group mt-3">
                                <input class="form-control" name="modprodImage" type="file" id="formFileMultiple" multiple>
                            </div>
                    <div class="modal-footer mt-3">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" name="modSave">Save changes</button></form>
                    </div>
                    </div>
                </div>
            </div>

        
        <script>
            new DataTable('#example');
        </script>
        <script src="../summerJS/summers.js"></script>
</body>
</html>
