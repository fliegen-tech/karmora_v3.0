<!-- Sidebar + Slider-->
<section class="siderslider">
    <div class="container">
        <div class="row">
            <!-- left links -->
            <?php $this->load->view('frontend/layout/partials/category'); ?>
            <!-- / left link -->

            <!-- Slider Area -->
            <div class="col-md-8 col-sm-8">
                <div class="welcome-heding k-r-mall">
                    <h2>Welcome to <span class="kormora-text">Karmora</span> <span class="kormora-text orange-color">Retail Mall</span></h2>
                    <img src="<?php echo $themeUrl ?>/images/themeimages/welcome-border-2.png">				
                    <div class="clearfix"></div>
                </div>
                <div class="clearfix"></div>
                <div class="slider-wrapper theme-default">
                    <div id="slider" class="nivoSlider">
                        <a href="#" class="nivo-imageLink" style="display: block;">
                            <img src="<?php echo $themeUrl ?>/images/themeimages/slider-img-1.png" data-thumb="" alt="Slide Title" style="width: 750px; visibility: hidden; display: inline;">
                        </a>
                        <a href="#" class="nivo-imageLink" style="display: none;">
                            <img src="<?php echo $themeUrl ?>/images/themeimages/slider-img-1.png" data-thumb="" alt="Slide Title" style="width: 750px; visibility: hidden; display: inline;">
                        </a>
                        <a href="#" class="nivo-imageLink" style="display: none;">
                            <img src="<?php echo $themeUrl ?>/images/themeimages/slider-img-1.png" data-thumb="" alt="Slide Title" style="width: 750px; visibility: hidden; display: inline;">
                        </a>
                        <div class="nivo-caption"></div>
                        <div class="nivo-directionNav"><a class="nivo-prevNav">Prev</a>
                            <a class="nivo-nextNav">Next</a></div></div><div class="nivo-controlNav">
                                <a class="nivo-control active" rel="0">1</a><a class="nivo-control" rel="1">2</a>
                                <a class="nivo-control" rel="2">3</a>
                        </div>
                    <div class="clearfix"></div>
                </div>

            </div>
            <!-- ./Slider Area -->

            <!-- Right SidebarSlider -->
            <div class="col-md-2 col-sm-2">
                <div class="right-sidebar p0">
                    <div class="title-asid-img upload-photo">
                        <?php if (isset($banner_detail) && $banner_detail['profile_pic'] != '') { ?>
                            <a <?php if ($this->session->userdata('front_data')) { ?> href="<?php echo base_url() . 'profile'; ?>" <?php } else {
                            echo 'href="#"';
                        } ?>>
                                <img style="width: 66px; height: 93px;" class="img-responsive" src="<?php echo $themeUrl ?>/images/profile-pic/<?php echo $banner_detail['profile_pic']; ?>" alt="" />
                            </a>
                        <?php } ?>   
                        <h2> <?php echo $banner_detail['username']; ?>  </h2>
                        <?php if (isset($banner_detail) && $banner_detail['member_location'] != '') { ?> 
                            <span><?php echo $banner_detail['member_location']; ?> </span>
<?php } ?>
                        <p><?php echo $banner_detail['user_account_type']; ?></p>
                    </div>
                    <div class="clearfix"></div>
                    <div class="img-holder left-banner retail-left-banner">
                        <img src="<?php echo $themeUrl ?>/images/themeimages/pink-k-kash-banner.png" alt="Free shopping community">
                    </div>

                </div>
            </div>
            <!-- ./Right SidebarSlider -->
        </div>
    </div>
</section>
<!-- /. Sidebar + Slider -->

<!-- Karmora Retail Mall -->
<section class="products-sec">
    <div class="container"> 
        <div class="retail-sec-heading text-center">
            <img src="<?php echo $themeUrl ?>/images/themeimages/heading-retail.png" alt="">
        </div>
        <div class="download-con">
            <h2> <i class="bags-icon"></i> Karmora Retail Mall - Shop &amp; Earn Cash Back at Your Favorite Stores </h2>  
            <div class="products-mrgn"> 
                <div class="col-md-2 col-sm-3 btm-mrgn">
                    <div class="rating-con">
                        <div class="sm-logo"><img src="<?php echo $themeUrl ?>/images/themeimages/logo.png" alt="Karmora"></div>
                        <img src="<?php echo $themeUrl ?>/images/themeimages/tar.jpg" alt="macys">
                        <div class="rating-bar-bottom">
                            <div class="cash-back-upto">Cash Back up to 60%</div>
                            <a href="#" class="click-btn">Click Here</a>
                            <ul class="list-inline list-sharing-icons">
                                <li><a href="#"><img src="<?php echo $themeUrl ?>/images/themeimages/share-fb.jpg" class="share-fb"></a></li>
                                <li><a href="#"><img src="<?php echo $themeUrl ?>/images/themeimages/share-tw.png" class="share-tw"></a></li>
                                <li><a href="#"><img src="<?php echo $themeUrl ?>/images/themeimages/share-pin.png" class="share-pin"></a></li>
                            </ul>
                        </div>
                    </div>
                </div> 
                <div class="col-md-2 col-sm-3 btm-mrgn">
                    <div class="rating-con">
                        <div class="sm-logo"><img src="<?php echo $themeUrl ?>/images/themeimages/logo.png" alt="Karmora"></div>
                        <img src="<?php echo $themeUrl ?>/images/themeimages/tar.jpg" alt="macys">
                        <div class="rating-bar-bottom">
                            <div class="cash-back-upto">Cash Back up to 60%</div>
                            <a href="#" class="click-btn">Click Here</a>
                            <ul class="list-inline list-sharing-icons">
                                <li><a href="#"><img src="<?php echo $themeUrl ?>/images/themeimages/share-fb.jpg" class="share-fb"></a></li>
                                <li><a href="#"><img src="<?php echo $themeUrl ?>/images/themeimages/share-tw.png" class="share-tw"></a></li>
                                <li><a href="#"><img src="<?php echo $themeUrl ?>/images/themeimages/share-pin.png" class="share-pin"></a></li>
                            </ul>
                        </div>
                    </div>
                </div> 

                <div class="col-md-2 col-sm-3 btm-mrgn">
                    <div class="rating-con">
                        <div class="sm-logo"><img src="<?php echo $themeUrl ?>/images/themeimages/logo.png" alt="Karmora"></div>
                        <img src="<?php echo $themeUrl ?>/images/themeimages/tar.jpg" alt="macys">
                        <div class="rating-bar-bottom">
                            <div class="cash-back-upto">Cash Back up to 60%</div>
                            <a href="#" class="click-btn">Click Here</a>
                            <ul class="list-inline list-sharing-icons">
                                <li><a href="#"><img src="<?php echo $themeUrl ?>/images/themeimages/share-fb.jpg" class="share-fb"></a></li>
                                <li><a href="#"><img src="<?php echo $themeUrl ?>/images/themeimages/share-tw.png" class="share-tw"></a></li>
                                <li><a href="#"><img src="<?php echo $themeUrl ?>/images/themeimages/share-pin.png" class="share-pin"></a></li>
                            </ul>
                        </div>
                    </div>
                </div> 

                <div class="col-md-2 col-sm-3 btm-mrgn">
                    <div class="rating-con">
                        <div class="sm-logo"><img src="<?php echo $themeUrl ?>/images/themeimages/logo.png" alt="Karmora"></div>
                        <img src="<?php echo $themeUrl ?>/images/themeimages/tar.jpg" alt="macys">
                        <div class="rating-bar-bottom">
                            <div class="cash-back-upto">Cash Back up to 60%</div>
                            <a href="#" class="click-btn">Click Here</a>
                            <ul class="list-inline list-sharing-icons">
                                <li><a href="#"><img src="<?php echo $themeUrl ?>/images/themeimages/share-fb.jpg" class="share-fb"></a></li>
                                <li><a href="#"><img src="<?php echo $themeUrl ?>/images/themeimages/share-tw.png" class="share-tw"></a></li>
                                <li><a href="#"><img src="<?php echo $themeUrl ?>/images/themeimages/share-pin.png" class="share-pin"></a></li>
                            </ul>
                        </div>
                    </div>
                    <a href="#" class="btn btn_default pull-right product-btn">All Stores</a>
                </div> 

                <div class="col-md-4">
                    <img src="<?php echo $themeUrl ?>/images/themeimages/video-2.jpg" height="220" width="350">
                    <ul class="list-inline video-sharing-icons">
                        <li><a href="#"><img src="<?php echo $themeUrl ?>/images/themeimages/share-fb.jpg" class="share-fb"></a></li>
                        <li><a href="#"><img src="<?php echo $themeUrl ?>/images/themeimages/share-tw.png" class="share-tw"></a></li>
                        <li><a href="#"><img src="<?php echo $themeUrl ?>/images/themeimages/share-pin.png" class="share-pin"></a></li>
                    </ul>
                    <a href="#" class="btn btn_default pull-right view-videos-btn">All Videos</a> 
                </div>
            </div>
        </div>
    </div>
</section>
<!-- / Karmora Retail Mall -->

<!-- KarmaCash -->
<section class="products-con">
    <div class="container">
        <div class="row">
            <!-- Left karmora left -->
            <div class="col-md-7">
                <div class="karmoracash-con">
                    <h2> <i class="fa fa-sitemap"></i>Build A Shopping Community &amp; Get Paid</h2>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-2 col-sm-2">
                                <div class="row">
                                    <img src="<?php echo $themeUrl ?>/images/themeimages/dol1.png" alt="fairy" class="dolls">
                                </div>
                            </div>
                            <div class="col-md-8 col-sm-8">
                                <div class="row">
                                    <div class="steping-con">
                                        <ul class="steping list-inline">
                                            <li class="number-control">
                                                <a href="#"><i class="fa fa-level-up"></i><em>Upgrade</em></a>
                                                <span>Become a Premier Shopper Today!</span>
                                                <div class="butn-number">1</div>
                                            </li>
                                            <li class="number-control">
                                                <a href="#"><i class="fa fa-user-plus"></i><em>Share</em></a>
                                                <span>Ask your friends, family and acquaintances to join for free!</span>
                                                <div class="butn-number">2</div>
                                            </li>
                                            <li class="number-control">
                                                <a href="#"><i class="fa fa-money"></i> <em>Get Paid</em></a>
                                                <span>Get Paid!</span>
                                                <div class="butn-number">3</div>
                                            </li>
                                        </ul> 
                                        <div class="shape"></div> 
                                    </div>
                                </div>
                                <div class="row evlkep-pink">
                                    <a href="#" class="btn btn-primary view-btn">View Details</a>
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-2">
                                <div class="row">
                                    <img src="<?php echo $themeUrl ?>/images/themeimages/dol2.png" alt="fairy" class="dolls"> 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ./Left karmora Cash -->
            </div>
            <div class="col-md-5 col-sm-12">
                <!-- ./Rightside karmora Cash -->
                <div class="karmora-right-con evlkep-pink">
                    <h2><i class="fa fa-video-camera"></i>Pay 4 My Purchase <a href="#" class="btn btn-default view-detail btn-video-detail">View Details</a> </h2>
                    <div class="video-con">
                        <img src="<?php echo $themeUrl ?>/images/themeimages/video-2.jpg">
                        <i class="fa fa-youtube-play player-video"></i>
                    </div>
                </div>
                <!-- ./Rightside karmora Cash -->
            </div>
        </div>
    </div>
</section>
<!-- ./ KarmaCash -->

<!-- Exclusive Products -->
<section class="products-sec evlkep-pink">
    <div class="container"> 
        <div class="pro-con product-box-cover">
            <h2> <i class="heart-icon"></i> Everyone Loves Cash Back Shopping with Karmora! </h2> 
            <div class="products-mrgn">
                <div class="col-md-12 col-sm-12">
                    <div class="row">
                        <div class="col-md-3 col-xs-3 col-sm-3">
                            <div class="video-con product-video-con video-k-email">
                                <a href="#">
                                    <img class="img-responsive" src="<?php echo $themeUrl ?>/images/themeimages/video-2.jpg">
                                    <i class="fa fa-youtube-play player-play-btn"></i>
                                </a>
                            </div>
                            <ul class="list-inline list-video-icons">
                                <li><a href="#"><img src="<?php echo $themeUrl ?>/images/themeimages/share-fb.jpg" class="share-fb"></a></li>
                                <li><a href="#"><img src="<?php echo $themeUrl ?>/images/themeimages/share-tw.png" class="share-tw"></a></li>
                                <li><a href="#"><img src="<?php echo $themeUrl ?>/images/themeimages/share-pin.png" class="share-pin"></a></li>
                            </ul>
                        </div>
                        <div class="col-md-3 col-xs-3 col-sm-3">
                            <div class="video-con product-video-con video-k-email">
                                <a href="#">
                                    <img class="img-responsive" src="<?php echo $themeUrl ?>/images/themeimages/video-2.jpg">
                                    <i class="fa fa-youtube-play player-play-btn"></i>
                                </a>
                            </div>
                            <ul class="list-inline list-video-icons">
                                <li><a href="#"><img src="<?php echo $themeUrl ?>/images/themeimages/share-fb.jpg" class="share-fb"></a></li>
                                <li><a href="#"><img src="<?php echo $themeUrl ?>/images/themeimages/share-tw.png" class="share-tw"></a></li>
                                <li><a href="#"><img src="<?php echo $themeUrl ?>/images/themeimages/share-pin.png" class="share-pin"></a></li>
                            </ul>
                        </div>
                        <div class="col-md-3 col-xs-3 col-sm-3">
                            <div class="video-con product-video-con video-k-email">
                                <a href="#">
                                    <img class="img-responsive" src="<?php echo $themeUrl ?>/images/themeimages/video-2.jpg">
                                    <i class="fa fa-youtube-play player-play-btn"></i>
                                </a>
                            </div>
                            <ul class="list-inline list-video-icons">
                                <li><a href="#"><img src="<?php echo $themeUrl ?>/images/themeimages/share-fb.jpg" class="share-fb"></a></li>
                                <li><a href="#"><img src="<?php echo $themeUrl ?>/images/themeimages/share-tw.png" class="share-tw"></a></li>
                                <li><a href="#"><img src="<?php echo $themeUrl ?>/images/themeimages/share-pin.png" class="share-pin"></a></li>
                            </ul>
                        </div>
                        <div class="col-md-3 col-xs-3 col-sm-3">
                            <div class="video-con product-video-con video-k-email">
                                <a href="#">
                                    <img class="img-responsive" src="<?php echo $themeUrl ?>/images/themeimages/video-2.jpg">
                                    <i class="fa fa-youtube-play player-play-btn"></i>
                                </a>
                            </div>
                            <ul class="list-inline list-video-icons">
                                <li><a href="#"><img src="<?php echo $themeUrl ?>/images/themeimages/share-fb.jpg" class="share-fb"></a></li>
                                <li><a href="#"><img src="<?php echo $themeUrl ?>/images/themeimages/share-tw.png" class="share-tw"></a></li>
                                <li><a href="#"><img src="<?php echo $themeUrl ?>/images/themeimages/share-pin.png" class="share-pin"></a></li>
                            </ul>
                            <a class="btn btn_default pull-right product-btn view-more-btn all-vids-btn-subpage" href="#">All Videos</a>
                        </div>


                    </div>
                </div>
            </div> 
        </div>
        <div class="col-md-6 col-md-offset-3">			
            <a class="btn btn_default pull-right product-btn submit-testimonial-btn" href="#">Submit Your Testimonial &amp; Earn $50 Karmora Kash!</a>			
        </div>

    </div>
</section>
