
<?php $this->load->view('admin/page_javascript'); ?>



<section id="content">
    <div id="topbar">
        <ol class="breadcrumb">
            <li><a href="dashboard.html"><i class="fa fa-home"></i></a></li>
            <li><a href="<?php echo base_url('admin/news_sticker'); ?>">News Sticker</a></li>
            <li class="active">Add News Sticker</li>
        </ol>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel">
                    <div class="panel-heading">
                        <div class="panel-title"> <i class="fa fa-pencil"></i> Add News Sticker </div>
                    </div>
                    <div class="panel-body">
                        <?php if (isset($successmessage)) { ?><div class="alert alert-info"><?php echo $successmessage; ?></div><?php } ?>
                        <?php $this->form_validation->set_error_delimiters('<span class="formerror">&nbsp;', '</span>'); ?>
                        <form class="form-horizontal" action="<?php echo base_url('admin/news_sticker/add'); ?>" method="post">

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
                                <label class="col-lg-2 control-label" for="store_title">Title</label>
                                <div class="col-lg-4">
                                <input id="" name="title" value="<?php echo isset($title) ? $title : set_value('title'); ?>" type="text" class="form-control" placeholder="Title" required/="" />
                                       <span class="error_message_class"><?php echo form_error('title'); ?></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-2 control-label" for="store_title">Description</label>
                                <div class="col-lg-4">
                                <textarea cclass="form-control" rows="10"    name="description"><?php echo isset($description) ? $description : set_value('description'); ?></textarea>
                                <span class="error_message_class"><?php echo form_error('description'); ?></span>
                            </div> 
                            </div>

                            <div class="form-group">
                                <div class="col-lg-4 col-md-offset-2">
                        
                                      <input type="submit" class="btn btn-success " name="submit" value="Add" />

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