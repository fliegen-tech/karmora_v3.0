<?php echo $header; ?>
<?php echo $sidebar; ?>

<style>
    .error_message_class{
        color:red;
        font-weight:bolder;
    }
</style>

<section id="content">
    <div id="topbar">
        <ol class="breadcrumb">
            <li><a href="dashboard.html"><i class="fa fa-home"></i></a></li>
            <li><a href="<?php echo base_url('admin/banner/index'); ?>">Banner</a></li>
            <li class="active">Edit Banner</li>
        </ol>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel">
                    <div class="panel-heading">
                        <div class="panel-title"> <i class="fa fa-pencil"></i> Edit Banner </div>
                    </div>
                    <div class="panel-body">
                        <?php if (isset($successmessage)) { ?><div class="alert alert-info"><?php echo $successmessage; ?></div><?php } ?>
                        <form class="form-horizontal" id="signupForm" method="post" enctype= "multipart/form-data"  >
                            
                            <div class="form-group">
                            <label class="col-lg-2 control-label">User Account Type</label>
                                <div class="col-md-4">
                                 <select class="form-control" name="fk_user_account_type_id[]" multiple="multiple" required="">
                                <?php
										if(!empty($UserAccountType)){
                                        	foreach ($UserAccountType as $cat) {
                                            ?>
                                             <option <?php  echo $controller->in_array_r($cat['pk_user_account_type_id'], $EditAccountType) ? "selected='selected'" : "";?>  value="<?php echo $cat['pk_user_account_type_id']; ?>"><?php echo $cat['user_account_type_title'] ?></option>

                                            <?php
                                        }}
                                        ?>
                                    </select>
                            </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="firstname" class="col-lg-2 control-label">Title</label>
                                <div class="col-lg-4">
                                    <input id="" value="<?php echo $banner_ads_title; ?>" readonly="" name="banner_ads_title" type="text" class="form-control" placeholder="Title"  />
                                </div>
                            </div> 
                            <div class="form-group">
                                <label for="firstname" class="col-lg-2 control-label">Type</label>
                                <div class="col-lg-4">
                                    <input id="" value="<?php echo $banner_ads_banner_type; ?>" readonly="" name="banner_ads_title" type="text" class="form-control" placeholder="Title"  />
                                </div>
                            </div> 
                            <div class="form-group">
                                <label for="firstname" class="col-lg-2 control-label"> Image</label>
                                <div class="col-lg-4">
                                    <img width="250" src="<?php echo base_url() . 'public/images/banner/' . $banner_ads_image; ?>">
                                </div>
                            </div> 
                            <div class="form-group">
                                <label class="col-lg-2 control-label" for="firstname">Redirect Url</label>
                                <div class="col-lg-4"> 
                                    <input id="" value="<?php if(isset($_POST['banner_ads_redirect_url'])){ echo $_POST['banner_ads_redirect_url'];}else{echo $banner_ads_redirect_url;} ?>"  name="banner_ads_redirect_url" type="text" class="form-control" placeholder="Redirect Url" />
                                    <span class="error_message_class"><?php echo form_error('banner_ads_redirect_url'); ?></span>
                                </div>
                            </div> 
                            
                            <div class="form-group">
                                <label class="col-lg-2 control-label" for="firstname">Add Postion</label>
                                <div class="col-lg-4"> 
                                    <input type="text" class="form-control" name="banner_ads_postion" value="<?php
                                    if (isset($_POST['banner_ads_postion'])) {
                                        echo $_POST['banner_ads_postion'];
                                    } else if (isset($banner_ads_postion)) {
                                        echo $banner_ads_postion;
                                    }
                                    ?>"  />
                                           <span class="error_message_class"><?php echo form_error('banner_ads_postion'); ?></span>
                                </div>
                            </div>
                            
                            <div class="form-group" >
                                <label for="banner_ads_use_sid" class="col-lg-2 control-label">Use Sid</label>
                                <div class="col-lg-4">
                                    <select name="banner_ads_use_sid" class="form-control" >
                                        <option value="Yes" <?php echo ($banner_ads_use_sid == 'Yes') ? 'selected="selected"' : ''; ?>>Yes</option>
                                        <option value="No" <?php echo ($banner_ads_use_sid == 'No') ? 'selected="selected"' : ''; ?>>No</option>
                                    </select>
                                    <span class="error_message_class"><?php echo form_error('banner_ads_use_sid'); ?></span>
                                </div>

                            </div>


                            <br>


                            <div class="form-group">
                                <div class="col-lg-4 col-md-offset-2">
                                    <input class="submit btn btn-blue" type="submit" name="submit" value="Submit" />
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php echo $footer; ?> 