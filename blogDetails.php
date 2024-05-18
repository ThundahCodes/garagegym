<style>
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
require_once("elements/header.php");
require_once('elements/nav.php');
require_once("elements/db.php");

/*
 * This PHP Script displays detailed information about a specific blog based on a provided ID from the blog.php page.
 * Includes error handling for invalid blog IDs and uses a foreach to iterate through each detail of the blog
 * from the $results array which fetches the results of the SQL statement to select all blogs.
*/

$BlogID = isset($_GET['id']) ? $_GET['id'] : null;

if (!empty($BlogID) && is_numeric($BlogID)) {

    $stmt = $con->prepare("SELECT * FROM BlogKommentare WHERE BlogID = :BlogID");
    $stmt->bindParam(':BlogID', $BlogID, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        ?>

        <div class="row" style="padding: 6rem 2rem 2rem 2rem;">

            <div class="col-lg-2 mb-3 d-flex justify-content-center align-items-center backButtonDiv">
                <a href="blog.php" class="backButtonLink">
                    <button class="btn btn-secondary fa fa-arrow-left fa-3x backButton"></button>
                </a>
            </div>
            <div class="col-lg-8 col-md-12 col-sm-12">
                <div style="width:100%; height:100%; text-align: right">
                    <h5 class="card-title fs-6 pb-1"><b><?php echo $result["Title"]; ?></b></h5>
                    <img src="<?php echo $result["filePath"]; ?>" class="card-img-top mx-auto" alt="..."
                         style="width: 100%">
                    <div class="card-body text-start pt-2">
                        <div class="card-title"> <?php echo $result["Blogdescription"]; ?></div>
                    </div>
                </div>
                <div class="col-lg-2"></div>
            </div>
        </div>
        <?php
    } else {
        echo "Blog not found.";
    }
} else {
    echo "Invalid blog ID.";
}
require_once("elements/footer.php");
?>
