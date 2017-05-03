<!DOCTYPE html>
<html lang="en">
<head>

    <title>RegioSQM</title>

    <meta charset="utf-8">

    <meta name="google" content="notranslate" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

    <!-- script -->
    <script src="<?php echo BASEURL ?>/assets/script/jquery-3.2.1.min.js"></script>
    <script src="<?php echo BASEURL ?>/assets/script/jquery.prompt.js"></script>
    <script src="<?php echo BASEURL ?>/assets/script/interface.js"></script>

    <!-- style -->
    <script src="https://use.fontawesome.com/1cb9f568c6.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Roboto|Fira+Sans:300,400,500" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo BASEURL ?>/assets/style/screen.css" />

    <!-- google analytics -->
    <!-- TODO insert in live version -->

</head>
<body>

    <header class="body-header">
    <div class="body-header-container">

        <div class="logo">
        <a href="<?php echo BASEURL ?>"><span class="re">Regio</span><span class="sq">SQM</span></a>
        </div>

        <nav class="">
            <ul>
                <!-- <li><a href="<?php echo BASEURL ?>/">New Prediction</a></li> -->
                <li><a href="<?php echo BASEURL ?>/usage">Usage</a></li>
                <li><a href="<?php echo BASEURL ?>/faq">FAQ</a></li> <!-- doi link &amp; github links -->
            </ul>
        </nav>

    </div>
    </header>

    <section class="body-content">

    <?php
        include('pages/'.$view.'.php');
    ?>


    </section>

    <footer class="body-footer">

        <div class="body-footer-container">
            Have feedback? Tweet at <a href="https://twitter.com/janhjensen">@jhjensen</a>
        </div>
    </footer>

</body>
</html>
