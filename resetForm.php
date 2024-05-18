<?php
session_start();

require("elements/header.php");

$failedUser = false;
$flag = false;
include_once("elements/db.php");

$email = $_SESSION["recoverEmail"];
$securityQuestion = "";

$secretKey = '-';
    
$statusMsg = '';


echo $statusMsg;

$stmt = $con->prepare("SELECT * FROM Users WHERE email = :email;");
if ($stmt) {
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->execute();
    $user = $stmt->fetchAll();

    foreach ($user as $row) {
        $securityQuestion = $row["SecurityQuestion"];
    }
}

if (isset($_POST["newPwd"]) && isset($_POST["email"])) {

    $newEmail = $_POST["email"];
    $pwd = $_POST["newPwd"];
    $hashedPassword = password_hash($pwd, PASSWORD_DEFAULT);
    $updateQuery = "UPDATE Users SET pwdHash = :newPassword WHERE email = :email;";
    $updateStmt = $con->prepare($updateQuery);
    $updateStmt->bindParam(':email', $newEmail, PDO::PARAM_STR);
    $updateStmt->bindParam(':newPassword', $hashedPassword, PDO::PARAM_STR);


    if ($updateStmt->execute()) {
        header("location:login.php");
    }


    $flag = true;
} elseif (isset($_POST["questionChk"])) {

    if(!empty($_POST['h-captcha-response'])){
        $verifyURL = 'https://hcaptcha.com/siteverify';

        $token = $_POST['h-captcha-response'];

        $data = array(
            'secret' => $secretKey,
            'response' => $token,
            'remoteip' => $_SERVER['REMOTE_ADDR']
        );

        $curlConfig = array(
            CURLOPT_URL => $verifyURL,
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POSTFIELDS => $data
        );
        $ch = curl_init();
        curl_setopt_array($ch, $curlConfig);
        $response = curl_exec($ch);
        curl_close($ch);

        $responseData = json_decode($response);

        if($responseData->success){

            foreach ($user as $row) {
                if ($_POST["questionChk"] == $row["SecurityAnswer"]) {
                    $flag = true;
                    break;
                }
            }

            $statusMsg = 'Your contact request has submitted successfully.';
        } else{
            $statusMsg = 'Robot verification failed, please try again.';
        }
    }else{
        $statusMsg = 'Please check on the CAPTCHA box.';
    }


}

?>

<div class="container-fluid bg-dark p-0">
    <?php require("elements/nav.php"); ?>


        <div class="p-5"></div>
        <div class="container">
            <h1 class="px-3"><?php echo $flag ? $email : "Password Reset"; ?></h1>
            <div class="row">
                <div class="col-lg-10">
                    <hr class="border hr opacity-100">
                </div>
                <div class="col-lg-2">
                    <p class="fs-4 my-0">Garage Gym</p>
                    <p class="fs-7">"not just your regular gym"</p>
                </div>
            </div>
            <div class="row justify-content-center">

                <?php if (!$flag) : ?>
                    <form action="resetForm.php" method="POST" class="col-lg-6 col-md-8 col-sm-10"
                          id="questionForm">
                        <div class="p-3"></div>
                        <div class="mb-3">
                            <label for="questionChk" class="form-label"><?php echo $securityQuestion; ?></label>
                            <input type="text" class="form-control" id="questionChk" name="questionChk" required>
                            <div class="p-2"></div>
                            <div class="h-captcha" data-sitekey="3e9209a2-7f66-431d-9ad9-3c55a2821f8c"></div>
                            <div class="p-2"></div>
                            <button class="btn btn-warning align-self-center">Submit
                            </button>

                    </form>
                <?php else : ?>
                    <form action="resetForm.php" method="POST" class="col-lg-6 col-md-8 col-sm-10">
                        <div class="mb-3">
                            <label for="newPwd" class="form-label">New Password:</label>
                            <input type="password" id="newPwd" name="newPwd" placeholder="Enter new password"
                                   class="form-control" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                                   title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters"
                                   required>
                        </div>
                        <input type="hidden" id="email" name="email" value="<?php echo $email ?>"> <?php "\n" ?>
                        <button type="submit" class="btn btn-warning align-self-center">Submit</button>
                    </form>
                <?php endif; ?>

            </div>
        </div>


    <?php
    if (!$flag && isset($_POST["questionChk"])) {


        ?>
        <?php require("elements/nav.php"); ?>

        <div class="container">
            <div class="row justify-content-center">
                <div class="container">
                    <div class="alert alert-danger my-2">
                        <?php echo "Wrong answer, try again!"; ?>
                    </div>
                </div>
            </div>
        </div>

        <?php
    }

    require("elements/footer.php");
    ?>
</div>
