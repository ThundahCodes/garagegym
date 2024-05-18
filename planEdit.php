<?php
require("elements/header.php");
/*
 * Here the role of the user will be checked if they are a trainer or an admin.
 * If they are not the user will be redirected to the login page.
 */
session_start();

$failDelete = "";


if ($_SESSION["role"] != "admin" && $_SESSION["role"] != "trainer") {
    header("location:login.php");
    exit();
}


require("elements/nav.php");

require("elements/db.php");

/*
 * A POST variable will be sent from a button which is linked to a form, the id of the item that should be deleted is in this variable
 * A prepared statement will be called to delete the plan with the corresponding id.
 * A $failDelete is here because there might be a connection in the database with foreign keys which does not allow it.
 * When this is true, an alert will be called to show that the plan cannot be deleted because of said error.
 */
if (isset($_POST["toDel"])) {
    $id = $_POST["toDel"];
    $stmt = $con->prepare("DELETE FROM Plane WHERE PlanID = :id");
    if ($stmt->execute()) {
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    } else {
        $failDelete = true;
    }
}
/*
 * In this "if" a check will conclude if the POST variables for the editing of existing subscriptions are given,
 * if they are given, a SQL Statement (UPDATE) will be called.
 */
if (isset($_POST["nameEdit"]) && isset($_POST["descEdit"]) && isset($_POST["priceEdit"]) && isset($_POST["typeEdit"]) && isset($_POST["id"])) {

    $innerID = $_POST["id"];
    $innerName = $_POST["nameEdit"];
    $innerDescription = $_POST["descEdit"];
    $innerPrice = $_POST["priceEdit"];
    $innerType = $_POST["typeEdit"];

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


    $sql2 = "UPDATE Plane SET Planname = :name, Plandescription = :description, Planprice = :price, Plantyp = :type, filePath = :filePath WHERE PlanID = :id;";
    $statement = $con->prepare($sql2);
    $statement->execute(["name" => $innerName, "description" => $innerDescription, "price" => $innerPrice, "type" => $innerType, "id" => $innerID, "filePath" => $filepath]);

}
/*
 * In this "if" a check will conclude if the POST variables for the addition/creation of a new subscription are given,
 * if they are given, a SQL Stored Procedure will be called.
 */
if (isset($_POST["nameAdd"]) && isset($_POST["descAdd"]) && isset($_POST["priceAdd"]) && isset($_POST["typeAdd"])) {
    $nameAdd = $_POST["nameAdd"];
    $descAdd = $_POST["descAdd"];
    $priceAdd = $_POST["priceAdd"];
    $typeAdd = $_POST["typeAdd"];

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
    $sql1 = "INSERT INTO Plane(Planname, Plandescription, Planprice, Plantyp, filePath) VALUES(:name, :description, :price, :type, :filePath);";
    $statement = $con->prepare($sql1);
    $statement->bindParam(":name", $nameAdd, PDO::PARAM_STR);
    $statement->bindParam(":description", $descAdd, PDO::PARAM_STR);
    $statement->bindParam(":price", $priceAdd, PDO::PARAM_STR);
    $statement->bindParam(":type", $typeAdd, PDO::PARAM_STR);
    $statement->bindParam(":filePath", $filepath, PDO::PARAM_STR);
    $statement->execute();
}

/**
 * Creates a Modal for the editing of an existing plan.
 * The modal is filled with the existing data and asks for the new data with the help of a form.
 * @param $id int ID of the plan
 * @param $name String Title of the plan
 * @param $description String Description of the plan
 * @param $price Double The price of the plan
 * @param $typ String The type of the plan (can be training or nourishment)
 * @param $filepath String The path of the image
 * ClassicEditor ist ein WYSIWYG Editor for the simple creation of better formatted texts. A library was imported and installed in the server with the name "ckeditor"
 */
function createProductModal($id, $name, $description, $price, $typ, $filepath)
{

    ?>
    <div class="modal fade modal-lg" id="editPlanModal<?php echo $id ?>" tabindex="-1"> <?php "\n" ?>
        <div class="modal-dialog"><?php "\n" ?>
            <div class="modal-content text-center">
                <div class="modal-header text-center">
                    <h1 class="modal-title fs-5 text-center" style="color: Black;" id="editPlanModal<?php echo $id ?>">
                        Modal for <?php echo $name ?> with the ID : <?php echo $id ?></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="planEdit.php" method="POST" enctype="multipart/form-data"><?php "\n" ?>
                        <div class="container" style="color: black !important;"> <?php "\n" ?>
                            <label for="nameEdit" class="form-label" style="color: Black;">What do you want to change
                                the name into: </label> <?php "\n" ?>
                            <input type="text" class="form-control" id="nameEdit" name="nameEdit"
                                   value="<?php echo $name; ?>" require> <?php "\n" ?>
                            <label for="descEdit" class="form-label" style="color: Black;"></label> <?php "\n" ?>
                            <textarea name="descEdit" id="descEdit" cols="30" rows="10"
                                      style="color: Black !important;">&lt;h3&gt;<?php echo $description ?>  &lt;/h3&gt;</textarea>
                            <script type="text/javascript">
                                ClassicEditor
                                    .create(document.querySelector('#descEdit'));
                            </script>
                            <label for="priceEdit" class="form-label" style="color: Black;">What do you want to change
                                the price into: </label> <?php "\n" ?>
                            <input type="text" class="form-control" id="priceEdit" name="priceEdit"
                                   value="<?php echo $price; ?>" require> <?php "\n" ?>
                            <label for="typeEdit" class="form-label" style="color: Black;">What do you want to change
                                the type into: </label> <?php "\n" ?>
                            <input type="text" class="form-control" id="typeEdit" name="typeEdit"
                                   value="<?php echo $typ; ?>" require> <?php "\n" ?>
                            <label for="fileEdit" class=>Upload the image :</label>
                            <input type="file" class="form-control" name="fileEdit" id="fileEdit" value="<?php echo $filepath;?>">
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


<div class="container-fluid">
    <div class="p-5"></div>
    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
            <tr class="table-dark">
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
             * With a SQL Select-Statement all the columns of the plans table will be selected.
             * These variables will be saved into "$result" and then iterated through a foreach.
             * The iterated variables will be given as parameters into the createProductModal and also will be used
             * to be shown in a bootstrap table.
             */
            $sql = "SELECT * FROM Plane;";
            $stmt = $con->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($result as $product) {
                createProductModal($product["PlanID"], $product["Planname"], $product["Plandescription"], $product["Planprice"], $product["Plantyp"], $product["filePath"]);

                ?>
                <tbody class="align-middle">
                <tr class="table-dark">
                    <td class="table-dark"><?php echo $product["Planname"]; ?></td>
                    <td class="table-dark"><?php echo $product["Plandescription"]; ?></td>
                    <td class="table-dark"><?php echo $product["Planprice"]; ?></td>
                    <td class="table-dark"><?php echo $product["Plantyp"]; ?></td>
                    <td class="table-dark">
                        <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal"
                                data-bs-target="#editPlanModal<?php echo $product["PlanID"]; ?>">Editieren
                        </button>
                    </td>
                    <form action="planEdit.php" method="POST">
                        <td class="table-dark">
                            <button type="submit" class="btn btn-danger mb-3" name="toDel"
                                    value="<?php echo $product["PlanID"]; ?>">Delete
                            </button>
                        </td>
                    </form>
                </tr>
                </tbody>
            <?php } ?>

        </table>
    </div>
    <div class="row">
        <div class="col-lg-11 col-md-10"></div>
        <div class="col-lg-1 col-md-2">
            <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addPlanModal">Add
                a Plan
            </button>
        </div>
    </div>
</div>
<!--
 * This is a modal that will be called by the "Add" button.
 * This modal has a form which holds the fields for the addition of a new plan, such as
 * those that require the name, description, price, type and filepath. The ID will be auto incremented from the database, hence it should not be given.
 * ClassicEditor ist ein WYSIWYG Editor for the simple creation of better formatted texts. A library was imported and installed in the server with the name "ckeditor"
-->
<div class="modal fade modal-lg" id="addPlanModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel" style="color: Black;">Add a Plan</h1>
            </div>
            <div class="modal-body">
                <form action="planEdit.php" method="POST" enctype="multipart/form-data">
                    <div class="container" style="color: Black !important;"> <?php "\n" ?>
                        <label for="nameAdd" class="form-label" style="color: Black;">Whats the name of the
                            plan </label> <?php "\n" ?>
                        <input type="text" class="form-control" id="nameAdd" name="nameAdd" require> <?php "\n" ?>
                        <label for="descAdd" class="form-label" style="color: Black;"></label> <?php "\n" ?>
                        <textarea name="descAdd" id="descAdd" cols="30" rows="10" style="color: Black !important;">&lt;h3&gt; Whats the description of the plan&lt;/h3&gt;</textarea>
                        <script type="text/javascript">
                            ClassicEditor
                                .create(document.querySelector('#descAdd'));
                        </script>
                        <label for="priceAdd" class="form-label" style="color: Black;">Whats the price of the
                            plan </label> <?php "\n" ?>
                        <input type="text" class="form-control" id="priceAdd" name="priceAdd" require> <?php "\n" ?>
                        <label for="typeAdd" class="form-label" style="color: Black;">Whats the type of the
                            plan </label> <?php "\n" ?>
                        <input type="text" class="form-control" id="typeAdd" name="typeAdd" require> <?php "\n" ?>
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

<?php
/*
 * Here an alert will be called if the delete plan is failed.
 */
if ($failDelete) {
    ?>
    <div class="container">
    <div class="alert alert-danger">
        <p class="text-center">You cannot delete the Plan with the ID: <?php echo $id ?>, because it is connected to an
            order, delete the corresponding order first.</p>
    </div>
    </div>
    <?php
}


?>

</body>

</html>


