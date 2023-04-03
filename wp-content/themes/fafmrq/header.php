<!DOCTYPE html>
<!--[if lt IE 7]>
<html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>
<html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>
<html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title><?php echo bloginfo('title'); wp_title('|', true); ?></title>
    <meta name="description" content="">

    <link href="http://fonts.googleapis.com/css?family=Alegreya+SC:700|Abel:400|Source+Sans+Pro:700" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="<?php echo theme_url(); ?>css/vendor/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo theme_url(); ?>css/reset.css">
    <link rel="stylesheet" href="<?php echo theme_url(); ?>css/vendor/icheck.css">
    <link rel="stylesheet" href="<?php echo theme_url(); ?>css/main.css">

    <?php wp_head(); ?>

    <!--[if lt IE 9]>
    <script src="<?php echo theme_url(); ?>js/vendor/html5-3.6-respond-1.1.0.min.js"></script>
    <![endif]-->
</head>
<body>
<!--[if lt IE 7]>
<p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade
                                                                                                                    your
                                                                                                                    browser</a>
                       or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to
                       improve your experience.</p>
<![endif]-->
<?php include "title.php" ?>
<?php include "menu.php" ?>
<?php wp_reset_postdata(); ?>

