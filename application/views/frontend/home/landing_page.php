 <!-- Landing Paras -->
   <section class="landing-para-sec">
     <div class="container">
       <div class="row">
         <div class="col-xs-12 col-sm-12col-md-12 col-lg-12">
           <div class="para-cover text-center">
             <p>Joining my <span class="highlighted-pink">Karmora Shopping Community</span> and earning up to <span class="highlighted-pink">30% Cash Back</span> on your online purchases is <span class="highlighted-pink">FREE</span> and <span class="highlighted-pink">Easy…</span></p>
             <p>Building your own <span class="highlighted-pink">Karmora Shopping Community</span> where you can earn up to <span class="highlighted-pink">50% Commission</span> on <span class="highlighted-pink">Every Purchase</span> made by your Shoppers is absolutely <span class="highlighted-pink">Brilliant!</span></p>
           </div>
         </div>
       </div>
     </div>
   </section>

   <section class="video-screen">
     <div class="container">
       <div class="row">
         <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
           <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 nopadding">
             <div class="karmora-video-cover">
                <iframe src="<?php echo $themeUrl ?>/images/themeimages/saved_resource.html" frameborder="0" allowfullscreen=""></iframe>
             </div>
           </div>
           <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 nopadding">
             <div class="karmora-video-text">
                <div class="founder-content">
                  <div class="found-img">
                    <?php if(isset($banner_detail) && $banner_detail['profile_pic'] != ''){ ?>  
                        <a <?php if ($this->session->userdata('front_data')) { ?> href="<?php echo base_url().'profile'; ?>" <?php }else{ echo 'href="#"';} ?>>
                            <img style="width: 68px; height: 68px;" class="img-responsive" src="<?php echo $themeUrl ?>/images/profile-pic/<?php echo $banner_detail['profile_pic']; ?>" alt="" />
                        </a>
                    <?php }else{ ?>
                      <a <?php if ($this->session->userdata('front_data')) { ?> href="<?php echo base_url().'profile'; ?>" <?php }else{ echo 'href="#"';} ?>>
                          <img src="<?php echo $themeUrl ?>/images/themeimages/team-founder.png" alt="" />
                      </a>
                    <?php } ?> 
                  </div>
                  <div class="founder-info">
                    <h4><?php echo $banner_detail['username']; ?></h4>
                    <?php if(isset($banner_detail) && $banner_detail['member_location'] != ''){ ?> 
                        <p><?php echo $banner_detail['member_location']; ?></p>
                    <?php } ?>
                    <p><img src="<?php echo $themeUrl ?>/images/themeimages/founder-badge.jpg" alt=""> <?php echo $banner_detail['user_account_type']; ?></p>
                  </div>
                </div>
                <div class="clearfix"></div>
                <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 col-lg-offset-1">
                <div class="kar-steps-cover">
                  <ul class="list-unstyled list-inline">
                    <li>
                      <div class="wifi-icon">
                          <i class="fa fa-wifi"></i>
                      </div>
                      <div class="kar-steps text-center">
                        <p>Step 1</p>
                        <p>Creat an account</p>
                      </div>

                    </li>
                    <li>
                      <div class="wifi-icon">
                          <i class="fa fa-wifi"></i>
                      </div>
                      <div class="kar-steps text-center">
                        <p>Step 2</p>
                        <p>Shop</p>
                      </div>

                    </li>
                    <li>
                      <div class="wifi-icon">
                          <i class="fa fa-wifi"></i>
                      </div>
                      <div class="kar-steps text-center">
                        <p>Step 3</p>
                        <p>Earn</p>
                      </div>

                    </li>
                  </ul>
                  <h5>Enter your details below to get started.</h5>
                  <div class="account-form">
                      <form  method="POST" id="form" name="form">
                      <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 col-lg-offset-2 col-md-offset-2 col-sm-offset-2 ">
                          <span class="error_msg"></span>
                        <div class="form-group">                      
                            <input type="email" required="required" name="email_address" class="form-control" id="" placeholder="Enter your email">
                        </div>
                        <div class="form-group">                      
                            <input type="text" required="required" name="user_name" class="form-control" id="" placeholder="Enter your name">
                        </div>
                          <input type="hidden" name="redirectUrl" value="<?php echo $_SERVER['REQUEST_URI']; ?>">
                          <button type="button" onclick="signup()" class="btn start-btn">Start</button>
                      </div>
                      
                    </form>
                  </div>
                  </div>
                </div>
                <div class="clearfix"></div>
             </div>
           </div>

         </div>
       </div>
     </div>
   </section>

   <section class="save-money-sec">
     <div class="container">
       <div class="row">
         <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
           <div class="save-money-head text-center">
             <h1>Save Money… Make Money… Win Cash &amp; Prizes!</h1>
           </div>
           <div class="cb-retail-mall">
             <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
               <div class="cb-retail-left">
                 <h1>Cash Back Retail Mall</h1>
                 <p>Shopping Online Never Felt So Good!</p>
                 <ul class="list-unstyled cb-retail-left-ul">
                   <li>Earn up to 30% Cash Back at over 2,000 online stores</li>
                   <li>Earn Commissions and Bonuses on Retail Mall Purchases</li>
                   <li>Earn $50 Karmora Kash just for joining… for FREE!</li>
                   <li>Win up to $100 Cash in a single “Click 2 Win”</li>
                 </ul>
                 <p class="cb-b-para">Did you know… this year over 200 Million US consumers will spend more than 
$400 Billion shopping online! Start building your Shopping Community today 
and grab up all the top shoppers before someone else does!</p>
               </div>
             </div>
             <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <div class="cb-retail-mall-img">
                    <img src="<?php echo $themeUrl ?>/images/themeimages/upto-30.png" alt="">
                    <a href="" class="pull-right btn surf-retail-btn">Surf the Retail Mall</a>
                </div>
             </div>
             <div class="clearfix"></div>
           </div>
         </div>
       </div>
     </div>
   </section>

  <section class="kem-sec">
     <div class="container">
       <div class="row">
         <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
              <div class="kem-cover">
              <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <div class="kem-img">
                    <img src="<?php echo $themeUrl ?>/images/themeimages/kemall-img.png" alt="">
                    <a href="" class="pull-left btn kemall-btn">Surf the Exclusive Mall</a>
                </div>
             </div>
             <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
               <div class="kem-content">
                 <h1>Karmora Exclusive Mall</h1>
                 <p>Quality Products for a Happier, Healthier and Wealthier You!</p>
                 <ul class="list-unstyled kem-content-ul">
                   <li>High Quality, All Natural, Toxic Free Skin Care Products</li>
                   <li>High Quality, All Natural, Diet &amp; Weight Loss Supplements</li>
                   <li>Great Deals on Exclusive Clothing, Jewelry &amp; Accessories</li>
                   <li>Save up to 50% oﬀ MSRP on your personal purchases</li>
                   <li>Earn up to 50% Commissions &amp; Bonuses</li>
                 </ul>
                 <p class="cb-b-para">Exclusive Tip… Join today for FREE and earn $50 Karmora Kash. Download the Cash Back Toolbar and earn another $25 for a total of $75 Karmora Kash without spending a penny! Now use it to make your ﬁrst Exclusive Mall Purchase or upgrade to Premier Shopper!</p>
               </div>
             </div>
             
             <div class="clearfix"></div>
           </div>
         </div>
       </div>
     </div>
   </section>

   <section class="wgcp-sec">
     <div class="container">
       <div class="row">
         <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="wgcp-head text-center">
              <h1>Win Great Cash &amp; Prizes</h1>
              <p>We want you to have FUN when shopping with Karmora! And… what could be more fun 
than winning great Cash &amp; Prizes!</p>
            </div>
            <div class="wgcp-boxes">
              <ul class="wgcp-ul list-unstyled list-inline">
                <li>
                  <div class="wgcp-li-box">
                    <img src="<?php echo $themeUrl ?>/images/themeimages/wgcp-box1.jpg" alt="">
                  </div>
                  <a href="" class="btn wgcp-btn">Surf Click 2 Win</a>
                </li>
                <li>
                  <div class="wgcp-li-box">
                    <iframe src="<?php echo $themeUrl ?>/images/themeimages/saved_resource.html" frameborder="0" allowfullscreen=""></iframe>
                  </div>
                  <a href="" class="btn wgcp-btn">Surf Pay 4 My Purchase</a>
                </li>
                <li>
                  <div class="wgcp-li-box">
                    <img src="<?php echo $themeUrl ?>/images/themeimages/wgcp-2.jpg" alt="">
                  </div>
                  <a href="" class="btn wgcp-btn">Surf Karmora Kash</a>
                </li>
              </ul>
            </div>
         </div>
       </div>
     </div>
   </section>
   <section class="training-support-sec">
     <div class="container">
       <div class="row">
         <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
           <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
           <div class="training-support-cover">
             <h1>Training &amp; Support</h1>
             <p>
Learn how our most successful Premier Shoppers have leverged 
our proprietary training and online marketing technologies to build 
some of Karmora’s most proﬁtable Shopping Communities!</p>
          </div>
           </div>
           <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
             <div class="training-right-img">
               <img src="<?php echo $themeUrl ?>/images/themeimages/training-img.jpg" alt="">
             </div>
           </div>
           <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
             <a href="" class="btn wgcp-btn sest-btn">Surf Exclusive Services &amp; Training</a>
           </div>
         </div>
       </div>
     </div>
   </section>

   <section class="about-sec-landing">
     <div class="container">
       <div class="row">
         <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
           <div class="landing-about">
             <h1 class="text-right">About Us</h1>
            <p>Headquartered in Scottsdale, Arizona, Karmora is the collaborative creation of a seasoned sales professional with more than 30 years of retail experience and a group of the brightest physicians, aestheticians, web developers, programmers and online marketing experts across the globe...</p>
            <a href="" class="btn wgcp-btn pull-right">Read on...</a>

           </div>
         </div>
       </div>
     </div>
   </section>

   <section class="our-mission-sec">
     <div class="container">
       <div class="row">
         <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
         <div class="ourmission-content">
           <h1>Our Mission Is 2 Simple</h1>
           <ul class="list-unstyled">
             <li>To provide our Shoppers with a fun and exciting environment where they can save money, make money, and win cash and prizes together as a Community! </li>
             <li>To provide our Premier Shoppers with the tools, guidance and training needed to help even the most inexperienced online marketer build the largest, most profitable Shopping Community possbile!   </li>
           </ul>
           </div>
         </div>
       </div>
     </div>
   </section>

<!-- Exclusive Products -->
    <section class="products-sec evlkep-pink">
      <div class="container"> 
        <h1 class="vid-h1">What do our Shoppers Think?</h1>
        <div class="pro-con product-box-cover landing-videos">
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
        </div>
        <div class="col-md-3 col-xs-3 col-sm-3">
          <div class="video-con product-video-con video-k-email">
            <a href="#">
              <img class="img-responsive" src="<?php echo $themeUrl ?>/images/themeimages/video-2.jpg">
              <i class="fa fa-youtube-play player-play-btn"></i>
            </a>
          </div>         
        </div>
        <div class="col-md-3 col-xs-3 col-sm-3">
          <div class="video-con product-video-con video-k-email">
            <a href="#">
              <img class="img-responsive" src="<?php echo $themeUrl ?>/images/themeimages/video-2.jpg">
              <i class="fa fa-youtube-play player-play-btn"></i>
            </a>
          </div>          
        </div>
        <div class="col-md-3 col-xs-3 col-sm-3">
          <div class="video-con product-video-con video-k-email">
            <a href="#">
              <img class="img-responsive" src="<?php echo $themeUrl ?>/images/themeimages/video-2.jpg">
              <i class="fa fa-youtube-play player-play-btn"></i>
            </a>
          </div>
          
         <a href="" class="btn wgcp-btn pull-right">More Videos</a>
        </div>
        
              
        </div>
             </div>
          </div> 
        </div>
 
    
       </div>
    </section>

    
    <!-- Ways To Join karmora -->
    <section class="products-con">
      <div class="container">
        <div class="row text-center">
          <div class="ways-tjk">
            <h2>2 GREAT WAYS TO JOIN KARMORA!</h2>
          </div>
        </div>
        <div class="row">
           <div class="col-md-4 col-md-offset-1 pt-1 col-sm-3 panel-center">
              <div class="panel panel-default"> 
                <div class="panel-heading pannel-custom1">
                  <h3 class="panel-title">Casual <span>Shopper</span></h3>
                </div> 
                <div class="panel-body">
                  <ul class="paneel-custom-body">
                    <li>
                      <div class="col-md-2 custom-mrgn">
                        <i class="iconz"><img src="<?php echo $themeUrl ?>/images/themeimages/store.png" alt="icon"></i>
                      </div>
                      <div class="col-md-10 custom-mrgn">
                        <p>Earn Top Cash Back at over 2,000 Name Brand Stores!</p>
                      </div>
                    </li>
                    <li>
                      <div class="col-md-2 custom-mrgn">
                        <i class="iconz">
                          <img src="<?php echo $themeUrl ?>/images/themeimages/cart.png" alt="icon">
                        </i>
                      </div>
                      <div class="col-md-10 custom-mrgn">
                        <p>Shop Karmora Exclusive Product Lines!</p>
                      </div> 
                    </li>
                    <li>
                      <div class="col-md-2 custom-mrgn">
                        <i class="iconz">
                          <img src="<?php echo $themeUrl ?>/images/themeimages/baja.png" alt="icon">
                        </i>
                      </div>
                      <div class="col-md-10 custom-mrgn">
                        <p>Earn $10 Karmora Kash for every referral!</p>
                      </div>
                    </li>
                    <li>
                      <div class="col-md-2 custom-mrgn">
                        <i class="iconz"><img src="<?php echo $themeUrl ?>/images/themeimages/giftbox.png" alt="icon"></i>
                      </div>
                      <div class="col-md-10  custom-mrgn">
                        <p>Win great cash prizes and much more...</p>
                      </div>
                    </li>
                  </ul>
                </div>
                <div class="panel-footer custom-pannel-footer">Sign Up for FREE! </div>
              </div>
           </div>         

           <div class="col-md-1 col-sm-1">&nbsp;</div>
           <div class="col-md-4 pt-3 col-sm-3">
              <div class="panel panel-default"> 
                <div class="panel-heading pannel-custom1">
                  <h3 class="panel-title">Premier <span> Shopper </span></h3>
                </div> 
                <div class="panel-body">
                  <ul class="paneel-custom-body">
                    <li>
                      <div class="col-md-2 custom-mrgn">
                        <i class="iconz"><img src="<?php echo $themeUrl ?>/images/themeimages/store.png" alt="icon"></i>
                      </div>
                      <div class="col-md-10 custom-mrgn">
                        <p>Earn the MAXIMUM cash back on all of your Karmora Purchases!</p>
                      </div>
                    </li>
                    <li>
                      <div class="col-md-2 custom-mrgn">
                        <i class="iconz"><img src="<?php echo $themeUrl ?>/images/themeimages/cart.png" alt="icon"></i>
                      </div>
                      <div class="col-md-10 custom-mrgn">
                        <p>Earn the MAXIMUM Discounts on Exclusive Karmora Product Lines!</p>
                      </div>
                    </li>
                    <li>
                      <div class="col-md-2 custom-mrgn">
                        <i class="iconz"><img src="<?php echo $themeUrl ?>/images/themeimages/sk.png" alt="icon"></i>
                       </div>
                       <div class="col-md-10 custom-mrgn">
                        <p>Get paid while building your Shopping Community!</p>
                       </div>
                    </li>
                    <li>
                      <div class="col-md-2 custom-mrgn">
                        <i class="iconz"><img src="<?php echo $themeUrl ?>/images/themeimages/hand-shake.png" alt="icon"></i>
                      </div>
                      <div class="col-md-10 custom-mrgn">
                        <p>Premier Shoppers participate in the most generous online shopping compensation plan on the planet and much, much more.</p>
                      </div>
                    </li>
                  </ul>
                </div>
                <div class="panel-footer custom-pannel-footer">Create your Shopping Community! </div>
              </div>
         </div>
             
           
        </div>
      </div>
    </section>
  <!-- Cards -->
    <div class="container-fluid cards-con">
      <ul class="list-inline text-center">
      <li><a href="#"><img src="<?php echo $themeUrl ?>/images/themeimages/visa.jpg" alt="card"></a></li>
      <li><a href="#"><img src="<?php echo $themeUrl ?>/images/themeimages/master.jpg" alt="card"></a></li>
      <li><a href="#"><img src="<?php echo $themeUrl ?>/images/themeimages/discover.png" height="100" alt="card"></a></li>
      <li><a href="#"><img src="<?php echo $themeUrl ?>/images/themeimages/norton.jpg" alt="card"></a></li> 
    </ul> 
    </div>
    <!-- ./ Cards -->
