<style>
#checkbox-agree{ margin-top:0px;}

</style>

<?php if (isset($message)) { ?>  
    <script type="text/javascript">
        $(window).load(function() {
            $('#Success').modal('show');
        });
    </script>
    <script>
        function timedRefresh(timeoutPeriod) {
            setTimeout("location.href='<?php echo base_url('Pay4MyPurchase'); ?>'", timeoutPeriod);
        }
        timedRefresh(30000);
    </script>
<?php } ?>


<?php if (isset($error_not)) { ?>  
    <script type="text/javascript">
        $(window).load(function() {
            $('#error_not_msg').modal('show');
        });
    </script>
    <script>
        function timedRefresh(timeoutPeriod) {
            setTimeout("location.href='<?php echo base_url(); ?>'", timeoutPeriod);
        }
        timedRefresh(4500);
    </script>
<?php } ?>

<div class="container" id="submit-page">
    <div class="row ">
        <div class="col-sm-12 col-md-12 col-lg-12">
            <h1 class="main-heading">Submit</h1>
            <h2>Submitting your video is as easy as 1...2...3!
                <!-- row -->      </h2>
            <p>&nbsp;</p>
        </div>
    </div>
  <h2 class=" col-xs-10 col-md-8 col-centered numbers-heading"><div class="h-number">1</div>Choose YouTube or Instagram then enter the link to your #Pay4MyPurchase video.</h2>

  <div class="row">
        <div class="col-md-6  col-md-offset-3" id="form-area" style="margin-top:0PX;">
               
        
          <div class="videos"><img src="<?php echo $themeUrl; ?>/images/mix/video-icons.png"></div>
          <form class="form-horizontal" id="form" action="" method="post">


              <fieldset><h4>Enter URL to a video</h4>

                    <!-- Name input-->
<!--
                    <div class="form-group">
                        <div class="col-md-12"> 

                            <select name="sales_id" class="form-control" style="">
                                <option value="" style="text-align:center;">Select Sales</option>
                                <?php if (!empty($UserSales)) {
                                    foreach ($UserSales as $sale) { ?>
                                        <option value="<?php echo $sale['pk_sales_id'] ?>" style="text-align:center;">
                                        <?php echo $sale['sales_advertiser_name'] ?>
                                        </option>
    <?php }
} ?>
                            </select>
                            <br /><span style="color:red;"><?php echo form_error('sales'); ?></span>
                        </div></div>



                    <div class="form-group">
                        <div class="col-md-12"> 
                            <input type="text" class="form-control" style="color:#c3c3c3;" placeholder="Your Email Addres (For Winner notification)" name="email_address" />
                            <span style="color:red;"><?php echo form_error('email_address'); ?></span>
                        </div>
                    </div>    

-->

                <div class="form-group">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-4">
                                    <select class="form-control" name="video_type">
                                        <option value="instagram">Instagram</option>
                                        <option value="youtube" selected>Youtube</option>

                                    </select>
                                </div>
                                <div class="col-md-8">
                                    <input id="name" name="url" type="text" class="form-control" style="color:#333">
                                    <span style="color:red;"><?php echo form_error('url'); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <p>&nbsp;</p>
                    
     <h2 class=" col-xs-10 col-md-10 col-centered numbers-heading"><div class="h-number">2</div>Create a title for your video.</h2>
                    <div class="clearfix"></div>




                <!-- Message body -->
                    <div class="form-group">
                        <div class="col-md-12">
                            <input  class="form-control" id="message" name="detail" maxlength="23" placeholder="Enter a title for  your video. Pick something catchy up to 23 characters!" rows="5" />
                            <span style="color:red;"><?php echo form_error('detail'); ?></span>
                        </div>
                    </div>
                    <!-- Message body -->
<p>&nbsp;</p>
                    <p>&nbsp;</p>
         
     <h2 class=" col-xs-10 col-md-10 col-centered numbers-heading"><div class="h-number">3</div>Check the box and click ENTER!</h2>
                    <div class="clearfix"></div>
                <div class="form-group">
                        <div class="col-md-7 col-md-offset-3"><input type="checkbox" name="agrement" class="col-xs-1 col-sm-1 col-md-1" id="checkbox-agree">
                            <p style="margin-top: 5px;">I agree to the <a href="#" data-toggle="modal" data-target="#funnyroules">Ridiculously Funny Rules!</a></p>
                            <span style="color:red;"><?php echo form_error('agrement'); ?></span>
                        </div>
                    </div>            

                    <!-- Form actions -->
                    <div class="form-group">
                    <input  class="btn btn-lg btn-primary"  id="big-btn" type="submit" name="submit" value=" ENTER! " >
                    </div>
                </fieldset>
            </form>


        </div>


    </div>


    <!-------four-boxes---->
</div>
<!-- .container #pay4mypurchase_v2 -->





<!--modal for signin-->
<div class="modal fade" id="error_not_msg" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="row-offset-control modal-content">
            <div class="row-offset-control">
                <button type="button" class=" close close-popup" onclick="homepage()" data-dismiss="modal" aria-hidden="true"><img src="<?php echo $themeUrl; ?>/images/icons/close.png"></button>

            </div>
            <div class="clear-float sn-modal-title">
                <h1>Video Pending Review!</h1>
            </div>

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <p>You have already entered Karmora's #Pay4MyPurchase video promotion! The review process can take up to  24 hours; so sit back, relax and do a little online shopping while you wait!</p>
                    <p>As always, we wish you Good Luck, Good Fortune and Good Karmora!</p>
                    <br />
                    <div style="text-align:center;">
                        <a href="<?php echo base_url('store/all'); ?>">
                            <input type="button" style=" background-color:#e74b89; border:1px solid #e74b89; border-radius:5px; color:white; font-weight:bold; width:150px; height:40px;" name="stores" value="View All Stores" />
                        </a>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>


<div class="modal fade" id="Success" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="row-offset-control modal-content">
            <div class="row-offset-control">
                <button type="button" class=" close close-popup" onclick="homepage()" data-dismiss="modal" aria-hidden="true"><img src="<?php echo $themeUrl; ?>/images/icons/close.png"></button>

            </div>
            <div class="clear-float sn-modal-title">
                <h1>Success</h1>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <p>Thank you for entering Karmora's #Pay4MyPurchase video promotion! Please give our team 24 hours to view and approve your video. We will send a confirmation e-mail as soon as this 
                        process is completed.</p>
                    <p>As always, we wish you Good Luck, Good Fortune and Good Karmora!</p>
                </div>
            </div>

        </div>
    </div>
</div>



<div class="modal fade" id="funnyroules" tabindex="-1" role="dialog" aria-labelledby="signupModalLabel" aria-hidden="true">
    <div class="modal-dialog pfmp">
        <div class="row row-offset-control modal-content">
            <div class="row row-offset-control">
                <button type="button" class=" close close-popup" data-dismiss="modal" aria-hidden="true"><img src="<?php echo $themeUrl; ?>/images/icons/close.png"></button>

            </div>
            <div class="clear-float sn-modal-title">
                <h1>Rules So Easy You'll Laugh Your Pants Off!</h1>
                <h2>Promotion Rules and Regurgitation</h2>
            </div>

            <div class="mod-footer clear-float">
                <ul>
                    <li> You must be a Karmora member to participate. Everyone who is anyone is a Karmora member!</li>
                    <li> Your purchase must have been made through your Karmora webstore. We do not give prize money to people willing to pay full price because they are obviously made of money and don't need it!</li>
                    <li> Don't procrastinate! This isn't homework or doing the dishes! The sooner you submit your video the more time you have to gain votes. We will not accept votes or videos after October 31, 2014 at 11:59:59 PM Arizona Time (we never have to change our clocks... how sweet is that!).</li>
                    <li> If using Instagram, make sure your profile is viewable to the public and/or we are connected. Ya know, you like us, we like you, so we follow each other. We can't guarantee we won't comment on all your selfies though!</li>
                    <li> Only videos containing funny, hilarious, crazy, entertaining, goofy, silly, or otherwise awesome content will be accepted for voting. Once accepted you will receive an email with your very own voting page to send to your peeps so they can hook you up with some righteous votes!</li>
                    <li> This is a PG Rated video promotion. Videos containing naughty stuff like profanity, nudity, or illegal activity will be viewed, probably laughed at, and then moved to the "X" rated vault and will never see the light of day!</li>
                    <li> Don't be a pirate. We cannot use videos with licensed music. If you use licensed music your video will walk the plank and drown in the Karmora Abyss. In land lover terms... your video will be rejected!</li>
                    <li> Be shameless! Invite everyone you know to vote for your video everyday. The video with the most votes gets the prize. You and your righteous peeps are limited to one vote per IP address per day.</li>
                    <li> Be even more than shameless and invite your friends to join your Karmora community and receive 10 votes for every person that joins. Who doesn't like saving money, making money and having fun?</li>
                    <li> We're not the Federal Reserve and we can't print money... yet :) We will pay for your purchase up to $250 regardless of your purchase amount. If you buy a Rolex for $10 Gazillion dollars you will only get a check for $250 from the Bank of Karmora!</li>
                    <li> We are nice, but not that nice. If you buy a pair of Crocs for $49 you will get a $49 check as your prize. Perhaps you should consider purchasing a pair of Crocs for each of your five Croc-a-Kids and maximize your prize potential! Please don't call us and say what a Croc-of-Poo it is that you only won $49 if you only buy a single pair.</li>
                    <li> Your purchase amount will be added to your eWallet and will be available for immediate collection.</li>
                    <li> Cheaters Never Win! If you get caught cheating for votes we will disqualify you and chant "cheater, cheater, cheater!"</li>
                    <li> In the event of a tie, Karmora staff in their unquestionable, undeniable, remarkable, just, fair and sole discretion will determine the winner.</li>
                    <li> Be a horrible winner and brag as much as possible to everyone you know (and don't know) about winning the promotion and how smart, funny and creative your are. And... after you catch your breath and your arm stops cramping from patting yourself on the back invite hem to join your Karmora Shopping Community!</li>
                    <li> Don't be a cry baby if you lose. No one likes a cry baby! Besides, this promotion is bound by our mem- bership Terms of Use which strictly prohibits crying. Seriously, we're not kidding. Well... kinda.</li>
                    <li> Winner will be announced on October 1, 2014.</li>
                </ul>
            </div>
        </div>
    </div>
</div>
<script>
function homepage(){
    document.getElementById('form').reset();
    location.href = baseurl+'/Pay4MyPurchase';
}
</script>