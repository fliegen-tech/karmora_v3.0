 <tr class="footer" >
    <td align="left" colspan="2"><?php echo $paging['paging_showing'];?></td>
    
    <td colspan="3" align="right">
    <!--  PAGINATION START  -->  
                
        <div class="pagination">
            
               <?php echo $paging['paging_first'];?>
                <?php echo $paging['paging_previous'];?>
               <?php echo $paging['paging_links'];?>
                <?php echo $paging['paging_next'];?>
                <?php echo $paging['paging_last'];?>
            <p>
            <?php //echo pagingcombo_generate($rowslimit, $currentpage, $datagridURL);?>
           </p>
        </div> 
    <!--  PAGINATION END  -->       
    </td>
  </tr>