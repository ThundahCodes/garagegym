<?php
/*
 * A check will be made to see if the user really is an admin
 * using the Session variable "role" which takes the user's role when logging in.
 */
include("elements/header.php");
session_start();
if ($_SESSION["role"] != "admin") {
    header("location:login.php");
    exit();
}

?>

<!-- Small amount of styling for when the links are hovered on. -->
<style>
    a:hover {
        color: white;
    }
</style>
<!--
 * This div container holds the links for the administrator to go into the administration pages.
 * By using paddings with the classes "p-*" the distance between the included navbar and the text is ensured.
-->
<div class="container-fluid bg-dark p-0">
    <?php include("elements/nav.php"); ?>
        <div class="container">
            <div class="row">
                <div class="p-5"></div>
                <h1 class="text-center fs-2">Admin Dashboard</h1>
                <div class="p-3"></div>
                <h1 class="text-center"><a href="orderOverview.php">Order Overview</a></h1>
                <br>
                <h1 class="text-center"><a href="planEdit.php">Edit Plans</a></h1>
                <br>
                <h1 class="text-center"><a href="aboEdit.php">Edit Subscriptions</a></h1>
                <br>
                <h1 class="text-center"><a href="userEdit.php">Edit Users</a></h1>
                <br>
                <h1 class="text-center"><a href="contactEdit.php">Manage Contacts</a></h1>
                <br>
                <h1 class="text-center"><a href="editBlog.php">Edit Blog</a></h1>
            </div>
        </div>
    <?php require("elements/footer.php"); ?>
</div>
</body>

</html>