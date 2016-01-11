<link rel="stylesheet" type="text/css" href="http://staging.leadzgen.com/assets/dashboard/vendor/plugins/datatables/css/datatables.min.css" />

<script type="text/javascript" language="javascript" class="init">


    $(document).ready(function () {
           var oTable = $('#example').dataTable();
           oTable.fnSort( [ [5,'desc'] ] );
    });
</script>
<section id="content">
    <div id="topbar">
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url() ?>admin/index"><i class="fa fa-home"></i></a></li>
            <li><a href="<?php echo base_url('admin/product/add'); ?>">Add Product</a></li>
            <li class="active">Product</li>
        </ol>
    </div>
    <div class="container">
        <div class="row">

            <div class="col-md-12">
                <div class="panel panel-visible">
                    <div class="panel-heading">
                        <div class="panel-title"> <i class="fa fa-tag"></i> Product List</div>
                    </div>
                    <div class="panel-body">
                        <?php if(isset($successmessage)) {?><div class="alert alert-info"><?php echo $successmessage ;?></div><?php } ?>
                     <?php    if (!empty($products)) { ?>
                        <table id="example" class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Price</th>
                                    <th>Image</th>
                                    <th>Magento ID</th>
                                    <th>Sku</th>
                                    <th>Status</th>
                                    <th>Creation Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                
                                    foreach ($products as $product) {
                                        ?>
                                        <tr>
                                            <td> <?php echo $product['product_name']; ?> </td>
                                            <td> <?php echo "$".$product['product_price']; ?> </td>
                                            <td> <img width="50"  src="<?php echo $product['product_image']; ?>" /></td>
                                            <td> <?php echo $product['fk_magento_id']; ?> </td>
                                            <td> <?php echo $product['product_sku']; ?> </td>
                                            <td class="hidden-xs">
                                                <?php
                                                $status = $product['product_status'];
                                                if ($status === "1") {
                                                    ?>

                                                    <a href="#" class="tableLinks" data-toggle="modal" data-target="#<?php echo $product['pk_product_id'] ?>-active">
                                                        <i class="fa fa-eye" title="Make inactive"></i>
                                                    </a>
                                                <?php } else {
                                                    ?>
                                                    <a href="#" class="tableLinks" data-toggle="modal" data-target="#<?php echo $product['pk_product_id'] ?>-inactive">
                                                        <i class="fa fa-eye-slash" title="Make active"></i></a>
                                                <?php } ?>

                                            </td>
                                            <td> <?php echo $product['product_creation_date_time'] ?></td>
                                            <td>
                                                <a class="tableLinks" href="<?php echo base_url('admin/manage_product/detail/'.$product["pk_product_id"]);?>">
                                                    <i class="fa fa-file" title="View"></i>
                                                </a>
                                                &nbsp;&nbsp;
                                                <!--<a href="#" class="tableLinks" data-toggle="modal" data-target="#<?php /*echo $product['pk_product_id'] */?>-delete">
                                                    <i class="fa fa-trash-o" title="Delete"></i>
                                                </a>
                                                &nbsp;&nbsp;
                                                <a href="<?php /*echo base_url() . 'admin/product/edit/' . $product['pk_product_id']; */?>" class="tableLinks">
                                                    <i class="fa fa-edit" title="Edit"></i>
                                                </a>-->
                                                <!-- &nbsp;&nbsp;
                                                <a href="<?php /*echo base_url() . 'admin/product/album/' . $product['pk_product_id']; */?>" class="tableLinks">
                                                    <i class="fa fa-adn" title="Add More Images"></i>
                                                </a>-->
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                
                                ?>

                            </tbody>
                        </table>
                        
                     <?php }else {?>
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
if(!empty($product)){
foreach ($product as $product) {

    if ($product['product_status'] === 'Active') {
        ?>
        <div class="modal fade" id="<?php echo $product['pk_product_id'] ?>-active" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title text-center">Are you sure?</h4>
                    </div>
                    <div class="modal-body">
                        <p class="margin-bottom-lg">You want to change the status?</p>
                        <div class="form-group text-center">
                            <a href="<?php echo site_url('admin/product/changeStatus/' . $product["pk_product_id"] . '/' . $product["product_status"]); ?>" class="btn btn-success btn-gradient margin-right-sm"><i class="fa fa-check"></i> Yes</a>

                            <button type="button" class="btn btn-danger btn-gradient" data-dismiss="modal"><i class="fa fa-warning"></i> No</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
    } else if ($product['product_status'] === 'Inactive') {
        ?>
        <div class="modal fade" id="<?php echo $product['pk_product_id']; ?>-inactive" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title text-center">Are you sure?</h4>
                    </div>
                    <div class="modal-body">
                        <p class="margin-bottom-lg">You want to change the status?</p>
                        <div class="form-group text-center">
                            <a href="<?php echo site_url('admin/product/changeStatus/' . $product["pk_product_id"] . '/' . $product["product_status"]); ?>" class="btn btn-success btn-gradient margin-right-sm"><i class="fa fa-check"></i> Yes</a>

                            <button type="button" class="btn btn-danger btn-gradient" data-dismiss="modal"><i class="fa fa-warning"></i> No</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
    ?>
    <div class="modal fade" id="<?php echo $product['pk_product_id']; ?>-delete" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title text-center">Are you sure?</h4>
                </div>
                <div class="modal-body">
                    <p class="margin-bottom-lg">You want to delete?</p>
                    <div class="form-group text-center">
                        <a href="<?php echo site_url('admin/product/delete/' . $product["pk_product_id"] . '/' . $product['product_image']); ?>" class="btn btn-success btn-gradient margin-right-sm"><i class="fa fa-check"></i> Yes</a>

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

