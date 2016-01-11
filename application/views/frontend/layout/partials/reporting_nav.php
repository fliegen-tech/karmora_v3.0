<?php $action = $this->router->fetch_class();?>
<div class="row" id="profile-nav">
    <div class="col-md-8 col-centered  ">
        <ul class="nav nav-pills">
            <li><a href="<?php echo base_url() ?>dashboard">DASHBOARD</a></li>
            <li><a href="<?php echo base_url() ?>profile">PROFILE</a></li>
            <li><a href="<?php echo base_url('cash-back') ?>">REPORTING</a></li>
            <li><a href="<?php echo base_url('cashmeout') ?>">CASH ME OUT</a></li>
            <li><a href="<?php echo base_url('marketing') ?>">MARKETING</a></li>
        </ul>
    </div>
</div>
<?php
if ($action === "reporting") {?>
    <div class="row" id="profile-nav">
        <div class="col-md-8 col-centered">
            <ul class="nav nav-pills">
                <li> <a href="<?php echo base_url() ?>cash-back" style="color: #000000;">My Cash Back</a> </li>
                <li><a href="<?php echo base_url() ?>good-karmora" style="color: #000000;">Good Karmora</a> </li>
                <li><a href="<?php echo base_url() ?>community" style="color: #000000;">My Community</a> </li>
                <li> <a href="<?php echo base_url() ?>summary" style="color: #000000;">Summary</a> </li>
            </ul>
        </div>
    </div>
    <?php
}
?>
