<?php
require("elements/header.php");
session_start();

if ($_SESSION["role"] != "trainer" && $_SESSION["role"] != "admin") {
    header("location:login.php");
    exit();
}


require("elements/db.php");

if (isset($_POST["toDel"])) {
    $id = $_POST["toDel"];
    $stmt = $con->prepare("DELETE FROM BlogKommentare WHERE BlogID = :id");
    $stmt->execute(["id" => $id]);
}


?>


<?php
if (isset($_POST["descEdit"]) && isset($_POST["id"]) && isset($_POST["titleEdit"])) {

    $innerID = $_POST["id"];
    $innerDescription = $_POST["descEdit"];
    $title = $_POST["titleEdit"];

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


    $sql2 = "UPDATE BlogKommentare SET Blogdescription = :description, filePath = :filepath, Title = :title where BlogID = :id;";
    $statement = $con->prepare($sql2);
    $statement->execute(["description" => $innerDescription, "id" => $innerID, "filepath" => $filepath, "title" => $title]);

}

if (isset($_POST["descAdd"]) && isset($_POST["uid"]) && isset($_POST["titleAdd"])) {
    $datetime = time();
    $date = date('Y-m-d H:i:s', strtotime($datetime));
    $descAdd = $_POST["descAdd"];
    $uid = $_POST["uid"];
    $title = $_POST["titleAdd"];

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

    $sql1 = "INSERT INTO BlogKommentare(Blogdescription, BlogDate, UserID, filePath, Title) VALUES(:description, :date,:UserID, :filepath, :title);";
    $statement = $con->prepare($sql1);
    $statement->bindParam(":date", $date, PDO::PARAM_INT);
    $statement->bindParam(":description", $descAdd, PDO::PARAM_STR);
    $statement->bindParam(":UserID", $uid, PDO::PARAM_STR);
    $statement->bindParam(":filepath", $filepath, PDO::PARAM_STR);
    $statement->bindParam(":title", $title, PDO::PARAM_STR);
    $statement->execute();
}
?>

<?php

function createProductModal($id, $desc, $date, $uid, $filepath, $title)
{

    ?>
    <div class="modal fade modal-lg" id="editBlogModal<?php echo $id ?>" tabindex="-1"> <?php "\n" ?>
        <div class="modal-dialog"><?php "\n" ?>
            <div class="modal-content text-center">
                <div class="modal-header text-center">
                    <h1 class="modal-title fs-5 text-center" style="color: Black;" id="editBlogModal<?php echo $id ?>">
                        Modal for blog with the Title : <?php echo $title; ?></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="editBlog.php" method="POST" enctype="multipart/form-data"><?php "\n" ?>
                        <div class="container" style="color: black !important;"> <?php "\n" ?>
                            <label for="titleEdit" class="form-label" style="color: Black;">What's the title of the
                                blog?</label> <?php "\n" ?>
                            <input type="text" name="titleEdit" id="titleEdit" cols="30" rows="10"
                                   style="color: Black !important;" value="<?php echo $title; ?>"></input>
                            <label for="descEdit" class="form-label" style="color: Black;"></label> <?php "\n" ?>
                            <textarea name="descEdit" id="descEdit" cols="30" rows="10"
                                      style="color: Black !important;">&lt;h3&gt;<?php echo $desc; ?>  &lt;/h3&gt;</textarea>
                            <script type="text/javascript">
                                ClassicEditor
                                    .create(document.querySelector('#descEdit'));
                            </script>
                            <?php "\n" ?>
                        </div> <?php "\n" ?>
                        <label for="fileEdit" class=>Upload the image :</label>
                        <input type="file" class="form-control" name="fileEdit" id="fileEdit"
                               value="<?php echo $filepath; ?>">
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
            <th scope="col">ID</th>
            <th scope="col">Title</th>
            <th scope="col">Description</th>
            <th scope="col">Date</th>
            <th scope="col">Creator</th>
            <th scope="col">&nbsp;</th>
            <th scope="col">&nbsp;</th>
        </tr>
        </thead>
        <?php

        $sql = "SELECT * FROM BlogKommentare;";
        $stmt = $con->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $product) {
            createProductModal($product["BlogID"], $product["Blogdescription"], $product["BlogDate"], $product["UserID"], $product["filePath"], $product["Title"]);

            ?>
            <tbody>
            <tr class="table-dark">
                <td class="table-dark"><?php echo $product["BlogID"]; ?></td>
                <td class="table-dark"><?php echo $product["Title"]; ?></td>
                <td class="table-dark"><?php echo $product["Blogdescription"]; ?></td>
                <td class="table-dark"><?php echo $product["BlogDate"]; ?></td>
                <td class="table-dark"><?php echo $product["UserID"]; ?></td>
                <td class="table-dark">
                    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal"
                            data-bs-target="#editBlogModal<?php echo $product["BlogID"]; ?>">Editieren
                    </button>
                </td>
                <form action="editBlog.php" method="POST">
                    <td class="table-dark">
                        <button type="submit" class="btn btn-danger mb-3" name="toDel"
                                value="<?php echo $product["BlogID"]; ?>">Delete
                        </button>
                    </td>
                </form>
            </tr>
            </tbody>
        <?php } ?>

    </table>
    <div class="row">
        <div class="col-md-11"></div>
        <div class="col-md-1">
            <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addBlogModal">
                Add
            </button>
        </div>
    </div>
</div>

<div class="modal fade modal-lg" id="addBlogModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel" style="color: Black;">Add a Blog</h1>
            </div>
            <div class="modal-body">
                <form action="editBlog.php" method="POST" enctype="multipart/form-data">
                    <div class="container" style="color: black !important;"> <?php "\n" ?>
                        <input type="hidden" id="uid" name="uid"
                               value="<?php echo $_SESSION["userID"] ?>"> <?php "\n" ?>
                        <label for="titleAdd" class="form-label" style="color: Black;">What's the title of the blog?
                            <br></label> <?php "\n" ?>
                        <input type="text" name="titleAdd" id="titleAdd" cols="30" rows="10"
                               style="color: Black !important;"></input>
                        <label for="descAdd" class="form-label" style="color: Black;"></label> <?php "\n" ?>
                        <textarea name="descAdd" id="descAdd" cols="30" rows="10" style="color: Black !important;">&lt;h3&gt;Whats the description of the blog&lt;/h3&gt;</textarea>
                        <script type="text/javascript">
                            ClassicEditor
                                .create(document.querySelector('#descAdd'));
                        </script>
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


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa"
        crossorigin="anonymous"></script>

</body>

</html>
