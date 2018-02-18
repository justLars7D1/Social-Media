<?php 
session_start();
include '../connect.php';

$address = mysqli_real_escape_string($connect, $_POST['address']);
$name = mysqli_real_escape_string($connect, $_POST['name']);

$test = "SELECT upload_id FROM uploads WHERE upload_name='".$name."' AND user_id='".$_SESSION['user']['user_id']."' ";
$queryTest = mysqli_query($connect, $test);
if (mysqli_num_rows($queryTest) != 1) {
	exit;
}

if (empty($address) || empty($name)) {
	echo 'Please fill in an adress!';
	exit;
}

$fetchTest = mysqli_fetch_assoc($queryTest);
$update = "UPDATE upload_geo SET address='".$address."' WHERE upload_id='".$fetchTest['upload_id']."' ";
if (mysqli_query($connect, $update)) {
	echo 'Successfully set the address to: '.$address;
}


?>