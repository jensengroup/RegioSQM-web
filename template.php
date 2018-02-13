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
    <script src="<?php echo BASEURL ?>/assets/script/interface.js?v=1.1"></script>

    <!-- style -->
    <script src="https://use.fontawesome.com/1cb9f568c6.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Roboto|Fira+Sans:300,400,500" rel="stylesheet">
    <!-- <link href="https://fonts.googleapis.com/css?family=Fira+Mono" rel="stylesheet"> -->
    <link href="https://fonts.googleapis.com/css?family=Roboto+Mono" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo BASEURL ?>/assets/style/screen.css" />

    <!-- google analytics -->
    <!-- TODO insert in live version -->
    <!-- Global Site Tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-34078381-3"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments)};
    gtag('js', new Date());

    gtag('config', 'UA-34078381-3');
    </script>


</head>
<body>

    <header class="body-header">
    <div class="body-header-container">

        <div class="logo">
        <a href="<?php echo BASEURL ?>"><span class="re">Regio</span><span class="sq">SQM</span></a>
        </div>


        <section class="navigation">
        <div class="border-menu"></div>
        <nav class="">
            <ul>
                <!-- <li><a href="<?php echo BASEURL ?>/">New Prediction</a></li> -->

                <li>
                <?php $status = cluster_status(); ?>
                <span class="server_status <?php print($status); ?>">
                    <i class="fa fa-cloud" aria-hidden="true"></i>
                    Cluster is <?php echo $status; ?>
                </span>
                </li>

                <li><a href="<?php echo BASEURL ?>/usage">Usage</a></li>
                <li><a href="<?php echo BASEURL ?>/faq">FAQ</a></li>
                <li><a class="github" href="https://github.com/jensengroup/RegioSQM">Source</a></li>
            </ul>
        </nav>
        </section>

    </div>
    </header>

    <section class="body-content">

    <?php
        include('pages/'.$view.'.php');
    ?>


    </section>

    <footer class="body-footer">

        <div class="body-footer-container">
            Have feedback? Tweet at <a href="https://twitter.com/janhjensen">@janhjensen</a>.
        </div>
    </footer>

</body>
</html>
