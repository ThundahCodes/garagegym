<?php
session_start();
include_once("elements/header.php");
if (!isset($_SESSION['email'])) {
    header("location:login.php");
    exit();
} else {
    include_once("elements/nav.php");
    include("elements/db.php");
    $currentEmail = "";
    $currentName = "";
    $currentPassword = "";
    $passwordVerify = "";
    $userID = $_SESSION['userID'];

    // Fetch the current user's data from the database
    $query = "SELECT name, email, pwdHash FROM Users WHERE id = :uid";
    $stmt = $con->prepare($query);
    $stmt->bindParam(":uid", $userID, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetchAll();
    foreach ($result as $row) {
        $currentName = $row['name'];
        $currentEmail = $row['email'];
        $currentPassword = "********";
        $passwordVerify = $row['pwdHash'];
    }
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $newName = $_POST["new_name"];
        $newEmail = $_POST["new_email"];
        $newPassword = $_POST["new_password"];
        $currentPassword = $_POST["current_password"];

        if (password_verify($currentPassword, $passwordVerify)) {
            $updateQuery = "UPDATE Users SET name = :newName, email = :newEmail, pwdHash = :newPassword WHERE ID = :uid";
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            $updateStmt = $con->prepare($updateQuery);
            $updateStmt->bindParam(":uid", $userID, PDO::PARAM_INT);
            $updateStmt->bindParam(":newName", $newName, PDO::PARAM_STR);
            $updateStmt->bindParam(":newEmail", $newEmail, PDO::PARAM_STR);
            $updateStmt->bindParam(":newPassword", $hashedPassword, PDO::PARAM_STR);
            if ($updateStmt->execute()) {
                $currentName = $newName;
                $currentEmail = $newEmail;
            } else {

            }
        } else {
            echo "Password incorrect";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Profile</title>
</head>
<body>
<div class="p-4"></div>
<div class="container">
    <h1 class="text-center mt-5">Edit Profile</h1>
    <form method="post" action="editProfile.php">
        <div class="mb-3">
            <label for="new_name" class="form-label">Name:</label>
            <input type="text" id="new_name" name="new_name" value="<?php echo $currentName; ?>" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="new_email" class="form-label">Email:</label>
            <input type="email" id="new_email" name="new_email" value="<?php echo $currentEmail; ?>" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="new_password" class="form-label">New Password:</label>
            <input type="password" id="new_password" name="new_password" placeholder="Enter new password" class="form-control">
        </div>
        <div class="mb-3">
            <label for="current_password" class="form-label">Current Password:</label>
            <input type="password" id="current_password" name="current_password" placeholder="Enter your old password" class="form-control">
        </div>
        <button type="submit" class="btn btn-warning">Save Changes</button>
    </form>
    <div class="p-3"></div>
    <p class="lead text-center"> Want to watch your orders? <a href="userOrders.php"> Click here! </a></p>
    <p class="lead text-center"> Want to watch your favourite orders? <a href="userFavourite.php"> Click here! </a></p>

</div>
<?php
include_once("elements/footer.php");
?>
</body>
</html>
