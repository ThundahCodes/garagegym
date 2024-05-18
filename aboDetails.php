<style xmlns="http://www.w3.org/1999/html">
    /*
     * This styling is designed for a 'back' button, including a hover effect for visual feedback.
     * The styling makes the button stand out with a not completely transparent background, which gets reduced by hovering
     * and includes a slight movement and shadow effect for depth. Media queries also help for the
     * presentation of the buttons in small screens.
      */
    .backButton {
        border-radius: 10% !important;
        background-color: rgba(255, 255, 255, 0.2);
        color: white;
        border: none !important;
        padding: 10px 23px !important;
        -webkit-transition: background-color 1s, color 1s, -webkit-transform 0.5s;
        transition: background-color 1s, transform 0.5s;
    }

    .backButton:hover {
        background-color: rgba(255, 255, 255, 0.8);
        color: black;
        -webkit-transform: translateX(-5px);
        -webkit-box-shadow: 5px 0px 18px 0px rgba(105, 105, 105, 0.8);
        -moz-box-shadow: 5px 0px 18px 0px rgba(105, 105, 105, 0.8);
        box-shadow: 5px 0px 18px 0px rgba(105, 105, 105, 0.8);
    }

    @media screen and (max-width: 600px) {
        .backButtonDiv {
            display: inline-block;
            padding: 15px;
        }
    }
</style>

<?php
session_start();
/*
 * This PHP Script retrieves the favorite subscriptions, processes addition of new favorites,
 * and displays detailed information about a specific subscription based on a provided ID from the abo.php page.
 * Includes error handling for invalid subscription IDs and integrates a favorite button for the users to add their favorites to the database.
*/
require_once("elements/header.php");
require_once('elements/nav.php');
require_once("elements/db.php");

$stmt = $con->prepare("SELECT distinct(aboID) FROM Favourites WHERE userID = :userID");
$stmt->bindParam(':userID', $_SESSION["userID"], PDO::PARAM_INT);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
$is_in= false;
echo "<br>";

$AboID =  $_GET['id'];
$_SESSION["AboID"] = $AboID;

if (isset($_GET["id"]) && isset($_GET["submit"])) {
    foreach ($result as $abb){
        if ($abb["aboID"] == $_SESSION["AboID"]){
            $is_in=true;
        }
    }
    echo "<br>";

    if (!$is_in) {
        $sql = "INSERT INTO Favourites(userID, aboID) values(:uid, :id)";
        $stmt = $con->prepare($sql);
        $stmt->bindParam(":uid", $_SESSION["userID"], PDO::PARAM_INT);
        $stmt->bindParam(":id", $_SESSION["AboID"], PDO::PARAM_INT);
        $stmt->execute();
    }
    unset($_GET["id"]);
    unset($_GET["submit"]);

}


if (!empty($_SESSION["AboID"]) && is_numeric($_SESSION["AboID"])) {
    $stmt = $con->prepare("SELECT * FROM Abos WHERE AboID = :AboID");
    $stmt->bindParam(':AboID', $_SESSION["AboID"], PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        ?>

        <div class="row" style="padding: 6rem 2rem 2rem 2rem;">

            <div class="col-lg-2 mb-3 d-flex justify-content-center align-items-center backButtonDiv">
                <a href="abos.php" class="backButtonLink">
                    <button class="btn btn-secondary fa fa-arrow-left fa-3x backButton"></button>
                </a>
            </div>
            <div class="col-lg-8 col-md-12 col-sm-12">
                <div style="width:100%; height:100%; text-align: right">
                    <h5 class="card-title fs-6 pb-1"><b><?php echo $result["Aboname"]; ?></b></h5>
                    <img src="<?php echo $result["filePath"]; ?>" class="card-img-top mx-auto" alt="..."
                         style="width: 100%">
                    <div class="card-body text-start pt-2">
                        <div class="card-title"> <?php echo $result["Abodescription"]; ?></div>
                    </div>

                </div>
                <div class="col-lg-2"></div>
            </div>
            <form action="aboDetails.php" method="GET">
                <div class="row justify-content-center">
                    <input type="hidden" id="id" name="id" value="<?php echo $result["AboID"]; ?>">
                    <input type="hidden" id="id" name="submit" value="1">
                    <button class="btn btn-warning" type="submit" id="favorite"">Favorite</button>
                </div>
            </form>
        </div>
        <?php
    } else {
        echo "Subscription not found.";
    }
} else {
    echo "Invalid subscription ID.";
}


require_once("elements/footer.php");
?>
<script>
    // This script alerts the user that the favorite was successful
    function myFunction() {
        alert("This subscription is now your favorite subscription ;)");
    }
</script>
<?php
