<?php 
    include("../connection/connection.php");
    include("source.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Summerhouse Cafe</title>
    <link rel="stylesheet" href="../css/summerStyles.css">
    <link rel="stylesheet" href="../api/datatable.css">
    <script src="../api/datatable.js"></script>
    <style>
        #container{
            display: grid;
            grid-template-columns: auto auto auto;
            column-gap: 20px;
        }
        .flow{
            overflow-y: scroll;
            max-height: 800px;
        }
    </style>
</head>
<body>
    <header class="p-2 header-style"">
            <div class="container">
                <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
                    <a href="admin.php" class="nav-link px-2 text-white"><img src="../images/logo.png" alt="logo" style="height: 90px;width: 90px;border-radius: 50%;object-fit: contain"></a>
                    <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                    <li class="nav-bar mt-2"><a href="admin.php" class="nav-link px-2 text-white">Home</a></li>
                    <li class="nav-bar mt-2"><a href="orders.php" class="nav-link px-2 text-white">Orders</a></li>
                    <li class="nav-bar mt-2"><a href="reports.php" class="nav-link px-2 text-white">Reports</a></li>
                    <li class="nav-bar mt-2"><a href="products.php" class="nav-link px-2 text-white" id="active">Products</a></li>
                    <li class="nav-bar mt-2"><a href="categories.php" class="nav-link px-2 text-white">Categories</a></li>
                    <li class="nav-bar mt-2"><a href="accounts.php" class="nav-link px-2 text-white">Accounts</a></li>
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
    <div class="container mt-5" id="container">
        <div class="flow shadow p-3 mb-5 bg-body rounded">
            <table id="example" class="table table-striped" style="width:100%">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Category</th>
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
                        <td><form action="products.php?id= <?php echo $rowprod['product_id']; ?>" method="post"><button type="button" name="btn-edit" data-bs-toggle="modal" data-bs-target="#exampleModal" class="btn btn-secondary">Edit</button>
                        <button type="submit" class="btn btn-danger" name="btn-delete">Delete</button></form></td>
                    </tr>
                        <?php } ?>
                </tbody>
            </table>
            </div>
            <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="POST">
                <div class="shadow p-3 mb-5 bg-body rounded">
                <h4>Add Products</h4>
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
                    <input type="text" class="form-control"  name="prodName">
                </div>
                <div class="input-group mt-3">
                    <span class="input-group-text">Php</span>
                    <input type="text" class="form-control" placeholder="Price"  name="prodPrice">
                </div>
                <div class="input-group mt-3">
                    <input class="form-control" type="file" id="formFileMultiple" multiple>
                </div>
                <div class="d-grid gap-2 mt-4">
                    <button class="btn btn-primary" type="submit" name="addProd">Add Products</button>
                </div>
                </div>
            </form>
        </div>
            <!-- Modal HERE -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Product</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                        <div class="modal-body">
                        <img src="<?php echo $rowprod['image']; ?>" style="height: 250px;width: 100%; object-fit: cover;">
                        <select class="form-select form-select-lg">
                            <option>Select Category</option>
                        </select>
                        <div class="input-group mt-3">
                            <span class="input-group-text">Product Name</span>
                            <input type="text" class="form-control">
                        </div>
                        <div class="input-group mt-3">
                            <span class="input-group-text">Php</span>
                            <input type="text" class="form-control" placeholder="Price">
                        </div>
                        <div class="input-group mt-3">
                            <input class="form-control" type="file" id="formFileMultiple" multiple>
                        </div>
                <div class="modal-footer mt-3">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
                </div>
            </div>
        </div>


        
        <script>
            new DataTable('#example');
        </script>
</body>
</html>