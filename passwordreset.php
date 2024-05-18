<?php
session_start();

require("elements/header.php");

$failedUser = false;

if (isset($_POST["email"])) {

    include_once("elements/db.php");

    $email = $_POST["email"];

    $stmt = $con->prepare("SELECT * FROM Users WHERE email = :email;");
    if ($stmt) {
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetchAll();
        if ($user) {

            $_SESSION["recoverEmail"] = $_POST["email"];
            header("location:resetForm.php");

        } else {
            $failedUser = true;
        }
    }

}

?>


    <div class="container bg-dark">
        <?php require("elements/nav.php"); ?>


        <div class="container">
            <div class="p-5"></div>
            <h1 class="px-3">Reset Password</h1>
            <div class="row">
                <div class="col-lg-10 col-sm-12">
                    <hr class="border hr opacity-100">
                </div>
                <div class="col-lg-2 d-flex justify-content-end">
                    <p class="fs-5 pb-2">Garage Gym</p>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <form action="passwordreset.php" method="POST" class="col-lg-6 col-md-8 col-sm-12">
                <div class="p-3"></div>
                <div class="mb-3">
                    <label for="email" class="form-label">Enter the email to recover your password : </label>
                    <input type="email" class="form-control" id="email" name="email"
                           aria-describedby="emailHelp" required>
                </div>
                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn btn-warning align-self-center">Submit</button>
                </div>
            </form>

            <?php

            if ($failedUser) {
                ?>
                <div class="p-2"></div>
                <div class="container">
                    <div class="alert alert-danger my-2">
                        <?php echo "This email does not exist"; ?>
                    </div>
                </div>
                <?php
            }

            $failedUser = false;
            ?>
        </div>
    </div>

    </div>

<?php require("elements/footer.php"); ?>