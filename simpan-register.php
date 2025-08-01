<?php
session_start();
include('koneksi.php');

$errors = array();

if (isset($_POST['reg_user'])) {
$name = mysqli_real_escape_string($conection, $_POST['name']);
$email = mysqli_real_escape_string($conection, $_POST['email']);
$password_1 = mysqli_real_escape_string($conection, $_POST['password']);
if (empty($name)) {
array_push($errors, "Username is required");
$_SESSION['error'] = "Username is required";
}
if (empty($email)) {
array_push($errors, "Email is required");
$_SESSION['error'] = "Email is required";
}
if (empty($password_1)) {
array_push($errors, "Password is required");
$_SESSION['error'] = "Password is required";
}

$user_check_query = "SELECT * FROM users WHERE name = '$name' OR email = '$email' LIMIT 1";
$query = mysqli_query($conection, $user_check_query);
$result = mysqli_fetch_assoc($query);

if ($result) { // if user exists
if ($result['name'] === $name) {
array_push($errors, "Username already exists");
}
if ($result['email'] === $email) {
array_push($errors, "Email already exists");
}
}

if (count($errors) == 0) {
$password = md5($password_1);

$sql = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$password')";
mysqli_query($conection, $sql);

$_SESSION['name'] = $name;
$_SESSION['success'] = "You are now logged in";
header('location: login.php');
} else {
header("location: register.php");
}
}?>