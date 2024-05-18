<script>
    /*
    * This script enhances the navigation bar's interactivity on scroll and click events.
    * On scrolling down, the navbar fades out for a cleaner view, and fades back in when scrolling up.
    * Additionally, it toggles background color and dimensions of the navbar when the
    * toggle button is clicked, catering to responsive design needs.
    */
    $(function () {
        var lastScrollTop = 0;
        var $navbar = $('.navbar');
        var $navbarCollapse = $('.navbar-collapse');

        $(window).scroll(function (event) {
            var st = $(this).scrollTop();
            if (st > lastScrollTop) {
                $navbar.fadeOut();
            } else {
                $navbar.fadeIn();
            }
            lastScrollTop = st;
        });

        $('.navbar-toggler').click(function() {
            $navbarCollapse.toggleClass('bg-gray');
            $navbar.toggleClass('full-width');
            $navbar.toggleClass('full-height');
        });
    });
</script>

<!--
    /*
    * The styling here is for customizing the appearance of the navbar and related elements.
    * It includes transitions for smooth animation, specific color schemes for links, background colors
    * for the toggle button, and responsive adjustments. There's also a section
    * with flexbox to align items properly, and modifications to the navbar's width and background
    * color upon certain interactions.
    */

-->
<style>
    .navbar {
        transition: top 0.3s;
        top: 0;
        height: 80px;
    }

    a, .nav-link {
        text-decoration: none;
        color: #ff8206;
        font-size: 1.25rem;
    }

    .navbar-brand {
        padding-left: 7px;
    }

    .navbar-toggler{
        background-color: #ff8206;
    }

    li {
        padding: 0 10px 5px 10px;
    }
    .settings{
        display: flex;
        justify-content: flex-end;
        align-items: center;
        padding-right: 20px;
    }

    .navbar-collapse.bg-gray {
        background-color: #444 !important;
    }

    .navbar.full-width {
        width: 100%;
    }
    .navbar.full-height {
        width: 100%;
    }
</style>


<?php
/*
 * The navbar is duplicated for the having multiples active on the occasion of whether the user is logged in or not.
 * When the user is logged in, they have normally more features, like the settings icon or the logout button while removing
 * the login and register buttons.
 */
if (isset($_SESSION["email"])) {
    ?>
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">
                <img src="elements/img/logo.svg" alt="Your Logo" width="40">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="aboutus.php">About us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="blog.php">Blog</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contact.php">Contact</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="abos.php">Subscriptions</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="plans.php">Plans</a>
                    </li>
                    <?php
                    // These three if-s check if the user is an admin or trainer, so that they can have access to their respective pages.
                    if ($_SESSION["role"] == "admin") {

                        ?>

                        <li class="nav-item">
                            <a class="nav-link" href="admin.php">Admin</a>
                        </li>

                        <?php
                    }
                    ?>
                    <?php

                    if ($_SESSION["role"] == "trainer") {

                        ?>
                        <li class="nav-item">
                            <a class="nav-link" href="trainer.php">Trainer</a>
                        </li>
                        <?php
                    }
                    ?>

                    <li class="nav-item">
                        <a class="nav-link" href="elements/logout.php">Logout</a>
                    </li>
                </ul>
                <?php
                if ($_SESSION["role"] == "admin") {

                    ?>

                    <a class="settings" href="http://garagegym.htl-projekt.com/ntfc.php">
                        <i class="fa-solid fa-bell"  style="color: #bf6012;"></i>
                    </a>
                    <?php

                }
                ?>


                <a class="settings" href="editProfile.php">
                    <p class="d-block d-sm-none"> Settings</p>
                    <img class="d-none d-sm-block" src="elements/img/settings_icon.png" alt="Settings" width="23">
                </a>
            </div>
        </div>
    </nav>

    <?php
    // This is the navbar for the guest users.
} else {
    ?>

    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand " href="index.php">
                <img src="elements/img/logo.svg" alt="Your Logo" width="40">
            </a>
            <button class="navbar-toggler mx-2" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item ">
                        <a class="nav-link" href="aboutus.php">About us</a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link" href="blog.php">Blog</a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link" href="contact.php">Contact</a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link" href="abos.php">Subscriptions</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="plans.php">Plans</a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link" href="register.php">Register</a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link" href="login.php">Login</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <?php
}
?>