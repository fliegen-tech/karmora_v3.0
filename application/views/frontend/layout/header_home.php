<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title> Get cash back, coupons & special offers at online shopping | Karmora  </title>

    <!-- Bootstrap -->
    <link href="<?php echo $themeUrl ?>/css/bootstrap.min.css" rel="stylesheet">

    <!-- Main Style -->
    <link href="<?php echo $themeUrl ?>/css/main.css" rel="stylesheet">

    <!-- Font Awsome -->
    <link href="<?php echo $themeUrl ?>/css/font-awesome.css" rel="stylesheet">
     <!-- Custom Plugins -->
     <link href="<?php echo $themeUrl ?>/css/owl.carousel.css" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="<?php echo $themeUrl ?>/css/slick.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo $themeUrl ?>/css/slick-theme.css">

     <!-- Google Fonts -->
    <link href='https://fonts.googleapis.com/css?family=Maven+Pro:400,500,700,900' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Raleway:400,100,300,500,600,700,800,900,200' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800' rel='stylesheet' type='text/css'>

    <link rel="stylesheet" href="https://raw.githubusercontent.com/daneden/animate.css/master/animate.css" />

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    
    <!-- HEADER -->
     <header>
      <!-- Top Bar located in views/layout/partials/ -->
      <?php $this->load->view('frontend/layout/partials/top_bar'); ?>
      <!-- ./Top Bar contain login and signup -->
      
      <!-- Logo Search Bar located in views/layout/partials/-->
      <?php $this->load->view('frontend/layout/partials/top_nav_bar'); ?>
      <!-- ./Logo Search Bar contain logo and search and social icon -->

      
 <!--  Nav Bar Located in views/layout/partials/ -->
      <?php $this->load->view('frontend/layout/partials/nav_bar'); ?>
      <!-- ./ Nav Bar contain menu--> 

      <?php
      $action = $this->router->fetch_class();
      ?>
      <?php if ($action == 'index') { ?> 
       <!--  slider Located in views/layout/partials/ -->
      <?php $this->load->view('frontend/layout/partials/slider'); ?>
      <?php } ?>
      <!-- ./ slider--> 
    </nav>


  </header>
    <script> var baseurl = '<?php echo base_url(); ?>' </script>
     

