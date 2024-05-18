<?php
session_start();
include("elements/header.php");
/*
 * Here the role of the user will be checked if they are an admin.
 * If they are not the user will be redirected to the login page.
 */
if ($_SESSION["role"] != "admin") {
    header("location:login.php");
    exit();
}
include_once("elements/db.php");
/*
 * A POST variable will be sent from a button which is linked to a form, the id of the item that should be deleted is located in this variable.
 * A prepared statement will be called to delete the contact with the corresponding id.
 */
if (isset($_POST["toDel"])) {
    $id = $_POST["toDel"];
    $stmt = $con->prepare("DELETE FROM Contact WHERE ContactID = :id");
    $stmt->execute(["id" => $id]);
}

?>


<?php require("elements/nav.php"); ?>
<div class="p-5"></div>
<div class="container-fluid">
    <table class="table">
        <thead>
        <tr class="table-dark">
            <th scope="col">Description</th>
            <th scope="col">User ID</th>
            <th scope="col">Email</th>
            <th scope="col">Contact ID</th>
            <th scope="col">&nbsp;</th>
        </tr>
        </thead>
        <?php
        /*
         * With a SQL Select-Statement all the columns of the contact table will be selected.
         * These variables will be saved into "$result" and then iterated through a foreach.
         * The iterated variables will be shown in a bootstrap table.
         */
        $sql = "SELECT * FROM Contact;";
        $stmt = $con->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $product) {
            ?>
            <tbody>
            <tr class="table-dark">
                <th class="table-dark" scope="row"><?php echo $product["ContactText"]; ?></th>
                <td class="table-dark"><?php echo $product["UserID"]; ?></td>
                <td class="table-dark"><?php echo $product["UserEmail"]; ?></td>
                <td class="table-dark"><?php echo $product["ContactID"]; ?></td>
                <form action="contactEdit.php" method="POST">
                    <td class="table-dark">
                            <button type="submit" class="btn btn-danger" name="toDel"
                                    value="<?php echo $product["ContactID"]; ?>">Delete/Erledigt
                            </button>
                        </td>
                </form>
            </tr class="table-dark">
            </tbody>
            <?php
        } ?>


    </table>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa"
        crossorigin="anonymous"></script>

</body>

</html>