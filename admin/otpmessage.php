<?php 
    require("../connection/connection.php");
    require("source.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Account!</title>
    <link rel="stylesheet" href="mystyle.css">
    <link rel="stylesheet" href="../api/datatable.css">
    <script src="../api/datatable.js"></script>
    <style>
        body{
            background-image: url(../images/wall.jpg);
            background-repeat: no-repeat;
            background-size: cover;
        }
    </style>
</head>
<body>
    <div class="container text-center">
        <div class="container-fluid w-50 mt-5">
            <div class="card shadow rounded">
            <a class="nav-link px-2 text-white mt-5"><img src="../images/logo.png" alt="logo" style="height: 150px;width: 150px;border-radius: 50%;object-fit: contain"></a>
            <form action="" method="post" class="mt-5 mb-5">
                <h1 id="msg">Account Created!</h1>
                <button type="submit" name="back" class="text-info border-0 fs-5 bg-white" id="back"><ins>Go back</ins></button>
            </form>
            </div>
        </div>
    </div>
</body>
</html>
<?php
    if(isset($_POST['back'])){
        unset($_SESSION['user']);
        $_SESSION['user'] = array();
        header('location: accounts.php');
    }
    if(empty($_SESSION['user'])){
        echo '
            <script>
                $(document).ready(function(){
                    $("#msg").html("Invalid Account");
                    $("#back").hide();
                    setTimeout(function(){
                        window.location.href = "accounts.php";
                    },1000)
                });
            </script>
        ';
    }
    if($_SESSION['user'] == ""){
        header('location: accounts.php');
    }
?>