<?php
session_start();
include("elements/db.php");
$email = "admin@gmail.com";
$name = 'testname12';
$password = "asdf";
$passwordrepeat = "asdf";
$userRole = "user";

$statement = $con->prepare("INSERT INTO Users (name, email, role, pwdHash) VALUES (:fullname, :email, :user, :pwdHash);");
$statement->bindParam(':fullname', $email, PDO::PARAM_STR);
$statement->bindParam(':email', $name, PDO::PARAM_STR);
$statement->bindParam(':pwdHash', $password, PDO::PARAM_STR);
$statement->bindParam(':user', $userRole, PDO::PARAM_STR);
$statement->execute();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Garage Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
</head>

<body>

    <?php

    ?>


    <div class="container-fluid">
        <main class="my-3">

            <div class="p-2"></div>
            <h1 class="text-center">Jetzt Registrieren</h1>
            <div class="p-3"></div>
            <form action="registertest.php" method="POST">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email address</label>
                            <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" require>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="name" class="form-control" id="name" name="name" aria-describedby="nameHelp" require>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" aria-describedby="passwordHelp" require>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label for="passwordrepeat" class="form-label">Password Repeat</label>
                            <input type="password" class="form-control" id="passwordrepeat" name="passwordrepeat" aria-describedby="repeatHelp" require>
                        </div>
                    </div>
                </div>
                <div class="p-3"></div>
                <div class="container-fluid">
                    <div class="row justify-content-center">
                        <button type="submit" class="btn btn-warning align-self-center">Submit</button>
                    </div>
                </div>
            </form>
    </div>


    <?php
    //Userfeedback
    if (isset($failedPassword)) {
        echo "<p>Passwords must be equal!</p>";
    }
    if (isset($failedUser)) {
        echo "<p>Username is already used! Please choose a different one!</p>";
    }
    ?>


    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>

</body>

</html>