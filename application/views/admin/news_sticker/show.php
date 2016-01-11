<link rel="stylesheet" type="text/css" href="http://staging.leadzgen.com/assets/dashboard/vendor/plugins/datatables/css/datatables.min.css" />

<script type="text/javascript" language="javascript" class="init">


    $(document).ready(function () {
           var oTable = $('#example').dataTable();
           oTable.fnSort( [ [1,'desc'] ] );
    });
</script>
<section id="content">
    <div id="topbar">
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url() ?>admin/index"><i class="fa fa-home"></i></a></li>
            <li><a href="<?php echo base_url('admin/news_sticker/add'); ?>">Add News Sticker</a></li>
            <li class="active">News Sticker</li>
        </ol>
    </div>
    <div class="container">
        <div class="row">

            <div class="col-md-12">
                <div class="panel panel-visible">
                    <div class="panel-heading">
                        <div class="panel-title"> <i class="fa fa-tag"></i> News Sticker List</div>
                    </div>
                    <div class="panel-body">
                        <?php if(isset($successmessage)) {?><div class="alert alert-info"><?php echo $successmessage ;?></div><?php } ?>
  	  			<?php if (!empty($hi_everyone)) { ?>
                        <table id="example" class="table table-striped table-bordered table-hover">
                	<thead>
                        <tr>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th>Action</th>
                    </tr>
                    </thead>
                     <tbody>
                     <?php
                                
                                    foreach ($hi_everyone as $cat) {
                                        ?>
                        <tr>
                            <td><?php echo $cat['news_ticker_title'] ;?></td>
                            <td><?php echo $cat['news_ticker_description']; ?></td>
                            <td class="hidden-xs">
                                                <?php
                                                $status = $cat['news_ticker_status'];
                                                if ($status === "Active") { ?>
                                                <a href="#" class="tableLinks" data-toggle="modal" data-target="#<?php echo $cat['pk_news_ticker_id'] ?>-active">
                                                    <i class="fa fa-eye" title="Make inactive"></i>
                                                </a>
                                                 <?php
                                                } else{ ?>
                                                   <a href="#" class="tableLinks" data-toggle="modal" data-target="#<?php echo $cat['pk_news_ticker_id'] ?>-inactive">
                                                    <i class="fa fa-eye-slash" title="Make active"></i>
                                                </a>

                                                <?php }?>

                                            </td>
                            					<td>
                                                <a href="<?php echo base_url() . 'admin/news_sticker/edit/' . $cat['pk_news_ticker_id']; ?>" class="tableLinks">
                                                    <i class="fa fa-edit" title="Edit"></i>
                                                </a> &nbsp; &nbsp;&nbsp;
                                                
                                                     <a href="#" class="tableLinks" data-toggle="modal" data-target="#<?php echo $cat['pk_news_ticker_id'] ?>-delete">
                                                <i class="fa fa-trash-o" title="Delete"></i>
                                            </a>
                                                </td>
                        </tr>
                      <?php } ?>  
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
if (!empty($hi_everyone)) {
foreach ($hi_everyone as $cat) {
    if ($cat['news_ticker_status'] === "Active") {
        ?>
        <div class="modal fade" id="<?php echo $cat['pk_news_ticker_id'] ?>-active" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title text-center">Are you sure?</h4>
                    </div>
                    <div class="modal-body">
                        <p class="margin-bottom-lg">You want to change the status?</p>
                        <div class="form-group text-center">
                            <a href="<?php echo site_url('admin/news_sticker/status/' . $cat["pk_news_ticker_id"] . '/' . $cat["news_ticker_status"]); ?>" class="btn btn-success btn-gradient margin-right-sm"><i class="fa fa-check"></i> Yes</a>

                            <button type="button" class="btn btn-danger btn-gradient" data-dismiss="modal"><i class="fa fa-warning"></i> No</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
    } else if ($cat['news_ticker_status'] === "Inactive") {
        ?>
        <div class="modal fade" id="<?php echo $cat['pk_news_ticker_id']; ?>-inactive" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title text-center">Are you sure?</h4>
                    </div>
                    <div class="modal-body">
                        <p class="margin-bottom-lg">You want to change the status?</p>
                        <div class="form-group text-center">
                            <a href="<?php echo site_url('admin/news_sticker/status/' . $cat["pk_news_ticker_id"] . '/' . $cat["news_ticker_status"] ); ?>" class="btn btn-success btn-gradient margin-right-sm"><i class="fa fa-check"></i> Yes</a>

                            <button type="button" class="btn btn-danger btn-gradient" data-dismiss="modal"><i class="fa fa-warning"></i> No</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
    ?>
    <div class="modal fade" id="<?php echo $cat['pk_news_ticker_id']; ?>-delete" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title text-center">Are you sure?</h4>
                </div>
                <div class="modal-body">
                    <p class="margin-bottom-lg">You want to delete?</p>
                    <div class="form-group text-center">
                        <a href="<?php echo site_url('admin/news_sticker/delete/' . $cat["pk_news_ticker_id"] ); ?>" class="btn btn-success btn-gradient margin-right-sm"><i class="fa fa-check"></i> Yes</a>

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