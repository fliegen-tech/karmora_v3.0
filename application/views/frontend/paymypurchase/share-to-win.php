<?php $share_url = base_url('Pay4MyPurchase/vote'); ?>
<style>
    .css3-btn { font-size: 16px; color: #FFF; padding: 9px 17px; height: 40px; }
    #two-col-list h3{ text-align: center !important;}
    #auto-mate{ }
    #auto-mate input{ width:20px; height:20px; float:left; margin-right:10px; }
    #auto-mate span{ margin-top: 3px; float: left;}
</style>
<?php if ($this->session->flashdata('friends_msg') == 'success') { ?>
    <script type="text/javascript">
        $(window).load(function () {
            $('#payModal').modal('show');
        });


    </script>

<?php } ?>
<?php
$link = 'href="' . base_url('upgrade') . '"';
if (isset($user_type) && ($user_type == 1 || $user_type == 2)) {
    // if user is already a webstore owner show pop-up
    $link = 'data-target="#amazon" data-toggle="modal" href="#"';
}
?>    
<link rel="stylesheet" type="text/css" href="<?php echo $themeUrl ?>/css/mediaboxAdv-Dark.css" />
<script src="<?php echo $themeUrl ?>/js/mootools-core-1.3.2.js"></script>
<script src="<?php echo $themeUrl ?>/js/mediaboxAdv.js"></script>
<link type="text/css" href="<?php echo $themeUrl; ?>/css/style_popup.css" rel="stylesheet" />
<script>
/// code for close fb share popup don't remove this code thanks NR
        var chk = '<?php echo $this->input->get('post_id', true) ?>';

        if (chk !== '') {
            self.close();
        }
</script>
<div class="container" id="pay4mypurchase_v2">
    <div class="row border-bottom ">
        <div class="col-sm-12 col-md-12 col-lg-12">
            <h1 class="main-heading">Sharing Good Karmora is as easy as 1...2...3</h1>
            <h2>Build Your Own Karmora Community of Shoppers and make some Cash!</h2>
            <p style="text-align:center;">Use our three step approach to building a strong community of shoppers where, as a <a <?php echo $link; ?>>Webstore Owner</a>,  you can earn 20% commission on the cash back paid to every member of your 
                shopping community. Community members can consist of friends & family members; acquaintances like neighbors, waiters, coworkers and hair stylists; or even better... fundraising 
                organizations like athletics teams, clubs, charities and religious organizations.</p>
            <!-- row --> 

        </div>
    </div>
    <!-------four-boxes---->
    <div class="row" id="two-col-list">
        <div class="col-md-12" style="text-align:center;">
            <h2 class=" col-xs-10 col-md-5 col-centered numbers-heading">
                <div class="h-number">1</div>
                Share some Good Karmora by email!</h2>
            <p>You can share Good Karmora via email and start building your Shopping Community in four very simple steps!    </p>
        </div>
        <div class="clearfix"></div>
        <h4 class=" col-xs-10 col-md-7 col-centered numbering">
            <div class="h-numbering">Step<br/><span>1</span></div>
            Select an email platform </h4>
        <div class="col-xs-12 col-sm-12 col-md-12" id="left-col" style="text-align:center;">
            <h3 class="text-center" style="color:#000; margin-bottom:0px; text-align:center;">Share With All Your Friends</h3>
            <div  id="share-circle" style="margin-top:20px; margin-bottom:0px;"> 
                <!--<a href="#" class="circle">
                            <div class="icon">
                                <div class="image aa"></div>
                            </div>
                            <div id="icon-title">Yahoo</div>
                        </a> -->
                <?php
                if (isset($list_link)) {
                    echo $list_link;
                }
                ?>
                <!--<a href="#" class="circle">
                            <div class="icon">
                                <div class="image bb"></div>
                            </div>
                            <div id="icon-title">MSN</div>
                        </a>-->
                <?php
                if (isset($msn_link)) {
                    echo $msn_link;
                }
                ?>
                <a href="javascript:;" onclick="targetout()" class="circle">
                    <div class="icon">
                        <div class="image dd"></div>
                    </div>
                    <div id="icon-title">Outlook</div>
                </a> 
                <!--<a href="#" class="circle">
                            <div class="icon">
                                <div class="image ff"></div>
                            </div>
                            <div id="icon-title">Gmail</div>
                        </a>-->
                <?php
                if (isset($gmail_link)) {
                    echo $gmail_link;
                }
                ?>
                <div class="clearfix"></div>
                <p>&nbsp;</p>
                <p>Choose an email account and all of your contacts will be sent an invite to join your Karmora Shopping Community.</p>
            </div>
            <div class="clearfix"></div>

        </div>
        <div class="clearfix"></div>
        <div class="col-md-6 col-centered">
            <div class="h2-line">
                <h2 style="background:#FFF; text-align:center; margin-bottom:0px; width:50px; margin-left:45%">OR</h2>
                <div class="clearfix"></div>
            </div>
        </div>
        <div class="clearfix"></div>
        <form id="formpromotion" method="post">
            <div class="col-xs-12 col-sm-6 col-md-6 col-centered " style="text-align:center;" >
                <h2>Share With Just Your Besties</h2>
                <div class="row"></div>
                <div class="clearfix"></div>
                <?php //echo $this->session->flashdata('friends_msg');  ?>
                <?php //echo form_error('friends_email');  ?>
                </br>
                <div class="row" id="invite-friend-div">
                    <div class="col-md-12">
                        <input type="text" placeholder="Friend&acute;s Name " name="friends_name[]"  class=" col-xs-12 col-sm-6 col-md-6 ">
                        <input type="email" placeholder="Friend&acute;s Email " name="friends_email[]" class=" col-xs-12 col-sm-6 col-md-6 " required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-centered" style="text-align:center;"> <br/>
                        <button type="button" id="addmore" class=" col-md-8 btn btn-default col-centered" style="display:inline-block; margin-bottom:10px;"> Add Another Friend </button>
                    </div>
                </div>
            </div>

            <div class="clearfix" style="margin-bottom:20px;"></div>
            <h4 class=" col-xs-10 col-md-7 col-centered numbering">
                <div class="h-numbering">Step<br/><span>2</span></div>
                Choose how often you would like to send your invite</h4>
            <div class="col-md-5 col-centered" id="radio-checkbox">
                <div class="checkbox-div">
                </div>

            </div>
            <script>
                $(document).ready(function () {
                    $("#no-thanks").click(function () {
                        $("#automail").hide();
                    });
                    $("#yes").click(function () {
                        $("#automail").show();
                    });
                });
            </script>

            <?php if (!$this->session->userdata('front_data')) {
                
            } else {
                ?>


    <?php if (!empty($automated_list)) { ?>
                    <div id="automail"> 
                        <div class="row">

                            <div class=" col-xs-12 col-sm-8 col-md-6 col-centered" id="auto-mate" style="margin-top:20px;margin-bottom:20px;">
                                <div class="col-xs-3 col-sm-3 col-md-3 "><input type="radio" name="automated_emails" /> <span> Just Once </span></div>
                                <div class="col-xs-3 col-sm-3 col-md-3 "><input type="radio" disabled="" name="automated_emails" <?php
                                                                                if ($automated_list[0]['email_frequency'] == 1) {
                                                                                    echo 'checked="checked"';
                                                                                }
                                                                                ?> value="1" /> <span> Daily </span></div>
                                <div class="col-xs-3 col-sm-3 col-md-3 "><input type="radio" disabled="" name="automated_emails" <?php
                                    if ($automated_list[0]['email_frequency'] == 7) {
                                        echo 'checked="checked"';
                                    }
                                    ?> value="7" />  <span> Weekly </span></div>
                                <div class="col-xs-3 col-sm-3 col-md-3 "><input type="radio" disabled="" name="automated_emails" <?php
                                    if ($automated_list[0]['email_frequency'] == 30) {
                                        echo 'checked="checked"';
                                    }
                                    ?> value="30" />  <span> Monthly </span></div>
                            </div>
                            <div class="col-md-12"><br></div>
                            <div class="checkbox-div">
                                <p style="text-align: center;">
                                    <a href="<?php echo base_url('Pay4MyPurchase/automated_email_delate'); ?>">Click Here</a> to stop Automated Emails
                                </p> 
                            </div>
                        </div>

                    </div> 
    <?php } else { ?>
                    <div id="automail"> 
                        <div class="row">

                            <div class=" col-xs-12 col-sm-8 col-md-6 col-centered" id="auto-mate" style="margin-top:20px;margin-bottom:20px;">
                                <div class="col-xs-3 col-sm-3 col-md-3 "><input type="radio" name="automated_emails" /> <span> Just Once </span></div>
                                <div class="col-xs-3 col-sm-3 col-md-3 "><input type="radio" onclick="automated_emails_call(this.value)" name="automated_emails" value="1" /> <span> Daily </span></div>
                                <div class="col-xs-3 col-sm-3 col-md-3 "><input type="radio" onclick="automated_emails_call(this.value)" name="automated_emails" value="7" />  <span> Weekly </span></div>
                                <div class="col-xs-3 col-sm-3 col-md-3 "><input type="radio" onclick="automated_emails_call(this.value)" name="automated_emails" value="30" />  <span> Monthly </span></div>
                            </div>
                        </div>

                    </div>
    <?php } ?>
<?php } ?>






            <div class="col-xs-12 col-sm-12  col-md-12">
                <div class="clearfix" style="margin-bottom:20px;"></div>
                <div class="row">
                    <h4 class=" col-xs-10 col-md-7 col-centered numbering">
                        <div class="h-numbering">Step<br/>
                            <span>3</span></div>
                        Preview &amp; Send Your Invite</h4>
                    <div class="col-md-4 col-centered" style="text-align:center;"> <br/>
                        
                        <a target="_blank" href='<?php echo base_url('Pay4MyPurchase/preview');?>' name="submit" class=" col-md-6 btn btn-default ">Preview Email</a>
                        <button type="submit" onclick="submitdata('Pay4MyPurchase/sharetowin')" class=" col-md-5  btn btn-default"> Send </button>
                    </div>
                </div>


                <h4 class=" col-xs-10 col-md-7 col-centered numbering">
                    <div class="h-numbering">Step<br/><span>4</span></div>Track Your Invitations</h4>

                <div class="col-md-4">
                    <div class="panel-group" id="accordion">
                        <div class="panel panel-default">
                            <div class="panel-heading" id="social-btn-r">
                                <h4 class="panel-title" >
<?php
if (isset($login_link)) {
    echo $login_link;
} else {
    ?>
                                        <a data-toggle="modal" data-target="#shoppersInvited">
<?php } ?>
                                        <!--<a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">--> Shoppers Invited </a> </h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="panel-group" id="accordion">
                        <div class="panel panel-default">
                            <div class="panel-heading" id="social-btn-r">
                                <h4 class="panel-title" >
<?php
if (isset($login_link)) {
    echo $login_link;
} else {
    ?>
                                        <a data-toggle="modal" data-target="#shoppersInCommunity">
<?php } ?>
                                        <!--<a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">--> Shoppers in your community </a> </h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="panel-group" id="accordion">
                        <div class="panel panel-default">
                            <div class="panel-heading" id="social-btn-r">
                                <h4 class="panel-title" >
<?php
if (isset($login_link)) {
    echo $login_link;
} else {
    ?>
                                        <a data-toggle="modal" data-target="#shoppersThinking">
<?php } ?>
                                        <!--<a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">--> Shoppers still thinking about joining your Community </a> </h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="row" id="four-boxes">
        <div class="col-md-12" style="text-align:center;"><h2 class="col-md-5 col-centered numbers-heading"><div class="h-number">2</div>
                Ask for votes via Social Media!</h2>
            <div class="col-md-8 col-centered">
                <div class="col-md-5">
                    <div id="now-showing" style="padding-top:0px;">
                        <a href="<?php echo base_url() ?>Pay4MyPurchase/vote">
                            <img src="<?php echo $themeUrl ?>/images/promotions/pay4mypurchase/<?php echo $image ?>" class="img-responsive" />
                        </a>
                    </div>
                    <br/>
                    <?php
//echo $media_url;
                    $path = urlencode($themeUrl . '/images/mix/share-bot.png');
                    $url = urlencode(base_url("Pay4MyPurchase/vote"));
                    $r_url = urlencode(base_url('Pay4MyPurchase/sharetowin'));
                    $title = urlencode('Help Me Win and Vote 4 My Video!');
                    $caption = urlencode('Join Karmora.com 4 FREE and earn up to 30% Cash Back from over 1,700 stores!');
                    $description = urlencode('I have entered the Karmora.com #Pay4MyPurchase video contest.  The person with the most votes can win up to $250.  Please help me and vote for my video every day!');
                    $img = $themeUrl . '/images/promotions/pay4mypurchase/' . $image;
                    $picture = urlencode($img);
                    $fb = "https://www.facebook.com/dialog/feed?app_id=1455287054704424&display=popup&name=" . $title . "&caption=" . $caption . "&link=" . $url . "&redirect_uri=" . $r_url . "&description=" . $description . "&picture=" . $picture;
                    ?>

                    <!--<a href="<?php //echo $fb; ?>">--> 
                    <a href="javascript: void(0)" onclick="window.open('<?php echo $fb; ?>', 'Sharer', 'toolbar=0,status=0,width=548,height=325');" target="_parent">
                        <img class="imgSocialIcon" src="<?php echo $themeUrl; ?>/images/icons/share-on-facebook.jpg" alt="share on facebook" > 
                    </a>
                    <a onclick="window.open('https://twitter.com/intent/tweet?url=<?php echo $url; ?>&amp;text=<?php echo $title; ?>', 'sharer', 'toolbar=0,status=0,width=548,height=325');" target="_blank" href="javascript: void(0)"> <img class="imgSocialIcon" alt="tweet" src="<?php echo $themeUrl; ?>/images/icons/tweeticons.png"> </a> 
                    <a onclick="window.open('http://www.pinterest.com/pin/create/button/?url=<?php echo $url; ?>&amp;media=<?php echo $picture ?>&amp;description=<?php echo $title; ?>', 'sharer', 'toolbar=0,status=0,width=548,height=325');" target="_blank" href="javascript: void(0)"> <img class="imgSocialIcon" alt="Pin it" src="<?php echo $themeUrl; ?>/images/icons/pinit_fg_en_rect_gray_20.png"> </a> 

    <!--<img src="<?php //echo $themeUrl;   ?>/images/mix/share-bot.png" class="img-responsive">-->
                </div>
                <div class="col-md-7" style="text-align:left">
                    <br/>
                    <br/>
                    <p>&nbsp;</p>
                    <p>Share this clickable banner via social media everyday! If clicked it will take your follower to your vote page.</p>

                    <p>Here’s how... Simply click on the channel you would like to share it on and write something snappy like, “Check out my video. If you like it... please vote for it everyday.  The contestant with the most votes wins.  Thanks for your support!</p>
                </div>

            </div>

        </div>
    </div>
    </br>
    </br>
    </br>
    <div class="row" style="text-align:center;">
        <div class="col-md-12">
            <h2 class="col-md-5 col-centered numbers-heading">
                <div class="h-number">3</div>
                Ask for votes in person!</h2>
            <div class="col-md-8 col-centered">
                <div class="col-md-5"><img src="<?php echo $themeUrl; ?>/images/mix/person.png" class="img-responsive"></div>
                <div class="col-md-7" style="text-align:left"><p>Ask anyone you see in public to vote for your video from their smart phone, tablet, or PC.  </p>
                    <p>If you really want to win, invite them to join your shopping community so that they too can earn up to 30% Cash Back on their purchases and you can generate an additional 10 votes on the spot!  </p>
                    <p>Remember, it’s FREE to join!</p>
                    <p>Now go out there and get them votes!</p>
                </div>

            </div>
        </div>
    </div>
</div>




<!-- Dashboard -->

<!-- .container #pay4mypurchase_v2 --> 
<!-- Shoppers Invited Modal -->
<div class="modal fade" id="shoppersInvited" tabindex="-1" role="dialog" aria-labelledby="signupModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="row row-offset-control modal-content">
            <div class="row row-offset-control">
                <button type="button" class="close close-popup" data-dismiss="modal" aria-hidden="true"><img src="<?php echo $themeUrl; ?>/images/icons/close.png"></button>
            </div>
            <div class="clear-float sn-modal-title">
                <h1>Shoppers Invited</h1>
                <div id="collapseOne" class="panel-collapse collapse <?php
                            if (!isset($login_link)) {
                                echo "in";
                            }
                            ?>">
                    <div class="panel-body">
                        <div class="col-md-12 table-responsive">
<?php
if (!empty($ShopperInvited)) {
    ?>
                                <table class="table table-striped custab" width="100%">
                                    <thead>
                                        <tr>
                                            <th>E-mail</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <?php
                                    foreach ($ShopperInvited as $row) {
                                        ?>
                                        <tr>
                                            <td align="left" width="75%"><?php echo $row['email']; ?></td>
                                            <td align="left" width="25%">Invited</td>
                                        </tr>
    <?php } ?>
                                </table>
    <?php
} else {
    echo '<div class="alert alert-info" role="alert">List is empty.</div>';
}
?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Shoppers In Your Community Modal -->
<div class="modal fade" id="shoppersInCommunity" tabindex="-1" role="dialog" aria-labelledby="signupModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="row row-offset-control modal-content">
            <div class="row row-offset-control">
                <button type="button" class="close close-popup" data-dismiss="modal" aria-hidden="true"><img src="<?php echo $themeUrl; ?>/images/icons/close.png"></button>
            </div>
            <div class="clear-float sn-modal-title">
                <h1>Shoppers In Your Community</h1>
                <div id="collapseTwo" class="panel-collapse collapse <?php
                            if (!isset($login_link)) {
                                echo "in";
                            }
                            ?>">
                    <div class="panel-body">
                        <div class="col-md-12 table-responsive">
<?php if (!empty($ShopperCommunity)) {
    ?>
                                <table class="table table-striped custab">
                                    <thead>
                                        <tr>
                                            <th>E-mail</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <?php
                                    foreach ($ShopperCommunity as $row) {
                                        ?>
                                        <tr>
                                            <td align="left"><?php echo $row['user_email']; ?></td>
                                            <td align="left">Joined</td>
                                        </tr>
                                <?php }
                                ?>
                                </table>
    <?php
} else {
    echo '<div class="alert alert-info" role="alert">List is empty.</div>';
}
?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Shoppers Thinking Modal -->
<div class="modal fade" id="shoppersThinking" tabindex="-1" role="dialog" aria-labelledby="signupModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="row row-offset-control modal-content">
            <div class="row row-offset-control">
                <button type="button" class="close close-popup" data-dismiss="modal" aria-hidden="true"><img src="<?php echo $themeUrl; ?>/images/icons/close.png"></button>
            </div>
            <div class="clear-float sn-modal-title">
                <h1>Shoppers Still Thinking About Joining Your Community</h1>
                <div id="collapseThree" class="panel-collapse collapse <?php
                            if (!isset($login_link)) {
                                echo "in";
                            }
                            ?>">
                    <div class="panel-body">
                        <div class="col-md-12 table-responsive">
<?php
if (!empty($aboutJoining)) {
    ?>
                                <table class="table table-striped custab">
                                    <thead>
                                        <tr>
                                            <th>E-mail</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <?php
                                    foreach ($aboutJoining as $row) {
                                        ?>
                                        <tr>
                                            <td align="left"><?php echo $row['email']; ?></td>
                                            <td align="left">Pending</td>
                                        </tr>
                                <?php }
                                ?>
                                </table>
    <?php
} else {
    echo '<div class="alert alert-info" role="alert">List is empty.</div>';
}
?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $("#addmore").click(function () {

        var html = '<div class="col-md-12"><input type="text" placeholder="Friend&acute;s Name " name="friends_name[]"  class=" col-xs-12 col-sm-6 col-md-6 "><input type="email" placeholder="Friend&acute;s Email " name="friends_email[]" class=" col-xs-12 col-sm-6 col-md-6"></div>';
        $("#invite-friend-div").append(html)
    });
</script>

<script>
    function targetout() {

        window.location = "mailto:";

    }
</script>
<script>
    function submitPreview(action)
    {
        var form = document.getElementById("formpromotion");
        form.noValidate = true;
        document.getElementById('formpromotion').action = action;
        document.getElementById('formpromotion').target = '_blank';
        document.getElementById('formpromotion').submit();

    }

    function submitdata(action)
    {
        var emailform = $("#formpromotion");
        emailform.noValidate = false;
        emailform.action = action;
        emailform.target = '_parent';
        emailform.submit();
    }

</script>
<script>
    function check_email(val) {
        if (!val.match(/\S+@\S+\.\S+/)) { // Jaymon's / Squirtle's solution
            // Do something
            return false;
        }
        if (val.indexOf(' ') != -1 || val.indexOf('..') != -1) {
            // Do something
            return false;
        }
        return true;
    }
</script>
<div id="fb-root"></div>
<script>
    (function (d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id))
            return;
        js = d.createElement(s);
        js.id = id;
        js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&appId=1415931638658243&version=v2.0";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
</script>
<!--Already Webstore Owner Modal-->
<div class="modal fade" id="payModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="row row-offset-control modal-content">
            <div class="row row-offset-control">
                <button type="button" class=" close close-popup" data-dismiss="modal"  aria-hidden="true"><img src="<?php echo $themeUrl ?>/images/close.png"></button>
            </div>
            <div class="clear-float sn-modal-title">
                <h2><span class="highlight">Success is Yours!  Your emails have been scheduled for delivery.</span></h2>
            </div>

        </div>
    </div>
</div>
<script>
    function appendRadio() {
        var automate = document.getElementById('automate');
        if (automate.checked) {
            document.getElementById('append-radio').style.display = 'block';
        } else {
            document.getElementById('append-radio').style.display = 'none';
        }

    }
</script>
<script>
    function automated_emails_call(time_selected) {
        var autoText = '';
        if(time_selected === "1"){
            autoText = 'daily';
        }else if(time_selected === "7"){
            autoText = 'weekly';
        }else{
            autoText = 'monthly';
        }
        jQuery.ajax({
            type: 'POST',
            url: baseurl + 'Pay4MyPurchase/automated_email/' + time_selected,
            context: document.body,
            error: function (data, transport) {
                alert("Sorry, the operation is failed.");
            },
            success: function (data) {
                alert('You have successfully scheduled your invites for '+autoText+' delivery');
                //location.href = baseurl+'share';

            }
        });
    }

</script>

<style>
    #append-radio{ 
        display: none;
    }
</style>