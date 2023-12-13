<?php
require("../connection/connection.php");
require("source.php");
$accRole = $_SESSION['user'][0];
$accUsername = $_SESSION['user'][1];
$accPassword = $_SESSION['user'][2];
$otpNumber = $_SESSION['user'][3];
$accNickname = $_SESSION['user'][4];
$accbirthdate = $_SESSION['user'][5];
$accAge = $_SESSION['user'][6];
$accGender = $_SESSION['user'][7];
$sqlinsertAcc = "INSERT INTO users (role_id, username, password, mobile_num, display_name, birthdate, age, gender)
VALUES ((SELECT role_id FROM roles WHERE role_id = $accRole), '$accUsername', '$accPassword', '$otpNumber', '$accNickname', '$accbirthdate','$accAge','$accGender')";
$resultInsertAcc = mysqli_query($conn, $sqlinsertAcc);
?>