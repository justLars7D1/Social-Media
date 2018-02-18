<?php 
session_start();
include '../connect.php';

$name = mysqli_real_escape_string($connect, $_POST['name']);

$selectUpload = "SELECT * FROM uploads WHERE upload_name='".$name."' ";
$queryUpload = mysqli_query($connect, $selectUpload);
$fetchUpload = mysqli_fetch_assoc($queryUpload);

$selectFollowers = "SELECT * FROM user_following WHERE following_id='".$fetchUpload['user_id']."' AND follower_id='".$_SESSION['user']['user_id']."' ";
$queryFollowers = mysqli_query($connect, $selectFollowers);

if (mysqli_num_rows($queryFollowers) == 1) {

	$testLiked = "SELECT * FROM upload_likes WHERE upload_id='".$fetchUpload['upload_id']."' AND liked_by_id='".$_SESSION['user']['user_id']."' ";
	$queryTest = mysqli_query($connect, $testLiked);

	if (mysqli_num_rows($queryTest) == 0) {

		$insert = "INSERT INTO upload_likes (upload_id, liked_by_id) VALUES (".$fetchUpload['upload_id'].", ".$_SESSION['user']['user_id'].") ";
		if (mysqli_query($connect, $insert)) {
			echo 'success';
		} else {
			echo 'error';
		}

	} else {

		$delete = "DELETE FROM upload_likes WHERE upload_id='".$fetchUpload['upload_id']."' AND liked_by_id='".$_SESSION['user']['user_id']."' ";
		if (mysqli_query($connect, $delete)) {
			echo 'success2';
		} else {
			echo 'error2';
		}

	}

} else {

	echo 'error3';

}

?>