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
                    <li class="nav-bar mt-2"><a href="categories.php" class="nav-link px-2 text-white">Categories</a></li>
                    <li class="nav-bar mt-2"><a href="accounts.php" class="nav-link px-2" id="active">Accounts</a></li>                    
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
                    <li class="nav-bar mt-4"><a href="categories.php" class="nav-link px-2 text-white">Categories</a></li>
                    <li class="nav-bar mt-4 mb-4"><a href="accounts.php" class="nav-link px-2" id="active">Accounts</a></li>
                    <span class="text-white">Welcome, <?php echo $_SESSION['displayName']."! "."(".$_SESSION['roleType']." - ".$_SESSION['roleDes'].")" ?></span>
                    <a class="btn fs-6 fw-bold text-white" style="background-color: rgb(255, 128, 0);" href="../logout.php">Logout</a>               
                </ul>
            </div>
            </div>
    </header>
    <br>
    <div class="container-fluid mt-5" id="container">
        <div class="flow shadow p-3 mb-5 bg-body rounded">
            <table id="example" class="table table-striped" style="width:100%">
                <thead>
                    <tr>
                        <th class="text-center">Account ID</th>
                        <th class="text-end">ROLE</th>
                        <th class="text-center">UserName</th>
                        <th class="text-end">Password</th>
                        <th class="text-end">Nickname</th>
                        <th class="text-end">Birthdate</th>
                        <th class="text-end">Age</th>
                        <th class="text-end">Gender</th>
                        <th class="text-end">Mobile number</th>
                        <th class="text-end">Date Account Registered</th>
                        <th class="text-end">Last Update</th>
                        <th class="text-end">Action</th>

                    </tr>
                </thead>
                <tbody>
                        <?php 
                            foreach($accData as $accRow){

                            
                        ?>
                    <tr>
                        <td><?php echo $accRow['user_id']; ?></td>
                        <td><?php echo $accRow['type']; ?></td>
                        <td><?php echo $accRow['username']; ?></td>
                        <td><?php echo $accRow['password']; ?></td>
                        <td><?php echo $accRow['display_name']; ?></td>
                        <td><?php echo $accRow['birthdate']; ?></td>
                        <td><?php echo $accRow['age']; ?></td>
                        <td><?php echo $accRow['gender']; ?></td>
                        <td><?php echo $accRow['mobile_num']; ?></td>
                        <td><?php echo $accRow['registered_at']; ?></td>
                        <td><?php echo $accRow['updated_at']; ?></td>
                        <td class="text-center"><form action="accounts.php?userId=<?php echo $accRow['user_id']; ?>" method="POST">
                        <button type="submit" name="accEdit" class="btn btn-secondary">Edit</button>
                        <button type="submit" id="del" class="btn btn-danger" name="deleteAcc">Delete</button></form></td>
                    </tr>
                        <?php } ?>
                </tbody>
            </table>
            </div>
            <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="POST">
                <div class="shadow p-3 mb-5 bg-body rounded text-center">
                    <h4 class="sunborn text-center">★Add Account</h4>
                <div>
                <select class="form-select form-select-lg" name="accRole">
                    <option class="text-secondary">SELECT ROLE</option>
                    <?php foreach($roleData as $roleRow) { ?>
                        <option value="<?php echo $roleRow['role_id'] ?>"><?php echo $roleRow['type'] ?></option>
                    <?php } ?>
                </select>
                <div class="input-group mt-3">
                    <span class="input-group-text">Username</span>
                    <input type="text" class="form-control"  name="accUsername" required>
                </div>
                <div class="input-group mt-3">
                    <span class="input-group-text">Password</span>
                    <input type="password" class="form-control"  name="accPassword" required>
                </div>
                <div class="input-group mt-3 w-auto">
                    <span class="input-group-text">Mobile number</span>
                    <input type="text" placeholder="+639*********" value="+63" minlength="13" maxlength="13" class="form-control" name="otpNumber" required>
                </div>
                <div class="input-group mt-3">
                    <span class="input-group-text">Nickname</span>
                    <input type="text" class="form-control"  name="accNickname" required>
                </div>
                <div class="input-group mt-3">
                    <span class="input-group-text">Birthdate</span>
                    <input type="date" class="form-control"  name="accBirthdate" required>
                </div>
                <div class="input-group mt-3">
                    <span class="input-group-text">Age</span>
                    <input type="number" class="form-control" min="18" max="70" name="accAge" required>
                </div>
                <select class="form-select mt-3" name="accGender">
                    <option class="text-secondary">Gender</option>
                    <option>Male</option>
                    <option>Female</option>
                    <option>Other</option>
                </select>
                <div class="d-grid gap-2 mt-4">
                    <button class="btn btn-primary" type="submit" name="addAcc">Add Account</button>
                </div>
                </div>
            </form>
        </div>
        <span><?php echo $_SESSION['accMessage']; ?></span>
        <?php
        if(isset($_POST['accEdit']))
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
                            <select class="form-select form-select-lg" name="modaccRole">
                                <option class="text-secondary">SELECT ROLE</option>
                                ';
                                foreach($roleData as $roleRow){
                                echo '<option value='; echo $roleRow["role_id"]; echo '>'; echo $roleRow["type"]; echo '</option>';
                                }
            echo '
                            </select>
                            <div class="input-group mt-3">
                                <span class="input-group-text">Username</span>
                                <input type="text" class="form-control"  name="modaccUsername" required>
                            </div>
                            <div class="input-group mt-3">
                                <span class="input-group-text">Password</span>
                                <input type="password" class="form-control"  name="modaccPassword" required>
                            </div>
                            <div class="input-group mt-3 w-auto">
                                <span class="input-group-text">Mobile number</span>
                                <input type="text" placeholder="+639*********" minlength="13" maxlength="13" class="form-control" name="modotpNumber" required>
                            </div>
                            <div class="input-group mt-3">
                                <span class="input-group-text">Nickname</span>
                                <input type="text" class="form-control"  name="modaccNickname" required>
                            </div>
                            <div class="input-group mt-3">
                                <span class="input-group-text">Birthdate</span>
                                <input type="date" class="form-control"  name="modaccBirthdate" required>
                            </div>
                            <div class="input-group mt-3">
                                <span class="input-group-text">Age</span>
                                <input type="number" class="form-control" min="18" max="70" name="modaccAge" required>
                            </div>
                            <select class="form-select mt-3" name="modaccGender">
                                <option class="text-secondary">Gender</option>
                                <option>Male</option>
                                <option>Female</option>
                                <option>Other</option>
                            </select>
                        </form>
                    <div class="modal-footer mt-3">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success" name="modaddAcc">Save changes</button></form>
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