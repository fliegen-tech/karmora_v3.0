<section class="products-sec sec-1 not-animated">
      <div class="container"> 
        <div class="pro-con">
          <h2> <i class="quilty-icon"></i> Karmora Exclusive Mall &#45; Quality Products for a Happier, Healthier & Wealthier You! </h2> 
          <div class="products-mrgn">
            <div class="col-md-8 col-sm-8">
               <div class="row">
               <?php 
                    if(!empty($fet_products)){
                        foreach ($fet_products as $product) {
                ?>
               <div class="col-md-3 col-sm-3">
                   <a href="<?php echo base_url().'product-detail/'.$product['product_alias'];  ?>">
                    <div class="pro-items">
                      <div class="product-holder-img" style="background :url(<?php echo $themeUrl ?>/images/product/<?php echo $product['product_image']; ?>) no-repeat;"></div> 
                      <div class="title-bar">
                        <h2><?php echo $product['product_title']; ?></h2>
                        <span class="description">The Exclusive Good Karmora Box<?php echo $product['product_short_description']; ?></span>
                      </div>
                    </div>
                   </a>   
               </div>
                <?php } }?>   
               
               
            </div>
             </div>

             <div class="col-md-4 col-sm-4">
                <div class="pro-items"> 
                  <div class="product-pic-holder" style="background :url(<?php echo $themeUrl ?>/images/themeimages/video-2.jpg) no-repeat;"></div>  
                  <i class="fa fa-play-circle player"></i> 
                </div>
                <a href="#" class="btn btn_default pull-right view-videos-btn">All Videos</a> 
             </div>
          </div> 
        </div>
       </div>
    </section>