<!-- Top Navbar -->
<?php if (isset($action) && ($action == 'index')) { ?> 
<nav class="navbar navbar-default">
<?php }else{ ?>
<nav class="navbar navbar-default inner-header">
<?php }?>
    
  <div class="container">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="<?php echo base_url(); ?>"><img src="<?php echo $themeUrl ?>/images/karmora-logo.png"></a>
    </div>
    <div class="custom-nav">
      <ul class="list-unstyled list-inline">
          <li><a href="#">About Karmora</a></li>
          <li><a href="#">Share</a></li>
          <li><a href="#">My Account</a></li>
          <li><a href="#">Karmora Kash</a></li>
          <li><a href="#">Contact Us</a></li>
          <?php if ($this->session->userdata('front_data')) { ?>
                <li> <a href="<?php echo base_url().'profile' ?>"><?php echo $this->session->userdata['front_data']['username']; ?></a> or <a href="<?php echo base_url().'logout' ?>">Logout</a></li> 
                <?php }else{ ?>
                <li><a href="#" data-toggle="modal" data-target="#loginModal">Login</a></li>
                <?php } ?>
          <li><a href="#"><i class="fa fa-shopping-cart"></i> Cart</a></li>
          <li class="heart-color"><a href="#"><i class="fa fa-heart"></i></a></li>

        </ul>  
    </div>


