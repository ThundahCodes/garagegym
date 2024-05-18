<?php
include("elements/header.php");
session_start();

include("elements/db.php");
include("elements/nav.php");

// Authentification to check if the user is logged in or not. If not the user shall be sent back to the login page, since he/she should not have access to this site
if (!isset($_SESSION["userID"])) {
    header("location:login.php");
}

$id = $_SESSION["userID"]; // Collection of the ID of a logged on user


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
            <th scope="col">OrderID</th>
            <th scope="col">Date</th>
            <th scope="col">Username</th>
            <th scope="col">Email</th>
            <th scope="col">Plan Name</th>
        </tr>
        </thead>
        <?php
        /*
         * A joined SQL Statement which takes the user data in correspondence to the orders and the plans that they have ordered.
         * All the data will then be displayed in a table with the help of a foreach loop that iterates through all the values in $result
         * $result fetches the values from the statement
         */
        $sql = "SELECT o.*, p.* ,u.name as Username, u.email as Email FROM Orders o join Users u on o.UserID = u.ID join Plane p on o.PlanID = p.PlanID WHERE u.ID = :id;";
        $stmt = $con->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_STR);

        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $product) {
            ?>
            <tbody>
            <tr class="table-dark">
                <th class="table-dark" scope="row"><?php echo $product["OrderID"]; ?></th>
                <td class="table-dark"><?php echo $product["Orderdate"]; ?></td>
                <td class="table-dark"><?php echo $product["Username"]; ?></td>
                <td class="table-dark"><?php echo $product["Email"]; ?></td>
                <td class="table-dark"><?php echo $product["Planname"]; ?></td>
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