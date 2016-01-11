<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="max-width:500px;">
        <div class="row row-offset-control modal-content">
            <div class="row row-offset-control">
                <button type="button" class=" close close-popup" data-dismiss="modal" aria-hidden="true"><img src="<?php echo $themeUrl ?>/images/close.png"></button>
            </div>
            <div class="clear-float sn-modal-title">
                <h2><span class="highlight">Login</span></h2>
                <h4><span class="highlight" id="sucessfully"></span></h4>
            </div>
            <div class="signup-options login-options">
                <div class="md-form-bg">
                    <form method="post" action="#" id="form-signin">
                        <div class="form-inner">
                            <h3>Please Login</h3>
                            <div class="form-fields">
                                <input type="text" placeholder="Username OR Email address" name="username"/>
                                <input type="password" placeholder="Password" name="password" />
                                <input type="hidden" name="redirectUrl" value="<?php echo $_SERVER['REQUEST_URI']; ?>">
                            </div>
                        </div>
                        <a class="btn-submit" href="javascript:;" type="submit" id="login_submit"> <span class="start-shopping" style="margin-top: 10px;" >Login</span> </a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>