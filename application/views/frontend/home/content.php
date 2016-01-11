
<!-- Karmora Specials -->
<section class="karmora-specials">
  <div class="container">
    <div class="row">
      <div class="section-heading">
          <h1>Karmora Specials</h1>
          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit sumit abel</p>
      </div>

      <?php if(!empty($fet_products)){ ?>
      <div class="karmora-product-cover">
      <!-- Single Product Cover -->
      <?php foreach ($fet_products as $pro) { ?>
      
      <div class="col-md-3">
          <div class="k-product-single-cover">
              <div class="k-img-procover">
                 <img src="<?php echo $pro['product_image']; ?>">                 
              </div>
             <!--  <div class="k-img-hover">
                  <img src="images/hover-prod.png">
                </div> -->
              <div class="k-prod-des">
                <h3><?php echo $pro['product_name']; ?></h3>
                <div class="k-price">$<?php echo $pro['product_price']; ?></div>
                <div class="start-rating-cover">
                    <div class="stars">
                      <form action="">
                        <input class="star star-5" id="star-5" type="radio" name="star"/>
                        <label class="star star-5 sactive" for="star-5"></label>
                        <input class="star star-4" id="star-4" type="radio" name="star"/>
                        <label class="star star-4 sactive" for="star-4"></label>
                        <input class="star star-3" id="star-3" type="radio" name="star"/>
                        <label class="star star-3 sactive" for="star-3"></label>
                        <input class="star star-2" id="star-2" type="radio" name="star"/>
                        <label class="star star-2" for="star-2"></label>
                        <input class="star star-1" id="star-1" type="radio" name="star"/>
                        <label class="star star-1" for="star-1"></label>
                      </form>
                   </div>
                </div>
                <div class="k-prod-hover">
                    <p><?php echo $pro['product_short_description']; ?></p>
                    <a href="<?php echo base_url().'product-detail/'.$pro['pk_product_id']; ?>">Shop Now</a>
                </div>
              </div>
          </div>        
      </div>
       
      <?php } ?>

      <!-- Single Product Cover -->
      
      </div> 

      <?php } ?>

    <div class="view-all-btn col-md-12">
        <a href="#">VIEW ALL KARMORA SPECIALS</a>
    </div>

    <div class="exclusive-deal-label">
       <a href="#">Exclusive Deals</a>
    </div>

    </div>
  </div>
</section>

<!-- Beauty and quality product section -->

<section class="karmora-bq-products">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="k-beauty-content">
         <h3>BEAUTIFUL & QUALITY</h3>
         <h1>KARMORA PRODUCTS</h1>
         <p>Quality Products for a Happier, Healthier & Wealthier You!</p>
        <a href="#" class="check-product-btn view-all-btn">CHECK PRODUCTS</a>
        <div class="clearfix"></div>
        </div>
        <div class="k-beauty-banner">
            <img src="<?php echo $themeUrl ?>/images/beauty-quality-product.jpg">
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Karmora Kash Back section -->

<section class="karmora-cb">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
       
        <div class="k-beauty-banner">
            <img src="<?php echo $themeUrl ?>/images/kash-back-banner.jpg">
        </div>

         <div class="k-kashback">
         <h3>UP TO</h3>
         <h1>30% OFF CASH BACK</h1>
         <p>Win Cold Hard Cash from your favourite store with Karmora </p>
        <a href="<?php echo base_url().'store'; ?>" class="check-product-btn view-all-btn">Check All Stors</a>
        <div class="clearfix"></div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Win Some Cold Hard Cash section -->

<section class="karmora-win">
  <div class="container">
    <div class="row">
       <div class="section-heading">
          <h1>Win Some Cold Hard CASH!</h1>
          <p>Win Great Prizes just by browsing your personal Karmora Website!</p>
      </div>
      <div class="win-hard-cash-circles">
          <div class="singl-circle yellow-light left-circle">
              <div class="icon-cover">
                <img src="<?php echo $themeUrl ?>/images/dollar.png">
                <div class="circle-title">
                  #WhereIsKarmoraKevin
                </div>
              </div>
              
          </div>
          <div class="singl-circle green-light center-circle">
              <div class="icon-cover">
                <img src="<?php echo $themeUrl ?>/images/t-shirt.png">
                <div class="circle-title">
                  #WhereIsKarmoraKevin
                </div>
              </div>
              
          </div>
          <div class="singl-circle blue-light right-circle">
              <div class="icon-cover">
                <img src="<?php echo $themeUrl ?>/images/gift.png">
                <div class="circle-title">
                  #WhereIsKarmoraKevin
                </div>
              </div>
              
          </div>
      </div>

    </div>
  </div>
</section>

<!-- Clients Slider -->
<section class="karmora-clients">
  <div class="container">
  <?php if (!empty($FeturdStores)) { ?>
    <div class="row">
      <div class="customNavigation col-md-1 col-md-offset-1">
        <a class="btn prev custom-arrow"><i class="fa fa-angle-left"></i></a>                               
      </div>
      <div class="col-md-8">
        <div id="owl-demo" class="owl-carousel">
          <?php
              foreach ($FeturdStores as $feature) {
                    ?>
                    <div class="item"> 
                        <a href="<?php echo base_url('store-detail/' . $feature['store_id']); ?>" target="_blank"><img src="<?php echo $themeUrl ?>/images/store/<?php echo $feature['store_logo']; ?>" alt="<?php echo $feature['store_title']; ?>"></a> 
                    </div>
                    <?php } ?>
            </div>            
      </div>

      <div class="customNavigation col-md-1">
                 <a class="btn next custom-arrow"><i class="fa fa-angle-right"></i></a>
      </div>
    </div>
    <?php } ?>
  </div>
</section>

