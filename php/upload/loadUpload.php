<?php 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if(file_exists('./php/connect.php') && is_readable('./php/connect.php') && include('./php/connect.php')) {
} else {
	include '../connect.php';
}

function humanTiming ($time) {
	$time = time() - $time;
	$time = ($time<1)? 1 : $time;
	$tokens = array (
        31536000 => 'year',
        2592000 => 'month',
        604800 => 'week',
        86400 => 'day',
        3600 => 'hour',
        60 => 'minute',
        1 => 'second'
    );
    foreach ($tokens as $unit => $text) {
        if ($time < $unit) continue;
        $numberOfUnits = floor($time / $unit);
        return $numberOfUnits.' '.$text.(($numberOfUnits>1)?'s':'');
    }
}

$random = uniqid('', true);
$followingIds = array();

$selectFollowing = "SELECT * FROM user_following WHERE follower_id='".$_SESSION['user']['user_id']."'";
$queryFollowing = mysqli_query($connect, $selectFollowing);

while ($rowFollowing = mysqli_fetch_assoc($queryFollowing)) {
	array_push($followingIds, $rowFollowing['following_id']);
	$selectUploads = "SELECT * FROM uploads WHERE user_id='".$rowFollowing['following_id']."' ORDER BY upload_id DESC";
	$queryUploads = mysqli_query($connect, $selectUploads);

	while ($rowUploads = mysqli_fetch_assoc($queryUploads)) {
		mysqli_query($connect, "UPDATE uploads SET random='".$random."' WHERE upload_id='".$rowUploads['upload_id']."'");			
	}			
}

$selectActualUploads = "SELECT * FROM uploads WHERE random='".$random."' ORDER BY upload_id DESC";
$queryActualUploads = mysqli_query($connect, $selectActualUploads);
while ($fetchUploads = mysqli_fetch_assoc($queryActualUploads)) {

	if (in_array($fetchUploads['user_id'], $followingIds)) {

		$selectUser = "SELECT * FROM users WHERE user_id='".$fetchUploads['user_id']."' ";
		$queryUser = mysqli_query($connect, $selectUser);
		$rowUser = mysqli_fetch_assoc($queryUser);

		echo '
			<div class="upload">
			<span class="uploaderUid">'.$rowUser['user_uid'].'</span>
			<span class="uploadTime">';

		$time = strtotime($fetchUploads['upload_time']);	

		echo humanTiming($time).' ago';		

			echo '</span>
			<img class="actualUpload" src="./uploads/'.$fetchUploads['upload_name'].'">
		'; 

		$selectOwnLiked = "SELECT * FROM upload_likes WHERE liked_by_id='".$_SESSION['user']['user_id']."' AND upload_id='".$fetchUploads['upload_id']."' ";
		$queryOwnLiked = mysqli_query($connect, $selectOwnLiked);
		if (mysqli_num_rows($queryOwnLiked) == 1) {
			echo '<i class="fa fa-thumbs-o-up fa-2x" aria-hidden="true" name="'.$fetchUploads['upload_name'].'" style="color:#197700;"></i>';
		} else {
			echo '<i class="fa fa-thumbs-o-up fa-2x" name="'.$fetchUploads['upload_name'].'" aria-hidden="true"></i>';
		}

		echo '
			<i class="fa fa-commenting-o fa-2x" name="'.$fetchUploads['upload_name'].'" aria-hidden="true"></i>
			<i id='.$fetchUploads['upload_name'].' class="fa fa-globe fa-2x" aria-hidden="true"></i>
			</div>
		';

	}

}

echo "<script type='text/javascript'>

	//Likes related
	$('.upload .fa-thumbs-o-up').on('click', function() {
		var name = this.attributes['name'].value;
		var parent = this;
		$.post('./php/upload/likeUpload.php', {name: name}, function(data) {
			if (data == 'success') {
				$(parent).css({'color': '#197700'});
			}
			if (data == 'success2') {
				$(parent).css({'color': 'black'});
			}
		});		
	});

</script>";

?>