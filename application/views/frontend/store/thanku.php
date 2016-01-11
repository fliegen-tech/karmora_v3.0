<div class="bodyWrap">
<?php //echo $url;?>

    <div class="containerH">
        <!--breadDiv -->
        <?php
        if (isset($login_check) && $login_check == 'login') {
            ?>
            <div class="alert alert-warning" role="alert">
                Please <a data-target="#loginModal" data-toggle="modal" href="#"><b>LOGIN</b></a> to proceed.</div>
            <?php
        }
        ?>
        <table width="1000" border="0" cellspacing="0" cellpadding="0">
            <tbody><tr>
                    <td width="650" height="608" align="center" valign="middle" class="bg"><table width="530" border="0" cellspacing="0" cellpadding="0">
                            <tbody><tr>
                                    <td align="center" valign="middle"><p class="heading2"><strong>One  moment please </strong> <img src="<?php echo $themeUrl; ?>/images/loader.gif" alt="..."></p>
                                        <span class="heading2">You are being transferred to one of our Premier Advertisers<br>
                                        </span><span class="heading3"><strong><?php echo $title; ?></strong></span><span class="heading2"><br>
                                            to complete your Karmora Shopping Experience.</span></td>
                                </tr>
                                <tr>
                                    <td height="30" align="center" valign="middle">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td height="30" align="center" valign="middle" class="border">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td align="center" valign="middle"><table width="400" border="0" cellspacing="0" cellpadding="0">
                                            <tbody><tr>
                                                    <!-- <td width="114"> <img width="50" height="50" src="<?php echo $themeUrl; ?>/images/profile-pic/<?php echo $profilePic; ?>" class="memberPic border-img"></td> -->
                                                    <td style="text-align: center" colspan="2" width="286" class="heading3"><strong>Shopping from a desktop or laptop computer is the safest way to ensure you receive credit for your purchase, as not all advertisers are able to track purchases from smart phones and tablet computers. Have a great day... and thanks for shopping with Karmora!</strong></td>
                                                </tr>
                                            </tbody></table></td>
                                </tr>
                            </tbody></table></td>
                </tr>
            </tbody></table>

    </div>
    <!--containerH -->
</div>
<div class="modal fade" id="Success" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="row row-offset-control modal-content " style="text-align:center;">
            <div class="row row-offset-control">
                <button type="button" class=" close close-popup" data-dismiss="modal" aria-hidden="true" onclick="redirectOnClose()"><img src="<?php echo $themeUrl; ?>/images/icons/close.png"></button>
            </div>
            </br></br>
            <img src="<?php echo $themeUrl; ?>/images/mix/cartoon-1.png" class="img-responsive col-centered";  >
            <div class="clear-float sn-modal-title">
                <h1>Aarrrghhh….you&acute;ve found $<?php echo $prize; ?>!</h1>
            </div>
            <div class="row">
                <div class="col-md-12 col-centered">
                    <p>Your treasure has been deposited into your My Cash Back on your Karmora.com account!<br>
                        Go crazy and spend it wherever, whenever and however you want!<br>
                        Or choose to cash out and stash it away in your own buried treasure chest, we don&acute;t care.<br>
                        Just don&acute;t leave a treasure map laying around, we can&acute;t guarantee we won&acute;t go searching for it.We are pirates after all!<br>
                         <br>
                        Thanks for participating in our promotion!<br>
                        Come back tomorrow and try your luck again for some more buried treasure!</p>
                    <p></p>
                    <p></p>

                </div>

            </div>
        </div>
    </div>
</div>
<?php /*if (isset($prize)) { ?>  
    <script type="text/javascript">
        $(window).load(function() {
            $('#Success').modal('show');
        });
    </script>
<?php } */?>
<?php if (isset($login_check) && $login_check == 'login') { ?>

    <script type="text/javascript">
        $(window).load(function() {
            $('#loginModal').modal('show');
        });
    </script>	
    <?php
} else {
    if (isset($prize)) {
        ?>
        <script type="text/javascript">
            $(window).load(function() {
                $('#Success').modal({
                    show: true,
                    keyboard: false,
                    backdrop: 'static'
                });
            });
        </script>
    <?php } else { ?>

        <script>
            function timedRefresh(timeoutPeriod) {
                setTimeout("location.href='<?php echo $url; ?>'", timeoutPeriod);
            }
            timedRefresh(900);
        </script>
        <?php
    }
}
//$url =  $store_url;
//header( "refresh:8;url=".$url); 
?>
<script>
function redirectOnClose() {
   setTimeout("location.href='<?php echo $url; ?>'");
}
</script>

