<?php 
session_start();
if (!empty($_SESSION['user'])) {
	echo 'You are already logged in!';
	exit;
}
include '../connect.php';

$UMail = mysqli_real_escape_string($connect, $_POST['forgotPasswordUMail']);
$uniqueId = uniqid();

if ($UMail == "") {

	echo 'Please fill in a valid username or email adress';
	exit;

}

if (filter_var($UMail, FILTER_VALIDATE_EMAIL)) {

	$select = "SELECT * FROM users WHERE user_email='".$UMail."'";
	$query =  mysqli_query($connect, $select);

	if (mysqli_num_rows($query) == 1) {

		$fetch = mysqli_fetch_assoc($query);
		$subject = "Meet | Forgot Password";
		$link = "https://www.justLars7D1.com/MEET/forgotpassword.php?id=".$uniqueId."";
		$content = "Hello ".$fetch['user_uid'].",\n\n
		You (or someone else) has requested a password reset on your email adress or username.\n
		If this is not you, we recommend that you don't use this link (unless you want to change this password ofcourse).\n
		This unique link is only valid for 24 hours after it was sent. Please keep in mind that this might be the reason that it doesn't work.\n
		If this is the case, just simply ask for a password reset again.\n
		".$link."\n\n
		We hope you are having an amazing time at meet!\n
		Greetings,\n\n
		~Lars Quaedvlieg | Meet CEO
		";

		$insert = "INSERT INTO forgot_password (user_id, user_unique_id) VALUES ('".$fetch['user_id']."', '".$uniqueId."')";

		if(mail($UMail, $subject, $content) && mysqli_query($connect, $insert)) {

			echo 'The email has been sent to the desired email adress! Please note that the link is only valid for 24 hours.';

		} else {

			echo "The email couldn't be sent, try again later. The servers may be down...";

		}

	} else {

		echo "This account doesn't exist! Create an account to start your adventure today!";

	}

} else {

	if (strlen($UMail) < 21) {

		$select = "SELECT * FROM users WHERE user_uid='".$UMail."'";
		$query =  mysqli_query($connect, $select);

		if (mysqli_num_rows($query) == 1) {

			$fetch = mysqli_fetch_assoc($query);
			$subject = "Meet | Forgot Password";
			$link = "https://www.justLars7D1.com/MEET/forgotpassword.php?id=".$uniqueId."";
			$content = "Hello ".$fetch['user_uid'].",\n\n
			You (or someone else) has requested a password reset on your email adress or username.\n
			If this is not you, we recommend that you don't use this email adress (unless you want to change this password ofcourse).\n
			This unique link is only valid for 24 hours after it was sent. Please keep in mind that this might be the reason that it doesn't work.\n
			If this is the case, just simply ask for a password reset again.\n
			".$link."\n\n
			We hope you are having an amazing time at meet!\n
			Greetings,\n\n
			~Lars Quaedvlieg | Meet CEO
			";

			$insert = "INSERT INTO forgot_password (user_id, user_unique_id) VALUES ('".$fetch['user_id']."', '".$uniqueId."')";			

			if(mail($fetch['user_email'], $subject, $content) && mysqli_query($connect, $insert)) {

				echo 'The email has been sent to the desired email adress! Please note that the link is only valid for 24 hours.';

			} else {

				echo "The email couldn't be sent, try again later. The servers may be down...";

			}

		} else {

			echo "This account doesn't exist! Create an account to start your adventure today!";

		}

	} else {

		echo 'Please fill in a valid username or email adress';

	}

}

?>