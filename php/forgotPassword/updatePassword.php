<?php
session_start(); 
if (!empty($_SESSION['user'])) {
	echo "You're already logged in!";
	exit;
}
include '../connect.php';

$pwd = mysqli_real_escape_string($connect, $_POST['pwd']);
$pwdConfirm = mysqli_real_escape_string($connect, $_POST['pwdConfirm']);
$uniqueId = mysqli_real_escape_string($connect, $_POST['uniqueId']);

if ($pwd == "" || $pwdConfirm == "") {
		
	echo  '<b>Please fill in a valid password</b>';
	exit;

}

if ($pwd !== $pwdConfirm) {
		
	echo "<b>The two passwords provided didn't match</b>";
	exit;

}

$select = "SELECT * FROM forgot_password WHERE user_unique_id='".$uniqueId."' ";
$fetch = mysqli_fetch_assoc(mysqli_query($connect, $select));

$hashed = password_hash($pwd, PASSWORD_DEFAULT);
$update = "UPDATE users SET user_pwd='".$hashed."' WHERE user_id='".$fetch['user_id']."'";
$delete = "DELETE FROM forgot_password WHERE user_id='".$fetch['user_id']."' AND user_unique_id='".$uniqueId."'";

if (mysqli_query($connect, $update) && mysqli_query($connect, $delete)) {

	$_SESSION['incorrectVerificationCode'] = "Your password has been reset, you can now login with your new password!";
	echo '<script>location.reload()</script>';
	exit;

} else {

	echo '<b>It appears that the servers are down, try again later.... We are really sorry for the inconvenience</b>';

}

?>