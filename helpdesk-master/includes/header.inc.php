<?php
session_start();

 if(!defined('IN_GS')){ die('you cannot load this page directly.'); }

 $page = get_page_slug(false);

 $_SESSION['test'] = 1;


 if(null !== get_cookie('GS_ADMIN_USERNAME')){
    $GLOBALS['userOnline'] = "y";
 }
 else{
    $GLOBALS['userOnline'] = "n";
 }

?>

<!doctype html>

<!--
=============================================
  Developed by Code Cobber
  https://www.codecobber.co.uk
=============================================
-->

<html class="no-js" lang="en">

<head>


    <meta charset=UTF-8>
    <title><?php get_page_clean_title(); ?> &mdash;  <?php get_site_name(); ?></title>
    <?php get_header(); ?>

    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- CSS Files -->
    <link rel="stylesheet" type="text/css" href="<?php get_theme_url(); ?>/css/effects.css" />
    <link rel="stylesheet" type="text/css" href="<?php get_theme_url(); ?>/css/push.css" />
    <link rel="stylesheet" type="text/css" href="<?php get_theme_url(); ?>/css/foundation.css" />
    <link rel="stylesheet" type="text/css" href="<?php get_theme_url(); ?>/css/rowData.css" />
    <link rel="stylesheet" type="text/css" href="<?php get_theme_url(); ?>/css/style.css" />
    <link rel="stylesheet" type="text/css" href="<?php get_theme_url(); ?>/css/animate.css" />

    <link rel="shortcut icon" type="image/png" href="<?php get_site_url() ?>favicon.png">


    <!-- Google Fonts xxx -->
    <link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?php get_theme_url(); ?>/css/cssFonts.css" />

    <!-- Font Awsome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

    <!-- Javascript -->
    <script src="<?php get_theme_url(); ?>/js/vendor/jquery.js"></script>

   <?php
   if(isset($page)){
      if($page == "create" || $page == "edit"){
    ?>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
      $( function() {
        $( "#datepicker" ).datepicker({dateFormat:"d-m-yy"});
      } );
      </script>
   <?php
      }
    } ?>



    <script id="scrollCheck" src="<?php get_theme_url(); ?>/js/scrollCheck.js"></script>



    <!-- Google Analytics below -->
    <link rel="canonical" href="http://www.yoursite.co.uk/">


    <!-- Facebook og settings -->
    <meta property="og:title" content="title" />
    <meta property="og:url" content="http://www.yoursite.co.uk" />
    <meta property="og:image" content="http://www.yoursite.co.uk/images/logo.png" />
    <meta property="og:type" content="company" />


    </head>

<body id="<?php get_page_slug(); ?>" >


    <!-- SideNav content -->

    <div id="mySidenav" class="sidenav">
        <ul>
            <?php get_navigation(return_page_slug()); ?>
            <li><a class="editme" href="#">Edit</a></li>
        </ul>
    </div>

    <div id="main" class="hide-for-medium">
        <span style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776; open</span>
    </div>

    <!-- ==================================================================================== -->



    <div id='start'>
