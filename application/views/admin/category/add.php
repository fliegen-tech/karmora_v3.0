<!-- Start: Content -->
<?php $this->load->view('admin/page_javascript'); ?>
<section id="content">
    <div id="topbar">
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url() ?>admin/index"><i class="fa fa-home"></i></a></li>
            <li><a href="#">Home</a></li>
            <li class="active">Dashboard</li>
        </ol>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-visible">
                    <div class="panel-heading">
                        <div class="panel-title"> <i class="fa fa-tag"></i> Add Category</div>
                    </div>
                    <div class="panel-body">
                    <?php if(isset($successmessage)) {?><div class="alert alert-info"><?php echo $successmessage ;?></div><?php } ?>
                        <form class="form-horizontal" role="form" action="<?php echo site_url() ?>admin/category/addCategory" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="action" value="add_category" />


                            <div class="form-group">
                                <label class="col-lg-2 control-label">User Account Type</label>
                                <div class="col-md-4">
                                    <select class="form-control" name="fk_user_account_type_id[]" multiple="multiple" required="">
                                        <?php
                                        if (!empty($UserAccountType)) {
                                            foreach ($UserAccountType as $cat) {
                                                ?>
                                                <option value="<?php echo $cat['pk_user_account_type_id']; ?>"><?php echo $cat['user_account_type_title'] ?></option>

                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                    <span class="error_message_class"><?php echo form_error('fk_user_account_type_id'); ?></span>   
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-2 control-label">Category Name</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control " placeholder="Name"  name= "cat_name" required="true" />

                                    <span class="error_message_class"><?php echo form_error('cat_name'); ?></span>    
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Parent Category</label>
                                <div class="col-md-4">
                                    <select class="form-control" name="parent_cat">
                                        <option value="0">None</option>
                                        <?php
                                        foreach ($catData as $cat) {
                                            ?>
                                            <option value="<?php echo $cat['pk_category_id']; ?>"><?php echo $cat['category_title'] ?></option>

                                            <?php
                                        }
                                        ?>
                                    </select>

                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Status</label>
                                <div class="col-md-4">
                                    <select class="form-control" name="cat_status">
                                        <option value="Active">Active</option>
                                        <option value="Inactive">Inactive</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Banner Image</label>
                                <div class="col-md-4">
                                    <input type ="file" name="cat_image" />
                                </div>
                            </div>
                            <div class="form-group">
                                    <label class="col-lg-2 control-label" for="firstname">Description</label>
                                    <div class="col-lg-4">  
                                        <textarea name="page_content" class="form-control" rows="10"  ><?php
                                            if (isset($_POST['page_content'])) {
                                                echo $_POST['page_content'];
                                            }
                                            ?>
                                        </textarea>
                                        <span class="error_message_class"><?php echo form_error('page_content'); ?></span>
                                    </div> 
                                </div>
                            <div class="form-group">
                                <div class="col-lg-4 col-md-offset-2">
                                    <input type="submit" class="btn btn-success " value="Add" />

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

<!-- End: Content --> 
</div>