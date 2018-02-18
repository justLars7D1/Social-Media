<?php 
session_start();
if (!empty($_SESSION['user'])) {
	//Make this later
}
include '../connect.php';

$uid = mysqli_real_escape_string($connect, $_POST['uid']);
$email = mysqli_real_escape_string($connect, $_POST['email']);
$age = mysqli_real_escape_string($connect, $_POST['age']);
$pwd = mysqli_real_escape_string($connect, $_POST['pwd']);
$confirmPwd = mysqli_real_escape_string($connect, $_POST['confirmPwd']);

if (!empty($uid) && !empty($email) && !empty($age) && !empty($pwd) && !empty($confirmPwd)) {

	if (strlen($uid) > 20 || strlen($pwd) > 20) {
		echo 'Your username or password exceeds the ammount of 20 characters!';
		exit;
	}

	if ($age > 11) {

		if ($pwd == $confirmPwd) {
			
			if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

				$selectUsers = "SELECT * FROM users WHERE user_uid='".$uid."' OR user_email='".$email."'";
				$queryUsers = mysqli_query($connect, $selectUsers);

				if (mysqli_num_rows($queryUsers) == 0) {

					$hashed = password_hash($pwd, PASSWORD_DEFAULT);

					$activationId = uniqid();

					//Everything is right -> Execute SQL
					$insert = "INSERT INTO users (user_uid, user_pwd, user_email, user_age, activated) VALUES ('".$uid."', '".$hashed."', '".$email."', '".$age."', '".$activationId."')";
					
					if (mysqli_query($connect, $insert)) {

						$subject = "Meet | Account Activation";
						$activationLink = "https://www.justLars7D1.com/MEET/activate.php?id=".$activationId."";
						$content = "Hello ".$uid.",\n\n
						Thank you very much for registering at https://www.justLars7D1.com/MEET/login.php!\n
						To activate your account, please click on the link bellow. Please not that this link is only valid for 24 hours after registering.\n
						".$activationLink."\n\n
						The Meet Team wishes you an amazing time at Meet!\n
						Greetings,\n\n
						~Lars Quaedvlieg | Meet CEO
						";

						if(mail($email, $subject, $content)) {

							echo 'Thank you for creating an account at Meet! A verification email has been sent to your email adress, please click on the verification link in the email to active your account.
							Please note that this link is only valid for 24 hours after registration.';

						}						

					} else {

						echo 'Database error... Try again later!';

					}

				} else {

					echo 'There is already a user with that username or email adress!';

				}

			} else {

				echo 'The email you filled in is incorrect!';

			}

		} else {

			echo "The two passwords didn't match!";

		}

	} else {

		echo 'You must be at least 12 years old to create an account!';

	}


} else {

	echo 'Please fill in all fields correctly!';

}


?>