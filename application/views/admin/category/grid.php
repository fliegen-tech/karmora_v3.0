<!-- Start: Content -->
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
            <li><a href="<?php echo base_url('admin/category/addCategory'); ?>">Add Category</a></li>
            <li class="active">Category</li>
        </ol>
    </div>
    <div class="container">
        <div class="row">

            <div class="col-md-12">
                <div class="panel panel-visible">
                    <div class="panel-heading">
                        <div class="panel-title"> <i class="fa fa-tag"></i> Category List</div>
                        <div class="panel-title" style=" margin-left:150px;">
                            <select name="filter" onchange="location.href = '<?php echo base_url('admin/category/index') ?>/' + this.value">      

                                <option value="all"  <?php if ($this->uri->segment(2) == 'all') echo 'selected="selected"' ?>>All</option>
                                <?php
                                foreach ($parrent_cats as $p_cat) {
                                    ?>
                                    <option <?php if ($this->uri->segment(2) == $p_cat['pk_category_id']) echo 'selected="selected"' ?> value="<?php echo $p_cat['pk_category_id'] ?>"><?php echo $p_cat['category_title'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="panel-body">
                        <?php if (isset($successmessage)) { ?><div class="alert alert-info"><?php echo $successmessage; ?></div><?php } ?>
                        <table id="example" class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Status</th>
                                    <th>Parent</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (!empty($catData)) {
                                    foreach ($catData as $cat) {
                                        ?>
                                        <tr>
                                            <td>

                                                <?php echo $cat['category_title'] ?>
                                            </td>
                                            <td class="hidden-xs">
                                                <?php
                                                $status = $cat['category_status'];
                                                if ($status === "Active") {
                                                    ?>
                                                    <a href="#" class="tableLinks" data-toggle="modal" data-target="#<?php echo $cat['pk_category_id'] ?>-active">
                                                        <i class="fa fa-eye" title="Make inactive"></i>
                                                    </a>


                                                    <?php
                                                } else if ($status === "Inactive") {
                                                    ?>
                                                    <a href="#" class="tableLinks" data-toggle="modal" data-target="#<?php echo $cat['pk_category_id'] ?>-inactive">
                                                        <i class="fa fa-eye-slash" title="Make active"></i>
                                                    </a>

                                                    <?php
                                                }
                                                ?>


                                            </td>
                                            <td class="hidden-xs hidden-sm">

                                                <?php
                                                $parent = $cat['parent_title'];

                                                if ($parent === NULL) {
                                                    echo "None";
                                                } else {
                                                    echo $parent;
                                                }
                                                ?>

                                            </td>
                                            <td>
                                                <a href="#" class="tableLinks" data-toggle="modal" data-target="#<?php echo $cat['pk_category_id'] ?>-delete">
                                                    <i class="fa fa-trash-o" title="Delete"></i>
                                                </a>
                                                |
                                                <a href="<?php echo site_url() ?>admin/category/editCategory/<?php echo $cat['pk_category_id'] ?>" class="tableLinks">

                                                    <i class="fa fa-edit" title="Edit"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                }
                                ?>

                            </tbody>
                        </table>
                        
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
if(!empty($catData)){
foreach ($catData as $cat) {
    if ($cat['category_status'] === "Active") {
        ?>
        <div class="modal fade" id="<?php echo $cat['pk_category_id'] ?>-active" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title text-center">Are you sure?</h4>
                    </div>
                    <div class="modal-body">
                        <p class="margin-bottom-lg">You want to change the status?</p>
                        <div class="form-group text-center">
                            <a href="<?php echo site_url('admin/category/status/' . $cat["pk_category_id"] . '/' . $cat["category_status"] . '/' . $this->uri->segment(4)); ?>" class="btn btn-success btn-gradient margin-right-sm"><i class="fa fa-check"></i> Yes</a>

                            <button type="button" class="btn btn-danger btn-gradient" data-dismiss="modal"><i class="fa fa-warning"></i> No</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
    } else if ($cat['category_status'] === "Inactive") {
        ?>
        <div class="modal fade" id="<?php echo $cat['pk_category_id']; ?>-inactive" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title text-center">Are you sure?</h4>
                    </div>
                    <div class="modal-body">
                        <p class="margin-bottom-lg">You want to change the status?</p>
                        <div class="form-group text-center">
                            <a href="<?php echo site_url('admin/category/status/' . $cat["pk_category_id"] . '/' . $cat["category_status"] . '/' . $this->uri->segment(4)); ?>" class="btn btn-success btn-gradient margin-right-sm"><i class="fa fa-check"></i> Yes</a>

                            <button type="button" class="btn btn-danger btn-gradient" data-dismiss="modal"><i class="fa fa-warning"></i> No</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
    ?>
    <div class="modal fade" id="<?php echo $cat['pk_category_id']; ?>-delete" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title text-center">Are you sure?</h4>
                </div>
                <div class="modal-body">
                    <p class="margin-bottom-lg">You want to delete?</p>
                    <div class="form-group text-center">
                        <a href="<?php echo site_url('admin/category/delete/' . $cat["pk_category_id"] . '/' . $this->uri->segment(4)); ?>" class="btn btn-success btn-gradient margin-right-sm"><i class="fa fa-check"></i> Yes</a>

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
