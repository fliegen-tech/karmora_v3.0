<link rel="stylesheet" type="text/css" href="http://staging.leadzgen.com/assets/dashboard/vendor/plugins/datatables/css/datatables.min.css" />

<script type="text/javascript" language="javascript" class="init">


    $(document).ready(function () {
           var oTable = $('#example').dataTable();
    });
</script>
<section id="content">
    <div id="topbar">
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url() ?>admin/index"><i class="fa fa-home"></i></a></li>
            <li><a href="<?php echo base_url('admin/video/add') ?>">Add Videos</a></li>
            <li class="active">Videos</li>
        </ol>
    </div>
    <div class="container">
        <div class="row">

            <div class="col-md-12">
                <div class="panel panel-visible">
                    <div class="panel-heading">
                        <div class="panel-title"> <i class="fa fa-tag"></i> Videos List</div>
                    </div>
                    <div class="panel-body">
                       <?php echo $this->session->flashdata('successmessage'); ?>
                
				<?php if(!empty($videos)){ ?>
                
				<table id="example" class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Video Title</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                            
                        <?php include('grid.php');?>
                
                
                            </tbody>
                        </table>
                   
                     <?php }else{ ?>
                        <div class="alert alert-info">No records found</div>
                     <?php }?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- End: Content --> 
</div>

<?php
/* * **************************************
 * Creating Modals for Status and delete
 * ************************************** */
if (!empty($videos)) {
    foreach ($videos as $video) {
        if ($video['video_status'] === "Active") {
            ?>
            <div class="modal fade" id="<?php echo $video['pk_video_id'] ?>-active" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-dialog-sm">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title text-center">Are you sure?</h4>
                        </div>
                        <div class="modal-body">
                            <p class="margin-bottom-lg">You want to change the video_status?</p>
                            <div class="form-group text-center">
                                <a href="<?php echo site_url('admin/video/changestatus/' . $video["pk_video_id"] . '/' . $video["video_status"] ); ?>" class="btn btn-success btn-gradient margin-right-sm"><i class="fa fa-check"></i> Yes</a>

                                <button type="button" class="btn btn-danger btn-gradient" data-dismiss="modal"><i class="fa fa-warning"></i> No</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        } else if ($video['video_status'] === "Inactive") {
            ?>
            <div class="modal fade" id="<?php echo $video['pk_video_id']; ?>-inactive" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-dialog-sm">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title text-center">Are you sure?</h4>
                        </div>
                        <div class="modal-body">
                            <p class="margin-bottom-lg">You want to change the video_status?</p>
                            <div class="form-group text-center">
                                <a href="<?php echo site_url('admin/video/changestatus/' . $video["pk_video_id"] . '/' . $video["video_status"]); ?>" class="btn btn-success btn-gradient margin-right-sm"><i class="fa fa-check"></i> Yes</a>

                                <button type="button" class="btn btn-danger btn-gradient" data-dismiss="modal"><i class="fa fa-warning"></i> No</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>
        <div class="modal fade" id="<?php echo $video['pk_video_id']; ?>-delete" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title text-center">Are you sure?</h4>
                    </div>
                    <div class="modal-body">
                        <p class="margin-bottom-lg">You want to delete?</p>
                        <div class="form-group text-center">
                            <a href="<?php echo site_url('admin/video/delete/' . $video["pk_video_id"] . '/'.$video['video_cover_photo']); ?>" class="btn btn-success btn-gradient margin-right-sm"><i class="fa fa-check"></i> Yes</a>

                            <button type="button" class="btn btn-danger btn-gradient" data-dismiss="modal"><i class="fa fa-warning"></i> No</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
}
?>


