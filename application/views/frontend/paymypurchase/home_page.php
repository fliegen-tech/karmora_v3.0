
<?php if (isset($login) && ($login != '')) { ?>  
    <script type="text/javascript">
        $(window).load(function () {
            $('#loginModal').modal('show');
        });
    </script>

<?php } ?>
<div class="container" id="pay4mypurchase_v2">
    <div class="row ">
        <div class="col-sm-12 col-md-12 col-lg-12">
            <h1 class="main-heading">#Pay4MyPurchase</h1>
            <h2>You bought it... You love it... We want to pay for it!</h2>
            <?php if (isset($pending_approval) && $pending_approval !== FALSE) { ?>
                <h2>Your Video Is Pending Approval</h2>
            <?php } ?>
            <h3>Getting your most recent Karmora purchase paid for is as easy as 1... 2... 3!</h3>

            <!-- row -->

        </div>
    </div>


    <div class="row" id="four-boxes">

        <!-- four-boxes -->
        <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
            <div class="box">
                <video width="245" height="245" controls>
                    <source src="https://www.karmora.com/videos/come_on_karmora.mp4" type="video/mp4">
                    
                </video> 
                
                <div class="space"></div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
            <div class="box">
                <div class="icon">
                    <div class="info" style=" min-height:245px;">
                        <div class="image">
                            <div class="img-numbers">1</div>
                        </div>
                        </br>
                        <p>Record a funny video reviewing your purchase and simply ask "Karmora... Please #Pay4MyPurchase" at the end your clip!</p>
                    </div>
                </div>
                <div class="space"></div>
            </div>
        </div>
        <div class="clearfix visible-sm"></div>
        <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
            <div class="box">
                <div class="icon">
                    <div class="info" style=" min-height:245px;">
                        <div class="image">
                            <div class="img-numbers">2</div>
                        </div>

                        </br>
                        </br>
                        <p>Submit your video by<br>
                            <?php
                            if (isset($pending_approval) && $pending_approval) {
                                ?>
                                <a href="" data-toggle="modal" data-target="#pending_approval">clicking here!</a>
                                <?php
                            } else {
                                ?><a href="<?php echo base_url('Pay4MyPurchase/submit') ?>">clicking here!</a><?php
                            }
                            ?>


                        <p>It's really simple!</p>
                    </div>
                </div>
                <div class="space"></div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
            <div class="box">
                <div class="icon">
                    <div class="info" style=" min-height:245px;">
                        <div class="image">
                            <div class="img-numbers">3</div>
                        </div>
<!--                        <p>Share your video by<br>
                            //<?php
//                            if (isset($pending_approval) && $pending_approval) {
//                                
                        ?>
                                <a href="" data-toggle="modal" data-target="#pending_approval">clicking here!</a>
                                //<?php
//                            } elseif (isset($pending_approval) && !$pending_approval) {
//                                
                        ?><a href="<?php // echo base_url('Pay4MyPurchase/share') ?>">clicking here!</a><?php
//                            } else {
//                                
                        ?><a href="<?php // echo base_url('Pay4MyPurchase/share')  ?>">clicking here!</a><?php
//                            }
//                            
                        ?>
                        </p>-->
                        <p>Once your video is approved, share it daily.  The video with the most votes wins!</p>
                    </div>
                </div>
                <div class="space"></div>
            </div>
        </div>
        <!-- /Boxes de Acoes -->

    </div>  


    <!-------four-boxes---->

    <div class="row" id="two-col-list">
        <div class="col-xs-12 col-sm-6 col-md-6" id="left-col">
            <h3>Do's</h3>
            <ul >
                <li style="font-size:16px;">Be funny! We want to see excitement, creativity,and a little bit of craziness!</li>
                <li style="font-size:16px;"> Record something memorable, you want people to talk about it!</li>
                <li style="font-size:16px;"> Spread the word about your video!</li>
                <li style="font-size:16px;"> Read our ridiculously funny rules! Do it!</li>
            </ul>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-6" >
            <h3>Don'ts</h3>
            <ul >
                <li style="font-size:16px;">Be boring, no one wants to vote for a boring video! </li>
                <li style="font-size:16px;"> Use profanity. No one likes a potty mouth!</li>
                <li style="font-size:16px;"> No Nudity. We're not interested. We promise!</li>
                <li style="font-size:16px;"> Anything illegal. Seriously. Just don't….Ever!</li>
            </ul>
        </div>
    </div>



    <!-- -----four-boxes-- -->

    <div class="row " >
        <div class=" col-xs-10 col-sm-4 col-md-3  col-centered">
            <button href="#" class=" col-md-12 css3-btn  " id="roules-btn-css3" data-toggle="modal" data-target="#funnyroules" > Ridiculously Funny Rules! </button>
        </div>
    </div>
    <div class="col-sm-12" style="text-align: center;">
        <br>Winner will be announced February 28, 2015
    </div>
    <div class="col-md-12" id="videos" style="margin-top: 50px; text-align: center;"></div>
    <!--    <div class="row" id="four-videos" >
            <h3 class="text-left">Need some ideas? Check these out...</h3>
            <div class="col-xs-12 col-sm-12 col-mds-12 col-lg-12 no-offset featured-slider">  
    
    
                
                    <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3" id="pay4mypurchase_1">
                        <div class="box">
                            <iframe class="icon" src="http://www.youtube.com/embed/JHMivBScoic" style="min-height: 245px; width: 100%;" class="info">
                            </iframe>
                            <div class="space"></div>
                        </div>
    
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3" id="pay4mypurchase_2">
                        <div class="box">
                            <iframe class="icon" src="http://www.youtube.com/embed/B-eZaWbo-40" style="min-height: 245px; width: 100%;" class="info">
                            </iframe>
                            <div class="space"></div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3" id="pay4mypurchase_3">
                        <div class="box">
                            <iframe class="icon" src="http://www.youtube.com/embed/pntik3BqO5Y" style="min-height: 245px; width: 100%;" class="info">
                            </iframe>
                            <div class="space"></div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3" id="pay4mypurchase_4">
                        <div class="box">
                            <iframe class="icon" src="http://www.youtube.com/embed/vD9SwOVhQVs" style="min-height: 245px; width: 100%;" class="info">
                            </iframe>
                            <div class="space"></div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3" id="pay4mypurchase_5">
                        <div class="box">
                            <iframe class="icon" src="http://www.youtube.com/embed/vD9SwOVhQVs" style="min-height: 245px; width: 100%;" class="info">
                            </iframe>
                            <div class="space"></div>
                        </div>
                    </div>
                    
                
    
                <a class="left carousel-control prev"  data-slide="prev" style="left: auto; right: 35px;">
                    <i class="fa icon-chevron-left fa-inverse fa-3"></i>
                </a>
                <a class="right carousel-control next"  data-slide="next">
                    <i class="fa icon-chevron-right fa-inverse fa-3"></i>
                </a>
        
            </div>  
        </div>-->
    <div class="row" id="four-videos" >
        <h3 class="text-left">Vote For Your Favorite Videos !</h3>
        <div class="col-xs-12 col-sm-12 col-mds-12 col-lg-12 no-offset featured-slider">  

            <?php
            $i = 1;
            if (isset($promotionalVideos)) {
                //echo '<pre>';
                //   print_r($promotionalVideos);
                //   echo '</pre>';
                foreach ($promotionalVideos as $promotionalVideo) {
                    ?>
                    <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3" id="pay4mypurchase_<?php echo $i; ?>" <?php if ($i >= 8) {
                        echo 'style="display:none"';
                    } ?>>
                        <div class="box">

                            <?php if ($promotionalVideo['video_type'] === 'youtube') { ?>
                                <?php
                                $vUr = str_replace("watch?v=", "embed/", $promotionalVideo['media']);
                                $array2 = explode('&list=', $vUr);
                                $vUrl = str_replace("http:", "https:", $array2[0]);
                                if (strpos($vUrl, 'http://') !== 0 && strpos($vUrl, 'https://') !== 0) {
                                    $vUrl = 'https://' . $vUrl;
                                }
                                if (isset($array2[0])) {
                                    $vUrl = $array2[0];
                                } else {
                                    $vUrl = $vUr;
                                }
                                ?>
                                <iframe class="icon" src="<?php echo $vUrl . '?wmode=transparent'; ?>" style="min-height: 245px; width: 100%;" class="info"></iframe>
        <?php } else { ?>
                                <video controls="controls"  width="255" height="215">
            <?php $vUrl = str_replace("http:", "https:", $promotionalVideo['media']); ?>
                                    <source src="<?php echo $promotionalVideo['media']; ?>" >
                                </video>
        <?php } ?>
                            <div class="space"></div>
                            <div class="row" align="center" style="">


                                <div class=" col-xs-12 col-sm-10 col-md-12 col-centered" id="vote-vid">
                                    <a href="javascript:;" class="vote" onclick="karmora_likes('<?php echo $promotionalVideo['promation_pk_id']; ?>')" > 
                                        <img src="<?php echo $themeUrl; ?>/images/paymypurchase/karmora_vote.png" /> 
                                    </a>
                                    <div class="voting-numbers">
                                        <b class="textp"  id="count_value-<?php echo $promotionalVideo['promation_pk_id']; ?>"> 
        <?php echo ($promotionalVideo['votescount'] > 0 ? $promotionalVideo['votescount'] : 0); ?>
                                        </b>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>


                            </div>
                        </div>
                    </div>
        <?php
        $i++;
    }
}
?>
            <p id="view-more" style="cursor: pointer" class="pull-right"><a>see more</a></p>
            <input id="show-video" type="hidden" value="8"/>
            <input id="total-video" type="hidden" value="<?php echo $i; ?>"/>
            <!--
                        <a class="left carousel-control prev"  data-slide="prev" style="left: auto; right: 35px;">
                            <i class="fa icon-chevron-left fa-inverse fa-3"></i>
                        </a>
                        <a class="right carousel-control next"  data-slide="next">
                            <i class="fa icon-chevron-right fa-inverse fa-3"></i>
                        </a>-->
            <script>
                $(document).ready(function () {
                    var total_video = $("#total-video").val();

                    if (total_video <= 8) {
                        $("#view-more").hide();
                    }
                });
                $("#view-more").click(function () {
                    var loop = $("#show-video").val();
                    var loop_r = (parseInt(loop) + 8);
                    for (var i = 1; i <= loop_r; i++) {
                        $("#pay4mypurchase_" + i).show();

                        if (i == $("#total-video").val()) {
                            $("#view-more").hide();
                        }
                    }

                });
            </script>
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
                    <li>You must be a Karmora member to participate. Everyone who is anyone is a Karmora member!</li>
                    <li>          Your purchase must have been made through your Karmora webstore. We do not give prize money to people willing to pay full price because they are obviously made of money and don't need it!</li>
                    <li>Don't procrastinate! This isn't homework or doing the dishes! The sooner you submit your video the more time you have to gain votes. We will not accept votes or videos after February 25, 2015 at 11:59:59 PM Arizona Time (we never have to change our clocks... how sweet is that!).</li>
                    <li>          If using Instagram, make sure your profile is viewable to the public and/or we are connected. Ya know, you like us, we like you, so we follow each other. We can't guarantee we won't comment on all your selfies though!</li>
                    <li>          Only videos containing funny, hilarious, crazy, entertaining, goofy, silly, or otherwise awesome content will be accepted for voting. Once accepted you will receive an email with your very own voting page to send to your peeps so they can hook you up with some righteous votes!</li>
                    <li>          This is a PG Rated video promotion. Videos containing naughty stuff like profanity, nudity, or illegal activity will be viewed, probably laughed at, and then moved to the "X" rated vault and will never see the light of day!</li>
                    <li>          Don't be a pirate. We cannot use videos with licensed music. If you use licensed music your video will walk the plank and drown in the Karmora Abyss. In land lover terms... your video will be rejected!</li>
                    <li>          Be shameless! Invite everyone you know to vote for your video everyday. The video with the most votes gets the prize. You and your righteous peeps are limited to one vote per IP address per day.</li>
                    <li>          Be even more than shameless and invite your friends to join your Karmora community and receive 10 votes for every person that joins. Who doesn't like saving money, making money and having fun?</li>
                    <li>          We're not the Federal Reserve and we can't print money... yet :) We will pay for your purchase up to $250 regardless of your purchase amount. If you buy a Rolex for $10 Gazillion dollars you will only get a check for $250 from the Bank of Karmora!</li>
                    <li>          We are nice, but not that nice. If you buy a pair of Crocs for $49 you will get a $49 check as your prize. Perhaps you should consider purchasing a pair of Crocs for each of your five Croc-a-Kids and maximize your prize potential! Please don't call us and say what a Croc-of-Poo it is that you only won $49 if you only buy a single pair.</li>
                    <li>          Your purchase amount will be added to your eWallet and will be available for immediate collection.</li>
                    <li> Cheaters Never Win! If you get caught cheating for votes we will disqualify you and chant "cheater, cheater, cheater!"</li>
                    <li>          In the event of a tie, Karmora staff in their unquestionable, undeniable, remarkable, just, fair and sole discretion will determine the winner.</li>
                    <li> Be a horrible winner and brag as much as possible to everyone you know (and don't know) about winning the promotion and how smart, funny and creative your are. And... after you catch your breath and your arm stops cramping from patting yourself on the back invite hem to join your Karmora Shopping Community!</li>
                    <li> Don't be a cry baby if you lose. No one likes a cry baby! Besides, this promotion is bound by our mem- bership Terms of Use which strictly prohibits crying. Seriously, we're not kidding. Well... kinda.</li>
                    <li> Winner will be announced on February 28, 2015.</li>
                </ul>
            </div>
        </div>
    </div>
</div> 

<!-- Pending Approval Modal -->
<div class="modal fade" id="pending_approval" tabindex="-1" role="dialog" aria-labelledby="signupModalLabel" aria-hidden="true">
    <div class="modal-dialog pfmp">
        <div class="row row-offset-control modal-content">
            <div class="row row-offset-control">
                <button type="button" class=" close close-popup" data-dismiss="modal" aria-hidden="true"><img src="<?php echo $themeUrl; ?>/images/icons/close.png"></button>
            </div>
            <div class="clear-float sn-modal-title">
                <h1>Video Pending Review&excl;</h1>
                <p>You have already entered Karmora&acute;s &num;Pay4MyPurchase video promotion&excl; The review process can take up to 24 hours&semi; so sit back&comma; relax and do a little online shopping while you wait&excl;</p>
                <p>As always&comma; we wish you Good Luck&comma; Good Fortune and Good Karmora&excl;</p>
                <br><br>

                <div class="row " style="margin-top: 25px;">
                    <div class=" col-xs-10 col-sm-4 col-md-4  col-centered">
                        <a class="col-md-12 css3-btn" style="color: #ffffff; padding: 5px 0px;" href="<?php echo base_url('store') ?>">View All Stores</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 
<script>
    function instragram(img_upda, url_update) {

        document.getElementById("videos").innerHTML = "";
        document.getElementById("videos").innerHTML = "<video controls='controls' poster='" + img_upda + "' class='img-responsive' ><source src='" + url_update + "' type='video/mp4'></video>";
    }
</script>
<script>
    function youtube(img_upda, url_update) {

        var iframyoutube = '<iframe width="100%" height="360" src="' + url_update + '" frameborder="0" allowfullscreen=""><img src="' + img_upda + '" class="img-responsive" />"' + img_upda + '"</iframe>';
        document.getElementById("videos").innerHTML = "";
        document.getElementById("videos").innerHTML = iframyoutube;
    }
</script>
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
                    $('#count_value-' + fk_prmotion_id).html('');
                    $('#count_value-' + fk_prmotion_id).html(data);
                    //$('#Thanks').modal('show');
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
                            <div class="member-name" style="text-align:left;"><?php
                                if (isset($user_first_name)) {
                                    echo $user_first_name;
                                }if (isset($user_last_name)) {
                                    echo ' ' . $user_last_name;
                                }
                                ?></div>
                            <div class="member-address" style="text-align:left;"><?php
                                if (isset($location)) {
                                    echo $location;
                                }
                                ?></div>
                            <div class="member-title" style="text-align:left;"><?php
                        if (isset($member_level)) {
                            echo $member_level;
                        }
                        ?></div>


                        </div>
                    </div>
                    <p>Thanks for voting for my video. If you could try to remember to vote for me everyday I would really appreciate it! The three Video with the most votes win!</p>
                    <p>
                        And... if you haven't joined Karmora already, please do. Not just because I will earn 10 more votes, but because it is a lot of fun and a great place where you can save money, make money and win money! Oh yeah, and did I mention that it is absolutely FREE to join!</p>

                    <p>Thanks!</p>

                    <h3><?php
                        if (isset($user_first_name)) {
                            echo $user_first_name . ' ' . $user_last_name;
                        }
                        ?> </h3>

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

