<?php
session_start();
include("elements/header.php");
/*
 * An authorisation check will be made, to see if the user is authorised to come into this page. The session variable role, is set on the log in page and
 *  that will be controlled.
 */
if ($_SESSION["role"] != "admin") {
    header("location:login.php");
    exit();
}
include_once("elements/db.php");


/*
 * If-Statement that takes the ID of a variable from a Form. The ID will then be converted in a MySQL query, to delete the user.
 */
if (isset($_POST["toDel"])) {
    $id = $_POST["toDel"];
    $stmt = $con->prepare("DELETE FROM Users WHERE id = :id");
    $stmt->execute(["id" => $id]);
}
require("elements/nav.php");

?>

<?php
/*
 * In this if-statement there will be a check done if all data required for the update of a user have been sent.
 * This data will be done with isset() which checks if the variable is sent from a POST form.
 * Then the data will be converted into variables and pushed into an UPDATE statement where the user data will be updated.
 */
if (isset($_POST["emailEdit"]) && isset($_POST["id"]) && isset($_POST["fullNameEdit"]) && isset($_POST["roleEdit"])) {

    $id = $_POST["id"];
    $email = $_POST["emailEdit"];
    $name = $_POST["fullNameEdit"];
    $role = $_POST["roleEdit"];


    $sql = "UPDATE Users SET name = :fullName, email = :email, role = :role WHERE id = :id";
    $statement = $con->prepare($sql);
    $statement->execute(["fullName" => $name, "email" => $email, "role" => $role, "id" => $id]);

}

?>

<?php
/*
 * In this if-statement there will be a check done if all data required for the addition of a user have been sent.
 * This data will be done with isset() which checks if the variable is sent from a POST form.
 * Then the data will be converted into variables and pushed into an INSERT INTO statement where the user data will be created.
 */
if (isset($_POST["emailAdd"]) && (isset($_POST["passwordAdd"])) && (isset($_POST["passwordrequire"])) && (isset($_POST["nameAdd"])) && (isset($_POST["roleAdd"]))) {


    function sanitizeInput($data) // Function for the input validation of data
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $email = sanitizeInput($_POST["emailAdd"]);
    $password = sanitizeInput($_POST["passwordAdd"]);
    $passwordrequire = sanitizeInput($_POST["passwordrequire"]);
    $fullname = sanitizeInput($_POST["nameAdd"]);
    $role = $_POST["roleAdd"];


    if ($password != $passwordrequire) {
        $failedPassword = true;
    } else {
        include_once("elements/db.php");
        $stmt = $con->prepare("CALL GetUsers(:email);");
        $stmt->execute(["email" => $email]);
        $user = $stmt->fetch();
        // Check is user already exists
        if ($user) {
            $failedUser = true;
        } else {
            // Add new user
            $pw_hash = password_hash($password, PASSWORD_DEFAULT);
            $statement = $con->prepare("INSERT INTO Users (name, email, role, pwdHash) VALUES (:fullname, :email, :role, :password);");
            $statement->bindParam(":fullname", $fullname, PDO::PARAM_STR);
            $statement->bindParam(":email", $email, PDO::PARAM_STR);
            $statement->bindParam(":role", $role, PDO::PARAM_STR);
            $statement->bindParam(":password", $pw_hash, PDO::PARAM_STR);
            $statement->execute();
            header("location:userEdit.php"); //php redirect
        }
    }
}

?>


<?php
/**
 * Creates a Modal for the editing of an existing user.
 * The modal is filled with the existing data and asks for the new data with the help of a form.
 * @param $id int ID of the user
 * @param $name String Full name of the user
 * @param $email String Email of the user
 * @param $role String Role of the user
 */
function createUserModal($id, $name, $email, $role)
{
    ?>


    <div class="modal fade modal-lg" id="userEditModal<?php echo $id; ?>" tabindex="-1" style="color: black !important;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Edit user with the id : <?php echo $id; ?> </h1>
                </div>
                <div class="modal-body">
                    <form action="userEdit.php" method="POST">
                        <div class="container"> <?php "\n" ?>
                            <div class="row">
                                <div class="col-md-6">

                                    <label for="fullNameEdit" class="form-label"
                                           style="color: black;">Name</label> <?php "\n" ?>
                                    <input type="text" class="form-control" id="fullNameEdit" name="fullNameEdit"
                                           value=<?php echo $name; ?>  require> <?php "\n" ?>
                                </div>
                                <div class="col-md-6">
                                    <label for="emailEdit" class="form-label"
                                           style="color: black;">Email</label> <?php "\n" ?>
                                    <input type="text" class="form-control" id="emailEdit" name="emailEdit"
                                           value=<?php echo $email; ?>  require> <?php "\n" ?>
                                </div>
                            </div>
                            <div class="p-1"></div>
                            <label for="roleEdit" class="form-label" style="color: black;">Role</label>
                            <select class="form-select" aria-label="Default select example" id="roleEdit"
                                    name="roleEdit" require>
                                <option selected value=<?php echo $role; ?>>Choose a role</option>
                                <option value="admin">Admin</option>
                                <option value="user">User</option>
                                <option value="trainer">trainer</option>
                            </select>
                            <div class="p-2"></div>
                            <input type="hidden" id="id" name="id" value="<?php echo $id ?>"> <?php "\n" ?>
                            <button type="submit" class="btn btn-primary">Update</button> <?php "\n" ?>
                        </div> <?php "\n" ?>
                    </form>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>

    <?php

}

?>

<div class="container-fluid">
    <div class="p-5"></div>
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                <tr class="table-dark">
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Role</th>
                    <th scope="col">ID</th>
                    <th scope="col">&nbsp;</th>
                    <th scope="col">&nbsp;</th>
                </tr>
                </thead>
                <?php
                /*
                 * With a SQL Select-Statement all the columns of the user table will be selected.
                 * These variables will be saved into "$result" and then iterated through a foreach.
                 * The iterated variables will be given as parameters into the createUserModal and also will be used
                 * to be shown in a bootstrap table.
                 */
                $sql = "SELECT * FROM Users order by ID;";
                $stmt = $con->prepare($sql);
                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach ($result as $product) {
                    createUserModal($product["ID"], $product["name"], $product["email"], $product["role"]);
                    ?>
                    <tbody>
                    <tr class="table-dark">
                        <th class="table-dark"><?php echo $product["name"]; ?></th>
                        <td class="table-dark"><?php echo $product["email"]; ?></td>
                        <td class="table-dark"><?php echo $product["role"]; ?></td>
                        <td class="table-dark"><?php echo $product["ID"]; ?></td>
                        <td class="table-dark">
                            <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal"
                                    data-bs-target="#userEditModal<?php echo $product["ID"]; ?>">Edit
                            </button>
                        </td>
                        <form action="userEdit.php" method="POST">
                            <td class="table-dark">
                                <button type="submit" class="btn btn-danger mb-3" name="toDel"
                                        value="<?php echo $product["ID"]; ?>">Delete
                                </button>
                            </td>
                        </form>
                    </tr class="table-dark">
                    </tbody>
                    <?php
                } ?>


            </table>
        </div>
    <div class="row">
        <div class="col-lg-11 col-md-10"></div>
        <div class="col-lg-1 col-md-2">
            <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addUserModal">Add a User
            </button>
        </div>
    </div>
</div>

<div class="modal fade modal-lg" id="addUserModal" tabindex="-1" style="color:#000 !important;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel" style="color: Black;">Add a User</h1>
            </div>
            <div class="modal-body">
                <form action="userEdit.php" method="POST">
                    <div class="p-3"></div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="nameAdd" class="form-label" style="color: black;">Name</label>
                                <input type="text" class="form-control" id="nameAdd" name="nameAdd" require>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="emailAdd" class="form-label" style="color: black;">Email address</label>
                                <input type="email" class="form-control" id="emailAdd" name="emailAdd"
                                       aria-describedby="emailHelp" require>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="passwordAdd" class="form-label" style="color: black;">Password</label>
                                <input type="password" class="form-control" id="passwordAdd" name="passwordAdd" require>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="passwordrequire" class="form-label" style="color: black;">Password
                                    Repeat</label>
                                <input type="password" class="form-control" id="passwordrequire" name="passwordrequire"
                                       require>
                            </div>
                        </div>
                    </div>
                    <div class="p-1"></div>
                    <label for="roleAdd" class="form-label" style="color: black;">Role</label>
                    <select class="form-select" aria-label="Default select example" id="roleAdd"
                            name="roleAdd" require>
                        <option selected>Choose a role</option>
                        <option value="admin">Admin</option>
                        <option value="user">User</option>
                        <option value="user">Trainer</option>
                    </select>
                    <div class="p-3"></div>
                    <div class="container-fluid">
                        <div class="row justify-content-center">
                            <button type="submit" class="btn btn-primary align-self-center">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa"
        crossorigin="anonymous"></script>

</body>

</html>