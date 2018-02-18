<?php 
session_start();
if (!empty($_SESSION['user'])) {
	echo 'You are already logged in!';
	exit;
}
include '../connect.php';

$UMail = mysqli_real_escape_string($connect, $_POST['UMail']);
$pwd = mysqli_real_escape_string($connect, $_POST['pwd']);

if (!empty($UMail) && !empty($pwd)) {

	if (strlen($pwd) < 21) {

		if (filter_var($UMail, FILTER_VALIDATE_EMAIL)) {

			$selectEnc =  "SELECT * FROM users WHERE user_email='".$UMail."'";
			$queryEnc = mysqli_query($connect, $selectEnc);
			$fetchEnc = mysqli_fetch_assoc($queryEnc);

			if (password_verify($pwd, $fetchEnc['user_pwd'])) {

				$select = "SELECT * FROM users WHERE user_email='".$UMail."'";
				$query = mysqli_query($connect, $select);

				if (mysqli_num_rows($query) == 1) {

					$fetch = mysqli_fetch_assoc($query);

					if ($fetch['activated'] == 1) {

						$_SESSION['user'] = $fetch;
						echo 'Redirecting...<script type="text/javascript">location.reload();</script>';	
						
					} else {

						echo 'Your account has not been activated yet, please click on the link sent to your email to activate your account!';

					}

				} else {

					echo 'Incorrect username or password!';

				}				

			} else {

				echo 'Incorrect username or password!';

			}

		} elseif (strlen($UMail) < 21) {

			$selectEnc =  "SELECT * FROM users WHERE user_uid='".$UMail."'";
			$queryEnc = mysqli_query($connect, $selectEnc);
			$fetchEnc = mysqli_fetch_assoc($queryEnc);

			if (password_verify($pwd, $fetchEnc['user_pwd'])) {

				$select = "SELECT * FROM users WHERE user_uid='".$UMail."'";
				$query = mysqli_query($connect, $select);

				if (mysqli_num_rows($query) == 1) {

					$fetch = mysqli_fetch_assoc($query);

					if ($fetch['activated'] == 1) {

						$_SESSION['user'] = $fetch;
						echo 'Redirecting...<script type="text/javascript">location.reload();</script>';	

					} else {

						echo 'Your account has not been activated yet, please click on the link sent to your email to activate your account!';

					}

				} else {

					echo 'Incorrect username or password!';

				}				

			} else {

				echo 'Incorrect username or password!';

			}

		}

	}

} else {

	echo 'Please fill in all fields correctly!';

}

?>