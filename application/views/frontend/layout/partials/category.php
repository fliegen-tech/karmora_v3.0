<div class="col-md-2 col-sm-2">
		  	
        <div class="img-holder left-banner community-banner left-nav retail-left-banner-left">
            <?php if (!empty($categories)) { ?>
                <ul class="list-unstyled list-left-dark-nav">
                  <?php if (!$this->session->userdata('front_data')) {?><li class="dropdown-submenu sp"><a class="list-icon isp" tabindex="-1" href="#" data-toggle="modal" data-target="#signupModal" >My Favorites </a>
                  <?php } else { ?>
                  <li><a href="<?php echo base_url('myfavorites'); ?>">My Favorites </a>
                  <?php } ?> 
                  <li><a href="<?php echo base_url('special-offer/smokin_hot_deals') ?>">Smoking Hot Deals</a></li>
                  <li><a href="<?php echo base_url('special-offer/cash_o_palooza') ?>">Exclusive Mall</a></li>
                  <li><a href="<?php echo base_url('store/all'); ?>">View All Stores</a></li>
                </ul>
                    <ul class="list-unstyled list-left-light-nav">
                        <?php  foreach ($categories as $cat) { ?>  
                            <li><a href="<?php echo base_url('store/' . $cat['alias']); ?>"><i class="fa fa-angle-right"></i> <?php echo $cat['title']; ?></a></li>
                        <?php } ?>
                    </ul>
            <?php } ?>     
          </div>
	<div class="clearfix"></div>
</div>