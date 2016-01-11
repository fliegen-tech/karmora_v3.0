<div id="main"> 
    <!-- Start: Sidebar -->
    <aside id="sidebar">
        <div id="sidebar-search">
            <div class="sidebar-toggle"> <i class="fa fa-bars"></i> </div>
        </div>
        <?php
        if (!isset($page)) {
            $page = '';
        } 
        ?>
        <div id="sidebar-menu">
            <ul class="nav sidebar-nav">
                <li <?php if ($page == 'dashbord') { ?>class="active" <?php } ?>>
                    <a href="<?php echo site_url(); ?>admin/admin/index">
                        <span class="glyphicons glyphicon-home"></span>
                        <span class="sidebar-title">Dashboard</span>
                    </a>
                </li>
                <li <?php if ($page == 'category') { ?>class="active" <?php } ?>> 
                    <a class="accordion-toggle collapsed" href="#manage_category">
                        <span class="glyphicons glyphicons-sort"></span>
                        <span class="sidebar-title">Category</span>
                        <span class="caret"></span>
                    </a>
                    <ul id="manage_category" class="nav sub-nav">
                        <li><a href="<?php echo base_url('admin/category'); ?>"><span class="glyphicons glyphicon-list"></span> View Category</a></li>
                        <li><a href="<?php echo base_url('admin/category/add'); ?>"><span class="glyphicons glyphicon-plus"></span> Add Category</a></li>

                    </ul>
                </li>
                <li <?php if ($page == 'banner') { ?>class="active" <?php } ?>> 
                    <a class="accordion-toggle collapsed" href="#banners">
                        <span class="glyphicons glyphicons-sort"></span>
                        <span class="sidebar-title">Banners</span>
                        <span class="caret"></span>
                    </a>
                    <ul id="banners" class="nav sub-nav">
                        <li><a href="<?php echo base_url('admin/banner/index'); ?>"><span class="glyphicons glyphicon-list"></span> View Banners</a></li>
                        <li><a href="<?php echo base_url('admin/banner/add'); ?>"><span class="glyphicons glyphicon-plus"></span> Add Banner</a></li>

                    </ul>
                </li>
                
                 <li <?php if ($page == 'manage_product') { ?>class="active" <?php } ?>> 
                    <a class="accordion-toggle collapsed" href="#manage_product">
                        <span class="glyphicons glyphicons-sort"></span>
                        <span class="sidebar-title">Products</span>
                        <span class="caret"></span>
                    </a>
                    <ul id="manage_product" class="nav sub-nav">
                        <li><a href="<?php echo base_url('admin/product'); ?>"><span class="glyphicons glyphicon-list"></span> View Products</a></li>
                        <li><a href="<?php echo base_url('admin/product/add'); ?>"><span class="glyphicons glyphicon-plus"></span> Add Product</a></li>

                    </ul>
                </li>
                
                <li <?php if ($page == 'store') { ?>class="active" <?php } ?>> 
                    <a class="accordion-toggle collapsed" href="#stores">
                        <span class="glyphicons glyphicons-shopping_cart"></span>
                        <span class="sidebar-title">Stores</span>
                        <span class="caret"></span>
                    </a>
                    <ul id="stores" class="nav sub-nav">
                        <li><a href="<?php echo base_url('admin/managestore/index') ?>"><span class="glyphicons glyphicon-list"></span> View Stores</a></li>
                        <li><a href="<?php echo base_url('admin/managestore/add') ?>"><span class="glyphicons glyphicon-plus"></span> Add Store</a></li>

                    </ul>
                </li>
                
                <li <?php if ($page == 'video') { ?>class="active" <?php } ?>> 
                    <a class="accordion-toggle collapsed" href="#manage_video">
                        <span class="glyphicons glyphicons-sort"></span>
                        <span class="sidebar-title">Videos</span>
                        <span class="caret"></span>
                    </a>
                    <ul id="manage_video" class="nav sub-nav">
                        <li><a href="<?php echo base_url('admin/video'); ?>"><span class="glyphicons glyphicon-list"></span> View Video</a></li>
                        <li><a href="<?php echo base_url('admin/video/add'); ?>"><span class="glyphicons glyphicon-plus"></span> Add Video</a></li>

                    </ul>
                </li>
                
                <li <?php if ($page == 'payforpurchase') { ?>class="active" <?php } ?>> 
                    <a class="accordion-toggle collapsed" href="#payforpurchase">
                        <span class="glyphicons glyphicons-sort"></span>
                        <span class="sidebar-title">Pay4Purchase</span>
                        <span class="caret"></span>
                    </a>
                    <ul id="payforpurchase" class="nav sub-nav">
                        <li><a href="<?php echo base_url('admin/payforpurchase'); ?>"><span class="glyphicons glyphicon-list"></span> View Pay4Purchase</a></li>
                        <li><a href="<?php echo base_url('admin/payforpurchase/assigndate'); ?>"><span class="glyphicons glyphicon-plus"></span> Assign Date</a></li>

                    </ul>
                </li>
                
                <li <?php if ($page == 'mangwinnerchest') { ?>class="active" <?php } ?>> 
                    <a class="accordion-toggle collapsed" href="#mangwinnerchest">
                        <span class="glyphicons glyphicons-sort"></span>
                        <span class="sidebar-title">Treasure Chest</span>
                        <span class="caret"></span>
                    </a>
                    <ul id="mangwinnerchest" class="nav sub-nav">
                        <li><a href="<?php echo base_url('admin/mangwinnerchest/gifts'); ?>"><span class="glyphicons glyphicon-list"></span> View  Gift Type</a></li>
                        <li><a href="<?php echo base_url('admin/mangwinnerchest/addgift'); ?>"><span class="glyphicons glyphicon-plus"></span> Add  Gift Type</a></li>
                        <li><a href="<?php echo base_url('admin/mangwinnerchest/index'); ?>"><span class="glyphicons glyphicon-list"></span> View Treasure</a></li>
                        <li><a href="<?php echo base_url('admin/mangwinnerchest/add'); ?>"><span class="glyphicons glyphicon-plus"></span> Add Treasure</a></li>
                        <li><a href="<?php echo base_url('admin/mangwinnerchest/tresureuser'); ?>"><span class="glyphicons glyphicon-plus"></span> View Winner  </a></li>

                    </ul>
                </li>

                 <li <?php if ($page == 'news_sticker') { ?>class="active" <?php } ?>> 
                    <a class="accordion-toggle collapsed" href="#news_sticker">
                        <span class="glyphicons glyphicons-sort"></span>
                        <span class="sidebar-title">News Sticker</span>
                        <span class="caret"></span>
                    </a>
                    <ul id="news_sticker" class="nav sub-nav">
                        <li><a href="<?php echo base_url('admin/news_sticker/add'); ?>"><span class="glyphicons glyphicon-list"></span> Add  News Sticker</a></li>
                        <li><a href="<?php echo base_url('admin/news_sticker'); ?>"><span class="glyphicons glyphicon-plus"></span> View News Sticker</a></li>

                    </ul>
                </li>
                
                <li> 
                    <br />
                </li>  
            </ul>
        </div>
    </aside>
    <!-- End: Sidebar --> 