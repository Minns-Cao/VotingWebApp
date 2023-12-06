<?php
//điều chỉnh múi giờ
date_default_timezone_set('Asia/Saigon');
include '../model/database.php';
session_start();
// phân quyền
if(isset($_SESSION['userLogin'])){
	header("Location: ../index.php");
} 

$userSignUp = $_SESSION['userSignUp'];
$email = $userSignUp['email'];
//cập nhật giá trị trực tiếp từ DB
$db = new Database();
$userSignUp = $db->getUserByEmail($email);
$otpCode = $_GET['otpCode'];
$db = new Database();
//thời gian hiện tại
$time_now = new DateTime();
//thời gian hết hạn của user
$expiretime = DateTime::createFromFormat('Y-m-d H:i:s', $userSignUp['expiretime']);

// echo '<pre>';
// var_dump($userSignUp['otp']);
// echo '</pre>';
// die;

if ($userSignUp != false) {
    if (isset($otpCode)) {
        if ($userSignUp['otp'] == $otpCode) {
            //kiểm tra thời gian sử dụng otp có bị quá hạn không
            if ($expiretime >= $time_now) {
                $result = $db->confirmUser($email, $otpCode);
                if ($result == false) {
                    var_dump($result);
                } else {
                    $_SESSION['msg'] = 'Đã xác thực thành công';
                    $_SESSION['status'] = 'success';
                    //đăng ký thành công thì chuyển session thành đăng nhập
                    $_SESSION['userLogin'] = $_SESSION['userSignUp'];
                    unset($_SESSION['userSignUp']);
                    header("Location: ../admin/db.php");
                    exit;
                }
            } else {
                $_SESSION['msg'] = 'OTP đã hết hạn, vui lòng yêu cầu gửi lại OTP';
                $_SESSION['status'] = 'danger';
            }
        } else {
            $_SESSION['msg'] = 'Mã OTP không chính xác, vui lòng kiểm tra lại';
            $_SESSION['status'] = 'danger';
        }
    }
};

?>
<!DOCTYPE html>
<html>

<head>
    <title>Slide Navbar</title>
    <link rel="stylesheet" type="text/css" href="slide navbar style.css">
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@500&display=swap" rel="stylesheet">
    <!-- boostrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
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
            width: 450px;
            height: auto;
            padding-bottom: 50px;
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
            margin-bottom: 20px;
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

        #otpCode {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-bottom: 20px;
        }

        #otpCode input {
            text-align: center;
            font-size: 34px;
            padding: 0;
            width: 60px;
            height: 60px;
            margin: 0;
        }

        .mes {
            display: block;
            text-decoration: none;
            font-size: 17px;
            text-align: center;
            color: #0f0c29;
            transition: all 0.2s ease;
        }
        .mes:hover {
            color: #e0dede;
        }
    </style>
</head>

<body>
    <div class="main">
        <input type="checkbox" id="chk" aria-hidden="true">
        <div id="otp">
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get">
                <label aria-hidden="true">Enter OTP Code</label>
                <div id="otpCode">
                    <input type="text" maxlength="1" class="input_node">
                    <input type="text" maxlength="1" class="input_node">
                    <input type="text" maxlength="1" class="input_node">
                    <input type="text" maxlength="1" class="input_node">
                    <input type="text" maxlength="1" class="input_node">
                    <input type="text" maxlength="1" class="input_node">
                </div>
                <a class="mes" href='./resendMail.php'>
                    Không nhận được mã? Nhấn để nhận lại OTP.
                </a>
                <input class="btn btnOtp" type="submit" value="Submit" name="signup">
            </form>
        </div>
    </div>
    <?php include './notication.php' ?>
    <!-- boostrap 5 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script>
        let inputs = document.querySelectorAll("#otp #otpCode .input_node");

        inputs.forEach((input, index) => {
            //Generate sequential numbers for input
            input.dataset.index = index;
            //event
            input.addEventListener("keyup", otpKeypress);
        });

        function otpKeypress(e) {
            const input = e.target;
            let indexField = input.dataset.index;
            let value;
            //filter key input
            if (/^[0-9]{1}$/.test(e.key)) {
                value = e.key;
                input.value = e.key;
            } else if (e.key === "Backspace") {
                value = "";
                input.value = "";
            } else {
                value = "";
                input.value = "";
                return;
            }

            //Change focus elm
            if (value.length > 0 && indexField < inputs.length - 1) {
                input.nextElementSibling.focus();
            }
            if (e.key === "Backspace" && indexField > 0) {
                input.value = "";
                input.previousElementSibling.focus();
            }
        }

        let submitOtp = document.querySelector("#otp form");
        submitOtp.addEventListener("submit", (event) => {
            event.preventDefault();
            let optCode = '';
            let trueFormat = true;
            inputs.forEach((elm) => {
                if (elm.value === "") {
                    inputs.forEach((elm) => {
                        elm.value = "";
                    });
                    trueFormat = false;
                }
                optCode += elm.value.toString();
            })
            if (trueFormat) {
                inputCode = `<input type="hidden" value="${optCode}" name="otpCode">`;
                submitOtp.insertAdjacentHTML("beforeend", inputCode);
                submitOtp.submit();
            } else {
                controlMessage.create("Mã OTP không chính xác, vui lòng nhập lại", "danger");
            }
        })
    </script>
</body>

</html>