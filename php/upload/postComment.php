<?php 
session_start();
include '../connect.php';

$postName = mysqli_real_escape_string($connect, $_POST['name']);

$validate = "SELECT * FROM uploads WHERE upload_name='".$postName."' ";
$qValidate = mysqli_query($connect, $validate);
$fValidate = mysqli_fetch_assoc($qValidate);

if (mysqli_num_rows($qValidate) == 0) {
	echo "This upload doesn't exist!";
	exit;
}

$validate = "SELECT * FROM user_following WHERE follower_id='".$_SESSION['user']['user_id']."' AND following_id='".$fValidate['user_id']."' ";
$qValidate = mysqli_query($connect, $validate);
$fValidate = mysqli_fetch_assoc($qValidate);

if (mysqli_num_rows($qValidate) != 1) {
	echo 'You are not following the person who uploaded this!';
	exit;
}

//Passed follow validation -> start comment popup

//Start making it... [move to other file later!]

include './testComment.php';


?>