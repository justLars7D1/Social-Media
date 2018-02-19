<?php
session_start();
date_default_timezone_set('Europe/Amsterdam');
if (!isset($_SESSION['user'])) {

  header('Location: ./login.php');
  exit;

}
?>
  <!DOCTYPE html>
  <html>

  <head>
    <title>Meet - Home</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#009688">
    <link rel='shortcut icon' href='./images/favicon.png'>
    <!--Jquery en andere libraries (CSS, JS, etc...)-->
    <link rel="stylesheet" type="text/css" href="./css/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="./css/w3.css">
    <link rel="stylesheet" type="text/css" href="./css/index.css">
    <script src="./js/jquery/jquery.min.js"></script>
    <script type="text/javascript" src="./js/index.js"></script>
  </head>

  <body>
    <div id="navbar">
      <span id="navHome">Home</span>
      <span id="navChallenges">Challenges</span>
      <span id="navSearch">Search <i class="fa fa-search-plus" aria-hidden="true"></i></span>
      <?php
        echo '<span id="navProfile"><a href="./profile.php?name='.$_SESSION['user']['user_uid'].'" style="text-decoration:none;">Profile</a></span>';
      ?>
        <span id="navLogout">Logout</span>
    </div>
    <div id="uploadsDisplay">
      <?php
		include './php/upload/loadUpload.php';
		?>
    </div>
    <div id="activities">
      <span id="welcomeMsg">Hello justLars7D1</span>
      <span id="currentTime">
			<?php
				echo date('H:i d-m-Y');
			?>
		</span>
      <span id="txtActivity">Recent Activity</span>
      <div id="recentActivity">
        <p class="following">You are now following Bram Houben</p>
        <p class="beFollowed">Bram Houben is now following you</p>
        <p class="liked">Bram Houben has just liked your upload</p>
      </div>
      <div id="uploadBtn">
        <span id="uploadFileText">Upload <i class="fa fa-upload" aria-hidden="true"></i></span>
      </div>
      <div id="sendUploadBtn">
        <span>POST</span>
      </div>
    </div>
    <input id="fileUpload" type="file">

    <div id="geoModals"></div>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDhUguoxXPNBYLGiUZvbCBK4RofkVfr2gM" type="text/javascript"></script>
  </body>

  </html>
