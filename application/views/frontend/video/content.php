<section class="karmora-videos">
       <div class="container">
          <div class="row">
              
              <div class="karmora-videos-text">
                  <h2>Promotional Videos</h2>
                   <div class="col-md-10 col-md-offset-1 karmora-videos-p">
                          <p>
                          Karmora promotional videos have been specifically written and produced to attract your social media friends and followers to your Karmora website. Watch… Enjoy… Share! For more information on how to share Karmora Commercials on your social media channels <a href="#">  Click Here!</a> </p>           
                        </div>
              </div>
              <?php if(isset($karmoraVideos) && !empty($karmoraVideos)){ //echo '<pre>'; print_r($karmoraVideos); die; ?>
                    <div class="kamora-videos-portfolio karmora-detail-videos">
                        <div class="karmora-videos-Promotional">              
                            <div class="karmora-videos-Promotional-videos">
                                <?php foreach ($karmoraVideos as $video => $info) { ?>
                                <div class="col-md-4 col-xs-4 col-sm-4 peomotional-karmora">
                                <h2><?php echo $info['video_title']; ?></h2>
                                <div class="video-con product-video-con video-k-email video-k-karomra">
                                  <a href="#">                                
                                    <iframe src="<?php echo $info['video_url'];?>" frameborder="0" allowfullscreen></iframe>
                                  </a>
                                </div>
                                <ul class="list-inline list-video-icons1">
                                  <li>
                                    <a href="#">
                                      <div class="fb-share-button" data-href="<?php echo $info['video_url'];?>" data-layout="button"></div>
                                    </a>
                                  </li>
                                  <li>
                                      <a href="https://twitter.com/share" class="twitter-share-button"{count} data-url="<?php echo $info['video_url'];?>" data-text="<?php echo $info['video_title'];?>">Tweet</a>
                                  </li>
                                  <li>
                                    <a onClick="window.open('http://www.pinterest.com/pin/create/button/?url=<?php $_SERVER['REQUEST_URI'] ?>&media=<?php echo $info['video_url'];?>&description=<?php echo $info['video_title'];?>', 'sharer', 'toolbar=0,status=0,width=548,height=325');" target="_parent" href="javascript: void(0)">
                                        <img class="share-pin" src="<?php echo $themeUrl; ?>/images/share-pin.png">
                                    </a>   
                                   
                                  </li>
                                </ul>
                                </div>
                                <?php } ?> 
                            </div>
                        </div>
                    </div>
              <?php } ?>
       </div> 
     </section>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.5&appId=735941383188266";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<script>
!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');
</script>
<script
    type="text/javascript"
    async defer
    src="//assets.pinterest.com/js/pinit.js"
></script>