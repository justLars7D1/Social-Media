<?php 
date_default_timezone_set("Europe/Amsterdam"); 
$currentTime = date('Y-m-d H:i:s');
$geoDefault = "false";

session_start();
if (!isset($_SESSION['user'])) {
	header('Location: ./login.php');
	exit;
}
include '../connect.php';

if (!empty($_FILES['file'])) {

	$file = $_FILES['file'];

	$fileName = $file['name'];
	$fileTmpName = $file['tmp_name'];
	$fileSize = $file['size'];
	$fileError = $file['error'];
	$fileType = $file['type'];

	$fileExt = explode('.', $fileName);
	$fileActualExt = strtolower(end($fileExt));

	$allowed = array('jpg', 'jpeg', 'pdn', 'png', 'bmp');

	if (in_array($fileActualExt, $allowed)) {
		
		if ($fileError === 0) {
			
			if ($fileSize < 5242880) {
				
				$fileNameNew = uniqid('', true).".".$fileActualExt;
				$fileDestination = '../../uploads/'.$fileNameNew;

				$sql = "INSERT INTO uploads (user_id, upload_name, upload_time) VALUES (?, ?, ?)";
				$sql2 = "INSERT INTO upload_geo (upload_id, geo_enabled) VALUES (?, ?)";

				if($statement = $connect->prepare($sql)) {

			        $statement->bind_param(
			        "iss",
			        $_SESSION['user']['user_id'],
			        $fileNameNew,
			        $currentTime
			        );

			        if ($statement->execute()) {
			        	
			        	move_uploaded_file($fileTmpName, $fileDestination);

			        	$selectNew = "SELECT * FROM uploads WHERE upload_name='".$fileNameNew."' ";
			        	$queryNew = mysqli_query($connect, $selectNew);
			        	$fetchNew = mysqli_fetch_assoc($queryNew);

			        	$statement2 = $connect->prepare($sql2);
				        $statement2->bind_param(
				        "is",
				        $fetchNew['upload_id'],
				        $geoDefault
				        );			

				        $statement2->execute();	        		

			        	echo 'Your post has been uploaded!';
						
			        } else {

			        	echo "Error, the file couldn't be uploaded... Try again later.";

			        }		

				} else {

			        	echo "Couldn't connect to the database... Try again later.";

			        }
				

			} else {

				echo "Your file is too big!";

			}

		} else {

			echo 'There was an error while uploading your file: ';
			echo $fileError;

		}

	} else {

		echo "This file type isn't supported.. Suported file types are: jpg, jpeg, pdn, png and bmp!";

	}

}
?>