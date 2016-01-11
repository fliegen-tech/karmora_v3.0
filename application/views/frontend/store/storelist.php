<section class="karmora-store-detail">
<div class="container">
    <div class="row">
        <?php //$this->load->view('frontend/layout/partials/category');?>
        <div class="col-xs-12 col-sm-12 col-md-12" id="st-listing" >
        <div class="col-md-12">
            <h1 class=" text-left"><?php echo $category_title; ?></h1>
            </div>

            <div class="col-md-12 table-responsive">
                <table class="table table-responsive table-striped " id="hunt-table">

                    <thead>
                        <tr>
                            <th>Store Name</th>
                            <th>Cash Back</th>
                            <th>Favorites</th>
                            <th>Shop</th>
                        </tr>
                    </thead>
                    <tbody class="store-table">
                        <tr>
                            <td colspan="4" style="text-align: center">
                                <a href="#"name="top"></a>
                                <?php
                                $first = true;
                                foreach ($storeArray as $nouseVars)
                                {
                                    if($first){reset($storeArray);$first=false;}
                                    ?>
                                <a href="#<?php echo key($storeArray);?>"><?php echo key($storeArray);?></a>
                                        <?php
                                    
                                    next($storeArray);
                                }
                                ?>
                            </td>
                        </tr>
                        <?php
                        $first = true;
                        foreach ($storeArray as $storeIn) {
                            if ($first){ reset($storeArray); $first=false;}
                            ?>
                        <tr>
                            <td colspan="3" style=" background-color: #CC2161;" align="left"><a  style="color: white; " href="#" name="<?php echo key($storeArray);?>"><b><?php echo key($storeArray);?></b></a></td>
                            <td style=" background-color: #CC2161; vertical-align: middle;"><a style="color: white; " href="#top">Back to Top</a></td>
                        </tr>
                        <?php 
                        foreach ($storeIn as $store) {
                            ?>
                            <tr>
                                <td><a href="<?php echo base_url() ?>store-detail/<?php echo $store['store_id'] ?>"><?php echo $store['store_title']; ?></a></td>
                                <td><?php echo $store['cash_back_percentage']; ?></td>
                                <td><span class="button-checkbox"  >
                                        <?php
                                        if (!$this->session->userdata('front_data')) {
                                            ?>
                                            <a href="#" id="addfav-button" data-toggle="modal" data-target="#signupModal">add</a>
                                            <?php
                                        } else {
                                            if ($store['fk_store_id'] != '') {
                                                ?>
                                            <span id="fav-<?php echo $store['store_id']?>"><a href="javascript:void(0)" onClick="unFavourtie(<?php echo $store['store_id']?>,'<?php echo $store_alis_url?>')" id="<?php echo $store['store_id'];?>" class="fav-icon active">add</a></span>
                                                <?php
                                            } else {
                                                ?>
                                            <span id="fav-<?php echo $store['store_id']?>"><a href="javascript:void(0)" onClick="favourtie(<?php echo $store['store_id']?>,'<?php echo $store_alis_url?>')" id="<?php echo $store['store_id'];?>" class="fav-icon" >add</a></span>
                                                <?php
                                            }
                                        }
                                        ?>

                                    </span></td>
                                <td>
                                   <?php if (!$this->session->userdata('front_data')) {
                                            ?>
                                            <a href="#"  data-toggle="modal" class="td-upgrade" data-target="#signupModal">Shop Now</a>
                                            <?php
                                        }else{?>
                                    <a href="<?php echo base_url() ?>store-visit/<?php echo $store['store_id'] ?>" target="_blank" class="td-upgrade">Shop Now</a>
                                        <?php } ?></td>
                            </tr>
    <?php
                        }
                        next($storeArray);
                                            }
?>

                    </tbody>
                </table>


            </div>


        </div>

    </div>



    <!--------profile-container------> 
</div>
</section>

<script>
function unFavourtie(storeId,alias){
    
    var Alias = "'"+alias+"'";
    jQuery.ajax({
        type: 'POST',
        url: baseurl +'SUnfavourtie/'+storeId+'/' + alias,
        context: document.body,
        error: function(data, transport) {
            alert("Sorry, the operation is failed.");
        },
        success: function(data) {
            //alert(data);
            $('#fav-'+storeId).html('');
            $('#fav-'+storeId).html('<span id="fav-'+storeId+'"><a href="javascript:void(0)" onClick="favourtie('+storeId+','+Alias+')" id="'+storeId+'" class="fav-icon">add</a></span>');
        }
    });
}

function favourtie(storeId,alias){
    
    var Alias = "'"+alias+"'";
    jQuery.ajax({
        type: 'POST',
        url: baseurl +'Sfavourtie/'+storeId+'/' + alias,
        context: document.body,
        error: function(data, transport) {
            alert("Sorry, the operation is failed.");
        },
        success: function(data) {
            //alert(data);
            $('#fav-'+storeId).html('');
            $('#fav-'+storeId).html('<span id="fav-'+storeId+'"><a href="javascript:void(0)" onClick="unFavourtie('+storeId+','+Alias+')" id="'+storeId+'" class="fav-icon active">add</a></span>');
        }
    });
}
</script>