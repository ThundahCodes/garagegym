<?php
include("elements/header.php");
session_start();
if ($_SESSION["role"] != "trainer" && $_SESSION["role"] != "admin") {
    header("location:login.php");
    exit();
}

?>

<style>
    a:hover {
        color: white;
    }
</style>

<div class="container-fluid bg-dark p-0">
    <?php include("elements/nav.php"); ?>
        <div class="container">
            <div class="row">
                <div class="p-5"></div>
                <h1 class="text-center fs-2">Trainer Dashboard</h1>
                <div class="p-3"></div>
                <h1 class="text-center"><a href="orderOverview.php">Order Overview</a></h1>
                <br>
                <h1 class="text-center"><a href="planEdit.php">Edit Plans</a></h1>
                <br>
                <h1 class="text-center"><a href="aboEdit.php">Edit Subscriptions</a></h1>
                <br>
                <h1 class="text-center"><a href="editBlog.php">Edit Blog</a></h1>
            </div>
        </div>
    <?php require("elements/footer.php"); ?>
</div>
</body>

</html>