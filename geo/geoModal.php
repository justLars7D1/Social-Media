<?php 
session_start();
include '../php/connect.php';

$upload_name = mysqli_real_escape_string($connect, $_POST['id']);
$selectGeo = "SELECT * FROM uploads WHERE upload_name='".$upload_name."'";
$queryGeo = mysqli_query($connect, $selectGeo);
$fetchGeo = mysqli_fetch_assoc($queryGeo);

$selectGeoPerms = "SELECT * FROM upload_geo WHERE upload_id='".$fetchGeo['upload_id']."' ";
$queryGeoPerms = mysqli_query($connect, $selectGeoPerms);
$fetchGeoPerms = mysqli_fetch_assoc($queryGeoPerms);

if ($fetchGeo['user_id'] == $_SESSION['user']['user_id']) {

  if ($fetchGeoPerms['geo_enabled'] == "false") {

  	include './modals/enableGeo.php';

  } elseif ($fetchGeoPerms['geo_enabled'] == "true" && $fetchGeoPerms['address'] == "") {

  	include './modals/setAdress.php';

  }

}

$selectFollowing = "SELECT * FROM user_following WHERE follower_id='".$_SESSION['user']['user_id']."' AND following_id='".$fetchGeo['user_id']."' ";
$queryFollowing = mysqli_query($connect, $selectFollowing);
if (mysqli_num_rows($queryFollowing) == 1) {

	if ($fetchGeoPerms['geo_enabled'] == "true" && $fetchGeoPerms['address'] != "") {
		
		include './modals/showMap.php';

	} elseif (($fetchGeoPerms['geo_enabled'] == "false" || $fetchGeoPerms['address'] == "") && $fetchGeo['user_id'] != $_SESSION['user']['user_id']) {

		include './modals/notEnabled.php';

	}

}

echo "      <script type='text/javascript'>
        
      $('#closeModal').on('click', function() {
          $('#geoModal').css({'display': 'none'});
      });

      $('#closeModalBtn').on('click', function() {
          $('#geoModal').css({'display': 'none'});
      });

      </script>";

?>