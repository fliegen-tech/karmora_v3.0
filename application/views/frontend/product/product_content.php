 <section class="about-sect">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
              <div class="col-md-3">
                <!-- List cover  -->
                <div class="left-product-list">
                  <div class="left-prod-list-cover">
                    <h2>Flawless Skin Care</h2>                    
                  </div>
                  <ul class="list-unstyled prod-ul-list">
                    <li><a href="#">Flawless Days</a></li>
                    <li><a href="#">Flawless Nights</a> </li>
                    <li><a href="#">Flawless Mist</a></li>
                    <li><a href="#">Flawless Days</a></li>
                  </ul>
                  <a href="" class="view-all-product-button">View All Products</a>
                </div> 
                <!-- List cover  -->
                <div class="left-product-list">
                  <div class="left-prod-list-cover">
                    <h2>Vitamins & Supplements</h2>                    
                  </div>
                  <ul class="list-unstyled prod-ul-list">
                    <li><a href="#">Weight Control</a></li>
                    <li><a href="#">Cognition</a> </li>
                    <li><a href="#">Men</a></li>
                    <li><a href="#">Women</a></li>
                  </ul>
                  <a href="" class="view-all-product-button">View All Products</a>
                </div> 
                <!-- List cover  -->
                <div class="left-product-list">
                  <div class="left-prod-list-cover">
                    <h2>Jewelery & Accessories</h2>                    
                  </div>
                  <ul class="list-unstyled prod-ul-list">
                    <li><a href="#">Product Name 1</a></li>
                    <li><a href="#">Product Name 2</a> </li>
                    <li><a href="#">Product Name 3</a></li>
                    <li><a href="#">Product Name 4</a></li>
                  </ul>
                  <a href="" class="view-all-product-button">View All Products</a>
                </div> 
                <!-- List cover  -->
                <div class="left-product-list">
                  <div class="left-prod-list-cover">
                    <h2>Weight Loss</h2>                    
                  </div>
                  <ul class="list-unstyled prod-ul-list">
                     <li><a href="#">Product Name 1</a></li>
                    <li><a href="#">Product Name 2</a> </li>
                    <li><a href="#">Product Name 3</a></li>
                    <li><a href="#">Product Name 4</a></li>
                  </ul>
                  <a href="" class="view-all-product-button">View All Products</a>
                </div> 



              </div>
              <div class="col-md-9 nopr prod-left-cov">
                <div class="karmora-product-detail">
                <div class="prodct-detail-banner">
                  <img src="<?php echo base_url() ?>public/images/themeimages/karmora-product-detail-img.jpg" alt="">
                </div>
                    <?php if(!empty($products)){ 
                            $CI =& get_instance();
                            $CI->load->model('productmodel');
                    ?> 
                <div class="prodcuts-container">
                    <div class="row">
                  <!-- prodbox 1 -->
                  <?php foreach($products as $pro) {?>
                  <div class="col-md-3 prod-box">
                      <div class="single-prod-cover">
                        <a href="#prod-modal-<?php echo $pro['pk_product_id']; ?>" class="img-link" data-toggle="modal">
                            <img src="<?php echo base_url().'public/images/product/'.$pro['product_image']; ?>" alt="">
                          <div class="searchicon">
                            <i class="fa fa-search"></i>
                            <div class="box-triangle-tranparent"></div>
                          </div>
                        </a>
                        <h3><?php echo $pro['product_title']; ?></h3>
                        <a href="" class="buy-now-btn">
                          Buy Now
                          <span><img src="<?php echo base_url() ?>public/images/themeimages/cart-buynow.png" align=""></span>
                        </a>
                      </div>

                      <!-- modal -->
                      
                      <div class="modal fade mymodalcss" id="prod-modal-<?php echo $pro['pk_product_id']; ?>">
                        <div class="modal-dialog">
                          <div class="modal-content"> 
                           <button type="button" class="close-button" data-dismiss="modal" aria-hidden="true"><span> + </span></button>  

                            <div class="modal-body">
                                <div class="col-md-5">
                                    <?php 
                                        $result = $CI->productmodel->getproductsImages($pro['pk_product_id']);
                                    ?>
                                        <div id="prod-slider_<?php echo $pro['pk_product_id']; ?>" class="carousel slide" data-ride="carousel">
                                        <ol class="carousel-indicators">
                                                <li data-target="#prod-slider_<?php echo $pro['pk_product_id']; ?>" data-slide-to="0" class="active"></li>
                                            <?php 
                                                 if(!empty($result)){  $k= 1;
                                                    foreach($result as $rez){  $k++; 
                                            ?>
                                                <li data-target="#prod-slider_<?php echo $pro['pk_product_id']; ?>" data-slide-to="<?php echo $k; ?>" class="active"></li>
                                            <?php } }?> 
                                        </ol>
                                      <div class="carousel-inner">
                                          <div class="item active">
                                                <img src="<?php echo base_url().'public/images/product/'.$pro['product_image']; ?>" align="">  
                                            </div>
                                        <?php 
                                             if(!empty($result)){
                                            foreach($result as $re){
                                        ?>
                                            <div class="item">
                                                <img src="<?php echo base_url().'public/images/product/'.$re['product_album_image']; ?>" align="">  
                                            </div>
                                             <?php } }?>  
                                          
                                      </div>
                                      <a class="left carousel-control" href="#prod-slider_<?php echo $pro['pk_product_id']; ?>" data-slide="prev"><span class="fa fa-angle-double-left"></span></a>
                                      <a class="right carousel-control" href="#prod-slider_<?php echo $pro['pk_product_id']; ?>" data-slide="next"><span class="fa fa-angle-double-right"></span></a>

                                  </div>
                                    
                                  
                                </div>

                                <div class="col-md-7 tabs-sec">
                                  <h1><?php echo $pro['product_title']; ?></h1>
                                  <div role="tabpanel" class="mytabs">
                                      <!-- Nav tabs -->
                                      <ul class="nav nav-tabs" role="tablist">
                                          <li role="presentation" class="active">
                                              <a href="#description" aria-controls="description" role="tab" data-toggle="tab">Description</a>
                                          </li>
                                          <li role="presentation">
                                              <a href="#howtouse" aria-controls="howtouse" role="tab" data-toggle="tab">How to use</a>
                                          </li>
                                          <li role="presentation">
                                              <a href="#ingredients" aria-controls="ingredients" role="tab" data-toggle="tab">Ingredients</a>
                                          </li>
                                          <li role="presentation">
                                              <a href="#video" aria-controls="video" role="tab" data-toggle="tab">Video</a>
                                          </li>
                                      </ul>
                                  
                                      <!-- Tab panes -->
                                      <div class="tab-content">
                                          <div role="tabpanel" class="tab-pane active" id="description">
                                          <div class="tab-custom-content">
                                                  <?php echo $pro['product_detail']; ?>
                                                  
                                          </div>


                                          </div>
                                          <div role="tabpanel" class="tab-pane" id="howtouse">
                                           <div class="tab-custom-content">
                                                  <?php echo $pro['product_how_to_use']; ?>
                                          </div>

                                          </div>
                                        
                                         <div role="tabpanel" class="tab-pane" id="ingredients">
                                           <div class="tab-custom-content">
                                                  <?php echo $pro['product_ingredients']; ?>
                                          </div>

                                          </div>

                                        <div role="tabpanel" class="tab-pane" id="video">
                                         <div class="tab-custom-content">
                                                <iframe src="https://www.youtube.com/embed/RLgKOs995Iw" frameborder="0" allowfullscreen></iframe>
                                        </div>

                                        </div>





                                      </div>
                                  </div>

                                </div>

                                <div class="col-md-12">
                                  <div class="row pricing-shoppers-cover">
                                  <form>
                                    <ul class="list-unstyled shoppers-price">
                                      <li>
                                      <div class="col-md-10">
                                       <input id="option1" type="radio" name="field" value="option">
  <label for="option1"><span><span></span></span>Casual Shopper </label>
                                       </div>                                      
                                       <div class="col-md-2 text-right">
                                          $99.99
                                       </div>
                                       <div class="clearfix"></div>
                                      </li>
                                      <li>
                                      <div class="col-md-10">
                                       <input id="option2" type="radio" name="field" value="option">
  <label for="option2"><span><span></span></span>Casual Shopper Monthly Auto-Ship</label>
                                       </div>                                      
                                       <div class="col-md-2 text-right">
                                          $89.99
                                       </div>
                                       <div class="clearfix"></div>
                                      </li>
                                      <li>
                                      <div class="col-md-10">
                                       <input id="option2" type="radio" name="field" value="option">
  <label for="option2"><span><span></span></span>Premier Shopper </label>
                                       </div>                                      
                                       <div class="col-md-2 text-right">
                                          $79.99
                                       </div>
                                       <div class="clearfix"></div>
                                      </li>
                                      <li>
                                      <div class="col-md-10">
                                       <input id="option2" type="radio" name="field" value="option">
  <label for="option2"><span><span></span></span>Premier Shopper Monthly Auto-Ship</label>
                                       </div>                                      
                                       <div class="col-md-2 text-right">
                                          $69.99
                                       </div>
                                       <div class="clearfix"></div>
                                      </li>
                                    </ul>
                              <!--       <h2>SCHEDULE AUTOSHIPS</h2>
                                    <ul class="list-unstyled shoppers-price">
                                      <li>
                                      <div class="col-md-10">
                                       <input id="option3" type="radio" name="field" value="option">
  <label for="option3"><span><span></span></span>Monthly Annualy </label>
                                       </div>                                      
                                       <div class="col-md-2">
                                          $299.00
                                       </div>
                                       <div class="clearfix"></div>
                                      </li>
                                      <li>
                                      <div class="col-md-10">
                                       <input id="option4" type="radio" name="field" value="option">
  <label for="option4"><span><span></span></span>Monthly Annualy</label>
                                       </div>                                      
                                       <div class="col-md-2">
                                          $185.00
                                       </div>
                                       <div class="clearfix"></div>
                                      </li>
                                    </ul> -->
                                      <div class="add-car-login-btn">       
                                        <a href="" class="add-to-cart">Add to cart</a>
                                         <a href="" class="login">Login</a>

                                      </div>
                                    </form>
                                  </div>
                                </div>
                                
                                <div class="clearfix"></div>
                            </div>
                           
                          </div>
                        </div>
                      </div>
                  </div>
                  <?php } ?>
                  


                </div>
                </div>
                   <?php } ?>
                </div>
                <!-- Exclusive Products -->
             <div class="evlkep-pink">
              <div class="pro-con product-box-cover ">
          <h2> <i class="heart-icon"></i>    Everyone Loves Flawless Skin Care! </h2> 
          <div class="products-mrgn">
            <div class="col-md-12 col-sm-12">
               <div class="row">
        <div class="col-md-3 col-xs-3 col-sm-3">
          <div class="video-con product-video-con video-k-email">
            <a href="#">
              <img class="img-responsive" src="<?php echo base_url() ?>public/images/themeimages/video-2.jpg">
              <i class="fa fa-youtube-play player-play-btn"></i>
            </a>
          </div>
          <ul class="list-inline list-video-icons share-icons-div">
              <li><a href="#"><img src="<?php echo base_url() ?>public/images/themeimages/share-fb.jpg" class="share-fb" /></a></li>
            <li><a href="#"><img src="<?php echo base_url() ?>public/images/themeimages/share-tw.png" class="share-tw" /></a></li>
            <li><a href="#"><img src="<?php echo base_url() ?>public/images/themeimages/share-pin.png" class="share-pin" /></a></li>
          </ul>
        </div>
        <div class="col-md-3 col-xs-3 col-sm-3">
          <div class="video-con product-video-con video-k-email">
            <a href="#">
              <img class="img-responsive" src="<?php echo base_url() ?>public/images/themeimages/video-2.jpg">
              <i class="fa fa-youtube-play player-play-btn"></i>
            </a>
          </div>
          <ul class="list-inline list-video-icons share-icons-div">
            <li><a href="#"><img src="<?php echo base_url() ?>public/images/themeimages/share-fb.jpg" class="share-fb" /></a></li>
            <li><a href="#"><img src="<?php echo base_url() ?>public/images/themeimages/share-tw.png" class="share-tw" /></a></li>
            <li><a href="#"><img src="<?php echo base_url() ?>public/images/themeimages/share-pin.png" class="share-pin" /></a></li>
          </ul>
        </div>
        <div class="col-md-3 col-xs-3 col-sm-3">
          <div class="video-con product-video-con video-k-email">
            <a href="#">
              <img class="img-responsive" src="<?php echo base_url() ?>public/images/themeimages/video-2.jpg">
              <i class="fa fa-youtube-play player-play-btn"></i>
            </a>
          </div>
          <ul class="list-inline list-video-icons share-icons-div">
            <li><a href="#"><img src="<?php echo base_url() ?>public/images/themeimages/share-fb.jpg" class="share-fb" /></a></li>
            <li><a href="#"><img src="<?php echo base_url() ?>public/images/themeimages/share-tw.png" class="share-tw" /></a></li>
            <li><a href="#"><img src="<?php echo base_url() ?>public/images/themeimages/share-pin.png" class="share-pin" /></a></li>
          </ul>
        </div>
        <div class="col-md-3 col-xs-3 col-sm-3">
          <div class="video-con product-video-con video-k-email">
            <a href="#">
              <img class="img-responsive" src="<?php echo base_url() ?>public/images/themeimages/video-2.jpg">
              <i class="fa fa-youtube-play player-play-btn"></i>
            </a>
          </div>
          <ul class="list-inline list-video-icons share-icons-div">
            <li><a href="#"><img src="<?php echo base_url() ?>public/images/themeimages/share-fb.jpg" class="share-fb" /></a></li>
            <li><a href="#"><img src="<?php echo base_url() ?>public/images/themeimages/share-tw.png" class="share-tw" /></a></li>
            <li><a href="#"><img src="<?php echo base_url() ?>public/images/themeimages/share-pin.png" class="share-pin" /></a></li>
          </ul>
          <a class="btn btn_default pull-right product-btn view-more-btn all-vids-btn-subpage" href="#">All Videos</a>
        </div>
        
              
        </div>
             </div>
          </div> 
        </div>
         <div class="col-md-8 col-md-offset-2">      
        <a href="#" class="btn btn_default pull-right product-btn submit-testimonial-btn">Submit Your Testimonial &amp; Earn $50 Karmora Kash!</a>      
    </div>
        </div>



                
              </div>

        </div>
      </div>
    </div>
      
    </section>