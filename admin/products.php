<?php 
    require("../connection/connection.php");
    require("source.php");
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
                <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
                    <a href="admin.php" class="nav-link px-2 text-white"><img src="../images/logo.png" alt="logo" style="height: 90px;width: 90px;border-radius: 50%;object-fit: contain"></a>
                    <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                    <li class="nav-bar mt-2"><a href="admin.php" class="nav-link px-2 text-white">Home</a></li>
                    <li class="nav-bar mt-2"><a href="orders.php" class="nav-link px-2 text-white">Orders</a></li>
                    <li class="nav-bar mt-2"><a href="reports.php" class="nav-link px-2 text-white">Reports</a></li>
                    <li class="nav-bar mt-2"><a href="products.php" class="nav-link px-2" id="active">Products</a></li>
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
                    </tr>
                </thead>
                <tbody>
                        <?php foreach($data as $rowprod){ ?>
                    <tr>
                        <td><img src="<?php echo $rowprod['image']; ?>" style="height: 150px;width: 250px; object-fit: cover;border-radius: 10px;"></td>
                        <td width="5%"><?php echo $rowprod['product_name']; ?></td>
                        <td><?php echo $rowprod['price']; ?></td>
                        <td><?php echo $rowprod['category_name']; ?></td>
                        <td><?php echo $rowprod['created_at']; ?></td>
                        <td><?php echo $rowprod['prod_updated_at']; ?></td>
                        <td><form action="products.php?prodid=<?php echo $rowprod['product_id']; ?>" method="post">
                        <button type="submit" name="btn-edit" data-bs-toggle="modal" data-bs-target="#exampleModal" class="btn btn-secondary">Edit</button>
                        <button type="submit" class="btn btn-danger" name="btn-delete">Delete</button></form></td>
                    </tr>
                        <?php } ?>
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
                    })
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
</body>
</html>
