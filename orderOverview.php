<?php
session_start();
include("elements/header.php");

if ($_SESSION["role"] != "trainer" && $_SESSION["role"] != "admin") {
    header("location:login.php");
    exit();
}
include_once("elements/db.php");

if (isset($_POST["toPaid"])) {
    $id = $_POST["toPaid"];
    $stmt = $con->prepare("UPDATE Orders SET isPaid = 1 where OrderID = :id");
    $stmt->execute(["id" => $id]);
}
else if (isset($_POST["toUnpaid"])) {
    $id = $_POST["toUnpaid"];
    $stmt = $con->prepare("UPDATE Orders SET isPaid = 0 where OrderID = :id");
    $stmt->execute(["id" => $id]);
}
if (isset($_POST["toDel"])) {
    $id = $_POST["toDel"];
    $stmt = $con->prepare("DELETE FROM Orders WHERE OrderID = :id");
    $stmt->execute(["id" => $id]);
}
    require("elements/nav.php");
    ?>
<div class="p-5"></div>
<div class="container-fluid">
    <table class="table">
        <thead>
        <tr class="table-dark">
            <th scope="col">OrderID</th>
            <th scope="col">Date</th>
            <th scope="col">Username</th>
            <th scope="col">Email</th>
            <th scope="col">PlanID</th>
            <th scope="col">UserID</th>
            <th scope="col">isPaid</th>
            <th scope="col">&nbsp</th>
            <th scope="col">&nbsp</th>

        </tr>
        </thead>
        <?php
        $sql = "SELECT o.*, u.name as Username, u.email as Email FROM Orders o join Users u on o.UserID = u.ID ;";
        $stmt = $con->prepare($sql);
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
                <td class="table-dark"><?php echo $product["PlanID"]; ?></td>
                <td class="table-dark"><?php echo $product["UserID"]; ?></td>
                <td class="table-dark"><?php echo $product["isPaid"]; ?></td>

                <form action="orderOverview.php" method="POST">
                    <?php

                    if ($product["isPaid"] == 0) {



                    ?>
                    <td class="table-dark">
                            <button type="submit" class="btn btn-primary" name="toPaid"
                                    value="<?php echo $product["OrderID"]; ?>">Set to paid
                            </button>
                        </td>

                    <?php } else { ?>

                        <td class="table-dark">
                                <button type="submit" class="btn btn-primary" name="toUnpaid"
                                        value="<?php echo $product["OrderID"]; ?>">Set to unpaid
                                </button>
                            </td>

                    <?php } ?>
                    <td class="table-dark">
                            <button type="submit" class="btn btn-danger" name="toDel"
                                    value="<?php echo $product["OrderID"]; ?>">Delete
                            </button>
                        </td>
                </form>

            </tr class="table-dark">
            </tbody>
            <?php
        } ?>


    </table>
</div>
</body>
</html>