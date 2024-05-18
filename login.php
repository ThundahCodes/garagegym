<?php
require("elements/header.php");
session_start();


/*
 *
 * If-Statement that takes the sent variables from POST and checks them with the database
 * A query with a stored procedure will be taken from the database to see all users and to check if the email exists
 * The queried user will then be checked with the sent data to prove if they are correct
 *
 */
$failPass = false;
if ((isset($_POST["password"])) && isset($_POST["email"])) {
    include_once("elements/db.php");
    $email = $_POST["email"];
    $password = $_POST["password"];
    $stmt = $con->prepare("CALL GetUsers(:email);"); // Usage of stored procedure for security reasons.
    $stmt->execute(["email" => $email]);
    $user = $stmt->fetch();

    if ($user) {
        if (password_verify($password, $user["pwdHash"])) {
            $userId = $user["ID"];
            $_SESSION["userID"] = $userId;
            $_SESSION["name"] = $user["name"];
            $_SESSION["email"] = $email;
            $_SESSION["role"] = $user['role'];
            header("location:index.php");
            exit();
        }

    } else {
        $failPass = true; // Triggers a message below that informs the user on a failed log in attempt
    }
}

?>


<style>
    .hr {
        color: white;
    }


</style>
<div class="container bg-dark">
    <?php require("elements/nav.php"); ?>
    <div class="p-5"></div>
    <h1 class="px-3">Login</h1>
    <div class="row">
        <div class="col-lg-10 col-sm-12">
            <hr class="border hr opacity-100">
        </div>
        <div class="col-lg-2 d-flex justify-content-end">
            <p class="fs-5 pb-2">Garage Gym</p>
        </div>
    </div>
    <div class="row justify-content-center">
        <form action="login.php" method="POST" class="col-lg-6 col-md-8 col-sm-10">
            <div class="p-3"></div>
            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password"
                       aria-describedby="passwordHelp" required>
            </div>
            <div class="d-flex justify-content-center">

            <button type="submit" class="btn btn-warning align-self-center">Submit</button>
            </div>
            <div class="p-3"></div>
            <p class="lead text-center fs-6">Forgot Password? <a class="register-link fs-6" href="passwordreset.php">Reset
                    now!</a></p>
        </form>
    </div>
    <?php

    if ($failPass) {

        ?>

        <div class="p-2"></div>
        <div class="alert alert-danger">
            <?php echo "Login Failed, be sure that the email or password is correct!"; ?>
        </div>

        <?php

    } ?>


</div>


<?php require("elements/footer.php");
      exit();?>
</body>
</html>