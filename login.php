<?php 
	include('connection/connection.php');
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>The Summerhouse Cafe!</title>
	<style>
* {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      font-family: 'Open Sans', sans-serif;
      background: url(images/1.jpg);
	  background-size: cover;
	  background-attachment: fixed;
	  background-repeat: no-repeat;
    }

    .container {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .form-container {
      width: 500px;
      margin: 0 auto;
      padding: 30px;
      background-color: rgba(20, 21, 55);
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(20, 21, 55);
      color: #fff;
    }

    h1 {
      text-align: center;
      margin-bottom: 10px;
      font-size: 36px;
      color: rgb(255, 128, 0);
    }
	.header{
		text-align: center;
	}
    form {
      display: flex;
      flex-direction: column;
    }

    label {
      margin-bottom: 10px;
      font-size: 18px;
    }

    input {
      padding: 12px;
      border: none;
      border-radius: 5px;
      margin-bottom: 10px;
      font-size: 16px;
      color: #fff;
      background-color: #555;
    }

    button {
      padding: 10px;
      background-color: rgb(255, 128, 0);
      color: #fff;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      font-size: 18px;
      transition: background-color 0.2s ease-in-out;
    }

    button:hover {
      background-color: rgb(255, 255, 255);
	  color: rgb(0, 0, 0);
    }

    a {
      text-decoration: none;
      color: #b38bff;
      font-size: 18px;
      transition: color 0.2s ease-in-out;
    }

    a:hover {
      color: #8c5fb2;
    }

    p {
      text-align: center;
      margin: 8px;
    }
	</style>
</head>
<body>
<div class="container">
    <div class="form-container" id="login-form">
	  	<div class="header">
			<img src="images/logo.png" alt="logo" style="width: 350;height:250px;border-radius:100%;">
		</div>
      <h1>Login</h1>
      <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST">
        <label for="username">Username</label>
        <input type="text" id="username" name="txtUsername" >
        <label for="password">Password</label>
        <input type="password" id="password" name="txtPassword" >
        <button type="submit" name="login">Login</button>
        <input type="hidden" name="roleDes">
        <input type="hidden" name="roleType">
        <input type="hidden" name="userId">
      </form>
    </div>
</div>









</body>
</html>

<?php 
	session_start();

	if(isset($_POST['login'])){
		$txtuser = filter_input(INPUT_POST,'txtUsername',FILTER_SANITIZE_SPECIAL_CHARS);
		$txtpass = filter_input(INPUT_POST,'txtPassword',FILTER_SANITIZE_SPECIAL_CHARS);
    $roleDes = filter_has_var(INPUT_POST,'userId');
    $roleDes = filter_has_var(INPUT_POST,'roleDes');
    $roleType = filter_has_var(INPUT_POST,'roleType');
    $hashPass = password_hash($txtpass, PASSWORD_DEFAULT);
		$roleSqlstaff = "SELECT * FROM users JOIN roles ON roles.role_id = users.role_id 
                    WHERE roles.role_id = 2  AND username = '$txtuser' AND password = '$txtpass'";
    $roleResult = mysqli_query($conn, $roleSqlstaff);
		if($roleResult -> num_rows > 0){
			while ($rows = $roleResult -> fetch_assoc()){
        ($_SESSION['roleDes'] = $rows['description']);
        ($_SESSION['roleType'] = $rows['type']);
        ($_SESSION['displayName'] = $rows['display_name']);
        ($_SESSION['userId'] = $rows['user_id']);
				($_SESSION['txtUsername'] = $rows['username']);
 				($_SESSION['txtPassword'] = $rows['password']);
				if(($rows['username'] == $txtuser) && ($rows['password'] == $txtpass)){

					header('location: staff/staff.php');

        }
			}
		}
		$roleSqladmin = "SELECT * FROM users JOIN roles ON roles.role_id = users.role_id 
    WHERE roles.role_id = 1  AND username = '$txtuser' AND password = '$txtpass'";
		$roleResult = mysqli_query($conn, $roleSqladmin);
		if($roleResult -> num_rows > 0){
			while ($rows = $roleResult -> fetch_assoc()){
        ($_SESSION['roleDes'] = $rows['description']);
        ($_SESSION['roleType'] = $rows['type']);
        ($_SESSION['displayName'] = $rows['display_name']);
        ($_SESSION['userId'] = $rows['user_id']);
				($_SESSION['txtUsername'] = $rows['username']);
 				($_SESSION['txtPassword'] = $rows['password']);
				if(($rows['username'] == $txtuser) && ($rows['password'] == $txtpass)){

					header('location: admin/admin.php');

				}
			}
		}
    echo'<script> alert("Invalid username or Password Please contact the owner!","WARNING!") </script>';
	}
?>