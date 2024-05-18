
<?php
session_start();
require("elements/header.php");
require("elements/nav.php");
  require("elements/db.php");

        if (isset($_POST["markRead"])){
            $id = $_POST["markRead"];
            $sql1 = "update Contact set isRead = 1 where ContactID= :id";
            $stmt = $con->prepare($sql1);
            $stmt->bindParam(":id",$id);
            $stmt->execute();
unset($_POST["markRead"]);
        }




/*
if ($_SESSION["role"] != "admin") {
    header("location:login.php");
    exit();
}
*/
require("elements/db.php");
$stmt = $con->prepare("select * from Contact order by ContactId desc limit 10 ");
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<div class="p-5"></div>
    <table class="table align-middle">
        <thead>
        <tr class="table-dark ">
            <th scope="col">ContactID</th>
            <th scope="col">ContactText</th>
            <th scope="col">UserID</th>
            <th scope="col">UserEmail</th>
            <th scope="col">Read</th>

        </tr>
        </thead>
        <?php

        foreach ($result as $comment) {
            ?>
            <tbody>
            <tr class="table-dark">
                <td class="table-dark"><?php echo $comment["ContactID"]; ?></td>
                <td class="table-dark"><?php echo $comment["ContactText"]; ?></td>
                <td class="table-dark"><?php echo $comment["UserID"]; ?></td>
                <td class="table-dark"><?php echo $comment["UserEmail"]; ?></td>

                <td class="table-dark"><?php  if($comment["isRead"]==0){?>

                        <form action="ntfc.php" method="POST">
                            <button type="submit" class="btn btn-warning mb-3" name="markRead" value="<?php echo $comment["ContactID"]; ?>">Mark Read</button>
                    </form>   <?php }else echo "Read"; ?></td>

            </tr>
            </tbody>
        <?php }

        ?>

