
<section class="connect-subscribe">
  <div class="container">
    <div class="row">          
          <div class="col-md-6 connect-box">
            <h1>Connect with us</h1>
            <ul class="connect-social list-unstyled list-inline">
              <li><i class="fa fa-facebook"></i></li>
              <li><i class="fa fa-twitter"></i></li>
              <li><i class="fa fa-google-plus"></i></li>
              <li><i class="fa fa-pinterest"></i></li>
              <li><i class="fa fa-youtube-play"></i></li>
            </ul>
          </div>

          <div class="col-md-6 subscribe-box">
              <h1>Subscribe to our News Letter</h1>
              <div id="my_id_sucs">
                <div class="alert alert-success" id="newsletterSuccess">
                  <strong>Success!</strong> You've been added to our email list.
                </div>
              </div>
                <div id="my_id_err">
                  <div class="alert alert-danger" id="newsletterError"></div>
                </div>
              <form id="newsletterForm" name="newsletter" onsubmit="return scriberajex();" method="POST">
                             
                <div class="form-group subscribeform">           
                  <div class="col-md-9 input-cover">
                  <input type="email" class="form-control" name="email" id="email" placeholder="Email Address">
                  </div>
                  <div class="col-md-3 button-cover">
                  <button type="submit" class="btn btn-primary">Subscribe</button>
                  </div>
                </div>
              
                
              
                
              </form>
          </div>

        
    </div>
  </div>
</section>

<footer class="footer">
  <div class="container">
    <div class="row">
      <div class="col-md-3">
      <div class="footer-link-box">
      <h2>Services</h2>
        <ul class="list-unstyled">
           <li><a href="#">Membership</a></li>
           <li><a href="#">FAQ</a></li>
           <li><a href="#">Live Support</a></li>
        </ul> 

        </div>
      </div>
       <div class="col-md-3">
      <div class="footer-link-box">
      <h2>Company</h2>
        <ul class="list-unstyled">
           <li><a href="#">About Karmora</a></li>
           <li><a href="#">Terms & Conditions</a></li>
           <li><a href="#">Privacy Policy</a></li>
           <li><a href="#">Refund Policy</a></li>
           <li><a href="#">Income Disclosure Statement</a></li>
           <li><a href="#">Cash Back Disclosure Statement</a></li>
           <li><a href="#">Employment</a></li>
        </ul> 

        </div>
      </div>
       <div class="col-md-3">
      <div class="footer-link-box">
      <h2>Services</h2>
        <ul class="list-unstyled">
           <li><a href="#">Membership</a></li>
           <li><a href="#">FAQ</a></li>
           <li><a href="#">Live Support</a></li>
        </ul> 

        </div>
      </div>
       <div class="col-md-3">
      <div class="footer-link-box">
      <h2>Company</h2>
        <ul class="list-unstyled">
           <li><a href="#">About Karmora</a></li>
           <li><a href="#">Terms & Conditions</a></li>
           <li><a href="#">Privacy Policy</a></li>
           <li><a href="#">Refund Policy</a></li>
           <li><a href="#">Income Disclosure Statement</a></li>
           <li><a href="#">Cash Back Disclosure Statement</a></li>
           <li><a href="#">Employment</a></li>
        </ul> 


        </div>
      </div>
      <div class="footer-copyright col-md-12">
      <div class="row">
      <div class="col-md-6">
      <div class="allrights">
        <ul class="list-unstyled list-inline">
           <li><a href="#">About Karmora</a></li>
           <li><a href="#">Terms & Condition</a></li>
           <li><a href="#">Contact Us</a></li>
        </ul> 

      </div>

      </div>

      <div class="col-md-6">
      <div class="allrights-text">
        <p>2015 Karmora - All Rights Reserved</p>
        
      </div>

      </div>
      </div>
      </div>
    </div>
  </div>
</footer>
    

    <script src="<?php echo $themeUrl ?>/js/jQuery.js"></script>.
    <script src="<?php echo $themeUrl ?>/js/bootstrap.min.js"></script>
    <script src="<?php echo $themeUrl ?>/js/owl.carousel.js"></script>
    <script src="<?php echo $themeUrl ?>/js/jquery-migrate-1.2.1.min.js"></script>
    <script type="text/javascript" src="<?php echo $themeUrl ?>/js/slick.js"></script>
    <script src="<?php echo $themeUrl ?>/js/custom.js"></script>
    <?php $this->load->view('frontend/layout/partials/popup'); ?>
    <?php $this->load->view('frontend/layout/partials/custom_js_call'); ?>

    





  </body>
</html>
  