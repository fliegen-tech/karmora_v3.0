<!-- Start: Content -->
<?php $this->load->view('admin/page_javascript'); ?>
<section id="content">
    <div id="topbar">
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url() ?>admin/index"><i class="fa fa-home"></i></a></li>
            <li><a href="<?php echo base_url('admin/category/index') ?>">Category</a></li>
            <li class="active">Update Category</li>
        </ol>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-visible">
                    <div class="panel-heading">
                        <div class="panel-title"> <i class="fa fa-tag"></i> Update Category</div>
                    </div>
                    <div class="panel-body">
                        <?php if (isset($successmessage)) { ?><div class="alert alert-info"><?php echo $successmessage; ?></div><?php } ?>
                        <form class="form-horizontal" role="form" action="" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="action" value="edit_category" />
                            <input type="hidden" name="id" value="<?php echo $category_id?>" />

                            <div class="form-group">
                                <label class="col-lg-2 control-label">User Account Type</label>
                                <div class="col-md-4">
                                    <select class="form-control" name="fk_user_account_type_id[]" multiple="multiple" required="true">
                                        <?php
                                        if (!empty($UserAccountType)) {
                                            foreach ($UserAccountType as $cat) {
                                                ?>
                                                <option value="<?php echo $cat['pk_user_account_type_id']; ?>" 
                                                        <?php echo $controller->in_array_r($cat['pk_user_account_type_id'], $EditAccountType) ? "selected='selected'" : ""; ?> >
                                                            <?php echo $cat['user_account_type_title'] ?>
                                                </option>
                                            <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-2 control-label">Category Name</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control " placeholder="Name"  name= "cat_name" required="true" value="<?php echo $category_title ?>" />


                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Status</label>
                                <div class="col-md-4">
                                    <select class="form-control" name="cat_status">
                                        <option value="Active" <?php
                                        if ($category_status === "Active") {
                                            echo "selected=selected";
                                        }
                                        ?>>Active</option>
                                        <option value="Inactive" <?php
                                        if ($category_status === "Inactive") {
                                            echo "selected=selected";
                                        }
                                        ?>>Inactive</option>
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
                                    <textarea name="page_content" class="form-control" rows="10"  >
<?php echo $category_description; ?>
                                    </textarea>

                                </div> 
                            </div>
                            <div class="form-group">
                                <div class="col-lg-4 col-md-offset-2">
                                    <input type="submit" class="btn btn-success " value="Update" />

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