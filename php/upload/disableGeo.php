<?php 
session_start();
include '../connect.php';

$upload_name = mysqli_real_escape_string($connect, $_POST['x']);

$selectUpload = "SELECT * FROM uploads WHERE upload_name='".$upload_name."' AND user_id='".$_SESSION['user']['user_id']."' ";
$queryUpload = mysqli_query($connect, $selectUpload);
if (mysqli_num_rows($queryUpload) == 1) {

	$rowUpload = mysqli_fetch_assoc($queryUpload);

	$insertGeo = "UPDATE upload_geo SET geo_enabled='false', address='' WHERE upload_id='".$rowUpload['upload_id']."'";
	if (mysqli_query($connect, $insertGeo)) {
		echo 'Disabled geolocation!';
	}

} else {

	echo 'You are not the uploader of this post!';

}

?>