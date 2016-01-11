

<section id="content">
    <div id="topbar">
        <ol class="breadcrumb">
            <li><a href="dashboard.html"><i class="fa fa-home"></i></a></li>
            <li><a href="<?php echo base_url('admin/video/index'); ?>">Videos</a></li>
            <li class="active"><?php if ($video_id!=0) {
    echo "Update";
} else echo "Add"; ?> Videos</li>
        </ol>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel">
                    <div class="panel-heading">
                        <div class="panel-title"> <i class="fa fa-pencil"></i> <?php if ($video_id!=0) {
    echo "Update";
} else echo "Add"; ?> Video </div>
                    </div>
                    <div class="panel-body">
<?php echo $this->session->flashdata('successmessage'); ?>
                        <form class="form-horizontal" id="signupForm" action="<?php echo base_url('admin/video/save'); ?>" method="post" enctype="multipart/form-data" >


                            <div class="form-group">
                                <label class="col-lg-2 control-label">User Account Type</label>
                                <div class="col-md-4">
                                    <select class="form-control" name="fk_user_account_type_id[]" multiple="multiple" required="">
<?php
if (!empty($UserAccountType)) {
    foreach ($UserAccountType as $cat) {
        ?>
                                                <option <?php if (isset($video_id) && $video_id != '') {
                                            echo $controller->in_array_r($cat['pk_user_account_type_id'], $EditAccountType) ? "selected='selected'" : "";
                                        } ?>  value="<?php echo $cat['pk_user_account_type_id']; ?>"><?php echo $cat['user_account_type_title'] ?></option>

        <?php
    }
}
?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Video Category</label>
                                <div class="col-md-4">
                                    <select class="form-control" name="video_cat[]"  multiple="multiple" required="">
                                        <?php
                                        if (!empty($videocats)) {
                                            foreach ($videocats as $cat) {
                                                ?>
                                                <option <?php if (isset($video_id) && $video_id != '') {
                                            echo $controller->in_array_r($cat['pk_category_id'], $EditVideo) ? "selected='selected'" : "";
                                        } ?>    value="<?php echo $cat['pk_category_id']; ?>"><?php echo $cat['category_title'] ?></option>

        <?php
    }
}
?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-2 control-label" for="fk_affiliate_network_id">Video Title</label>
                                <div class="col-lg-4">
                                    <input class="form-control" placeholder="Title"  type="text" name="video_title" value="<?php echo isset($video_title) ? $video_title : set_value('video_title'); ?>" />
                                    <span class="error_message_class"><?php echo form_error('video_title'); ?></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-2 control-label" for="fk_affiliate_network_id">Video Link:</label>
                                <div class="col-lg-4">
                                    <input class="form-control" placeholder="Video Link"  type="text" name="video_link" value="<?php echo isset($video_link) ? $video_link : set_value('video_link'); ?>" />
                                    <span class="error_message_class"><?php echo form_error('video_link'); ?></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-2 control-label" for="fk_affiliate_network_id">Video Cover photo:</label>
                                <div class="col-lg-4">
                                    <input type="file" name="cover_photo" />
                                    <span class="error_message_class"> <?php echo form_error('cover_photo'); ?></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-lg-4 col-md-offset-2">
                                    <input class="submit btn btn-success" type="submit" name="submit" value="<?php if ($video_id!=0) {
    echo "Update";
} else echo "Add"; ?>"/>
                                    <input type="reset" class="btn btn-danger " value="Cancel" />
                                </div>
                            </div>           	
                            <input type="hidden" name="video_id" value="<?php echo isset($video_id) ? $video_id : 0; ?>"  />
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
