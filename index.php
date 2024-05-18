<?php
session_start();
require("elements/header.php");
?>

<?php
require("elements/nav.php");
?>

<style>

    html {
        overflow-x: hidden;
    }

    /*VIDEO*/
    .video-container {
        position: relative;
        width: 100%;
        height: 100vh; /* Adjust as needed */
        overflow: hidden;
    }

    .watermark {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-size: contain; /* Adjust as needed */
        opacity: 0.8; /* Adjust the opacity of the watermark */
        z-index: 1; /* Place the watermark behind the video */
        transition: opacity 1s ease; /* Adjust the transition duration and easing */
    }

    .video {
        width: 100%;
        height: 100%;
        object-fit: cover;
        position: sticky;
        top: 0;
        left: 0;
        z-index: -1;
    }
    @media only screen and (max-width: 600px) {
        .video-container {
            display: none;
        }
    }

    /*FIRST_ROW_LOGO_NAME*/

    @media only screen and (max-width: 600px) {
        .video-container {
            display: none;
        }
    }
    .logo_name {
        height: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        opacity: 0;
        transition: opacity 1s ease;
    }

    .logo_landing {
        height: 30vh;
    }

    .nameDiv {
        height: 50%;
        display: grid;
        justify-content: center;
        align-items: center;
    }

    .name_landing {
        margin: 2vh 6vh 2vh 6vh;
        font-size: 70px;
    }

    .slogan {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    @media only screen and (max-width: 600px) {
        .phoneTitle {
            padding-top: 20vh;
            display: grid;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        .phoneLogo {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            height: auto;
            padding: 0;
            margin-bottom: 10px; /* Adjust the margin as needed */
        }

        .phoneName {
            font-size: 40px;
            margin-top: 0; /* Remove margin-top to vertically align with the logo */
        }
    }




    /*INTRODUCTION*/
    .introduction {
        font-size: 14px;
        text-align: center;
    }

    /*FLIPPING CARDS*/
    .flipCards {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 350px;
    }

    .VLine {
        display: flex;
        justify-content: center;
        align-items: center;

    }

    .vl {
        border-left: 6px solid #ff8206;
        height: 100%;
    }

    .flip-card {

        background-color: transparent;
        width: 300px;
        height: 300px;
        perspective: 1000px;
    }

    .flip-card-inner {
        position: relative;
        width: 100%;
        height: 100%;
        text-align: center;
        transition: transform 0.6s;
        transform-style: preserve-3d;
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);

    }

    .flip-card:hover .flip-card-inner {
        transform: rotateY(180deg);
    }

    .flip-card-front, .flip-card-back {
        position: absolute;
        width: 100%;
        height: 100%;
        -webkit-backface-visibility: hidden;
        backface-visibility: hidden;
    }

    .flip-card-front {
        background-color: #ffffff;
        color: black;
    }

    .flip-card-front h1 {
        font-size: 30px;
        padding: 0 0 0 10px;
        color: #ff8206;
        text-align: left;
    }

    .flip-card-front h5 {
        font-size: 16px;
        width: 100%;
        padding: 170px 0 0 0px;
        color: white;
        text-shadow: 2px 2px 4px rgb(255, 130, 6);
        text-align: center;
    }

    .card1 {
        background-image: url('elements/img/esli.jpeg');
        opacity: 0.9;
        background-size: cover;
        background-position: center;
        position: relative;
        color: white;
        overflow: hidden;
    }

    .card2 {
        background-image: url('elements/img/deniEsli.jpeg');
        opacity: 0.9;
        background-size: cover;
        background-position: center;
        position: relative;
        color: white;
        overflow: hidden;
    }


    .flip-card-back {
        background-color: #ff8206;
        color: white;
        transform: rotateY(180deg);
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 12px;
    }


    /*buttos*/
    .refPlane, .refAbo {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .btn {
        background-color: #ff8206;
        border: none;
        color: white;
        text-align: center;
        font-size: 16px;
        height: 60px;
        width: 40vh;
        opacity: 0.8;
        transition: 0.3s;
    }

    .btn:hover {
        opacity: 1
    }


    /*COUNTER*/
    counter {
        display: flex;
        justify-content: center;
        align-items: center;
        float: left;
        width: 25%;
        padding: 0 5px;
        margin: 10px -5px;
    }

    .row:after {
        content: "";
        display: table;
        clear: both;
    }

    .card {
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
        padding: 16px 0 0 0;
        text-align: center;
        background-color: #444;
        color: #ff8206;
    }

    .fa {
        font-size: 50px;
    }


    /*RIBBON*/

    .ribbon_new,
    .ribbon_hot {
        transition: transform .2s;
    }

    .ribbonDiv {
        display: flex;
        justify-content: space-between;
    }

    .zoom {
        padding: 50px;
        background-color: #444;
        transition: transform .2s;
        width: 350px;
        height: 350px;
        margin: 0 auto;
        position: relative;
        background-image: url('elements/img/esli.jpeg');
    }

    @media only screen and (min-width: 600px) {
        .zoom:hover {
            -ms-transform: scale(1.5);
            -webkit-transform: scale(1.5);
            transform: scale(1.5);
        }
    }

    .ribbon_new,
    .ribbon_hot {
        width: 60px;
        font-size: 14px;
        padding: 4px;
        position: absolute;
        right: -25px;
        top: -12px;
        text-align: center;
        border-radius: 25px;
        transform: rotate(20deg);
        color: white;
    }

    .ribbon_new {
        background-color: #ff9800;
    }

    .ribbon_hot {
        background-color: #d02c2c;
    }

    .ribbonNew,
    .ribbonHot {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        height: 80vh;
    }

    @media only screen and (max-width: 600px) {
        .zoom {
            width: 70%; /* Adjust the width for smaller screens */
            height: 70%; /* Adjust the height for smaller screens */
        }

        .ribbon_new,
        .ribbon_hot {
            width: 50px; /* Adjust the width for smaller screens */
            font-size: 10px; /* Adjust the font size for smaller screens */
            padding: 2px; /* Adjust the padding for smaller screens */
            right: -15px; /* Adjust the right position for smaller screens */
            top: -8px; /* Adjust the top position for smaller screens */
            border-radius: 12px; /* Adjust the border-radius for smaller screens */
        }
    }

</style>

<div class="video-container">
    <video class="video" autoplay muted loop playsinline>
        <source src="elements\img\garagegym.mp4" type="video/mp4">
    </video>
    <div class="watermark">
        <div class="col-lg-12">
            <div class="logo_landing"></div>
            <div class="nameDiv">
                <h1 class="name_landing m-0 p-0"><b>Garage Gym</b></h1>
                <p class="slogan"></p>
            </div>
        </div>
    </div>
</div>

<div class="body">
    <div class="row firstRow d-none d-md-flex">
        <div class="col-lg-12 col-md-12 col-sm-12 logo_name d-flex justify-content-center align-items-center">
            <img class="logo_landing" src="elements\img\logo.svg">
            <div class="nameDiv">
                <h1 class="name_landing"><b><span>Garage</span> <span>Gym</span></b></h1>
                <p class="slogan fs-7"><span>"not just your regular gym"</span></p>
            </div>
        </div>
    </div>

    <div class="row phoneTitle d-md-none"> <!-- Use Bootstrap class d-md-none to show only on small screens -->
        <div class="col-12">
            <div class="phoneLogo">
                <img width="200px" src="elements\img\logo.svg">
            </div>
            <div class="nameDiv">
                <h1 class="phoneName"><b>Garage Gym</b></h1>
                <p class="slogan fs-7">"not just your regular gym"</p>
            </div>
        </div>
    </div>



    <div class="p-4 break1"></div>

    <div class="row secondRow">
        <div class="col-lg-1"></div>
        <div class="col-lg-10 introduction">
            <p>Welcome to Garage Gym – your ultimate destination for fitness plans and subscriptions meticulously crafted to fit your lifestyle and goals.</p>
        </div>
        <div class="col-lg-1"></div>
    </div>

    <div class="p-4 break2"></div>

    <div class="row">
        <div class="col-lg-1"></div>
        <div class="col-lg-4 flipCards">
            <div class="flip-card">
                <div class="flip-card-inner">
                    <div class="flip-card-front">
                        <div class="card1" style="width:300px;height:300px;">
                            <h1>Personalized Fitness Plans</h1>
                            <h5>Unlock Your Best Self with Tailored Fitness Programs</h5>
                        </div>
                    </div>
                    <div class="flip-card-back">
                        <p class=" m-2">Discover the power of personalized fitness with our expertly crafted workout
                            plans designed just for you. Whether you're a beginner looking to kickstart your fitness
                            journey or a seasoned enthusiast aiming for specific goals, our experienced trainers will
                            create a customized plan that suits your individual needs, preferences, and fitness levels.
                            Get ready to embrace a healthier, fitter version of yourself as you embark on a journey to
                            achieve your fitness aspirations.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-2 VLine">
            <div class="vl"></div>
        </div>
        <div class="col-lg-4 flipCards">
            <div class="flip-card">
                <div class="flip-card-inner">
                    <div class="flip-card-front">
                        <div class="card2" style="width:300px;height:300px;">
                            <h1>Group Fitness Classes</h1>
                            <h5>Energize Your Workout Routine with Group Fitness</h5>
                        </div>
                    </div>
                    <div class="flip-card-back">
                        <p class="m-2">Join our dynamic community of fitness enthusiasts and experience the motivation
                            and energy of our group fitness classes. From high-intensity interval training (HIIT) to
                            invigorating yoga sessions, our diverse range of classes caters to all fitness levels. Enjoy
                            the camaraderie of like-minded individuals as our certified instructors guide you through
                            challenging yet rewarding workouts. Embrace the power of collective motivation and achieve
                            your fitness goals together.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-1"></div>
    </div>

    <div class="p-4"> <!--break3 --> </div>
    <div class="p-4 break4"><!--break4 --></div>

    <div class="row counter">
        <div class="col-lg-1  col-sm-1"></div>

        <!-- Happy Customers -->
        <div class="col-lg-3 col-sm-10 mb-3 px-3">
            <div class="card">
                <p><i class="fa fa-cube"></i></p>
                <h3>450</h3>
                <p>Happy Customers</p>
            </div>
        </div>
        <!-- Square Meters -->
        <div class="col-lg-2 col-sm-10 mb-3 px-3">
            <div class="card">
                <p><i class="fa fa-calendar"></i></p>
                <h3>250</h3>
                <p>Squre Meters</p>
            </div>
        </div>
        <!-- Instructors -->
        <div class="col-lg-2 col-sm-10 mb-3 px-3">
            <div class="card">
                <p><i class="fa fa-person"></i></p>
                <h3>5</h3>
                <p>Instructors</p>
            </div>
        </div>
        <!-- Days a Week -->
        <div class="col-lg-3 col-sm-10 mb-1 px-3">
            <div class="card">
                <p><i class="fa fa-heart"></i></p>
                <h3>6</h3>
                <p>Days a Week</p>
            </div>
        </div>

        <div class="col-lg-1 col-md-1"></div>
    </div>


    <div class="p-4 break5"></div>
    <div class="p-4 break6"></div>

    <div class="row ribbonDiv">
        <div class="col-lg-2"></div>
        <div class="col-lg-3 ribbonNew">
            <div class="zoom">
                <span class="ribbon_new">NEW</span>
            </div>
        </div>
        <div class="col-lg-2" ></div>
        <div class="col-lg-3 ribbonHot">
            <div class="zoom">
                <span class="ribbon_hot">HOT</span>
            </div>
        </div>
        <div class="col-lg-2"></div>
    </div>
    <?php require("elements/footer.php"); ?>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const video = document.querySelector(".video");
        const content = document.querySelector(".firstRow");
        const logo = document.querySelector(".logo_name");

        window.addEventListener("scroll", function () {
            const scrollValue = window.scrollY;

            const videoOpacity = 1 - scrollValue / 300;
            video.style.opacity = videoOpacity;

            const contentOpacity = Math.min(scrollValue / 300, 1);
            content.style.opacity = contentOpacity;

            if (videoOpacity <= 0 && scrollValue > 200) {
                const logoOpacity = Math.min((scrollValue - 200) / 100, 1);
                logo.style.opacity = logoOpacity;
            } else {
                logo.style.opacity = 0;
            }
        });

        // Smooth scrolling for button with ID section1
        const section1Button = document.querySelector('.refPlane button');

        section1Button.addEventListener('click', function (e) {
            e.preventDefault();

            const targetId = this.parentElement.getAttribute('href').substring(1);
            const targetElement = document.getElementById(targetId);

            if (targetElement) {
                window.scrollTo({
                    top: targetElement.offsetTop,
                    behavior: 'smooth'
                });
            }
        });
    });

    document.addEventListener('DOMContentLoaded', function () {
        var watermark = document.querySelector('.watermark');

        // Set a timeout to fade out the watermark after 3 seconds
        setTimeout(function () {
            watermark.style.opacity = 0;
        }, 3000);
    });
</script>

</body>
</html>

