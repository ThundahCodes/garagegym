<?php
session_start();
require("elements/header.php");
/*
 * In this if-statement there will be a check done if all data required for the addition of a user have been sent.
 * This data will be done with isset() which checks if the variable is sent from a POST form.
 * Then the data will be converted into variables and pushed into a stored procedure where the user data will be created.
 */
if (isset($_POST["email"]) && isset($_POST["name"]) && isset($_POST["password"]) && isset($_POST["passwordrepeat"]) && isset($_POST["SecurityQuestion"]) && isset($_POST["SecurityAnswer"])) {
    include("elements/db.php");


    function sanitizeInput($data) // Function for the input validation of data
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $email = $_POST["email"];
    $name = $_POST["name"];
    $password = $_POST["password"];
    $passwordrepeat = $_POST["passwordrepeat"];
    $secQuestion = $_POST["SecurityQuestion"];
    $secAnswer = $_POST["SecurityAnswer"];
    $userRole = "user";


    if ($password != $passwordrepeat) {
        $failedPassword = true;
    } else {
        if (!preg_match('/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/', $password)) { // Regex check to see if the user has put in a strong enough password.
            $failedPasswordValidation = true;
            $passwordValidationError = "Password must contain at least one number, one uppercase letter, one lowercase letter, and be at least 8 characters long.";
        } else {


            $stmt = $con->prepare("SELECT * FROM Users WHERE email = :email;");
            if ($stmt) {
                $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                $stmt->execute();
                $user = $stmt->fetchAll();
                if ($user) {
                    $failedUser = true;
                } else {
                    $pw_hash = password_hash($password, PASSWORD_DEFAULT);
                    $statement = $con->prepare("CALL CreateUser(:fullname, :email, :user, :pwdHash, :secQuestion, :secAnswer);"); // Stored Procedure to create a user.
                    if ($statement) {

                        $statement->bindParam(':fullname', $name, PDO::PARAM_STR);
                        $statement->bindParam(':email', $email, PDO::PARAM_STR);
                        $statement->bindParam(':pwdHash', $pw_hash, PDO::PARAM_STR);
                        $statement->bindParam(':user', $userRole, PDO::PARAM_STR);
                        $statement->bindParam(':secQuestion', $secQuestion, PDO::PARAM_STR);
                        $statement->bindParam(':secAnswer', $secAnswer, PDO::PARAM_STR);


                        if ($statement->execute()) {
                            $_SESSION["email"] = $email;
                            $_SESSION["role"] = "user";
                            $registerSuccess = true;
                        } else {

                            echo "\nPDO::errorInfo():\n";
                            print_r($con->errorInfo());
                        }
                    } else {
                        echo "failed preparing the insert statement! ";
                    }
                }
            } else {
                echo "failed preparing the statement! ";
            }
        }
    }
}

?>

<div class="container bg-dark">
    <?php require("elements/nav.php"); ?>
    <div class="p-5"></div>
    <h1 class="px-3">Register</h1>
    <div class="row">
        <div class="col-lg-10 col-sm-12">
            <hr class="border hr opacity-100">
        </div>
        <div class="col-lg-2 d-flex justify-content-end">
            <p class="fs-5 pb-2">Garage Gym</p>
        </div>
    </div>
    <div class="p-2"></div>
    <div class="row justify-content-center">
        <form action="register.php" method="POST" class="col-lg-10 col-md-8 col-sm-10">
            <div class="row justify-content-center">
                <div class="pt-4  col-md-5">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" class="form-control" id="email" name="email"
                           aria-describedby="emailHelp"
                           required>
                </div>
                <div class="pt-4 col-md-5">
                    <label for="name" class="form-label">Name</label>
                    <input type="name" class="form-control" id="name" name="name" aria-describedby="nameHelp"
                           required>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="pt-4 col-md-5">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password"
                           aria-describedby="passwordHelp" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                           title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters"
                           required>
                </div>
                <div class="pt-4  col-md-5">
                    <label for="passwordrepeat" class="form-label">Password Repeat</label>
                    <input type="password" class="form-control" id="passwordrepeat" name="passwordrepeat"
                           aria-describedby="repeatHelp" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                           title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters"
                           required>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="pt-4 col-md-5">
                    <label for="SecurityQuestion" class="form-label">Security Question</label>
                    <select class="form-select" aria-label="Default select example" id="SecurityQuestion"
                            name="SecurityQuestion">
                        <option disabled> Security Question</option>
                        <option>What city were you born in?</option>
                        <option>What was the make and model of your first car?</option>
                        <option>What was the first concert you attended?</option>
                        <option>In what city did your parents meet?</option>
                    </select>
                </div>
                <div class="pt-4 col-md-5">
                    <label for="SecurityAnswer" class="form-label">Security Answer</label>
                    <input type="name" class="form-control" id="SecurityAnswer" name="SecurityAnswer" required>
                </div>
            </div>
            <div class="p-2"></div>
            <div class="d-flex justify-content-center align-items-center w-100">
                <button type="submit" class="btn btn-warning">Submit</button>
            </div>
            <div class="p-3"></div>
            <p class="lead text-center fs-6">Already have an account? <a class="register-link fs-6" href="login.php">Log
                    in now!</a></p>
    </div>
    <?php
    // Different errors for the user in case of a failed register attempt.
        if (isset($failedUser)) { ?>
        <div class="p-2"></div>
        <div class="alert alert-danger">
            <?php echo "This email is already taken"; ?>
        </div>
    <?php } else if (isset($failedPasswordValidation)) { ?>
        <div class="p-2"></div>
        <div class="alert alert-danger">
            <?php echo $passwordValidationError; ?>
        </div>
    <?php } else if (isset($registerSuccess)) { ?>
        <div class="p-2"></div>
        <div class="alert alert-success">
            <?php echo "Register Success!"; ?>
        </div>
    <?php } ?>
    </form>
</div>
</div>
</div>
<?php require("elements/footer.php"); ?>
</body>
</html>