<?php
error_reporting(E_ERROR);
ini_set('display_errors', 1);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vender/PHPMailer/src/Exception.php';
require 'vender/PHPMailer/src/PHPMailer.php';
require 'vender/PHPMailer/src/SMTP.php';

include './model/database.php';
include './model/user.php';
$db = new Database();

session_start();

// phân quyền
if (isset($_SESSION['userLogin'])) {
	header("Location: index.php");
}

if (isset($_POST['login'])) {
	//Case: User clickes the login button
	$email = $_POST['email'];
	$password = $_POST['password'];

	$userLogin = $db->checkUser($email, $password);
	if (isset($userLogin)) {
		$_SESSION['userLogin'] = $userLogin;
		//check to see if it's an admin or not
		$role = $userLogin['role'];
		if ($role == 'admin') {
			$_SESSION['msg'] = 'Đăng nhập thành công dưới quyền admin';
			$_SESSION['status'] = 'success';
			header("Location: ./admin/db.php");
			exit;
		} else if ($role == 'user') {
			$_SESSION['msg'] = "User " . $userLogin['username'] . ": Đăng nhập thành công ";
			$_SESSION['status'] = 'success';
			header("Location: index.php");
			exit;
		} else {
			echo "Authorization error";
			exit;
		}
	} else {
		$_SESSION['msg'] = 'Sai tài khoản hoặc mật khẩu!!!';
		$_SESSION['status'] = 'danger';
	};
} else if (isset($_POST['signup'])) {
	//Case: User clickes the signup button
	//get data from form
	$username = $_POST['user'];
	$email = $_POST['email'];
	$password = $_POST['password'];
	//Generate confirmedCode
	$confirmedCode = mt_rand(100000, 999999);

	//get datafrom database
	$isDupUsername = $db->isDupUsername($username);
	$isDupEmail = $db->isDupEmail($email);

	if ($isDupUsername) {
		$_SESSION['msg'] = 'Username đã tồn tại, vui lòng thay đổi';
		$_SESSION['status'] = 'warning';
	} else if ($isDupEmail) {
		$_SESSION['msg'] = 'Email đã tồn tại, hãy chuyển đến trang đăng nhập';
		$_SESSION['status'] = 'warning';
	} else {
		//mailer send mail
		$mail = new PHPMailer(true);
		try {
			//Server settings
			$mail->SMTPDebug = 0;                      //Enable verbose debug output
			$mail->isSMTP();                                            //Send using SMTP
			$mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
			$mail->SMTPAuth   = true;                                   //Enable SMTP authentication
			$mail->Username   = 'caom900@gmail.com';                     //SMTP username
			$mail->Password   = 'jsvi qjuf hqwh egxu';                               //SMTP password
			$mail->SMTPSecure = 'tls';            //Enable implicit TLS encryption
			$mail->Port       = 587;                                    //TCP port to connect to; use 587 
			//Recipients
			$mail->setFrom('caom900@gmail.com', "CaoMinh's Website");
			$mail->addAddress("$email");     //Add a recipient
			//Content
			$mail->isHTML(true);                                  //Set email format to HTML
			$mail->Subject = 'OTP CODE CAOMINH WEB';
			$mail->Body    = "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional //EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'><html xmlns='http://www.w3.org/1999/xhtml' xmlns:o='urn:schemas-microsoft-com:office:office' xmlns:v='urn:schemas-microsoft-com:vml' lang='en'>

<head><link rel='stylesheet' type='text/css' hs-webfonts='true' href='https://fonts.googleapis.com/css?family=Lato|Lato:i,b,bi'>
  <title>Email template</title>
  <meta property='og:title' content='Email template'>
  
<meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>

<meta http-equiv='X-UA-Compatible' content='IE=edge'>

<meta name='viewport' content='width=device-width, initial-scale=1.0'>
  
  
</head>
  
  <body bgcolor='#F5F8FA' style='width: 100%; margin: auto 0; padding:0; font-family:Lato, sans-serif; font-size:18px; color:#33475B; word-break:break-word'>

<! View in Browser Link --> 
    
<div id='email' style='margin: auto; width: 600px; background-color: white;'>
    <table align='right' role='presentation'>
      <tr>
        <td style='vertical-align: top;' valign='top'>
        <a class='subtle-link' href='#' style='text-decoration: underline; font-weight: bold; font-size: 9px; text-transform: uppercase; letter-spacing: 1px; color: #CBD6E2;'>View in Browser</a>
        </td>
        </tr><tr>
    </tr></table>


<! Banner --> 
       <table role='presentation' width='100%'>
          <tr>
       
            <td bgcolor='#00A4BD' align='center' style='vertical-align: top; color: white;' valign='top'>
          
           <img alt='Flower' src='https://hs-8886753.f.hubspotemail.net/hs/hsstatic/TemplateAssets/static-1.60/img/hs_default_template_images/email_dnd_template_images/ThankYou-Flower.png' width='400px' align='middle'>
              
              <h1 style='font-size: 56px;'> Welcome $user! </h1>
              
            </td>
      </tr></table>

  <! First Row --> 

<table role='presentation' border='0' cellpadding='0' cellspacing='10px' style='padding: 10px;'>
   <tr>
     <td style='vertical-align: top;' valign='top'>
      <h2 style='font-size: 28px; font-weight: 900; text-align: center;'>'MinnsVote' is pleased to have you. </h2>
          <p style='font-weight: 100;'>
            We are delighted to welcome you to 'MinnsVote' - the online voting and rating platform. To ensure security, the <b>OTP code</b> below will help you authenticate your account.
          </p>
              <button style='display: block; margin: 0 auto; font: inherit; background-color: #FF7A59; border: none; padding: 10px; text-transform: uppercase; letter-spacing: 2px; font-weight: 900; font-size: 24px; color: white; border-radius: 5px; box-shadow: 3px 3px #d94c53;'> 
                $confirmedCode
              </button>
        </td> 
        </tr>
               </table>
   
      <! Banner Row --> 
<table role='presentation' bgcolor='#EAF0F6' width='100%' style='margin-top: 50px;'>
    <tr>
        <td align='center' style='vertical-align: top; padding: 30px 30px;' valign='top'>
          
       <h2 style='font-size: 28px; font-weight: 900;'> Thank You </h2>
          <p style='font-weight: 100;'>
            Thank you very much for participating in 'Voting MinhCao.' We hope you have a great experience on our platform and will continue to contribute your ideas to the community.
    
            </p>     
        </td>
        </tr>
    </table>

      <! Unsubscribe Footer --> 
    
<table role='presentation' bgcolor='#F5F8FA' width='100%'>
    <tr>
        <td align='left' style='vertical-align: top; padding: 30px 30px;' valign='top'>
          <p style='font-weight: 100; color: #99ACC2;'> Made with &hearts; by Cao Minh </p>
        </td>
        </tr>
    </table> 
    </div>
  </body>
    </html>";
			$mail->AltBody = "Your confirm code:" . $confirmedCode;
			$mail->send();
			// thêm user vào trong database
			$userSignUp = new User($username, $email, $password);
			$db->addUser($userSignUp, $confirmedCode);
			//lưu user đang đăng ký vào session
			$_SESSION['userSignUp'] = $db->getUserByEmail($email);
			//chuyển sang trang confirm
			$_SESSION['msg'] = 'Hãy kiểm tra email của bạn, mã OTP đã được gửi';
			$_SESSION['status'] = 'success';
			header("Location: http://localhost/voting/components/confirm.php?email=$email");
			exit;
		} catch (Exception $e) {
			echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
		}
	}
}
?>

<!DOCTYPE html>
<html>

<head>
	<title>Slide Navbar</title>
	<link rel="stylesheet" type="text/css" href="slide navbar style.css">
	<link href="https://fonts.googleapis.com/css2?family=Jost:wght@500&display=swap" rel="stylesheet">
	<!-- boostrap 5 -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
	<head>
  <script src="https://www.google.com/recaptcha/enterprise.js?render=6LfADPsoAAAAAJOU2YuHG2G9KlhlR0sROmB3q5FT" async defer></script>
  <!-- Your code -->
</head>
	<style>
		body {
			margin: 0;
			padding: 0;
			display: flex;
			justify-content: center;
			align-items: center;
			min-height: 100vh;
			font-family: 'Jost', sans-serif;
			background: linear-gradient(to bottom, #0f0c29, #302b63, #24243e);
		}

		.main {
			width: 350px;
			height: 500px;
			background: red;
			overflow: hidden;
			background: url("https://doc-08-2c-docs.googleusercontent.com/docs/securesc/68c90smiglihng9534mvqmq1946dmis5/fo0picsp1nhiucmc0l25s29respgpr4j/1631524275000/03522360960922298374/03522360960922298374/1Sx0jhdpEpnNIydS4rnN4kHSJtU1EyWka?e=view&authuser=0&nonce=gcrocepgbb17m&user=03522360960922298374&hash=tfhgbs86ka6divo3llbvp93mg4csvb38") no-repeat center/ cover;
			border-radius: 10px;
			box-shadow: 5px 20px 50px #000;
		}

		#chk {
			display: none;
		}

		#signup {
			position: relative;
			width: 100%;
			height: 100%;
		}

		label {
			color: #fff;
			font-size: 2.5rem;
			justify-content: center;
			display: flex;
			margin: 60px;
			font-weight: bold;
			cursor: pointer;
			transition: .5s ease-in-out;
		}

		input {
			width: 60%;
			height: 20px;
			background: #e0dede;
			justify-content: center;
			display: flex;
			margin: 20px auto;
			padding: 20px;
			border: none;
			outline: none;
			border-radius: 5px;
		}

		.btn {

			width: 60%;
			height: 40px;
			margin: 10px auto;
			justify-content: center;
			display: block;
			color: #fff;
			background: #573b8a;
			font-size: 1em;
			font-weight: bold;
			margin-top: 20px;
			outline: none;
			border: none;
			border-radius: 5px;
			transition: .2s ease-in;
			cursor: pointer;
		}

		.btn:hover {
			background: #6d44b8;
		}

		#login {
			height: 460px;
			background: #eee;
			border-radius: 60% / 10%;
			transform: translateY(-180px);
			transition: .8s ease-in-out;
		}

		#login label {
			color: #573b8a;
			transform: scale(.6);
		}

		#chk:checked~#login {
			transform: translateY(-500px);
		}

		#chk:checked~#login label {
			transform: scale(1);
		}

		#chk:checked~#signup label {
			transform: scale(.6);
		}
	</style>
</head>

<body>
	<div class="main">
		<input type="checkbox" id="chk" aria-hidden="true">
		<div id="signup">
			<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
				<label for="chk" aria-hidden="true">Sign up</label>
				<input type="text" name="user" placeholder="User name" required="" pattern="^[a-zA-Z0-9]+([._]?[a-zA-Z0-9]+)*$">
				<input type="email" name="email" placeholder="Email" required="" pattern="^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$">
				<input type="password" name="password" placeholder="Password" required="">
				<input class="btn" type="submit" value="Sign up" name="signup">
			</form>
		</div>

		<div id="login">
			<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
				<label for="chk" aria-hidden="true">Login</label>
				<input type="email" name="email" placeholder="Email" required="">
				<input type="password" name="password" placeholder="Password" required="">
				<input class="btn" type="submit" value="Login" name="login" class="g-recaptcha" data-sitekey="6LfADPsoAAAAAJOU2YuHG2G9KlhlR0sROmB3q5FT" data-callback='onSubmit' data-action='submit'>
			</form>
		</div>
	</div>
	<?php include './components/notication.php' ?>
	<!-- boostrap 5 -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>