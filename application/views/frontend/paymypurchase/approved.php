<div class="container" id="pay4mypurchase_v2">
  <div class="row ">
    <div class="col-sm-12 col-md-12 col-lg-12">
      <h1 class="main-heading">#Pay4MyPurchase</h1>
      <h2>CONGRATULATIONS!</h2>
      <h3>You&acute;re in it to WIN IT&excl;</h3>
      
      <!-- row --> 
      
    </div>
  </div>


<div class="row" id="four-boxes"> 
    
    <!-- four-boxes -->
    <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
      <div class="box">
        <div class="icon">					

          <div class="info" style="padding-top:10px;"> 
             <?php if($video_type =='instagram'){ ?>
                <video controls="controls" poster="<?php echo $themeUrl;?>/images/paymypurchase/share_to_friend_video.png" width="230" height="175" >
                <source src="<?php echo $media_url; ?>" >
        		<?php }else if($video_type=='youtube'){
                    $array = explode('watch?v=',$media_url);
					if(!empty($array)){
						if(isset($array[1])){
                                                    $array2 = explode('&list=',$array[1]);
                                                    //print_r($array2); die;
                                                    
							//echo $array[1]; die;
							$url = 'http://img.youtube.com/vi/' . $array[1] . '/hqdefault.jpg';
						}else{
							$url = $themeUrl.'/images/paymypurchase/share_to_friend_video.png';
						}                    
					if($url==''){
						$url = $themeUrl.'images/paymypurchase/share_to_friend_video.png';
						}
					
                                                if(isset($array2[0])){
                                                    $url_change = $array2[0];
                                                }elseif(isset($array2[1])){
                                                    $url_change = $array[1];
                                                }
                                        } 
                                         
            	?>
                
                <iframe width="220" height="190" src="https://www.youtube.com/embed/<?php if(isset($url_change)){ echo $url_change ;} ?>?rel=0&showinfo=0">
                </iframe> 
<!--              <a href="<?php //echo $media_url; ?>" rel="lightbox[social 700 392]" >
                <img src="<?php //echo $url;?>"   width="220" height="190" />
              </a>-->
         <?php } ?>     
          
          
          </div>
        </div>
        <div class="space"></div>
      </div>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
      <div class="box">
        <div class="icon">
          <div class="info">
            <div class="image">
              <div class="img-numbers">1</div>
            </div>
            <p>Your video has been APPROVED!</p>
          </div>
        </div>
        <div class="space"></div>
      </div>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
      <div class="box">
        <div class="icon">
          <div class="info">
            <div class="image">
              <div class="img-numbers">2</div>
            </div>
            <p>Share your video by
 <br>
              <a href="<?php echo base_url('Pay4MyPurchase/sharetowin') ?>">clicking here!  
</a></p>
            <p>Ask everyone you know to vote for your video daily and you may win!</p>
          </div>
        </div>
        <div class="space"></div>
      </div>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
      <div class="box">
        <div class="icon">
          <div class="info">
            <div class="image">
              <div class="img-numbers">3</div>
            </div>
            <p>View your personal vote page by
<br>
              <a href="<?php echo base_url('Pay4MyPurchase/vote') ?>">clicking here!</a></p>
            <p>Stay up to date with how many votes your video has!
</p>
          </div>
        </div>
        <div class="space"></div>
      </div>
    </div>
    <!-- /Boxes de Acoes --> 
    
  </div>

  <!-------four-boxes----> 
  
</div>


  
  

