<?php 
session_start();
if (!isset($_GET['id']) || !empty($_SESSION['user'])) {
	header('Location: ./login.php');
}
include './php/connect.php';

$activationId = $_GET['id'];

$select = "SELECT * FROM forgot_password WHERE user_unique_id='".$activationId."'";
$query = mysqli_query($connect, $select);

if (mysqli_num_rows($query) == 0) {

	if (empty($_SESSION['incorrectVerificationCode'])) {

		$_SESSION['incorrectVerificationCode'] = "This password reset id was incorrect. Please note that this might be the case, because you didn't use the link within 24 hours.";
		header('Location: ./login.php');
		exit;

	}

	header('Location: ./login.php');
	exit;

}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Meet | Forgot Password</title>
	<script src="./js/jquery/jquery.min.js"></script>
</head>
<body>
<label>Please fill in your new password!</label><br>
<input type="password" id="password" placeholder="Password"><br>
<input type="password" id="passwordConfirm" placeholder="Confirm Password"><br>
<button type="submit" id="submitUpdatePassword">Update your password!</button><br>
<div id="errorMessage"></div>

<script type="text/javascript">
$('#submitUpdatePassword').on('click', function() {
	var uniqueId = '<?php echo $activationId; ?>';
	var pwd = $('#password').val();
	var pwdConfirm = $('#passwordConfirm').val();
	$.post('./php/forgotPassword/updatePassword.php', {pwd: pwd, pwdConfirm: pwdConfirm, uniqueId: uniqueId}, function(data) {
		$('#errorMessage').html(data);
	});
});
</script>
</body>
</html>
