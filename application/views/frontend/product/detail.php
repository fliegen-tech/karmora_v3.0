<!-- karmora product detaill flawlss -->

<section class="karmora-flawless">
    <div class="container">
        <div class="row">
            <div class="col-md-8 flawless-left-bar">
                <div class="col-md-3 karmora-product-flawless-cover">
                    <div class="karmora-flawless-cover" style="overflow: hidden;">
                        <img style="width:100%;" src="<?php echo $product_detail->product_image; ?>">
                    </div>
                </div>
                <div class="col-md-8 col-md-offset-1">
                    <div class="karmora-flawless-detail">
                        <h2><?php echo $product_detail->product_name; ?></h2>
                        <div class="start-rating-cover">
                            <div class="stars">
                                <form action="">
                                    <input class="star star-5" id="star-5" type="radio" name="star">
                                    <label class="star star-5 sactive" for="star-5"></label>
                                    <input class="star star-4" id="star-4" type="radio" name="star">
                                    <label class="star star-4 sactive" for="star-4"></label>
                                    <input class="star star-3" id="star-3" type="radio" name="star">
                                    <label class="star star-3 sactive" for="star-3"></label>
                                    <input class="star star-2" id="star-2" type="radio" name="star">
                                    <label class="star star-2" for="star-2"></label>
                                    <input class="star star-1" id="star-1" type="radio" name="star">
                                    <label class="star star-1" for="star-1"></label>
                                    <small>(123) Submit a Review</small>
                                </form>
                                <h6>Read Reviews | Watch Reviews</h6>
                            </div>
                        </div>
                        <p><?php echo $product_detail->product_short_description; ?></p>
                        <p><?php echo $product_detail->prodcut_description; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="product-shopper-card">
                    <h2><?php echo $product_detail->product_price; ?></h2>
                    <!-- <div class="product-casual-shoper">
                            <a href="" class="product-casual-link">Casual Shopper</a> 		
                    </div> -->
                    <div class="col-md-9 col-md-offset-1">

                        <h5 data-toggle="popover" title="" data-content="A larger popover to demonstrate the max-width of the Bootstrap popover" data-placement="bottom" data-original-title="Popover title">Casual Shopper</h5>
                    </div>			
                    <form role="form" class="product-shopping-flowers">
                        <div class="col-md-9 col-md-offset-1">
                            <input type="radio" id="rb1" name="rb" value="" checked="">
                            <label for="rb1">One Time Purchase</label>
                        </div>
                        <div class="col-md-2">
                            $45
                        </div>  
                        <div class="col-md-9 col-md-offset-1">
                            <input type="radio" id="rb2" name="rb" value="" checked="">
                            <label for="rb2">Auto Delivery <h6>(Save 20%)</h6></label>
                        </div>
                        <div class="col-md-2">
                            $32
                        </div>
                        <div class="col-md-9 col-md-offset-1">
                            <a href="">Learn More</a>
                        </div>
                        <div class="col-md-9 col-md-offset-1">
                            <h5 data-toggle="popover" title="" data-content="A larger popover to demonstrate the max-width of the Bootstrap popover" data-placement="bottom" data-original-title="Popover title">Premier Shopper</h5>
                        </div>			
                        <div class="col-md-9 col-md-offset-1">
                            <input type="radio" id="rb3" name="rb" value="" checked="">
                            <label for="rb3">One Time Purchase</label>
                        </div>
                        <div class="col-md-2">
                            $45
                        </div>  
                        <div class="col-md-9 col-md-offset-1 ">
                            <input type="radio" id="rb4" name="rb" value="" checked="">
                            <label for="rb4">Auto Delivery <h6>(Save 20%)</h6></label>
                        </div>
                        <div class="col-md-2">
                            $32
                        </div>
                        <div class="col-md-8 col-md-offset-1">
                            <a href="">Learn More</a>
                        </div>

                        <div class="col-md-8 col-md-offset-1" style="text-align:center;">
                            <button type="submit" class="btn btn-default btn-add-product">Add to Cart</button>
                        </div>
                        <div class="col-md-8 col-md-offset-1 btn-product-cart">
                            <a href="">Add to My Favorites<i class="fa fa-heart"></i></a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- End karmora product detaill flawlss -->

<!-- Karmora binefits -->
<section class="karmora-product-benifts">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="karmora-benifts">
                    <h3>The Benifits</h3>
                    <p>Triple- benefit eye cream helps treat and prevent under-eye aging with Eye Brightening Complex to reduce dark circles and puffiness while illumina-ting the eye area.</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="karmora-benifts">
                    <h3>HOW TO USE</h3>
                    <p>Every day after cleansing and toning, gently pat a small amount onto the brow bone and beneath the eye and gently massage. For optimal results, follow with a Resurgence Day or Night Moisturizer.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- End Karmora benifts -->

<!-- Karmora product benifts -->
<section class="karmora-product-cares">
    <div class="container">
        <div class="row">
            <div class="karmora-cares-hading">
                <h2>KARMORA CARES!</h2>
                <h5>ALL FLAWLESS SKIN CARE PRODUCTS ARE CERTIFIED TO BE...</h5>
            </div>
            <div class="col-md-2">
                <div class="karmora-cares-image-cover">
                    <img src="<?php echo $themeUrl; ?>/images/care-karmora.png">
                </div>
            </div>
            <div class="col-md-10">
                <div class="cares-detail">
                    <h3>
                        <span>SAFE</span>
                        - Certiﬁed to be free from any harmful chemicals!
                    </h3>
                    <h3>
                        <span>NATURAL</span>
                        - Certiﬁed to contain only ingredients that are 100% natural and from the Earth!
                    </h3>
                    <h3>
                        <span>ECO FRIENDLY</span>
                        - Certiﬁed to have been manufactured sustainably and safe for the environment!
                    </h3>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Karmora benifts -->

<!-- Karmora Special -->

<section class="karmora-specials">
    <div class="container">
        <div class="row">
            <div class="section-heading">
                <h1>For Best Results</h1>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit sumit abel</p>
            </div>
            <div class="karmora-product-cover text-center">
                <!-- Single Product Cover -->
                <div class="col-md-3 inline-block">
                    <div class="k-product-single-cover">
                        <div class="k-img-procover">
                            <img src="<?php echo $themeUrl; ?>/images/prod.png">                
                        </div>
                        <!--  <div class="k-img-hover">
                             <img src="images/hover-prod.png">
                           </div> -->
                        <div class="k-prod-des ">
                            <h3>First Product Name Goes Here</h3>
                            <div class="k-price">$45.99</div>
                            <div class="start-rating-cover">
                                <div class="stars">
                                    <form action="">
                                        <input class="star star-5" id="star-5" type="radio" name="star">
                                        <label class="star star-5 sactive" for="star-5"></label>
                                        <input class="star star-4" id="star-4" type="radio" name="star">
                                        <label class="star star-4 sactive" for="star-4"></label>
                                        <input class="star star-3" id="star-3" type="radio" name="star">
                                        <label class="star star-3 sactive" for="star-3"></label>
                                        <input class="star star-2" id="star-2" type="radio" name="star">
                                        <label class="star star-2" for="star-2"></label>
                                        <input class="star star-1" id="star-1" type="radio" name="star">
                                        <label class="star star-1" for="star-1"></label>
                                    </form>
                                </div>
                            </div>
                            <div class="k-prod-hover">
                                <p>Some long product description will show on hover</p>
                                <a href="#">Shop Now</a>
                            </div>
                        </div>
                    </div>        
                </div> 

                <!-- Single Product Cover -->
                <div class="col-md-3 inline-block">
                    <div class="k-product-single-cover">
                        <div class="k-img-procover">
                            <img src="<?php echo $themeUrl; ?>/images/prod.png">                
                        </div>
                        <!-- <div class="k-img-hover">
                            <img src="images/hover-prod.png">
                          </div> -->
                        <div class="k-prod-des">
                            <h3>First Product Name Goes Here</h3>
                            <div class="k-price">$45.99</div>
                            <div class="start-rating-cover">
                                <div class="stars">
                                    <form action="">
                                        <input class="star star-5" id="star-5" type="radio" name="star">
                                        <label class="star star-5 sactive" for="star-5"></label>
                                        <input class="star star-4" id="star-4" type="radio" name="star">
                                        <label class="star star-4 sactive" for="star-4"></label>
                                        <input class="star star-3" id="star-3" type="radio" name="star">
                                        <label class="star star-3 sactive" for="star-3"></label>
                                        <input class="star star-2" id="star-2" type="radio" name="star">
                                        <label class="star star-2 sactive" for="star-2"></label>
                                        <input class="star star-1" id="star-1" type="radio" name="star">
                                        <label class="star star-1" for="star-1"></label>
                                    </form>
                                </div>
                            </div>
                            <div class="k-prod-hover">
                                <p>Some long product description will show on hover</p>
                                <a href="#">Shop Now</a>
                            </div>
                        </div>
                    </div>        
                </div> 

                <!-- Single Product Cover -->
                <div class="col-md-3 inline-block">
                    <div class="k-product-single-cover">
                        <div class="k-img-procover">
                            <img src="<?php echo $themeUrl; ?>/images/prod.png">                
                        </div>
                        <!--  <div class="k-img-hover">
                             <img src="images/hover-prod.png">
                           </div> -->
                        <div class="k-prod-des">
                            <h3>First Product Name Goes Here</h3>
                            <div class="k-price">$45.99</div>
                            <div class="start-rating-cover">
                                <div class="stars">
                                    <form action="">
                                        <input class="star star-5" id="star-5" type="radio" name="star">
                                        <label class="star star-5 sactive" for="star-5"></label>
                                        <input class="star star-4" id="star-4" type="radio" name="star">
                                        <label class="star star-4 sactive" for="star-4"></label>
                                        <input class="star star-3" id="star-3" type="radio" name="star">
                                        <label class="star star-3 sactive" for="star-3"></label>
                                        <input class="star star-2" id="star-2" type="radio" name="star">
                                        <label class="star star-2 sactive" for="star-2"></label>
                                        <input class="star star-1" id="star-1" type="radio" name="star">
                                        <label class="star star-1" for="star-1"></label>
                                    </form>
                                </div>
                            </div>
                            <div class="k-prod-hover">
                                <p>Some long product description will show on hover</p>
                                <a href="#">Shop Now</a>
                            </div>
                        </div>
                    </div>        
                </div> 
            </div> 

        </div>
    </div>
</section>
<!-- Karmora special -->
