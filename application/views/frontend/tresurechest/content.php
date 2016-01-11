


<!-- product-detail -->
<section class="click-for-cash">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <ul class="list-inline list-c2w-logos">
                    <li>
                        <img src="<?php echo $themeUrl ?>/images/themeimages/earn-dollor.jpg" class="img-responsive earn-dollor">
                    </li>
                    <li>
                        <img src="<?php echo $themeUrl ?>/images/themeimages/earn-dollor.jpg" class="img-responsive earn-dollor">
                    </li>
                    <li>
                        <img src="<?php echo $themeUrl ?>/images/themeimages/earn-dollor.jpg" class="img-responsive earn-dollor">
                    </li>
                    <li>
                        <img src="<?php echo $themeUrl ?>/images/themeimages/earn-dollor.jpg" class="img-responsive earn-dollor">
                    </li>
                </ul>
                <div class="click-for-cash-head">
                    <p>Win Great Prizes just by browsing your personal Karmora Website!</p>
                </div>
            </div>

            <div class="col-md-12">
                <div class="click-para">
                    <div class="col-md-10 col-md-offset-1">
                        <p>Karmora has hidden prizes great prizes all over your website.  Simply click “Shop Now” on any Retail Store or Exclusive Product for a chance to win Great Prizes!  No purchase is necessary to collect your prize, but do yourself and Karmora a solid and shop around when you land on the Click 2 Win sponsor Website or Product Page. For more information on the Click 2 Win Program <a href="http://staging3.karmora.com/newdesigns/click-2-win.html#">Click Here.</a></p>
                    </div>
                </div>
                <div class="accordian-cover">
                    <?php if (!empty($Win_Cold_Hard_Cash)) { ?>
                        <div class="col-hard-cash">
                            <div class="chc-heading">  
                                <h2>Win Cold Hard Cash</h2>
                            </div>
                            <div class="clearfix"></div>
                            <?php foreach ($Win_Cold_Hard_Cash as $cash) { ?>  
                                <div class="col-md-2 bright col-xs-6 col-sm-6">
                                    <div class="crency-cover">
                                        <h1><?php echo $cash['winner_chest_gift_amount']; ?></h1>
                                        <img src="<?php echo $themeUrl ?>/images/promotions/winner_chest/<?php echo $cash['winner_chest_gift_picture']; ?>">
                                        <p><?php echo $cash['quantity']; ?> remaining</p>
                                    </div>
                                </div>
                            <?php } ?>  

                        </div>
                    <?php } ?> 
                    <div class="clearfix"></div>
                    <?php if (!empty($Win_Gift_Cards)) { ?>
                        <div class="gift-cards">
                            <div class="gc-heading">  
                                <h2>Win Gift Cards</h2>
                            </div>
                            <div class="clearfix"></div>
                            <?php foreach ($Win_Gift_Cards as $card) { ?>  
                                <div class="col-md-2 bright col-xs-6 col-sm-6">
                                    <div class="crency-cover">                    
                                        <img style="width:119px; height: 78px;" src="<?php echo $themeUrl ?>/images/promotions/winner_chest/<?php echo $card['winner_chest_gift_picture']; ?>">
                                        <p><?php echo $card['quantity']; ?> remaining</p>
                                    </div>
                                </div>
                            <?php } ?>  

                        </div>
                    <?php } ?> 
                    <div class="clearfix"></div>
                    <?php if (!empty($Win_Exclusive_Products)) { ?>
                        <div class="exclusive-products">
                            <div class="ep-heading">  
                                <h2>Win Exclusive Products</h2>
                            </div>
                            <div class="clearfix"></div>
                            <?php foreach ($Win_Exclusive_Products as $prod) { ?> 
                                <div class="col-md-2 bright col-xs-6 col-sm-6">
                                    <div class="crency-cover ep-prod-cover">                   
                                        <img src="<?php echo $themeUrl ?>/images/promotions/winner_chest/<?php echo $prod['winner_chest_gift_picture']; ?>">
                                        <p><?php echo $prod['winner_chest_gift_title']; ?></p>
                                    </div>
                                </div>
                            <?php } ?>  

                            <div class="clearfix"></div>
                        </div>
                    <?php } ?>  	
                    <?php if (!empty($winner)) { ?>
                        <table class="table table-striped table-responsive">

                            <thead>

                                <tr>

                                    <th>Data Stamp</th>

                                    <th>Name</th>

                                    <th>Prize Found</th>



                                </tr>

                            </thead>

                            <tbody>
                                <?php foreach ($winner as $w) { ?>
                                    <tr>

                                        <td><?php echo $w['winning_date']; ?></td>

                                        <td><?php echo $w['user_first_name'] . ' ' . $w['user_last_name']; ?></td>

                                        <td><?php echo $w['amount']; ?></td>
                                    </tr>
                                <?php } ?>    

                            </tbody>

                        </table>
                    <?php } ?>
                    <div class="cash-button-cover text-center">
                        <a href="<?php echo base_url().'how-to-win'; ?>" class="cash-btn">How 2 Win</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
<!-- / product-detail --> 