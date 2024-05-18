<!--
 * The <style> block within the <head> tag defines CSS styles for the webpage.
 * These styles include formatting for the footer, text transformation to uppercase, flexbox layouts for logo alignment,
 * grid layouts for contact information and footer blocks, and visual styling for text and dividers.
-->
<head>
    <style>
        footer {
            margin: 0px 20px 0px 0px;
        }

        .text-uppercase {
            display: grid;
            padding: 53px 0px 0px 0px;
            font-size: 25px;
            color: #ffffff
        }

        .logo-name {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .logo {
            height: 100px;
            padding-right: 15px;
        }

        .container-fluid {
            padding: 0;
        }

        .contactinfo {
            display: grid;
            justify-content: center;
            align-items: center;
            margin: 20px 0px 0px 0px;
        }

        .underline {
            display: grid;
            justify-content: center;
            height: 3px;
            width: 230px;
            margin-bottom: 30px;
            background-color: #FFFFFF;
        }

        .footertext {
            padding: 0px 0px 20px 0px;
        }

        .footer {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .first_block, second_block, third_block {
            display: grid;
            justify-content: space-around;
            align-items: center;
        }

        .first_block {
            display: grid;
            justify-content: center;
            align-items: center;
        }

        .second_block {
            display: grid;
            justify-content: center;
            align-items: center;
        }

        .third_block {
            display: grid;
            justify-content: center;
            align-items: center;
        }

    </style>
</head>

<div class="p-4"></div>
<!--
 * The Footer uses Bootstrap classes for styling and layout, including a dark background, text centering,
 * and responsive column layouts for different screen sizes.
 * The footer contains three main blocks: the logo and contact information, about us links, and product links,
 * each in its respective column.
-->
<footer class="text-center text-lg-start bg-dark">
    <div class="container-fluid text-center text-md-start">
        <div class="footer row">
            <div class="col-lg-1 col-md-1 col-sm-0"></div>
            <div class="col-lg-4 col-md-12 col-sm-12 mx-auto mb-4 text-light first_block">
                <div class="p-2"></div>
                <div class="logo-name">
                    <img src="elements/img/logo.svg" alt="logo" class="logo"/>
                    <span class="titleName" style="font-size: 27px;">Garage Gym</span>
                </div>
                <div class="contactinfo">
                    <div class="p-2"></div>
                    <p><i class="fas fa-envelope me-3"></i> garagegym@gmail.com</p>
                    <p><i class="fas fa-phone me-3"></i>+355 69 568 8866 </p>
                    <p><i class="fas fa-home me-3"></i> Rruga Studenti, Shkoder Albania</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-12 col-sm-12 mx-auto mb-4 text-light second_block">
                <div class="p-2"></div>
                <h6 class="text-uppercase fw-bold mb-4 titleName d-flex justify-content-center align-items-center">
                    About Us
                </h6>
                <div class="underline"></div>
                <div class="footertext">
                    <p class="d-flex justify-content-center align-items-center">
                        <a href="aboutus.php" class="text-reset">About</a>
                    </p>
                    <p class="d-flex justify-content-center align-items-center">
                        <a href="contact.php" class="text-reset">Contact</a>
                    </p>
                </div>
            </div>
            <div class="col-lg-3 col-md-12 col-sm-12 mx-auto mb-4 text-light third_block">
                <div class="p-2"></div>
                <h6 class="text-uppercase fw-bold mb-4 titleName d-flex justify-content-center align-items-center">
                    Products
                </h6>
                <div class="underline">
                </div>
                <div class="footertext">
                    <p class="d-flex justify-content-center align-items-center">
                        <a href="abos.php" class="text-reset">Subscriptions</a>
                    </p>
                    <p class="d-flex justify-content-center align-items-center">
                        <a href="plans.php" class="text-reset">Plans</a>
                    </p>
                </div>
            </div>
            <div class="col-lg-1 col-md-1 col-sm-0"></div>
        </div>
    </div>
    <div class="text-center text-light p-2" style="background-color: rgba(0, 0, 0, 0.05); font-size: 10px;">
        © 2024 Copyright: Garage Gym - All Rights Reserved
    </div>
</footer>