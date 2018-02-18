$(document).ready(function() {

	var errTime;

	//Trigger Login Modal
	$('#loginTrigger').on('click', function() {
		$('#loginModal').css({"display": "block"});
	});

	/* | Within Login  Modal | */
	//Close Modal
	$('#closeLoginModal').on('click', function() {
		$('#loginModal').css({"display": "none"});
		$('#stylingRegisterModal').addClass("w3-animate-zoom");
		$('#stylingLoginModal').addClass("w3-animate-zoom");
	});

	//Trigger Register Modal
	$("#loginTriggerRegister").on('click', function() {
		$('#stylingRegisterModal').removeClass("w3-animate-zoom");
		$('#loginModal').css({"display": "none"});
		$('#registerModal').css({"display": "block"});
	});

	//Close Modal
	$('#closeLoginModalBtn').on('click', function() {
		$('#loginModal').css({"display": "none"});
		$('#stylingRegisterModal').addClass("w3-animate-zoom");
		$('#stylingLoginModal').addClass("w3-animate-zoom");
	});	

	//Trigger forgot password modal
	$('#forgotPasswordLogin').on('click', function() {
		$('#loginModal').css({'display': 'none'});
		$('#stylingLoginModal').removeClass("w3-animate-zoom");
		$('#forgotPasswordModal').css({"display": "block"});
	});
 
	//Login user - Login button
	$('#loginLoginUser').on('click', function() {
		var UMail = $('#loginUMail').val();
		var pwd = $('#loginPassword').val();
		$.post('./php/login/loginUser.php', {UMail: UMail, pwd: pwd}, function(data) {
			if (errTime) {
				clearTimeout(errTime);
			}
			$('.errorMsg').html('<span class="w3-display-middle">' + data + '</span>');
			errTime = setTimeout(function() {
				$('.errorMsg').html('');
			}, 5000);
		});
	});

	/* | Within forgot password modal | */
	//Close Modal (Button)
	$('#closeForgotPasswordModalBtn').on('click', function() {
		$('#forgotPasswordModal').css({"display": "none"});
		$('#stylingRegisterModal').addClass("w3-animate-zoom");
		$('#stylingLoginModal').addClass("w3-animate-zoom");
	});

	//Close Modal (Cross)
	$('#closeFPwdModalCross').on('click', function() {
		$('#forgotPasswordModal').css({"display": "none"});
		$('#stylingRegisterModal').addClass("w3-animate-zoom");
		$('#stylingLoginModal').addClass("w3-animate-zoom");		
	});

	//Go back to login modal
	$('#backForgotPasswordModalBtn').on('click', function() {
		$('#forgotPasswordModal').css({"display": "none"});
		$('#loginModal').css({'display': 'block'});

	});

	//Reset pwd actual 
	$('#passwordResetButton').on('click', function() {
		var forgotPasswordUMail = $('#forgotPasswordUMail').val();
		$.post('./php/forgotPassword/forgotPassword.php', {forgotPasswordUMail: forgotPasswordUMail}, function(data) {
			if (errTime) {
				clearTimeout(errTime);
			}
			$('.errorMsg').html('<span class="w3-display-middle">' + data + '</span>');
			errTime = setTimeout(function() {
				$('.errorMsg').html('');
			}, 5000);			
		});
	});

	//Trigger Register Modal
	$('#registerTrigger').on('click', function() {
		$('#registerModal').css({"display": "block"});
	});

	/* | Within Register  Modal | */
	//Close Modal	
	$('#closeRegisterModal').on('click', function() {
		$('#registerModal').css({"display": "none"});
		$('#stylingRegisterModal').addClass("w3-animate-zoom");
		$('#stylingLoginModal').addClass("w3-animate-zoom");
	});

	//Create Account - Register Button
	$('#registerCreateAccount').on('click', function() {
		var uid = $('#registerUsername').val();
		var email = $('#registerEmail').val();
		var age = $('#registerAge').val();
		var pwd = $('#registerPassword').val();
		var confirmPwd = $('#registerConfirmPassword').val();
		$.post('./php/register/createAccount.php', {uid: uid, email: email, age: age, pwd: pwd, confirmPwd: confirmPwd}, function(data) {
			if (errTime) {
				clearTimeout(errTime);
			}
			$('.errorMsg').html('<span class="w3-display-middle">' + data + '</span>');
			errTime = setTimeout(function() {
				$('.errorMsg').html('');
			}, 5000);
		});
	});

	//Trigger Login Modal
	$("#registerTriggerLogin").on('click', function() {
		$('#stylingLoginModal').removeClass("w3-animate-zoom");
		$('#registerModal').css({"display": "none"});	
		$('#loginModal').css({"display": "block"});
	});

	//Close Modal
	$('#closeRegisterModalBtn').on('click', function() {
		$('#registerModal').css({"display": "none"});
		$('#stylingRegisterModal').addClass("w3-animate-zoom");
		$('#stylingLoginModal').addClass("w3-animate-zoom");
	});	

	//Trigger What is Meet Modal
	$('#whatIsMeet').on('click', function() {
		$('#whatIsMeetModal').css({"display": "block"});
	});

	/* | Within whatIsMeet Modal | */

	//Close Modal
	$('#closeWhatIsMeetModal').on('click', function() {
		$('#whatIsMeetModal').css({"display": "none"});
		$('#stylingWhatIsMeetModal').addClass("w3-animate-zoom");
		$('#stylingWhatIsMeetModal').addClass("w3-animate-zoom");
	});
	//Close Modal
	$('#closeWhatIsMeetModalBtn').on('click', function() {
		$('#whatIsMeetModal').css({"display": "none"});
		$('#stylingWhatIsMeetModal').addClass("w3-animate-zoom");
		$('#stylingWhatIsMeetModal').addClass("w3-animate-zoom");
	});	

});

