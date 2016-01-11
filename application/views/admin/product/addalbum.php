<div id="check">
    <section id="content">
        <div id="topbar">
            <ol class="breadcrumb">
                <li><a href="<?php echo site_url() ?>admin/index"><i class="fa fa-home"></i></a></li>
                <li class="active">Add Album </li>
            </ol>
        </div>
        <div class="container">
            <div class="col-md-5 col-lg-12">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel profile-panel">
                            <div class="panel-heading">
                                <div class="panel-title"> <i class="fa fa-user"></i> Product Detail</div>
                            </div>
                            
                            <form class="form-horizontal" id="signupForm" method="post" enctype= "multipart/form-data"  >
                            <div class="panel-footer">
                                <div class="row">

                                    <div class="col-md-12">
                                       <div class="console-btn console-alt console-block">
                                            <div class="console-icon"> <span class="glyphicons glyphicons-wrench"></span> </div>
                                            <div class="console-text">
                                                <div class="console-title"><input type="file" name="files[]" multiple ></div>
                                                <br>
                                                <div class="console-title"><input class="submit btn btn-success" type="submit" name="submit" value="Upload" /></div>
                                            </div>
                                        </div>
                                        <label  for="category" class="control-label">Product Album Images</label>
                                        <div class="controls controls-row" style="margin-top: 10px;" >
                                        <?php define('IMAGEPATH', FCPATH . '/public/images/product/'.$pk_product_id.'/album/'); ?>   
                                        <div class="col-md-12">
                                         <?php foreach (glob(IMAGEPATH.'*') as $filename) { ?>   
                                            <div class="col-md-2" style="margin-bottom: 20px;"><img src="<?php echo base_url() . 'public/images/product/'.$pk_product_id .'/album/'.basename($filename); ?>" style="height:80px;max-width:80px"></div>
                                         <?php } ?>
                                        </div>   
                                        </div>
                            
                                        
                                    </div>
                                </div>
                            </div>
                            </form>
                            <div class="panel-body">
                                <div class="row">
                                    <?php if (isset($successmessage)) { ?><div class="alert alert-info"><?php echo $successmessage; ?></div><?php } ?>
                                                    
                                                <div class="col-xs-2" id="profile-avatar"><span class="profile-name"> <b class="text-primary">Main Image</b></span> <img src="<?php echo base_url() . 'public/images/product' . '/' . $product_image; ?>" class="img-responsive" width="180" height="150" alt="avatar" /> </div>
                                                <div class="col-xs-10">
                                                    <div class="profile-data"> 


                                                        <ul class="profile-info list-unstyled">
                                                            <li style="padding:10px;"><b class="text-primary" style="margin-right: 50px;">Product Title:</b> <?php echo $product_title; ?></li>
                                                            <li style="padding:10px;"><b class="text-primary" style="margin-right: 50px;">Product SKU:</b> <?php echo $product_sku; ?></li>
                                                            <li style="padding:10px;"><b class="text-primary" style="margin-right: 30px;">Product IS Featured:</b> <?php if($product_is_fetured == 1){echo 'Yes';}else{ echo 'No';} ?></li>
                                                            <li style="padding:10px;"><b class="text-primary" style="margin-right: 50px;">Product Since:</b> <?php echo $product_create_date; ?></li>
                                                            <li style="padding:10px;"><b class="text-primary" style="margin-right: 50px;">Product Price:</b> <?php echo $product_price; ?></li>
                                                            <li style="padding:10px;"><b class="text-primary" style="margin-right: 50px;">Product Status:</b> <?php echo $product_status; ?></li>
                                                            <li style="padding:10px;"><b class="text-primary" style="margin-right: 50px;">Product Short Description:</b> <?php echo $product_short_description; ?></li>
                                                            <li style="padding:10px;"><b class="text-primary" style="margin-right: 50px;">Product Detail:</b> <?php echo $product_detail; ?></li>

                                                        </ul>

                                                    </div>
                                                </div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                                
                        </div>
                        
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- End: Content --> 
</div>
</div>






