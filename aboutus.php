<?php
/*
 * Implementation of a header that holds the mandatory scripts and files for the page to function properly
 */
session_start();
require("elements/header.php");

?>

<!-- Div container that holds the Title of the page, the name in the right side and also bootstrap classes to fix the responsivity -->
<div style="width: auto ">
    <?php require_once("elements/nav.php"); ?>
    <div class="container">
        <div class="p-5"></div>
        <h1 class="px-3">Project Team</h1>
        <div class="row">
            <div class="col-lg-10 col-sm-12">
                <hr class="border hr opacity-100">
            </div>
            <div class="col-lg-2 d-flex justify-content-end">
                <p class="fs-5 pb-2">Garage Gym</p>
            </div>
        </div>
    </div>
    <!--
     * Container with a black background which holds the images, names and titles of each person of the group
     * The images are held into columns using the bootstrap grid functions and are with paddings in each side to hold a clean distance
     -->
    <div class="container-fluid bg-dark">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-2 col-sm-10 px-3 py-3 text-center">
                    <img src="elements/img/Amadeo Portrait.jpg" class="img-fluid img1"
                         style="height: auto; width: 264px; margin: 0 auto;">
                    <p style="font-size: 25px;" class="p-0 m-0">Amadeo <br> Durgaj</p>
                    <p style="font-size: 15px; color: #ff8206">Project Leader</p>
                </div>

                <div class="col-lg-2 col-sm-10 px-3 py-3 text-center">
                    <img src="elements/img/Arbi Portrait.jpg" class="img-fluid img1"
                         style="height: auto; width: 264px; margin: 0 auto;">
                    <p style="font-size: 25px;" class="p-0 m-0">Arbi <br> Zhabjaku</p>
                    <p style="font-size: 15px; color: #ff8206">Project Leader</p>
                </div>

                <div class="col-lg-2 col-sm-10 px-3 py-3 text-center">
                    <img src="elements/img/Deni Portrait.jpg" class="img-fluid img1"
                         style="height: auto; width: 264px; margin: 0 auto;">
                    <p style="font-size: 25px;" class="p-0 m-0">Deni <br> Dibra</p>
                    <p style="font-size: 15px; color: #ff8206">Project Member</p>
                </div>

                <div class="col-lg-2 col-sm-10 px-3 py-3 text-center">
                    <img src="elements/img/Mirjoni Portrait.jpg" class="img-fluid img1"
                         style="height: auto; width: 264px; margin: 0 auto;">
                    <p style="font-size: 25px;" class="p-0 m-0">Mirjon <br> Puka</p>
                    <p style="font-size: 15px; color: #ff8206">Project Member</p>
                </div>
            </div>
        </div>

        <div class="p-3"></div>
        <div class="row px-5">
            <h2 class="h2 mt-2 mb-3 text-center" style="font-size: 43px; color:#ff8206 ">About Us</h2>
        </div>

        <div class="row col-md-12 px-4">

            <p class="pb-3 text-center">
                Welcome to Garage Gym – your ultimate destination for fitness plans and subscriptions meticulously crafted to fit your lifestyle and goals. Born from the shared passion and dedication of four fitness enthusiasts - Amadeo, Arbi, Mirjon, and Deni - our website is more than just a gym; it's a community. We believe in making fitness accessible and achievable for everyone, which is why we've designed a range of plans to suit different needs and preferences. Whether you're just starting out or looking to elevate your fitness journey, Garage Gym is here to guide you every step of the way. Join us and discover the difference personalized care and expertise can make in your fitness journey.</p>
        </div>
        <?php require("elements/footer.php"); ?>
    </div>
</div>