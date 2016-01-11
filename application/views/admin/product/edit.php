<?php echo $header; ?>
<?php echo $sidebar; ?>

<section id="content">
    <div id="topbar">
        <ol class="breadcrumb">
            <li><a href="dashboard.html"><i class="fa fa-home"></i></a></li>
            <li><a href="<?php echo base_url('admin/product'); ?>">Product</a></li>
            <li class="active">Edit Product</li>
        </ol>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel">
                    <div class="panel-heading">
                        <div class="panel-title"> <i class="fa fa-pencil"></i> Edit Product </div>
                    </div>
                    <div class="panel-body">
                       <?php if(isset($successmessage)) {?><div class="alert alert-info"><?php echo $successmessage ;?></div><?php } ?>
                        <form class="form-horizontal" id="signupForm" method="post" enctype= "multipart/form-data"  >
			
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Product Category</label>
                                <div class="col-md-4">
                                    <select class="form-control" multiple="multiple" disabled="disabled"  name="parent_cat[]">
                                        <?php
                                        if(!empty($product_cat)){ 
                                            foreach ($product_cat as $cat) {
                                            ?>
                                            <option <?php if (isset($pk_product_id) && $pk_product_id != '') { echo $controller->in_array_r($cat['pk_category_id'], $Edit_product_ca) ? "selected='selected'" : ""; } ?> value="<?php echo $cat['pk_category_id']; ?>"><?php echo $cat['category_title'] ;?></option>
                                        <?php }} ?>
                                    </select>

                                </div>
                            </div>
                            
                            
                            <div class="form-group">
                                <label  class="col-lg-2 control-label" for="firstname">Product Title</label>
                                <div class="col-lg-4"> 
                                    <input id="" value="<?php
                                    if (isset($_POST['product_title'])) {
                                        echo $_POST['product_title'];
                                    } else if (isset($product_title)) {
                                        echo $product_title;
                                    }
                                    ?>"  name="product_title" type="text" class="form-control" placeholder="Title" required="" />
                                           <span class="error_message_class"><?php echo form_error('product_title'); ?></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label  class="col-lg-2 control-label" for="firstname">Product Price</label>
                                <div class="col-lg-4"> 
                                    <input id="" value="<?php
                                    if (isset($_POST['product_price'])) {
                                        echo $_POST['product_price'];
                                    } else if (isset($product_price)) {
                                        echo $product_price;
                                    }
                                    ?>"  name="product_price" type="text" class="form-control" placeholder="Price" required="" />
                                           <span class="error_message_class"><?php echo form_error('product_price'); ?></span>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label  class="col-lg-2 control-label" for="firstname">Is Featured Product</label>
                                <div class="col-lg-4"> 
                                    <input type="checkbox" name="product_is_fetured" value="1" <?php if(isset($_POST['product_is_fetured'])){ echo $_POST['product_is_fetured'];}else if(isset($product_is_fetured) && $product_is_fetured == 1){ echo 'checked="checked"';} ?>>
                                           <span class="error_message_class"><?php echo form_error('product_is_fetured'); ?></span>
                                </div>
                            </div>
                            
                           <div class="form-group">
                                <label  class="col-lg-2 control-label" for="firstname">Product Short Description</label>
                                <div class="col-lg-4"> 
                                    <input id="" value="<?php
                                    if (isset($_POST['product_short_description'])) {
                                        echo $_POST['product_short_description'];
                                    } else if (isset($product_short_description)) {
                                        echo $product_short_description;
                                    }
                                    ?>"  name="product_short_description" type="text" class="form-control" placeholder="Product Short Description" required="" />
                                           <span class="error_message_class"><?php echo form_error('product_short_description'); ?></span>
                                </div>
                            </div>
                            
                           <div class="form-group">
                                <label  class="col-lg-2 control-label" for="firstname">Product Detail</label>
                                <div class="col-lg-4"> 
                                    <textarea name="product_detail" required="required"><?php if(isset($product_detail)){ echo $product_detail;} ?> </textarea>
                                           <span class="error_message_class"><?php echo form_error('product_detail'); ?></span>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label  class="col-lg-2 control-label" for="firstname">Product How To Use</label>
                                <div class="col-lg-4"> 
                                    <textarea name="product_how_to_use"> <?php if(isset($product_how_to_use)){ echo $product_how_to_use;} ?></textarea>
                                           
                                </div>
                            </div>
                            <div class="form-group">
                                <label  class="col-lg-2 control-label" for="firstname">Product Ingredients</label>
                                <div class="col-lg-4"> 
                                    <textarea name="product_ingredients"><?php if(isset($product_ingredients)){ echo $product_ingredients;} ?> </textarea>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label  class="col-lg-2 control-label" for="firstname">Product Meta Tag</label>
                                <div class="col-lg-4"> 
                                    <input id="" value="<?php
                                    if (isset($_POST['product_meta_tag'])) {
                                        echo $_POST['product_meta_tag'];
                                    } else if (isset($product_meta_tag)) {
                                        echo $product_meta_tag;
                                    }
                                    ?>"  name="product_meta_tag" type="text" class="form-control" placeholder="Product Meta Tag" required="" />
                                           <span class="error_message_class"><?php echo form_error('product_meta_tag'); ?></span>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label  class="col-lg-2 control-label" for="firstname">Product Meta Description</label>
                                <div class="col-lg-4"> 
                                    <input id="" value="<?php
                                    if (isset($_POST['product_meta_description'])) {
                                        echo $_POST['product_meta_description'];
                                    } else if (isset($product_meta_description)) {
                                        echo $product_meta_description;
                                    }
                                    ?>"  name="product_meta_description" type="text" class="form-control" placeholder="Product Meta Description" required="" />
                                           <span class="error_message_class"><?php echo form_error('product_meta_description'); ?></span>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <div class="col-lg-4 col-md-offset-2">
                                    <input class="submit btn btn-success" type="submit" name="submit" value="Update" />
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

<?php echo $footer; ?> 