<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Gatelogix
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		CodeIgniter
 * @author		Gatelogix (Sajjad Mahmood)
 * @copyright	Copyright (c) 2008 - 2012, Gatelogix, Inc.
 * @since		Version 1.0
 * @filesource
 */
// ------------------------------------------------------------------------

/**
 * CodeIgniter Paging Helpers
 *
 * @package		CodeIgniter
 * @subpackage	Helpers
 * @category	Helpers
 * @author		Gatelogix (Sajjad Mahmood)
 */
// ------------------------------------------------------------------------

/**
 * will generate the array of strings for next, previous, links for the navigation 
 *
 * @param integer $total [total number of records]
 * @param integer $page [page number]
 * @param integer $rows [total number of records page page]
 * @param integer $max [how many links needs to show on the left and right hand side]
 * @param string $navURL [Page url]
 * @param integer $isAjaxCall [optional]
 */
function paging_generate($total, $page, $rows, $max, $navURL, $status = '') {
    $status_a = '';
    if ($status != '') {
        $status_a = '/' . $status;
    }
    $max = 3;
    $navigationArray = array();
    $totelPages = ceil($total / $rows);
    $questionsgrid = '';

    $hrefValue = $navURL . '/' . $totelPages . '/' . $rows . $status_a;
    if ($totelPages <= 3 || $page == $totelPages) {
        $lastIcon = '';
    } else {
        
        $lastIcon = '<li><a href="' . $hrefValue . '">Last</a></li>';
    }
    $navigationArray['paging_last'] = $lastIcon;

    $hrefValue = $navURL . '/1/' . $rows . $status_a;
    if ($page <= 4) {
        $firstIcon = '';
    } else {
        $firstIcon = '<li><a href="' . $hrefValue . '">First</a></li>';
    }
    $navigationArray['paging_first'] = $firstIcon;
    //-------------------By Rizwan----------------------\\
    if ($page * $rows >= $total) {
        $nextIcon = '<li ><a href="#">»</a></li>';
    } else {
        $pageNext = $page + 1;
        $hrefValue = $navURL . '/' . $pageNext . '/' . $rows . $status_a;


       $nextIcon = '<li><a href="' . $hrefValue . '">»</a></li>';
		//$nextIcon = '<a href="' . $hrefValue . '"  class="next">More ▼</a>';
    }
    if ($page == 1) {
        $prevIcon = '<li><a href="#">«</a><li>';
    } else {
        $pagePrev = $page - 1;
        $hrefValue = $navURL . '/' . $pagePrev . '/' . $rows . $status_a;

        $prevIcon = '<li><a href="' . $hrefValue . '">«</a></li>';
    }
    $navigationArray['paging_next'] = $nextIcon;
    $navigationArray['paging_previous'] = $prevIcon;
    $navigationArray['paging_links'] = "";
    $navigationArray['paging_total'] = "";
    $navigationArray['paging_showing'] = "";

    $pageStr = "";
    $page_links_str = "";
    //if more than one page of results
    if ($totelPages != 1) {
        //used in the loop

        $max_links = $max + 1;
        $h = 1;
        //if page is above max link
        if ($page > $max_links) {
            //start of loop 
            $h = ( ( $h + $page ) - $max_links );
        }
        //if page is not page one
        if ($page >= 1) {
            //top of the loop extends
            $max_links = $max_links + ( $page - 1);
        }
        //if the top page is visible then reset the top of the loop to the $this->mNumberOfPages
        if ($max_links > $totelPages) {
            $max_links = $totelPages + 1;
        }
        //create the page links
        for ($k = $h; $k < $max_links; $k++) {
            if ($k == $page) {
                $pageStr.='<li class="active"><a href="#">' . $k . '</a></li>';
            } else {
                $hrefValue = $navURL . '/' . $k . '/' . $rows . $status_a;

                $pageStr.='<li><a href="' . $hrefValue . '">' . $k . '</a></li>';
            }
            if ($k == $totelPages) {
                $navigationArray['paging_links'].="";
                break;
            }
        }
    } else {
        $pageStr.='<li class="active"><a href="#">1</a></li>';
    }
    $navigationArray['paging_links'].= $pageStr;


    if ($rows > $total) {
        $rows = $total;
    }
    if ($page > 1) {
        $rec = $page * $rows;
        $rec1 = ($page - 1) * $rows;
        if ($page == $totelPages) {
            $navigationArray["paging_total"].="<b>" . ($rec1 + 1) . "</b> of <b>" . $total . "</b> Total Records";
            $navigationArray["paging_showing"].="Showing <b>" . ($rec1 + 1) . "</b> to <b>" . $total . "</b> of <b>" . $total . "</b> Total Records";
        } else {
            $navigationArray["paging_total"].="<b>" . ($rec1 + 1) . "</b> of <b>" . $total . "</b>";
            $navigationArray["paging_showing"].="Showing <b>" . ($rec1 + 1) . "</b> to <b>" . $rec . "</b> of <b>" . $total . "</b> Total Records";
        }
    } else {
        if ($total <= 0) {
            $page = 0;
            $rows = 0;
        } else {
            $page = 1;
        }
        $navigationArray["paging_total"].="<b>" . $page . "</b> of <b>" . $total . "</b> Total Records";
        $navigationArray["paging_showing"].="Showing <b>" . $page . "</b> to <b>" . $rows . "</b> of <b>" . $total . "</b> Total Records";
    }
    return $navigationArray;
}

/**
 * will generate the combo box that is part of the pagination 
 *
 * @param integer $rows [how many rows there are currently in the datagrid]
 * @param string $navURL [Page url]
 * @param integer $isAjaxCall [optional]
 */
function pagingcombo_generate($rows, $page = 1, $datagridURL) {
    ?>
    Limit<select class="smallInput" onchange="window.location = '<?php echo $datagridURL . '/' . $page; ?>/' + this.value">
        <option value="2"  <?php echo ($rows == 2) ? 'selected="selected"' : ''; ?>>2</option>
        <option value="10" <?php echo ($rows == 10) ? 'selected="selected"' : ''; ?>>10</option>
        <option value="20" <?php echo ($rows == 20) ? 'selected="selected"' : ''; ?>>20</option>
        <option value="30" <?php echo ($rows == 30) ? 'selected="selected"' : ''; ?>>30</option>
        <option value="40" <?php echo ($rows == 40) ? 'selected="selected"' : ''; ?>>40</option>
        <option value="50" <?php echo ($rows == 50) ? 'selected="selected"' : ''; ?>>50</option>
        <option value="60" <?php echo ($rows == 60) ? 'selected="selected"' : ''; ?>>60</option>
        <option value="70" <?php echo ($rows == 70) ? 'selected="selected"' : ''; ?>>70</option>
        <option value="80" <?php echo ($rows == 80) ? 'selected="selected"' : ''; ?>>80</option>
        <option value="90" <?php echo ($rows == 90) ? 'selected="selected"' : ''; ?>>90</option>
        <option value="100" <?php echo ($rows == 100) ? 'selected="selected"' : ''; ?>>100</option>
    </select>
    <?php
}

/* End of file paging_helper.php */
/* Location: ./application/helpers/paging_helper.php */