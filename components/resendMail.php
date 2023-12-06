<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vender/PHPMailer/src/Exception.php';
require '../vender/PHPMailer/src/PHPMailer.php';
require '../vender/PHPMailer/src/SMTP.php';

include '../model/database.php';
include '../model/user.php';
$db = new Database();
session_start();
$userSignUp = $_SESSION['userSignUp'];
$username = $userSignUp['username'];
$email = $userSignUp['email'];
$password = $userSignUp['password'];
//Generate confirmedCode
$confirmedCode = mt_rand(100000, 999999);

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
    $mail->Subject = 'Resend OTP code CaoMinh Website';
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
    $db->updUserResend($userSignUp, $confirmedCode);
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
