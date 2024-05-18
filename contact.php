<?php
/*
 * Mandatory importing of the header, navbar and database connection for further usage.
 */
session_start();
require("elements/header.php");
include("elements/db.php");
require("elements/nav.php");

// Variables for the display of successful or error alerts
$errorMessage = false;
$successMessage = false;
/*
 * In this "if" it will be checked if a POST request is sent.
 * If the POST is sent the   
 */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id = 0;
    $name = $_POST['name'];
    $email = $_POST['email'];
    $contactText = $_POST['contactText'];
    if (isset($_SESSION["userID"])) {
        $id = $_SESSION["userID"];
        $sql = "INSERT INTO Contact(ContactText, UserID, UserEmail) VALUES(:contactText, :uid, :email);";
        $stmt = $con->prepare($sql);
        $stmt->bindParam(":contactText", $contactText, PDO::PARAM_STR);
        $stmt->bindParam(":uid", $id, PDO::PARAM_INT);
        $stmt->bindParam(":email", $email, PDO::PARAM_STR);
        $stmt->execute();

        $successMessage = true;

    } else {
        $errorMessage = true;
    }

}

?>

<style>
    .hr {
        color: white;
    }
</style>
<div class="container">
    <div class="p-5"></div>
    <h1 class="px-3">Contact</h1>
    <div class="row">
        <div class="col-lg-10 col-sm-12">
            <hr class="border hr opacity-100">
        </div>
        <div class="col-lg-2 d-flex justify-content-end">
            <p class="fs-5 pb-2">Garage Gym</p>
        </div>
    </div>
    <div class="row pt-4">
        <div class="col-md-6 offset-md-3">
            <form action="contact.php" method="post">
                <div class="mb-4">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Name" required>
                </div>
                <div class="mb-4">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Email"
                           required>
                </div>
                <div class="mb-4">
                    <label for="contactText" class="form-label">Contact Text</label>
                    <textarea class="form-control" id="contactText" name="contactText"
                              placeholder="Contact Text"
                              required></textarea>
                </div>
                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn btn-warning">Submit</button>
                </div>

                <?php
                if ($errorMessage) {


                    ?>

                    <div class="p-2"></div>
                    <div class="alert alert-danger">
                        <?php echo "The message has not been sent!"; ?>
                    </div>


                    <?php
                } else if ($successMessage) {
                    ?>
                        <div class="p-2"></div>
                    <div class="alert alert-info" role="alert">
                        The message has been sent
                    </div>
                <?php
                }
                ?>
            </form>
        </div>
    </div>
</div>
<?php require("elements/footer.php"); ?>

</body>
</html>