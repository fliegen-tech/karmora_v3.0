<!DOCTYPE html>
<html>

    <head>
        <!-- 
          NOTE: This index page is primarily for demonstrative purposes. 
          dashboard.html is more suitable for use as it has 
          been stripped of added animations 
        -->

        <!-- Meta, title, CSS, favicons, etc. -->
        <meta charset="utf-8" />
        <title>Karmora - Admin Dashboard</title>
        <meta name="keywords" content="Karmora" />
        <meta name="description" content="Karmora" />
        <meta name="author" content="usman" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />

        <!-- Core CSS  -->
         <link rel="stylesheet" type="text/css" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('public/admin'); ?>/css/jquery.dataTables.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('public/admin'); ?>/css/bootstrap.min.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('public/admin'); ?>/fonts/glyphicons_pro/glyphicons.min.css" />

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
        <script src="<?php echo base_url('public/admin'); ?>/js/jquery.min.js"></script>
        <script src="<?php echo base_url('public/admin'); ?>/js/jquery-ui.min.js"></script>
        <script src="<?php echo base_url('public/admin'); ?>/js/datatable/media/js/jquery.dataTables.js"></script>
        <script src="<?php echo base_url('public/admin'); ?>/js/datatable/media/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" language="javascript" src="<?php echo base_url('public/admin'); ?>/js/datatable/examples/resources/syntax/shCore.js"></script>
	<script type="text/javascript" language="javascript" src="<?php echo base_url('public/admin'); ?>/js/datatable/examples/resources/demo.js"></script>
	
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head>
    <script type="text/javascript">
        var base_url = '<?php echo base_url(); ?>';
    </script>
    <body class="dashboard index-load">
        <!-- Start: Theme Preview Pane -->
        <div id="skin-toolbox">
            <div class="skin-toolbox-toggle"> <i class="fa fa-flask"></i> </div>
            <div class="skin-toolbox-panel">
                <h4 class="padding-left-sm">Theme Options</h4>
                <form id="skin-toolbox-form" >
                    <div class="form-group">
                        <label class="checkbox-inline">
                            <input id="header-option" class="checkbox" type="checkbox" checked="" />
                            Fixed <b>Header</b> </label>
                    </div>
                    <hr class="short" style="margin: 7px 10px;" />

                    <div class="form-group margin-bottom-lg">
                        <label class="checkbox-inline">
                            <input id="searchbar-hidden" class="checkbox" type="checkbox" />
                            Hide <b>Search Bar</b> </label>
                    </div>
                    <h4 class="padding-left-sm">Layout Options</h4>
                    <div class="form-group">
                        <label class="radio-inline">
                            <input class="radio" type="radio" name="optionsRadios" id="fullwidth-option" checked="" />
                            Fullwidth </label>
                    </div>
                    <div class="form-group">
                        <label class="radio-inline">
                            <input class="radio" type="radio" name="optionsRadios" id="boxed-option" />
                            Boxed Layout</label>
                    </div>
                    <hr class="short" />

                </form>
            </div>
        </div>
        <!-- End: Theme Preview Pane --> 

        <!-- Start: Header -->
        <header class="navbar navbar-fixed-top">
            <div class="pull-left"> <a class="navbar-brand" href="<?php echo site_url('admin/index'); ?>">
                    <div class="navbar-logo"><img src="<?php echo base_url('public/admin'); ?>/img/logos/karmora-websiteLogo.png" class="img-responsive" alt="logo" /></div>
                </a> </div>
            <div class="pull-right header-btns">

                <div class="btn-group user-menu">
                    <button type="button" class="btn btn-sm dropdown-toggle" data-toggle="dropdown"> <span class="glyphicons glyphicons-user"></span>
                        <b>
                            <?php
                            if ($this->session->userdata('admin_data') != "") {
                                echo $this->session->userdata['admin_data']['username'];
                            }
                            ?>
                        </b> 
                    </button>
                    <button type="button" class="btn btn-sm dropdown-toggle padding-none" data-toggle="dropdown">  </button>
                    <ul class="dropdown-menu checkbox-persist" role="menu">
                        <li class="menu-arrow">
                            <div class="menu-arrow-up"></div>
                        </li>
                        <li class="dropdown-header">Your Account <span class="pull-right glyphicons glyphicons-user"></span></li>
                        <li>
                            <ul class="dropdown-items">
                                <li>
                                    <div class="item-icon"><i class="fa fa-envelope-o"></i> </div>
                                    <a class="item-message" href="#">Messages</a> </li>
                                <li>
                                    <div class="item-icon"><i class="fa fa-calendar"></i> </div>
                                    <a class="item-message" href="#">Calendar</a> </li>
                                <li class="border-bottom-none">
                                    <div class="item-icon"><i class="fa fa-cog"></i> </div>
                                    <a class="item-message" href="#">Settings</a> </li>
                                <li class="padding-none">
                                    <div class="dropdown-lockout"><i class="fa fa-lock"></i> <a href="#">Edit Profile</a></div>
                                    <div class="dropdown-signout"><i class="fa fa-sign-out"></i> <a href="<?php echo site_url() ?>admin/logout">Sign Out</a></div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </header>
        <!-- End: Header --> 