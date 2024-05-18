<?php
/*
 * Mandatory importing of the header, navbar and database connection for further usage.
 */
session_start();
require_once("elements/header.php");
require_once('elements/nav.php');
require_once("elements/db.php");

?>

<div class="container">
    <div class="p-5"></div>
    <h1 class="px-3">Subscriptions</h1>
    <div class="row">
        <div class="col-lg-10 col-sm-12">
            <hr class="border hr opacity-100">
        </div>
        <div class="col-lg-2 d-flex justify-content-end">
            <p class="fs-5 pb-2">Garage Gym</p>
        </div>
    </div>
</div>

<div class="container">
    <div class="row align-items-center abo-items">
        <?php
        /*
         * This script here allows for the portrayal of the different subscriptions in the website.
         * The page uses bootstrap cards to show the data which are taken by PDOs and a SQL Statement.
         * The SQL Statement gets all the subscriptions in descending order so that the newest come out first.
         * A foreach loop is then made to bring out the different details for the subscription to fill the card,
         * said descriptions are saved in the array "$result" which fetches all results from the statement.
         */
        $stmt = $con->prepare("SELECT * FROM Abos ORDER BY AboID DESC");
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $aboCount = 0;
        foreach ($result as $product) {
            ?>
            <div class="col-lg-6 col-md-12 col-sm-12 py-4 abo-item" style="min-width: 200px; height: auto; <?php echo ($aboCount >= 2) ? 'display:none;' : ''; ?>">
                <div class="card mx-auto bg-secondary text-white" style="width:75%; height:100%">
                    <img src="<?php echo $product["filePath"];?>" class="card-img-top">
                    <div class="card-body text-center" style="height:100%;">
                        <h5 class="card-title fs-6"> <b><?php echo $product["Aboname"]; ?></b> </h5>
                        <div class="card-title"> <?php echo $product["Aboprice"] . " ALL"; ?></div>
                    </div>
                    <div class="d-flex justify-content-center align-items-center pb-3">
                        <a href="aboDetails.php?id=<?php echo $product["AboID"]; ?>" class="btn btn-dark text-light">Read
                            More</a>
                    </div>
                </div>
                <div class="p-2"></div>
            </div>
            <?php
            $aboCount++;
        }
        ?>
    </div>
    <div class="container">
        <div class="row d-flex justify-content-center">
            <button id="readMoreBtn" class="btn btn-secondary col-lg-3">Read more subscriptions</button>
            <button id="showLessBtn" class="btn btn-secondary col-lg-3" style="display: none;">Show Less</button>
        </div>
    </div>
</div>

<script>
    /*
    * This script toggles visibility of 'abo-item' elements on the page. The 'Read More' button
    * reveals all items and hides itself while showing the 'Show Less' button. The 'Show Less'
    * button hides items beyond the first two, and toggles the button display back.
    */
    document.getElementById("readMoreBtn").addEventListener("click", function() {
        var blogItems = document.querySelectorAll(".abo-item");
        blogItems.forEach(function(item) {
            item.style.display = "block";
        });
        this.style.display = "none";
        document.getElementById("showLessBtn").style.display = "block";
    });

    document.getElementById("showLessBtn").addEventListener("click", function() {
        var blogItems = document.querySelectorAll(".abo-item");
        blogItems.forEach(function(item, index) {
            if (index >= 2) {
                item.style.display = "none";
            }
        });
        document.getElementById("readMoreBtn").style.display = "block";
        this.style.display = "none";
    });
</script>

<?php
require_once("elements/footer.php");
?>
