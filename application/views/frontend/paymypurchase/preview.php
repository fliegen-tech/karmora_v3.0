<?php 


$this->load->view('admin/frontlayouts/header')?>
<div class="container" style="margin-top:60px; font-family: Oswald;">
  <div class="row">
    <div class="col-lg-9"> 
      
      <!-- the actual blog post: title/author/date/content -->
      <h1 class="h1-heading" style="text-align:left"><?php //echo $friends_emails; ?></h1>
      <hr>
      <div class="row">
         <?php echo $subject ?>
      </div>
          </div>
  
  </div>
  <hr>
</div>

<?php $this->load->view('admin/frontlayouts/footer')?>