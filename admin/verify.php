<?php 
    require("../connection/connection.php");
    require("source.php");
?>

<?php
    if(!isset($_SESSION['error']) || empty($enteredOtp)){
        $_SESSION['error'] = "";
        $enteredOtp = "";
    }else{
        $_SESSION['error'] = "<h3 class='text-white bg-danger text-center'>The Code ".$enteredOtp." is Invalid!</h3>";
    }
    if(empty($_SESSION['user'])) {
        header('location: otpmessage.php');
    }
    if(!isset($_SESSION['otp'])){
        echo '
            <script>
                alert("Please Connect to the Internet");
                setTimeout(function(){
                    window.location.href ="accounts.php";
                },0)
            </script>
        ';
    }
    if(empty($enteredOtp)){
        $_SESSION['error'] = "<div class='text-center mt-5'><span class='fw-bold'>Enter a Code</span></div>";
    }
?>

<?php 
    require '../vendor/autoload.php';
    use Vonage\Client;
    use Vonage\Client\Credentials\Basic;
    $accRole = $_SESSION['user'][0];
    $accUsername = $_SESSION['user'][1];
    $accPassword = $_SESSION['user'][2];
    $otpNumber = $_SESSION['user'][3];
    $accNickname = $_SESSION['user'][4];
    $accbirthdate = $_SESSION['user'][5];
    $accAge = $_SESSION['user'][6];
    $accGender = $_SESSION['user'][7];
    if(isset($_POST['resend'])){
        //extra apikey 99961d82
        //extra apiSecret ogW3N3zfGxbSn71I
        $apiKey = '5232a88f';
        $apiSecret = 'PEPLMV9flkl3mGZl';
        $fromNumber = '+639061008410';
        $toNumber = $otpNumber; 

        $otp = mt_rand(1000, 9999);
        $message = "Your OTP is: $otp";
        $_SESSION['otp'] = $otp;
        try {
            $basic = new Basic($apiKey, $apiSecret);
            $client = new Client($basic);
            $response = $client->message()->send([
                'to' => $toNumber,
                'from' => $fromNumber,
                'text' => $message
            ]);
            if ($response['messages'][0]['status'] == 0) {
                // Return OTP as a JSON response
                 json_encode(['otp' => $otp, 'status' => 'success']);
            } else {
                json_encode(['status' => 'error', 'message' => $response['messages'][0]['error-text']]);
            }
        } catch (\Exception $e) {
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
?>
<?php 
    ?>
    <script>
        let digitValidate = function(ele){
        console.log(ele.value);
        ele.value = ele.value.replace(/[^0-9]/g,'');
        }

        let tabChange = function(val){
            let ele = document.querySelectorAll('input');
            if(ele[val-1].value != ''){
            ele[val].focus()
            }else if(ele[val-1].value == ''){
            ele[val-2].focus()
            }   
        }
    </script>

    <?php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Account!</title>
    <link rel="stylesheet" href="mystyle.css">
    <link rel="stylesheet" href="../api/datatable.css">
    <script src="../api/datatable.js"></script>
    <style>
        input{
            height: 40px;
            width: 40px;
            background-color: transparent;
            border-radius: 4px;
            border: 1px solid #2f8f1f;
            text-align: center;
            outline: none;
            &::-webkit-outer-spin-button,
            &::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
            }
        }
        .otpword  {
        -webkit-text-stroke: 1px rgba(20, 21, 55);
        -webkit-text-fill-color: transparent;
        color: rgba(20, 21, 55);
        font-family: 'Roboto', sans-serif;
        font-weight: 900;
        text-align: center;
        }
        body{
            background-image: url(../images/wall.jpg);
            background-repeat: no-repeat;
            background-size: cover;
        }
    </style>
</head>
<body>
    <div class="container text-center">
        <div class="container-fluid w-50 mt-5">
            <div class="card shadow rounded">
            <a class="nav-link px-2 text-white mt-3 mb-4"><img src="../images/logo.png" alt="logo" style="height: 150px;width: 150px;border-radius: 50%;object-fit: contain"></a>
            <form action="" method="post" class="mt-2 mb-5">
                <h3 class="otpword">OTP VERIFICATION</h3>
                <hr>
                <span>Hi, <span class="fw-bold fs-4"><?php echo $_SESSION['user'][4]; ?></span></span>
                <p>We've sent a One Time Password(OTP) to <br> <?php echo substr($_SESSION['user'][3],0,-7),"*******"?></p>
                <span id="error"><?php echo $_SESSION['error'];?></span>
                <input type="text" oninput='digitValidate(this)' onkeyup='tabChange(1)' minlength="1" maxlength="1" name="txtotp1" id="txtotp1" class="mt-3">
                <input type="text" oninput='digitValidate(this)' onkeyup='tabChange(2)' minlength="1" maxlength="1" name="txtotp2" id="txtotp2" class="ms-2">
                <input type="text" oninput='digitValidate(this)' onkeyup='tabChange(3)' minlength="1" maxlength="1" name="txtotp3" id="txtotp3" class="ms-2">
                <input type="text" oninput='digitValidate(this)' onkeyup='tabChange(4)' minlength="1" maxlength="1" name="txtotp4" id="txtotp4" class="ms-2">
                <p>Didn't received the OTP?<button type="submit" name="resend" id="resend" class="text-info border-0 bg-white">Resend</button>
                <span id="timer" class="text-danger fw-bold fs-5"></span></p>
                <input type="hidden" id="accRole" value="<?php echo $_SESSION['user'][0]; ?>">
                <input type="hidden" id="accUsername" value="<?php echo $_SESSION['user'][1]; ?>">
                <input type="hidden" id="accPassword" value="<?php echo $_SESSION['user'][2]; ?>">
                <input type="hidden" id="otpNumber" value="<?php echo $_SESSION['user'][3]; ?>">
                <input type="hidden" id="accNickname" value="<?php echo $_SESSION['user'][4]; ?>">
                <input type="hidden" id="accbirthdate" value="<?php echo $_SESSION['user'][5]; ?>">
                <input type="hidden" id="accAge" value="<?php echo $_SESSION['user'][6]; ?>">
                <input type="hidden" id="accGender" value="<?php echo $_SESSION['user'][7]; ?>">
                <input type="hidden" id="otp" value="<?php echo $_SESSION['otp']; ?>">
                <button type="button" id="btn-verify" class="btn btn-success w-25" name="btn-verify">Verify</button>
                <!--<h6>Temporary OTP: <?php echo $_SESSION['otp'];?></h6>-->
            </form>
            <dd class="mt-3">For additional help, contact the Admin or Owner</dd>
            </div>
        </div>
    </div>
    <script src="../summerJS/summers.js"></script>
</body>
</html>
<?php 
    if(isset($_POST['resend'])){
        ?>
        <script>
        $(document).ready(function(){
            let resend = $('#resend').hide();
            timer = 30;
            function countdown(){
                $('#timer').html(timer);
                timer--;
                if(timer > 0){
                    setTimeout(countdown, 1000);
                }else{
                    resend.show();
                    $('#timer').hide();
                }
            };
            setTimeout(countdown, 1000);
        });
    </script>
        <?php
    }
?>