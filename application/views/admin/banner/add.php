
<section id="content">
    <div id="topbar">
        <ol class="breadcrumb">
            <li><a href="dashboard.html"><i class="fa fa-home"></i></a></li>
            <li><a href="<?php echo base_url('admin/banner'); ?>">Banner</a></li>
            <li class="active">Add Banner</li>
        </ol>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel">
                    <div class="panel-heading">
                        <div class="panel-title"> <i class="fa fa-pencil"></i> Add Banner </div>
                    </div>
                    <div class="panel-body">
                       <?php if(isset($successmessage)) {?><div class="alert alert-info"><?php echo $successmessage ;?></div><?php } ?>
                        <form class="form-horizontal" id="signupForm" method="post" enctype= "multipart/form-data"  >
							
                            <div class="form-group">
                            <label class="col-lg-2 control-label">User Account Type</label>
                                <div class="col-md-4">
                                 <select class="form-control" name="fk_user_account_type_id[]" multiple="multiple" required="">
                                <?php
										if(!empty($UserAccountType)){
                                        	foreach ($UserAccountType as $cat) {
                                            ?>
                                             <option value="<?php echo $cat['pk_user_account_type_id']; ?>"><?php echo $cat['user_account_type_title'] ?></option>

                                            <?php
                                        }}
                                        ?>
                                    </select>
                            </div>
                            </div>
                            
                            <div class="form-group">
                                <label  class="col-lg-2 control-label" for="">Select Banner Type</label>     
                                <div class="col-lg-4">
                                    <select name="banner_ads_banner_type" class="form-control" required="">
                                        <option value="">Select Banner Type</option>
                                        <option value="Slider">Slider</option>
                                        <option value="Banner">Banner</option>
                                    </select>
                                    <span class="error_message_class"><?php echo form_error('banner_ads_banner_type'); ?></span>
                                </div>

                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label" for="fk_affiliate_network_id">Select Affiliate Network</label>
                                <div class="col-lg-4">    
                                    <select name="fk_affiliate_network_id" class="form-control" >
                                        <option value="0">None</option>
                                        <?php
                                        if (!empty($affilate)) {
                                            foreach ($affilate as $af) {
                                                ?>
                                                <option value="<?php echo $af['pk_affiliate_network_id']; ?>"><?php echo $af['affiliate_network_name']; ?></option>  
                                                <?php
                                            }
                                        }
                                        ?>

                                    </select>
                                    <span class="error_message_class"><?php echo form_error('fk_affiliate_network_id'); ?></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label" for="banner_ads_use_sid">Use Sid</label>
                                <div class="col-lg-4">  
                                    <select name="banner_ads_use_sid" class="form-control" >
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>
                                    <span class="error_message_class"><?php echo form_error('banner_ads_use_sid'); ?></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label"  for="banner_ads_status">Status</label>
                                <div class="col-lg-4"> 
                                    <select name="banner_ads_status" class="form-control" >
                                        <option value="1">Active</option>
                                        <option value="0">In Active</option>
                                    </select>
                                    <span class="error_message_class"><?php echo form_error('banner_ads_status'); ?></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label  class="col-lg-2 control-label" for="firstname">Title</label>
                                <div class="col-lg-4"> 
                                    <input id="" value="<?php
                                    if (isset($_POST['banner_ads_title'])) {
                                        echo $_POST['banner_ads_title'];
                                    } else if (isset($banner_ads_title)) {
                                        echo $banner_ads_title;
                                    }
                                    ?>"  name="banner_ads_title" type="text" class="form-control" placeholder="Title" required/="" />
                                           <span class="error_message_class"><?php echo form_error('banner_ads_title'); ?></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label" for="firstname">Redirect Url</label>
                                <div class="col-lg-4"> 
                                    <input id="" value="<?php
                                    if (isset($_POST['banner_ads_redirect_url'])) {
                                        echo $_POST['banner_ads_redirect_url'];
                                    } else if (isset($banner_ads_redirect_url)) {
                                        echo $banner_ads_redirect_url;
                                    }
                                    ?>"  name="banner_ads_redirect_url" type="text" class="form-control" placeholder="Redirect Url" />
                                    <span class="error_message_class"><?php echo form_error('banner_ads_redirect_url'); ?></span>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-lg-2 control-label" for="firstname">Add Postion</label>
                                <div class="col-lg-4"> 
                                    <input type="text" class="form-control" name="banner_ads_position" value="<?php
                                    if (isset($_POST['banner_ads_position'])) {
                                        echo $_POST['banner_ads_position'];
                                    } else if (isset($banner_ads_position)) {
                                        echo $banner_ads_position;
                                    }
                                    ?>"  />
                                           <span class="error_message_class"><?php echo form_error('banner_ads_position'); ?></span>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-lg-2 control-label" for="firstname">Upload Image</label>
                                <div class="col-lg-4"> 
                                    <input type="file" name="photo_file" required/="" />
                                           <span class="error_message_class">
                                               <?php echo form_error('photo_file'); ?>
                                               <?php if (isset($image_error)) echo $image_error; ?>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-4 col-md-offset-2">
                                    <input class="submit btn btn-success" type="submit" name="submit" value="Add" />
                                    <input type="reset" class="btn btn-danger " value="Cancel" />
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
