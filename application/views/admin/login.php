<!DOCTYPE html>
<html>

    <head>
        <!-- Meta, title, CSS, favicons, etc. -->
        <meta charset="utf-8" />
        <title><?php echo $title ?></title>
        <meta name="keywords" content="HTML5 Bootstrap 3 Admin Template UI Theme" />
        <meta name="description" content="Stardom - A Responsive HTML5 Admin UI Template Theme" />
        <meta name="author" content="Holladay" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />

        <!-- Font CSS  -->
        <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700" />

        <!-- Core CSS  -->
        <link rel="stylesheet" type="text/css" href="https://netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css" />
        <link rel="stylesheet" type="text/css" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('admin/public/admin'); ?>/fonts/glyphicons_pro/glyphicons.min.css" />

        <!-- Plugin CSS -->
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('public/admin'); ?>/vendor/plugins/calendar/fullcalendar.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('public/admin'); ?>/vendor/plugins/datatables/css/datatables.min.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('public/admin'); ?>/css/animate.css" />

        <!-- Theme CSS -->
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('public/admin'); ?>/css/theme.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('public/admin'); ?>/css/pages.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('public/admin'); ?>/css/plugins.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('public/admin'); ?>/css/responsive.css" />

        <!-- Demonstration CSS -->
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('public/admin'); ?>/css/demo.css" />

        <!-- Your Custom CSS -->
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('public/admin'); ?>/css/custom.css" />




        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head>
    <body class="login-page">

        <a href="<?php echo base_url(); ?>" id="return-arrow"> <i class="fa fa-arrow-circle-left fa-3x text-red2"></i> <span> Return <br />
                to Home </span> </a> 

        <!-- Start: Main -->
        <div id="main">
            <div class="container">
                <div class="row">
                    <div id="page-logo"> <img src="<?php echo base_url('public/admin'); ?>/img/logos/karmora-websiteLogo.png" class="img-responsive" alt="logo" /> </div>
                </div>
                <div class="row">

                    <div class=" panel col-md-4 col-md-offset-4">
                        <div class="panel-heading">
                            <div class="panel-title"> <i class="fa fa-lock"></i> Login </div>

                        </div>
                        <form class="cmxform" id="altForm" method="post" >
                            <div class="panel-body">
                                <?php if (isset($general_error) && ($general_error != '')) { ?>  
                                    <div class="alert alert-danger alert-dismissable">
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <?php echo $general_error; ?> <a href="#" class="alert-link"></a>.
                                    </div>
                                <?php } ?>
                                <?php if (isset($username_error) && ($username_error != '')) { ?>  
                                    <div class="alert alert-danger alert-dismissable">
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <?php echo $username_error; ?> <a href="#" class="alert-link"></a>.
                                    </div>
                                <?php } ?>
                                <?php if (isset($password_error) && ($password_error != '')) { ?>  
                                    <div class="alert alert-danger alert-dismissable">
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <?php echo $password_error; ?><a href="#" class="alert-link"></a>.
                                    </div>
                                <?php } ?>

                                <div class="form-group">
                                    <div class="input-group"> <span class="input-group-addon"><i class="fa fa-user"></i> </span>
                                        <input type="text" class="form-control phone" name="username" autocomplete="off" placeholder="User Name" required="true" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group"> <span class="input-group-addon"><i class="fa fa-key"></i> </span>
                                        <input type="password" class="form-control product"  name="password" autocomplete="off" placeholder="Password" required="true" />
                                    </div>
                                </div>

                            </div>
                            <div class="panel-footer">
                                <div class="form-group margin-bottom-none">
                                    <input class="btn btn-primary pull-right" name="submit" type="submit" value="Login" />
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- End: Main --> 

        <!-- Core Javascript - via CDN --> 
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script> 
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script> 
        <script src="https://netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script> 

        <!-- Theme Javascript --> 
        <script type="text/javascript" src="<?php echo base_url('public/admin'); ?>/js/uniform.min.js"></script> 
        <script type="text/javascript" src="<?php echo base_url('public/admin'); ?>/js/main.js"></script>
        <script type="text/javascript" src="<?php echo base_url('public/admin'); ?>/js/custom.js"></script> 
        <script type="text/javascript">

            jQuery(document).ready(function() {

                // Init Theme Core 	  
                Core.init();

            });

        </script>
    </body>
</html>