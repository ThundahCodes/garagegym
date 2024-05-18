<?php
/*
 * Here the role of the user will be checked if they are a trainer or an admin.
 * If they are not the user will be redirected to the login page.
 */
require("elements/header.php");
session_start();

if ($_SESSION["role"] != "trainer" && $_SESSION["role"] != "admin") {
    header("location:login.php");
    exit();
}



require("elements/db.php");

/*
 * A POST variable will be sent from a button which is linked to a form, the id of the item that should be deleted is in this variable
 * A prepared statement will be called to delete the subscription with the corresponding id.
 */
if (isset($_POST["toDel"])) {
    $id = $_POST["toDel"];
    $stmt = $con->prepare("DELETE FROM Abos WHERE AboID = :id");
    $stmt->execute(["id" => $id]);
}
    



?>


<?php
/*
 * In this "if" a check will conclude if the POST variables for the editing of existing subscriptions are given,
 * if they are given, a SQL Statement (UPDATE) will be called.
 */
if (isset($_POST["nameEdit"]) && isset($_POST["descEdit"]) && isset($_POST["priceEdit"]) && isset($_POST["id"])) {

    $innerID = $_POST["id"];
    $innerName = $_POST["nameEdit"];
    $innerDescription = $_POST["descEdit"];
    $innerPrice = $_POST["priceEdit"];

    // Code that gets an image from the user and adds it to the webserver, this filepath will then also be saved in the database so it can always be called
    $filepath = null;
    if (is_uploaded_file($_FILES['fileEdit']["tmp_name"])) {
        $target_dir = "elements/img/";
        $tmp_file = $_FILES['fileEdit']["tmp_name"];
        $filepath = $target_dir . $_FILES["fileEdit"]["name"];
        $imageFileType = strtolower(pathinfo($tmp_file, PATHINFO_EXTENSION));
        $check = getimagesize($_FILES["fileEdit"]["tmp_name"]);
        $uploadOk = 1;
        if ($check !== false) {
            move_uploaded_file($tmp_file, $filepath);
            $uploadOk = 1;
            $filepath = $filepath;
        } else {
            echo "<br> File is not an image. <br>";
            $uploadOk = 0;
        }
    } else {
        echo "<br> empty image <br>";
    }

    $sql2 = "UPDATE Abos SET Aboname = :name, Abodescription = :description, Aboprice = :price, filePath = :filePath WHERE AboID = :id;";
    $statement = $con->prepare($sql2);
    $statement->execute(["name" => $innerName, "description" => $innerDescription, "price" => $innerPrice, "id" => $innerID, "filePath" => $filepath]);

}
/*
 * In this "if" a check will conclude if the POST variables for the addition/creation of a new subscription are given,
 * if they are given, a SQL Stored Procedure will be called.
 */
if (isset($_POST["nameAdd"]) && isset($_POST["descAdd"]) && isset($_POST["priceAdd"])) {
    $nameAdd = $_POST["nameAdd"];
    $descAdd = $_POST["descAdd"];
    $priceAdd = $_POST["priceAdd"];

    // Code that gets an image from the user and adds it to the webserver, this filepath will then also be saved in the database so it can always be called.
    $filepath = null;
    if (is_uploaded_file($_FILES['fileAdd']["tmp_name"])) {
        $target_dir = "elements/img/";
        $tmp_file = $_FILES['fileAdd']["tmp_name"];
        $filepath = $target_dir . $_FILES["fileAdd"]["name"];
        $imageFileType = strtolower(pathinfo($tmp_file, PATHINFO_EXTENSION));
        $check = getimagesize($_FILES["fileAdd"]["tmp_name"]);
        $uploadOk = 1;
        if ($check !== false) {
            move_uploaded_file($tmp_file, $filepath);
            $uploadOk = 1;
            $filepath = $filepath;
        } else {
            echo "<br> File is not an image. <br>";
            $uploadOk = 0;
        }
    } else {
        echo "<br> empty image <br>";
    }
    // A stored procedure will be used here to ensure the safety of the database by not showing the real statement.
    $sql1 = "CALL CreateSubscription(:name, :price, :description, :filePath);";
    $statement = $con->prepare($sql1);
    $statement->bindParam(":name", $nameAdd, PDO::PARAM_STR);
    $statement->bindParam(":price", $priceAdd, PDO::PARAM_STR);
    $statement->bindParam(":description", $descAdd, PDO::PARAM_STR);
    $statement->bindParam(":filePath", $filepath, PDO::PARAM_STR);
    $statement->execute();
}
?>

<?php

/**
 * Creates a Modal for the editing of an existing subscription.
 * The modal is filled with the existing data and asks for the new data with the help of a form.
 * @param $id int ID of the subscription
 * @param $name String Title of the subscription
 * @param $description String Description of the subscription
 * @param $price Double The price of the subscription
 * ClassicEditor ist ein WYSIWYG Editor for the simple creation of better formatted texts. A library was imported and installed in the server with the name "ckeditor"
 */
function createProductModal($id, $name, $description, $price)
{

    ?>
    <div class="modal fade modal-lg" id="editAboModal<?php echo $id ?>" tabindex="-1"> <?php "\n" ?>
        <div class="modal-dialog"><?php "\n" ?>
            <div class="modal-content text-center">
                <div class="modal-header text-center">
                    <h1 class="modal-title fs-5 text-center" style="color: Black;" id="editAboModal<?php echo $id ?>">Modal for <?php echo $name ?> with the ID : <?php echo $id ?></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
                </div>
                <div class="modal-body">
                    <form action="aboEdit.php" method="POST" enctype="multipart/form-data"><?php "\n" ?>
                        <div class="container" style="color: black !important;"> <?php "\n" ?>
                            <label for="nameEdit" class="form-label" style="color: Black;">What do you want to change the name into: </label> <?php "\n" ?>
                            <input type="text" class="form-control" id="nameEdit" name="nameEdit"  value="<?php echo $name; ?>" require> <?php "\n" ?>
                            <label for="descEdit" class="form-label" style="color: Black;"></label> <?php "\n" ?>
                            <textarea name="descEdit" id="descEdit" cols="30" rows="10" style="color: Black !important;">&lt;h3&gt;<?php echo $description ?>  &lt;/h3&gt;</textarea>
                            <script type="text/javascript">
                                ClassicEditor
                                    .create(document.querySelector('#descEdit'));
                            </script>
                            <label for="priceEdit" class="form-label" style="color: Black;">What do you want to change the price into: </label> <?php "\n" ?>
                            <input type="text" class="form-control" id="priceEdit" name="priceEdit" value="<?php echo $price; ?>" require> <?php "\n" ?>
                            <label for="fileEdit" class=>Upload the image :</label>
                            <input type="file" class="form-control" name="fileEdit" id="fileEdit">
                        </div> <?php "\n" ?>
                        <div class="p-2"></div> <?php "\n" ?>
                        <input type="hidden" id="id" name="id" value="<?php echo $id ?>"> <?php "\n" ?>
                        <button type="submit" class="btn btn-primary">Update</button> <?php "\n" ?>
                    </form>
                </div>
            </div> <?php "\n" ?>
        </div> <?php "\n" ?>
    </div> <?php "\n" ?>

    <?php
}
?>

<?php
require("elements/nav.php");

?>

<div class="container-fluid">
    <div class="p-5"></div>
    <table class="table align-middle">
        <thead>
        <tr class="table-dark ">
            <th scope="col">Name</th>
            <th scope="col">Description</th>
            <th scope="col">Price</th>
            <th scope="col">Type</th>
            <th scope="col">&nbsp;</th>
            <th scope="col">&nbsp;</th>
        </tr>
        </thead>
        <?php
        /*
         * With a SQL Select-Statement all the columns of the subscriptions (Abos) table will be selected.
         * These variables will be saved into "$result" and then iterated through a foreach.
         * The iterated variables will be given as parameters into the createProductModal and also will be used
         * to be shown in a bootstrap table.
         */
        $sql = "SELECT * FROM Abos;";
        $stmt = $con->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $product) {
            createProductModal($product["AboID"], $product["Aboname"], $product["Abodescription"], $product["Aboprice"], $product["filePath"]);

            ?>
            <tbody>
            <tr class="table-dark">
                <td class="table-dark"><?php echo $product["Aboname"]; ?></td>
                <td class="table-dark"><?php echo $product["Abodescription"]; ?></td>
                <td class="table-dark"><?php echo $product["Aboprice"]; ?></td>
                <td class="table-dark"><button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#editAboModal<?php echo $product["AboID"]; ?>">Editieren</button></td>
                <form action="aboEdit.php" method="POST">
                    <td class="table-dark">
                            <button type="submit" class="btn btn-danger mb-3" name="toDel" value="<?php echo $product["AboID"]; ?>">Delete</button>
                       </td>
                </form>
            </tr>
            </tbody>
        <?php } ?>

    </table>
    <div class="row">
        <div class="col-md-11"></div>
        <div class="col-md-1">
            <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addAboModal">Add</button>
        </div>
    </div>
</div>
<!--
 * This is a modal that will be called by the "Add" button.
 * This modal has a form which holds the fields for the addition of a new subscription, such as
 * those that require the name, description, price and filepath. The ID will be auto incremented from the database, hence it should not be given.
 * ClassicEditor ist ein WYSIWYG Editor for the simple creation of better formatted texts. A library was imported and installed in the server with the name "ckeditor"
-->
<div class="modal fade modal-lg" id="addAboModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel" style="color: Black;">Add a Sub</h1>
            </div>
            <div class="modal-body">
                <form action="aboEdit.php" method="POST" enctype="multipart/form-data">
                    <div class="container" style="color: black !important;"> <?php "\n" ?>
                        <label for="nameAdd" class="form-label" style="color: Black;">Whats the name of the subscription </label> <?php "\n" ?>
                        <input type="text" class="form-control" id="nameAdd" name="nameAdd" require> <?php "\n" ?>
                        <label for="descAdd" class="form-label" style="color: Black;"></label> <?php "\n" ?>
                        <textarea name="descAdd" id="descAdd" cols="30" rows="10" style="color: Black !important;">&lt;h3&gt;Whats the description of the plan&lt;/h3&gt;</textarea>
                        <script type="text/javascript">
                            ClassicEditor
                                .create(document.querySelector('#descAdd'));
                        </script>
                        <label for="priceAdd" class="form-label" style="color: Black;">Whats the price of the subscription </label> <?php "\n" ?>
                        <input type="text" class="form-control" id="priceAdd" name="priceAdd" require> <?php "\n" ?>
                        <label for="fileAdd" class=>Upload the image :</label>
                        <input type="file" class="form-control" name="fileAdd" id="fileAdd">
                        <div class="p-2"></div>
                        <button type="submit" class="btn btn-primary">Add</button> <?php "\n" ?>
                    </div> <?php "\n" ?>
                </form>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>

</body>

</html>