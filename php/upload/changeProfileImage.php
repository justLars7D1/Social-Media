<?php
session_start();
if (!isset($_SESSION['user'])) {
  header('Location: ./login.php');
  exit;
}

if (!isset($_FILES['file'])) {
  header('Location: ./login.php');
  exit;
}

include('../connect.php');

$file = $_FILES['file'];

$fileName = $file['name'];
$fileTmpName = $file['tmp_name'];
$fileSize = $file['size'];
$fileError = $file['error'];
$fileType = $file['type'];

$fileExt = explode('.', $fileName);
$fileActualExt = strtolower(end($fileExt));

$allowed = array('jpg', 'jpeg', 'png', 'bmp');

if (in_array($fileActualExt, $allowed)) {

  if ($fileError === 0) {

    if ($fileSize < 5242880) {

      $fileNameNew = uniqid('', true).".".$fileActualExt;
      $fileDestination = '../../uploads/'.$fileNameNew;

      $stmt = $connect->prepare('UPDATE user_info SET user_profile_image=? WHERE user_id=?');
      $stmt->bind_param('si', $fileNameNew, $_SESSION['user']['user_id']);

      if ($stmt->execute()) {
        move_uploaded_file($fileTmpName, $fileDestination);
        echo 'Your profile image has been changed!';
      } else {
        echo 'There was an error while trying to upload your file...';
      }

    } else {

      echo "Your file is too big!";

    }

  } else {

    echo 'There was an error while uploading your file: ';
    echo $fileError;

  }

} else {

  echo "This file type isn't supported.. Suported file types are: jpg, jpeg, png and bmp!";

}



?>
