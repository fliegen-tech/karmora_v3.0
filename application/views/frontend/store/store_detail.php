  <section class="karmora-store-detail">
  <div class="container">
  <div class="row">

    <div class="col-md-12">
    <!-- store detail -->
    <div class="desc-top">
        <h1><?php echo $title; ?></h1>
        <span>Cash Back <?php echo $comm_percentage; ?></span>
        <?php if (isset($login_check) && $login_check == 'login') { ?>
           <a class="" style="padding: 6px 12px; cursor: pointer;" data-toggle="modal" data-target="#signupModal" id="addfav-button"  >add</a>    
            <?php } else {
                    if (isset($alredyFavourite) && $alredyFavourite == 'alredyFavourite') {?>
                            <a  class="active" style="padding: 6px 12px; cursor: pointer;" href="<?php echo base_url('Unfavourtie/' . $storeId) ?>" id="addfav-button">add</a>
                                <?php } else { ?>
                                         <a style="padding: 6px 12px; cursor: pointer;" href="<?php echo base_url('favourtie/' . $storeId) ?>" id="addfav-button"  >add</a>
                                <?php }}?>
                    <img src="<?php echo $themeUrl ?>/images/<?php echo $image; ?>">
        <p><?php echo $description; ?>.</p>
        <?php if (!$this->session->userdata('front_data')) { ?>
                <a href="#"  data-toggle="modal" class="btn btn-default" data-target="#signupModal">Shop Now</a>
                    <?php } else { ?>
                        <a class="btn btn-default" data-toogle="modal" href="<?php echo base_url('store-visit/' . $storeId) ?>" target="_blank" id="shop-now-btn">Shop Now</a>
                    <?php } ?>
    </div>
</div>
        
        </div>
    </div>
</section>