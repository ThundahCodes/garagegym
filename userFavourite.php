<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<?php
include("elements/header.php");
session_start();

include("elements/db.php");
include("elements/nav.php");

if (!isset($_SESSION["userID"])) {
    header("location:login.php");
}

$id = $_SESSION["userID"];


?>

<div class="container-fluid bg-dark p-0">
    <div class="p-5"></div>
    <div class="container">
        <h1 class="px-3">Your Orders</h1>
        <div class="row">
            <div class="col-lg-10">
                <hr class="border hr opacity-100">
            </div>
            <div class="col-lg-2">
                <p class="fs-4 my-0">Garage Gym</p>
                <p class="fs-7">"not just your regular gym"</p>
            </div>
        </div>
        <div class="p-5"></div>
        <table class="table">
            <thead>
            <tr class="table-dark">
                <th scope="col">UserID</th>
                <th scope="col">aboID</th>
                <th scope="col">FavouriteID</th>
            </tr>
            </thead>
            <?php
            $sql = "SELECT * from Favourites;";
            $stmt = $con->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_STR);

            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($result as $Favourite) {
                ?>
                <tbody>
                <tr class="table-dark">
                    <th class="table-dark" scope="row"><?php echo $Favourite["userID"]; ?></th>
                    <td class="table-dark"><?php echo $Favourite["aboID"]; ?></td>
                    <td class="table-dark"><?php echo $Favourite["FavoriteID"]; ?></td>
                </tr class="table-dark">
                </tbody>
                <?php
            } ?>
        </table>
    </div>
    <?php require("elements/footer.php"); ?>
</div>
</body>

</html>
</body>
</html>