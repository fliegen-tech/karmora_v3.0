<style>
    .image {
        position:relative;
    }
    .image .textp {
        position: absolute;
        top: 2px;
        left: -5px;
        width: 100px;
    }
	
	.voting-numbers{ padding-left:25px;}


	
</style>


<?php $share_url = base_url('Pay4MyPurchase/vote'); ?>

<div class="container" id="pay4mypurchase_v2">
    <div class="row ">
        <div class="col-sm-12 col-md-12 col-lg-12">
            <h1 class="main-heading">Vote</h1>
            <?php if (!$this->session->userdata('front_data')) { ?>
            <h2>Please help me win by voting for my video every day!</h2>
            <?php }else{ ?>
            <h2>This is your personal vote page.&nbsp;&nbsp;&nbsp;You should check this page every day to see the number of votes you have and to vote for your own video.</h2>
            <?php } ?>
           

        </div>
        <div class="clearfix"></div>
        
        <div class=" col-xs-10 col-sm-8 col-md-7 col-centered  ">
            <?php if ($video_type == 'instagram') { ?>
            <video controls="controls" poster="<?php echo $themeUrl; ?>/images/paymypurchase/video_captaure.png" class="img-responsive" height="415" autoplay="autoplay">
                    <source src="<?php echo $media; ?>" >
            </video>
                <?php } else if ($video_type == 'youtube') { ?>
                    <?php $vUr = str_replace("watch?v=", "embed/", $media);
                    
                    $vUrl = str_replace("http:", "https:", $vUr);?>
                    <div class="videoWrapper">
                <iframe width="640" height="360" src="<?php echo $vUrl.'?rel=0&showinfo=0'; ?>">
                </iframe> 
                </div>
<?php } ?>
                <p>&nbsp;</p>
        </div>
       
        <div class=" col-xs-12 col-sm-10 col-md-12 col-centered" id="vote-vid">
   
                    
                    <a href="javascript:;" class="vote"  onclick="karmora_likes('<?php echo $fk_prmotion_id; ?>')"> 
		    <img src="<?php echo $themeUrl; ?>/images/paymypurchase/karmora_vote.png" /> </a>
		    <div class="voting-numbers">
		    <b class="textp" id="count_value-<?php echo $promotionalImage['promation_pk_id']; ?>"><?php echo ($promotionalImage['votescount'] > 0 ? $promotionalImage['votescount']: 0); ?>
			 </b> 
                    </div>
                    <div class="clearfix" ></div>
                    </div>
                    
        
        
        
        
        
        <p>&nbsp;</p>
        </div>
    <!-------four-boxes---->
    <div class="row">
        <?php if (!$this->session->userdata('front_data')) { ?>
        <div class="col-sm-12 col-md-12 col-lg-12">
        <h3 class="pink-text">Plus, if you join Karmora TODAY I will receive an additional 10 votes and it's absolutely FREE to join!</h3>
        <h2>Earn up to 30% Cash Back on your online Purchases and WIN great Prizes!</h2>
        <h1 class="pink-text text-center"> IT'S FREE!!!!!<!-- row --> </h1>
      </div>
        <?php } ?>

        <div class="col-xs-8 col-sm-8 col-md-5 col-centered">
            
        <div class="form-group">
        <?php if (!$this->session->userdata('front_data')) { ?>
        <a class="col-md-6  pull-left" href="#" id="big-2-btn" data-toggle="modal" data-target="#signup_prize" style=" margin-top:0px;">Join Today!</a>
        <a href="#" id="big-2-btn"  data-toggle="modal" data-target="#signup_prize" class="pull-right green" style="margin-top:0px;">Tell Me More!</a>
<?php } ?>
    </div>
    </div>
    </div> 
    
    <div class="row">
        <div class=" col-md-12">
            </br> </br>
            <p style="text-align:center;">Promotional Period start from November till January 2015</p></div>
    </div>

</div>
<!-- .container #pay4mypurchase_v2 -->

</form>
<script>
    function karmora_likes(fk_prmotion_id) {
        jQuery.ajax({
            type: 'POST',
            url: baseurl + 'Pay4MyPurchase/karmora_likes/' + fk_prmotion_id,
            context: document.body,
            error: function (data, transport) {
                alert("Sorry, the operation is failed.");
            },
            success: function (data) {
                //alert(data);
                if (data != 'my') {
                    $('#count_value').html('');
                    $('#count_value').html(data);
                    $('#Thanks').modal('show');
                } else {
                    $('#thanks_voting_error').modal('show');
                }
            }
        });
    }

</script>


<!-- Thanks -->

<div class="modal fade" id="Thanks" tabindex="-1" role="dialog" aria-labelledby="thanksModalLabel" aria-hidden="true">
    <div class="modal-dialog">

        <div class="row row-offset-control modal-content">
            <div class="row row-offset-control">
                <button type="button" class=" close close-popup" data-dismiss="modal" aria-hidden="true"><img src="<?php echo $themeUrl; ?>/images/icons/close.png"></button>
            </div>
            <div class="clear-float sn-modal-title">
                <h1>Thank You for Voting!</h1>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div id="member">
                        <div class="member-thumb"><img src="<?php echo $themeUrl; ?>/images/profile-pic/<?php echo $profile_pic; ?>" height="74" width="74"></div>
                        <div class="member-text">
                            <div class="member-name" style="text-align:left;"><?php if (isset($user_first_name)) {
    echo $user_first_name;
}if (isset($user_last_name)) {
    echo ' ' . $user_last_name;
} ?></div>
                            <div class="member-address" style="text-align:left;"><?php if (isset($location)) {
    echo $location;
} ?></div>
                            <div class="member-title" style="text-align:left;"><?php if (isset($member_level)) {
    echo $member_level;
} ?></div>


                        </div>
                    </div>
                    <p>Thanks for voting for my video. If you could try to remember to vote for me everyday I would really appreciate it! The Video with the most votes win!</p>
                    <p>
                        And... if you haven't joined Karmora already, please do. Not just because I will earn 10 more votes, but because it is a lot of fun and a great place where you can save money, make money and win money! Oh yeah, and did I mention that it is absolutely FREE to join!</p>

                    <p>Thanks!</p>

                    <h3><?php if (isset($user_first_name)) {
    echo $user_first_name . ' ' . $user_last_name;
} ?> </h3>

<?php
if (!$this->session->userdata('front_data')) {
    ?>
                        <div class="form-group">

                            <a href="#" id="big-2-btn" data-toggle="modal" data-target="#signup_prize">Join Karmora</a>

                        </div>
<?php } ?>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- /Thanks --> 



<div id="voting_error"> 

    <!--modal for signin-->
    <div class="modal fade" id="thanks_voting_error" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-sm" style="border: none;">
            <div class="modal-content content_2" >
                <a href="#" class="close close-popup" data-dismiss="modal">
                    <img src="<?php echo $themeUrl; ?>/images/paymypurchase/close.png" />
                </a>

                <div class="modal-body" id="" style="text-align:center;">
                    <div class="pop-hading"> You have already voted for this video!</div>
                    <p>
                        Please come back in 24 hours and vote again!
                    </p>

                </div>
            </div>
        </div>
    </div>
</div>

