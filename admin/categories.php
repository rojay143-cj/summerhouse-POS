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
                    <li class="nav-bar mt-2"><a href="products.php" class="nav-link px-2 text-white">Products</a></li>
                    <li class="nav-bar mt-2"><a href="categories.php" class="nav-link px-2" id="active">Categories</a></li>
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
                    <li class="nav-bar mt-4"><a href="products.php" class="nav-link px-2 text-white">Products</a></li>
                    <li class="nav-bar mt-4"><a href="categories.php" class="nav-link px-2" id="active">Categories</a></li>
                    <li class="nav-bar mt-4 mb-4"><a href="accounts.php" class="nav-link px-2 text-white">Accounts</a></li>
                    <span class="text-white">Welcome, <?php echo $_SESSION['displayName']."! "."(".$_SESSION['roleType']." - ".$_SESSION['roleDes'].")" ?></span>
                    <a class="btn fs-6 fw-bold text-white" style="background-color: rgb(255, 128, 0);" href="../logout.php">Logout</a>               
                </ul>
            </div>
            </div>
    </header>
    <div class="container-fluid mt-5" id="container">
        <div class="flow shadow p-3 mb-5 bg-body rounded">
            <table id="example" class="table table-striped" style="width:100%">
                <thead>
                    <tr>
                        <th class="text-center">Category ID</th>
                        <th class="text-center">Category Name</th>
                        <th class="text-center">Date Category Created</th>
                        <th class="text-center">Last Updated</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                        <?php foreach($categories as $rows){ 
                            //data-bs-target="#exampleModal" data-bs-toggle="modal"
                        ?>
                    <tr>
                        <td width="25%"><?php echo $rows['category_id']; ?></td>
                        <td><?php echo $rows['category_name']; ?></td>
                        <td><?php echo $rows['created_at']; ?></td>
                        <td><?php echo $rows['updated_at']; ?></td>
                        <td class="text-end" width="25%"><form action="categories.php?id=<?php echo $rows['category_id']; ?>" method="POST">
                        <button type="submit" name="catEdit" class="btn btn-secondary" value="<?php echo $rows['category_id'];?>">Edit</button>
                        <button type="submit" id="del" class="btn btn-danger" name="deleteCat">Delete</button></form></td>
                    </tr>
                        <?php } ?>
                </tbody>
            </table>
            </div>
            <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="POST">
                <div class="shadow p-3 mb-5 bg-body rounded">
                <h4 class="text-center sunborn">★Add Category</h4>
                <div>
                <div class="input-group mt-3">
                    <span class="input-group-text">Category Name</span>
                    <input type="text" class="form-control"  name="catName" required>
                </div>
                <div class="d-grid gap-2 mt-4">
                    <button class="btn btn-primary" type="submit" name="addCat">Add Category</button>
                </div>
                </div>
            </form>
            <p><?php echo $_SESSION['catMessage']; ?></p>
            <p><?php echo $_SESSION['modcatMessage']; ?></p>
        </div>
        <?php
        if(isset($_POST['catEdit']))
        {
            echo'
                <script>
                    $(document).ready(function(){
                        $("#exampleModal").modal("show");
                    })
                </script>
            ';
            echo '
                <!-- Modal Create Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Categories</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="" method="post">
                            <div class="modal-body">
                            <div class="input-group mt-3">
                                <span class="input-group-text">Category Name</span>
                                <input type="text" name="modalcatName" class="form-control" required>
                            </div>
                    <div class="modal-footer mt-3">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success" name="catSave">Save changes</button></form>
                    </div>
                    </div>
                </div>
            </div>
            ';
            }
        ?>

        
        <script>
            new DataTable('#example');
        </script>
        <script src="../summerJS/summers.js"></script>
</body>
</html>