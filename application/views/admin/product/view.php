<?php
/**
 * Created by PhpStorm.
 * User: Muhammad Noman Rauf
 * Date: 1/7/2016
 * Time: 8:29 PM
 */
?>
<style>

    p{
        margin-left: 10px;
    }
</style>
<section id="content">
    <div id="topbar">
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url() ?>admin/index"><i class="fa fa-home"></i></a></li>
            <li><a href="<?php echo base_url('admin/product'); ?>">Product</a></li>
            <li class="active">Product Detail</li>
        </ol>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-visible">
                    <div class="panel-heading">
                        <div class="panel-title"><i class="fa fa-tag"></i> Product Detail</div>
                    </div>
                    <div class="panel-body">
                        <?php
                        if (!empty($product_detail)) {

                            ?>
                            <div class="col-md-6">
                                <img src="<?php echo $product_detail->product_image; ?>"
                                                       alt="Product Image"
                                                       class="img-responsive"/>
                            </div>
                            <div class="col-md-6">
                                <h3>Title</h3>
                                <p><?php echo $product_detail->product_name;?></p>
                                <h3>Magento ID</h3>
                                <p><?php echo $product_detail->fk_magento_id;?></p>
                                <h3>SKU</h3>
                                <p><?php echo $product_detail->product_sku;?></p>
                                <h3>Price</h3>
                                <p>$<?php echo $product_detail->product_price;?></p>
                                <h3>Short Description</h3>
                                <p><?php echo $product_detail->product_short_description;?></p>
                                <h3>Description</h3>
                                <p><?php echo $product_detail->prodcut_description;?></p>
                            </div>
                            <div class="col-md-12">
                                <form action="" method="post">
                                    <input type="submit" value="submit" name="submit"/>
                                </form>
                            </div>
                    <?php        
                        } else {
                            echo "No Data Founded.";
                        } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
