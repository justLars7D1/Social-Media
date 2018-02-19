<?php
session_start();
date_default_timezone_set('Europe/Amsterdam');
include('./php/connect.php');

if (!isset($_GET['name'])) {
    header('Location: ./login.php');
    exit;
}

if (!isset($_SESSION['user'])) {
    header('Location: ./login.php');
    exit;
}

$allInfo = array();

$userToDisplay = mysqli_real_escape_string($connect, $_GET['name']);
$user_info_stmt = $connect->prepare('SELECT users.user_id,
                          user_info.user_profile_image, user_info.user_tag, user_info.user_special_tag, user_info.user_total_exp, user_info.user_profile_desc
                          FROM users, user_info
                          WHERE users.user_uid=?
                          AND user_info.user_id=users.user_id');
$user_info_stmt->bind_param('s', $userToDisplay);
if ($user_info_stmt->execute()) {
    $result = $user_info_stmt->get_result();
    $result = $result->fetch_assoc();

    if (empty($result)) {
        echo "This account doesn't exist!";
        exit;
    }

    foreach ($result as $data) {
        array_push($allInfo, $data);
    }

    $following_stmt = $connect->prepare('SELECT COUNT(following_id) FROM user_following WHERE following_id=?');
    $following_stmt->bind_param('i', $allInfo[0]);
    $following_stmt->execute();
    $result0 = $following_stmt->get_result();
    $result0 = $result0->fetch_assoc();

    foreach ($result0 as $data) {
        $data -= 1;
        array_push($allInfo, $data);
    }

    $following_stmt = $connect->prepare('SELECT COUNT(follower_id) FROM user_following WHERE follower_id=?');
    $following_stmt->bind_param('i', $allInfo[0]);
    $following_stmt->execute();
    $result0 = $following_stmt->get_result();
    $result0 = $result0->fetch_assoc();
    foreach ($result0 as $data) {
        $data -= 1;
        array_push($allInfo, $data);
    }
} else {
    echo 'There was an error fetching the account!';
}

$levelingArray = [
  0, 1000, 2000, 3250, 4750, 6500, 9250, 13000, 17750,
  23500, 30250, 38750, 49000, 61000, 74750, 90250, 108250, 128750, 151750,
  177250, 205250, 236500, 271000, 308750, 349750, 394000, 442250, 494500, 550750,
  611000, 675250, 744250, 818000, 896500, 979750, 1067750, 1161250, 1260250, 1364750,
  1474750, 1590250,	1712000, 1840000, 1974250, 2114750,2261500,	2415250, 2576000, 2743750,
  2918500, 3100250, 3289750, 3487000,	3692000, 3904750,	4125250, 4354250,	4591750, 4837750,
  5092250, 5355250, 5627500, 5909000, 6199750, 6499750, 6809000, 7128250, 7457500, 7796750,
  8146000, 8505250, 8875250, 9256000, 9647500, 10049750, 10462750
];
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
    <link rel="stylesheet" type="text/css" href="./css/profile.css">
    <script src="./js/jquery/jquery.min.js"></script>
    <script type="text/javascript" src="./js/profile.js"></script>
  </head>

  <body>
    <div id="navbar">
      <span id="navHome">Home</span>
      <span id="navChallenges">Challenges</span>
      <span id="navSearch">Search <i class="fa fa-search-plus" aria-hidden="true"></i></span>
      <span id="navProfile">Profile</span>
      <span id="navLogout">Logout</span>
    </div>

    <?php

    if ($_SESSION['user']['user_uid'] == $userToDisplay) {
      echo '<style>
      #profileImage:hover {
        opacity:0.8;
        cursor:pointer;
      }

      </style>
      <input type="file" id="changeProfilePicture">
      ';
    }

echo '
  <div id="profileSlider">
    <img id="profileImage" src="./uploads/'.$allInfo[1].'">
    <h1 id="username">'.$_GET['name'].'</h1>
    <h3 id="user_tag">'.$allInfo[2].'</h3>
    <div id="followers"><p>'.$allInfo[6].' Followers</p></div>
    <div id="following"><p>'.$allInfo[7].' Following</p></div>';



foreach ($levelingArray as $key => $dataPoint) {

  #if exp is maxed
    if ($allInfo[4] == 10462750) {
        $level = 75;
        $expNeeded = 413000;
        $expHaving = 413000;
        $percentage = 100;
        break;
    }

    #if exp is 0
    if ($allInfo[4] == 0) {
        $level = 1;
        $expNeeded = 1000;
        $expHaving = 0;
        $percentage = 0;
        break;
    }

    #if just leveled up
    if ($allInfo[4] == $dataPoint) {
        $level = intval($key)+1;
        $expNeeded = $dataPoint - $levelingArray[$key-1];
        $expHaving = 0;
        $percentage = 0;
        break;
    }

    #if not just leveled up
    if ($allInfo[4] < $dataPoint) {
        $level = intval($key);
        $expNeeded = $dataPoint - $levelingArray[$key-1];
        $expHaving = $expNeeded - ($dataPoint - $allInfo[4]);
        $percentage = $expHaving/$expNeeded*100;
        break;
    }
}

$colorsArray = [['#FFEB3B', 'w3-yellow'], ['#E91E63', 'w3-pink'], ['#673AB7', 'w3-purple'], ['#CDDC39', 'w3-green'], ['#2196F3', 'w3-blue'], ['#87CEEB', 'w3-indigo'], ['#FF9800', 'w3-orange'], ['#F44336', 'w3-red']];

if ($level <= 9) {
    $colorVal0 = $colorsArray[0][0];
    $colorVal1 = $colorsArray[0][1];
}

if ($level >= 10 && $level <= 19) {
    $colorVal0 = $colorsArray[1][0];
    $colorVal1 = $colorsArray[1][1];
}
if ($level >= 20 && $level <= 29) {
    $colorVal0 = $colorsArray[2][0];
    $colorVal1 = $colorsArray[2][1];
}
if ($level >= 30 && $level <= 39) {
    $colorVal0 = $colorsArray[3][0];
    $colorVal1 = $colorsArray[3][1];
}
if ($level >= 40 && $level <= 49) {
    $colorVal0 = $colorsArray[4][0];
    $colorVal1 = $colorsArray[4][1];
}
if ($level >= 50 && $level <= 59) {
    $colorVal0 = $colorsArray[5][0];
    $colorVal1 = $colorsArray[5][1];
}
if ($level >= 60 && $level <= 69) {
    $colorVal0 = $colorsArray[6][0];
    $colorVal1 = $colorsArray[6][1];
}

if ($level >= 70 && $level <= 75) {
    $colorVal0 = $colorsArray[7][0];
    $colorVal1 = $colorsArray[7][1];
}

echo '
  <div class="level" style="background-color:'.$colorVal0.';"><h4><b>Lv '.$level.'</b></h4></div>
  <div class="w3-light-grey meter">
    <div class="'.$colorVal1.'" style="height:1.5vh;width:'.$percentage.'%;border-top-left-radius:0.2vw;border-bottom-left-radius:0.2vw;"></div>
  </div>
  <div class="expProgress">
    <h4>'.$expHaving.'/'.$expNeeded.' exp</h4>
  </div>
  <div id="profileDesc">
    <h5><b>'.$allInfo[5].'</b></h5>
  </div>
  <div id="profileTag">
    <h3>'.$allInfo[3].'</h3>
  </div>
  <div id="hideProfile">';

  $stmt = $connect->prepare('SELECT COUNT(upload_id) FROM uploads WHERE user_id=?');
  $stmt->bind_param('i', $allInfo[0]);
  $stmt->execute();
  $result1 = $stmt->get_result();
  $result1 = $result1->fetch_assoc();

  echo '<h1><b>'.$result1['COUNT(upload_id)'].' Uploads</b></h1>
  </div>
</div>';

echo '<div id="uploads">';

$stmt = $connect->prepare('SELECT upload_id, upload_name FROM uploads WHERE user_id=? ORDER BY upload_id DESC');
$stmt->bind_param('i', $allInfo[0]);
$stmt->execute();
$result1 = $stmt->get_result();

while ($fetch = $result1->fetch_assoc()) {
  echo '<img src="./uploads/'.$fetch['upload_name'].'" class="upload">';
}

echo '</div>';

?>

  </body>

  </html>
