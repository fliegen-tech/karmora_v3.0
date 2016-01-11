            <?php $i =1;
					      foreach($videos as $c){
							 
							  ($i % 2 == 0)?$t = 0:$t = 1;
							  
							   ?>
                            <tr >
                             
                                <td>
                                  <?php echo $c['video_title']; ?>
                                </td>
                                <td class="hidden-xs">
                                    
													<?php if($c['video_status']=='Active'){ ?>
                                                   
                                                           <a href="#" class="tableLinks" data-toggle="modal" data-target="#<?php echo $c['pk_video_id'] ?>-active">
                                                        <i class="fa fa-eye" title="Make inactive"></i>
                                                    </a>
                                                   
                                                    <?php }else{ ?>
                                                   
                                                           <a href="#" class="tableLinks" data-toggle="modal" data-target="#<?php echo $c['pk_video_id'] ?>-inactive">
                                                        <i class="fa fa-eye-slash" title="Make active"></i>
                                                    </a>
                   
                                                    <?php } ?>
                                    </td>
                                    <td>
                                   					 <a href="<?php echo base_url('admin/video/edit/'.$c['pk_video_id']); ?>" class="tableLinks"><i class="fa fa-edit" title="Edit"></i></a> &nbsp;&nbsp;                
                                                    <a href="#" class="tableLinks" data-toggle="modal" data-target="#<?php echo $c['pk_video_id'] ?>-delete">
                                                    <i class="fa fa-trash-o" title="Delete"></i>
                                                </a>
                                  
                                </td>
                            </tr>
                     <?php 
					      $i++;
						 } ?>