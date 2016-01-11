<!-- Footer -->
<div class="row row-offset-control clear-float footer">
    <div class="container">
        <div class="text-center">
            <ul class="sociol-media-icons">
                <li><a href="https://twitter.com/Shopkarmora"><i class="fa fa-twitter fa-inverse fa-1x"></i></a></li>
                <li><a href="https://www.facebook.com/karmora"><i class="fa fa-facebook fa-inverse fa-1x"></i></a></li>
                <li><a href="https://plus.google.com/108133976193153231629"><i class="fa fa-google-plus fa-inverse fa-1x"></i></a></li>
                <li><a href="http://www.pinterest.com/shopkarmora/"><i class="fa fa-pinterest fa-inverse fa-1x"></i></a></li>
                <li><a href="http://www.youtube.com/user/ShopKarmora"><i class="fa fa-youtube fa-inverse fa-1x"></i></a></li>
                <li><a href="#"><i class="fa fa-wordpress fa-inverse fa-1x"></i></a></li>
            </ul>         
        </div>

        <div class="row row-offset-control">
            <div class="col-sm-7 col-md-7 col-lg-7 footer-about">
                <h3>About Karmora</h3>
                                    <p>
                        <p style="margin: 0in; font-family: Calibri; font-size: 11.0pt;">Karmora is a socially conscious online development company specializing in building, managing and supporting turnkey webstores.&nbsp;</p>
<p style="margin: 0in; font-family: Calibri; font-size: 11.0pt;">Our goal is to provide our members with a fun, simplistic and cost effective environment where they can make money online in just minutes instead of the days, months or even years it would take for the average person to learn how to conceptualize, host, develop, launch and maintain their own website.&nbsp;</p>
<p style="margin: 0in; font-family: Calibri; font-size: 11.0pt;">Karmora is the first of its kind&hellip; Anywhere&hellip; Ever!&nbsp; In a click of a mouse you can have your very own customizable and fully functional Webstore with practically every named brand product you could ever want to buy or sell on the internet for profit.&nbsp; It&rsquo;s just that simple.&nbsp;</p>                    </p>
                    
                <div class="footer-logo">
                    <a href="#">
                        <img src="<?php echo base_url() ?>public/images/footer-logo.png" alt="logo" />
                    </a>
                </div>
            </div>
            <div class="col-md-5 col-md-5 col-lg-5 latest-from-blog">
                <h3>Latest Blogs</h3>
                                        <div class="blog clear-float">
                            <p class="p-heading">
                                <img class="pull-left img-circle" src="<?php echo base_url() ?>public/images/avatar.jpg" alt="thumb" style="height: 80px; width: 80px;"/>
                            <div class="description">
                                Another Entry Title For The Blog<br />
                                <span class="posted-on">Posted on:</span> <span class="date">November 11,2008</span> <a class="read-more" href="#">Read More</a> 
                            </div>
                            </p>
                        </div>
                        <div class="space-10"></div>
                                                <div class="blog clear-float">
                            <p class="p-heading">
                                <img class="pull-left img-circle" src="<?php echo base_url() ?>public/images/avatar.jpg" alt="thumb" style="height: 80px; width: 80px;"/>
                            <div class="description">
                                Post Heading Here For The blog<br />
                                <span class="posted-on">Posted on:</span> <span class="date">November 11,2008</span> <a class="read-more" href="#">Read More</a> 
                            </div>
                            </p>
                        </div>
                        <div class="space-10"></div>
                        
            </div>
        </div>

    </div>
</div>
<!-- End Footer -->

<!-- Copyright -->
<div class="row row-offset-control copyright">
    <div class="container">
        <div class="text-center">
            <ul class="login-controls">
                                        <li><a  href="#">Disclosure Statement</a></li>

                                                <li><a  href="#">Privacy Policy</a></li>

                                                <li><a  href="#">Refund Policy</a></li>

                                                <li><a  href="#">Terms of Use</a></li>

                                                <li><a  href="#">About Karmora</a></li>

                        
            </ul>
            <p>&COPY; 2014 Karmora. All Rights Reserved.</p>
        </div>
    </div>
</div>
<!-- End Copyright -->

<!-- ================== Modals ================== -->
<!-- Singup -->
<form id="form-signup">
<div class="modal fade" id="signupModal" tabindex="-1" role="dialog" aria-labelledby="signupModalLabel" aria-hidden="true">
    <div class="modal-dialog">

        <div class="row row-offset-control modal-content"  id="signup-content">

            <div class="row row-offset-control">
                
                <div class="mod-head pull-right">        
                    <h4>Already a Member? <a href="#" data-toggle="modal" data-target="#loginModal">Login</a></h4>
                </div>
            </div>
            <div id="first_step">
            <div class="clear-float sn-modal-title">
                <h2>Step 1 - <span class="highlight">Join Now. It´s Free !</span></h2>
            </div>
                <div class="err_message" id="error_msgs_first_step"></div>
            <div class="signup-options">
                <div class="login-with-facebook" onclick="Login()">
                    <i class="fa fa-facebook fa-inverse fa-7x"></i>
                    <h5 class="fb-message">Join with facebook</h5>
                    <label class="option hidden-xs">OR</label>
                </div>
                <div class="md-form-bg">
                   
                        <div class="form-inner">
                            <h3>Please Signup</h3>                
                            <div class="form-fields">                
                                <input type="text" id="usr_name" name="name" placeholder="Name" />
                                <input type="email" id="usr_email" name="email" placeholder="Email" />                
                            </div>
                            <label class="form-lbl">We will not share or sell your information.</label>
                        </div>
                        <a class="btn-submit" href="#" id="nextstep">
                            <i class="fa fa-arrow-right fa-2x"></i>
                        </a>
            
                </div>
            </div>
            </div>
            <div id="second_step" style="display:none">
                <a id="steponeback" style="cursor:pointer">Back</a>
            <div class="clear-float sn-modal-title">
                <h2>Step 2 - <span class="highlight">Join Now. It&acute;s Free !</span></h2>
            </div>
                <div class="err_message" id="error_msgs_second_step"></div>
            <div class="signup-options login-options">
                <div class="md-form-bg">
                   
                        <div class="form-inner">
                            <h3>Please Signup</h3>                
                            <div class="form-fields">                
                                <input type="text" id="usr_username" name="username" placeholder="Username" />
                                <input type="password" name="password" placeholder="Password" />                
                            </div>
                            <label class="form-lbl">Refered by a member <a href="#">Click Here</a>.</label>
                        </div>
                        <a class="btn-submit" id="signup_form_submit">
                            <span class="start-shopping">Start Shopping</span>
                        </a>
              
                </div>
            </div>
            </div>
            <div class="mod-footer clear-float">
                <p>By becoming a Karmora Member, I agree to the Karmora <a href="#">terms and conditions</a></p>
                <p>Karmora is the premier cash back Webstore offering top rebates and coupons to more than 1,500+ name brand stores, Whether you are a bargain shopper looking for the best coupons, free shipping codes, promotional codes, deals, and rebates sites; a networker looking to build a community of shoppers where you can earn commissions every day; or a fundraising organization looking for an exciting new way to raise funds for your worthy cause, Karmora is the home for you!</p>
                <p><a href="#">I'd prefer to look around a bit before making a decision to join Karmora</a></p>
                <p>© 2015 Karmora, LLC. All rights reserved. <a href="#">Privacy Policy</a></p>
            </div>

        </div>

    </div>
</div><!-- /.modal -->
</form>
<!-- Login -->
<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="row row-offset-control modal-content">

            <form class="form-signin" id="form-signin" role="form" >
                        <h2 class="form-signin-heading">Please sign in</h2>
                        <input name="username" type="text" class="form-control" placeholder="Email address Or User name" required autofocus>
                        <input type="password"  name="password" class="form-control" placeholder="Password" style="margin-top:10px;" required>
                        <label class="checkbox">
                            <div class="error_msgs" id="error_msg"></div>
                            <!--<input type="checkbox" value="remember-me"> Remember me-->
                        </label>
                        <input class="btn btn-lg btn-primary btn-block" type="submit" value="SignIn">
                    </form>

        </div>
    </div>
</div>
</div><!-- /.modal -->
<!-- End Modals -->
<script>
    
    
     $("#nextstep").click(function() {

        $.post(baseurl + 'signup/validate_shoper_first_form', $('#form-signup').serialize(), function(data, status) {

            if (data == 1) {
                $("#second_step").show();
                $("#first_step").hide();
                $('#error_msgs_first_step').html('')

            } else
                $('#error_msgs_first_step').html(data)

        });

    });
    
    /****back link  javascript****/
     $("#steponeback").click(function() {
        $("#second_step").hide();
        $("#first_step").show();
    });
    
     $("#signup_form_submit").click(function() {
            $.post(baseurl + 'signup/shoper_signup', $('#form-signup').serialize(), function(data, status) {

                if (data == 1) {
                    $('#signup-content').html("Signed Up Sucessfully")
                    setTimeout(function() {
                        location.reload()
                    }, 1000);
                } else
                    $('#error_msgs_second_step').html(data)

            });
     });
    
    $(document).ready(function() {

        $("#owl-demo").owlCarousel({
            autoPlay: 3000,
            singleItem: true,
            navigation: true,
            pagination: false,
            navigationText: ["<",">"]
        });

        var owl = $("#owl-featured");

        owl.owlCarousel({
            items: 5,
            navigation: true,
            autoPlay: 3000

        });

    });
    
    
   /****ajax call for signin****/


    $(function() {
        $('#form-signin').submit(function(e) {

            e.preventDefault();
            $.post(baseurl + 'login', $('#form-signin').serialize(), function(data, status) {
            var parsedJson  =   jQuery.parseJSON(data);    
            //console.info(parsedJson);
                for (var k in parsedJson) {
                    if(parsedJson.msg==="1") {
                        $('#sucessfully').html('<div class="error_msgs">Sucessfully Loged in</div>');
                        setTimeout(function() {
                       // console.info(data+'dashboard');
                        //console.info(parsedJson.data+'dashboard');
                        location.href = parsedJson.data+'dashboard';
                        //  console.info(data);
                    }, 1000);
                    }
                    else if(parsedJson.msg ==="0") {
                        $('#error_msg').html('Username and password do not match');
                    }
                }
            });


        });


    });
 
</script>
</body>
</html>
