<?php
/*if(empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] == "off"){
    $redirect = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    header('HTTP/1.1 301 Moved Permanently');
    header('Location: ' . $redirect);
    exit();
}*/

/*
3. Forgot Password !!!! && reCaptcha daaraan toevoegen !!!
4. Recaptcha Registration !!!!!
5. Resend Email after not clicked in 24 hours !!!
6. Add X to get rid of error messages .errorMsg && .errMsg !!!
7. IOS scrolling MUST be fixed !!!!!
8. Toevoegen Service Worker !
*/

session_start();
if (!empty($_SESSION['user'])) {

  header('Location: ./index.php');
  exit;

}

?>

<!DOCTYPE html>
<html lang="en">
<title>Meet - Login</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="theme-color" content="#009688">
<link rel='shortcut icon' href='./images/favicon.png'>
<link rel="stylesheet" type="text/css" href="./css/w3.css">
<link rel="stylesheet" type="text/css" href="./css/login.css">
<script src="./js/jquery/jquery.min.js"></script>
<script type="text/javascript" src="./js/login.js"></script>
<body>
<img src="./images/background-login1.jpg" id="bg-img" alt="The background image couldn't load...">
<?php

if (!empty($_SESSION['correctVerificationCode'])) {
  echo '<div class="errMsg"><span class="w3-display-middle">'.$_SESSION['correctVerificationCode'].'</span></div>';
  echo '<style type="text/css">
    .errMsg {

    position: fixed;
    top: 0;
    z-index: 3;
    background-color: #f44336;
    width: 100vw;
    height: 8vh;
    font-size: 1.5vh;

  }
  </style>';
  echo "<script type='text/javascript'>
          var errTime = setTimeout(function() {
        $('.errMsg').remove();
      }, 10000);
  </script>";
  unset($_SESSION['correctVerificationCode']);
}

if (!empty($_SESSION['incorrectVerificationCode'])) {
  echo '<div class="errMsg"><span class="w3-display-middle">'.$_SESSION['incorrectVerificationCode'].'</span></div>';
    echo '<style type="text/css">
    .errMsg {

    position: fixed;
    top: 0;
    z-index: 3;
    background-color: #f44336;
    width: 100vw;
    height: 8vh;
    font-size: 1.5vh;

  }
  </style>';
  echo "<script type='text/javascript'>
          var errTime = setTimeout(function() {
        $('.errMsg').remove();
      }, 10000);
  </script>";
  unset($_SESSION['incorrectVerificationCode']);
}

?>

<div id="info" class="w3-container w3-display-middle w3-panel w3-border">
  <h1 class="w3-center"><b>Meet | Alpha</b></h1>
  <h4 class="w3-center w3-text-blue"><i>Start new friendships</i></h4>
  <p class="w3-center">Log in and continue your adventure!</p>
  <button id="loginTrigger" class="w3-button w3-teal w3-large w3-section w3-block w3-round">Login</button>
  <p class="w3-center">Don't have an account yet? Create one today!</p>
  <button id="registerTrigger" class="w3-button w3-teal w3-large w3-block w3-margin-bottom w3-round">Register</button>
  <button id="whatIsMeet" class="w3-button w3-deep-orange w3-large w3-block w3-margin-bottom w3-round">What is Meet?</button>
</div>

<!-- | Login Modal Start | -->
  <div id="loginModal" class="w3-modal">
  <div class="errorMsg w3-center"></div>
    <div id="stylingLoginModal" class="w3-modal-content w3-card-4 w3-animate-zoom w3-round" style="max-width:600px">
      <div class="w3-center"><br>
        <span id="closeLoginModal" class="w3-button w3-xlarge w3-hover-red w3-display-topright" title="Close Modal">&times;</span>
        <h2>Meet Alpha | Login</h2>
      </div>

        <div class="w3-container w3-section">
          <label><b>Username or Email</b></label>
          <input id="loginUMail" class="w3-input w3-border w3-margin-bottom" type="text" placeholder="Enter Username/Email Adress" required>
          <label><b>Password</b></label>
          <input id="loginPassword" class="w3-input w3-border" type="password" placeholder="Enter Password" required>
          <button id="loginLoginUser" class="w3-button w3-block w3-teal w3-section w3-padding" type="submit">Login</button>
          <!-- Add "Remember me" checkbox-->
          <label>Don't have an account yet?</label>
          <button id="loginTriggerRegister" type="button" class="w3-button w3-block w3-teal w3-section">Register</button>
        </div>

      <div class="w3-container w3-border-top w3-padding-16 w3-light-grey w3-round">
        <button id="closeLoginModalBtn" type="button" class="w3-button w3-red">Cancel</button>
        <span class="w3-right w3-padding w3-hide-small" id="forgotPasswordLogin" style="text-decoration: underline; cursor: pointer;">Forgot password?</span>
      </div>

    </div>
  </div>
<!-- | Login Modal End | -->

<!-- | Forgot Password Modal Start | -->
  <div id="forgotPasswordModal" class="w3-modal">
  <div class="errorMsg w3-center"></div>
    <div id="stylingLoginModal" class="w3-modal-content w3-card-4 w3-round" style="max-width:600px">
      <div class="w3-center"><br>
        <span id="closeFPwdModalCross" class="w3-button w3-xlarge w3-hover-red w3-display-topright" title="Close Modal">&times;</span>
        <h2>Meet Alpha | Forgot Password</h2>
      </div>

        <div class="w3-container w3-section">
          <label><b>Username or Email Adress</b></label>
          <input id="forgotPasswordUMail" class="w3-input w3-border w3-margin-bottom" type="text" placeholder="Enter Username/Email Adress" required>
          <label>We will email you a link to reset your password! This link is only valid for 24 hours after clicking the button.</label>
          <button id="passwordResetButton" type="button" class="w3-button w3-block w3-teal w3-section">Submit</button>
        </div>

      <div class="w3-container w3-border-top w3-padding-16 w3-light-grey w3-round">
        <button type="button" class="w3-button w3-red" id="closeForgotPasswordModalBtn">Cancel</button>
        <button class="w3-button w3-deep-orange w3-right" id="backForgotPasswordModalBtn">Back</button>
      </div>

    </div>
  </div>
<!-- | Forgot Password Modal End | -->

<!-- | Register Modal Start | -->
  <div id="registerModal" class="w3-modal">
  <div class="errorMsg w3-center"></div>
    <div id="stylingRegisterModal" class="w3-modal-content w3-card-4 w3-animate-zoom w3-round" style="max-width:600px">

      <div class="w3-center"><br>
        <span id="closeRegisterModal" class="w3-button w3-xlarge w3-hover-red w3-display-topright" title="Close Modal">&times;</span>
        <h2>Meet Alpha | Register</h2>
      </div>

        <div class="w3-container w3-section">
          <label><b>Username</b></label>
          <input id="registerUsername" class="w3-input w3-border w3-margin-bottom" type="text" placeholder="Enter Username" required>
          <label><b>Email Adress</b></label>
          <input id="registerEmail" class="w3-input w3-border w3-margin-bottom" type="text" placeholder="Enter Email Adress" required>
          <label><b>Age</b></label>
          <input id="registerAge" class="w3-input w3-border w3-margin-bottom" type="number" placeholder="Enter Age" required>
          <label><b>Password</b></label>
          <input id="registerPassword" class="w3-input w3-border w3-margin-bottom" type="password" placeholder="Enter Password" required>
          <label><b>Confirm Password</b></label>
          <input id="registerConfirmPassword" class="w3-input w3-border w3-margin-bottom" type="password" placeholder="Enter Password" required>
          <label><i>By creating an account you accept our <a href="">Privacy Policy</a> and <a href="">Terms of Service</a></i></label>
          <button id="registerCreateAccount" class="w3-button w3-block w3-teal w3-section w3-padding" type="submit">Register</button>
          <label>Already have an account?</label>
          <button id="registerTriggerLogin" type="button" class="w3-button w3-block w3-teal w3-section">Login</button>
        </div>

      <div class="w3-container w3-border-top w3-padding-16 w3-light-grey w3-round">
        <button id="closeRegisterModalBtn" type="button" class="w3-button w3-red">Cancel</button>
      </div>

    </div>
  </div>
<!-- | Register Modal End | -->

<!-- | What is Meet? Modal Start | -->
  <div id="whatIsMeetModal" class="w3-modal">
    <div id="stylingWhatIsMeetModal" class="w3-modal-content w3-card-4 w3-animate-zoom w3-round" style="max-width:600px">

      <div class="w3-center"><br>
        <span id="closeWhatIsMeetModal" class="w3-button w3-xlarge w3-hover-red w3-display-topright" title="Close Modal">&times;</span>
        <h2>So what is Meet?</h2>
      </div>

        <div class="w3-container w3-section">
        <label>Meet is a Social Media website created by a 15 year old student as a project for Computer Science and for his Profile Paper. The website is meant to be a better version of
        Instagram. To achieve this goal, he asked multiple people what they thought was wrong with Instagram and what they would like to see as (fun) features. When he got these opinions,
        he created Meet which contained most of these ideas. Meet is currently in Alpha and is being developed. Meet's release date tends to change, but is currently somewhere in <i>January</i>.
        <br>Thank you so much for your interest, speaking for the entire Meet team, we really hope you enjoy your time at Meet,<br><br>
        <b>~Lars | Meet CEO</b></label>
        </div>

      <div class="w3-container w3-border-top w3-padding-16 w3-light-grey w3-round">
        <button id="closeWhatIsMeetModalBtn" type="button" class="w3-button w3-red">Cancel</button>
      </div>

    </div>
  </div>
<!-- | What is Meet? Modal End | -->

<!--<script type="text/javascript">
if ('serviceWorker' in navigator) {
  window.addEventListener('load', function() {
    navigator.serviceWorker.register('./swLogin.js').then(function(registration) {
      // Registration was successful
      console.log('ServiceWorker registration successful with scope: ', registration.scope);
    }, function(err) {
      // registration failed :(
      console.log('ServiceWorker registration failed: ', err);
    });
  });
}
</script>-->
</body>
</html>
