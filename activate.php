<?php 
session_start();
if (!isset($_GET['id']) || !empty($_SESSION['user'])) {
	header('Location: ./login.php');
}
include './php/connect.php';

$activationId = $_GET['id'];

if ($activationId !== '1') {

	$select = "SELECT * FROM users WHERE activated='".$activationId."'";
	$query = mysqli_query($connect, $select);

	if (mysqli_num_rows($query) > 0) {

		$fetch = mysqli_fetch_assoc($query);
		$update = "UPDATE users SET activated='1' WHERE user_id='".$fetch['user_id']."'";

		if (mysqli_query($connect, $update)) {				

			$insertFollowing = "INSERT INTO user_following (follower_id, following_id) VALUES (".$fetch['user_id'].", ".$fetch['user_id'].")";
			if (mysqli_query($connect, $insertFollowing)) {

			$_SESSION['correctVerificationCode'] = 'Your account has been activated. You can now login!';
			header('Location: ./login.php');
				
			}

		} else {

			$_SESSION['incorrectVerificationCode'] = "Database error! Could not activate your account right now, try again later... We are truly sorry for the inconvenience";
			header('Location: ./login.php');

		}

	} else {

		$_SESSION['incorrectVerificationCode'] = "This verification code was incorrect. Please note that this might be the case, because you didn't use the link within 24 hours.";
		header('Location: ./login.php');

	}

} else {

	$_SESSION['incorrectVerificationCode'] = "This verification code was incorrect. Please note that this might be the case, because you didn't use the link within 24 hours.";
	header('Location: ./login.php');

}



?>
<!DOCTYPE html>
<html>
<head>
	<title>Meet | Account Activation</title>
</head>
<body>

</body>
</html>