<?php
session_start();
include('koneksi.php');

$errors = array();

if (isset($_POST['login_user'])) {
$username = mysqli_real_escape_string($conection, $_POST['name']);
$password = mysqli_real_escape_string($conection, $_POST['password']);

if (empty($name)) {
array_push($errors, "Username is required");
}

if (empty($password)) {
array_push($errors, "Password is required");
}

if (count($errors) == 0) {
$password = md5($password);
$query = "SELECT * FROM users WHERE name = '$name' AND password = '$password' ";
$result = mysqli_query($conection, $query);

if (mysqli_num_rows($result) == 1) {
$_SESSION['name'] = $name;
$_SESSION['success'] = "Your are now logged in";
header("location: index.php");
} else {
array_push($errors, "Wrong Username or Password");
$_SESSION['error'] = "Wrong Username or Password!";
header("location: login.php");
}
} else {
array_push($errors, "Username & Password is required");
$_SESSION['error'] = "Username & Password is required";
header("location: login.php");
}
}

?>