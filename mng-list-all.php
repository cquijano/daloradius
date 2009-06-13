<?php
/*
 *********************************************************************************************************
 * daloRADIUS - RADIUS Web Platform
 * Copyright (C) 2007 - Liran Tal <liran@enginx.com> All Rights Reserved.
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 *
 *********************************************************************************************************
 *
 * Authors:	Liran Tal <liran@enginx.com>
 *
 *********************************************************************************************************
 */
 
    include ("library/checklogin.php");
    $operator = $_SESSION['operator_user'];

	include('library/check_operator_perm.php');


	//setting values for the order by and order type variables
	isset($_REQUEST['orderBy']) ? $orderBy = $_REQUEST['orderBy'] : $orderBy = "id";
	isset($_REQUEST['orderType']) ? $orderType = $_REQUEST['orderType'] : $orderType = "asc";
	
	include_once('library/config_read.php');
    $log = "visited page: ";
    $logQuery = "performed query for listing of records on page: ";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<script src="library/javascript/pages_common.js" type="text/javascript"></script>
<script src="library/javascript/rounded-corners.js" type="text/javascript"></script>
<script src="library/javascript/form-field-tooltip.js" type="text/javascript"></script>

<script type="text/javascript" src="library/javascript/ajax.js"></script>
<script type="text/javascript" src="library/javascript/ajaxGeneric.js"></script>

<title>daloRADIUS</title>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="css/1.css" type="text/css" media="screen,projection" />
<link rel="stylesheet" href="css/form-field-tooltip.css" type="text/css" media="screen,projection" />
<link rel="stylesheet" type="text/css" href="library/js_date/datechooser.css">
<!--[if lte IE 6.5]>
<link rel="stylesheet" type="text/css" href="library/js_date/select-free.css"/>
<![endif]-->
</head>

<?php

    include ("menu-mng-users.php");

?>

		<div id="contentnorightbar">
		
				<h2 id="Intro"><a href="#" onclick="javascript:toggleShowDiv('helpPage')"><?php echo $l['Intro']['mnglistall.php'] ?>
				<h144>+</h144></a></h2>
				
                <div id="helpPage" style="display:none;visibility:visible" >
			<?php echo $l['helpPage']['mnglistall'] ?>
			<br/>
		</div>

		<div id="returnMessages">
		</div>


<?php

	include 'include/management/pages_common.php';
	include 'library/opendb.php';
	include 'include/management/pages_numbering.php';		// must be included after opendb because it needs to read the CONFIG_IFACE_TABLES_LISTING variable from the config file


        // setup php session variables for exporting
        $_SESSION['reportTable'] = $configValues['CONFIG_DB_TBL_RADCHECK'];
        $_SESSION['reportQuery'] = " WHERE UserName LIKE '%'";
        $_SESSION['reportType'] = "usernameListGeneric";

	
	//orig: used as maethod to get total rows - this is required for the pages_numbering.php page
	$sql = "SELECT distinct(".$configValues['CONFIG_DB_TBL_RADCHECK'].".username),".$configValues['CONFIG_DB_TBL_RADCHECK'].".value,
		".$configValues['CONFIG_DB_TBL_RADCHECK'].".id,".$configValues['CONFIG_DB_TBL_RADUSERGROUP'].".groupname as groupname, ". 
		$configValues['CONFIG_DB_TBL_RADCHECK'].".attribute, ".$configValues['CONFIG_DB_TBL_DALOUSERINFO'].".firstname, ".
		$configValues['CONFIG_DB_TBL_DALOUSERINFO'].".lastname FROM ".$configValues['CONFIG_DB_TBL_RADCHECK']." ".
		" LEFT JOIN ".$configValues['CONFIG_DB_TBL_DALOUSERINFO']." ON ".
		$configValues['CONFIG_DB_TBL_RADCHECK'].".username=".$configValues['CONFIG_DB_TBL_DALOUSERINFO'].".username ".
		" LEFT JOIN ".$configValues['CONFIG_DB_TBL_RADUSERGROUP']." ON ".
		$configValues['CONFIG_DB_TBL_RADCHECK'].".username=".$configValues['CONFIG_DB_TBL_RADUSERGROUP'].".username ".
		" WHERE (Attribute LIKE '%-Password') OR (Attribute='Auth-Type') GROUP BY UserName";
	$res = $dbSocket->query($sql);
	$numrows = $res->numRows();


	/* we are searching for both kind of attributes for the password, being User-Password, the more
	   common one and the other which is Password, this is also done for considerations of backwards
	   compatibility with version 0.7        */
	
	$sql = "SELECT * FROM (".
		"SELECT distinct(".$configValues['CONFIG_DB_TBL_RADCHECK'].".username),".$configValues['CONFIG_DB_TBL_RADCHECK'].".value,
		".$configValues['CONFIG_DB_TBL_RADCHECK'].".id,".$configValues['CONFIG_DB_TBL_RADUSERGROUP'].".groupname as groupname, ". 
		$configValues['CONFIG_DB_TBL_RADCHECK'].".attribute, ".$configValues['CONFIG_DB_TBL_DALOUSERINFO'].".firstname, ".
		$configValues['CONFIG_DB_TBL_DALOUSERINFO'].".lastname FROM ".$configValues['CONFIG_DB_TBL_RADCHECK']." ".
		" LEFT JOIN ".$configValues['CONFIG_DB_TBL_DALOUSERINFO']." ON ".
		$configValues['CONFIG_DB_TBL_RADCHECK'].".username=".$configValues['CONFIG_DB_TBL_DALOUSERINFO'].".username ".
		" LEFT JOIN ".$configValues['CONFIG_DB_TBL_RADUSERGROUP']." ON ".
		$configValues['CONFIG_DB_TBL_RADCHECK'].".username=".$configValues['CONFIG_DB_TBL_RADUSERGROUP'].".username ".
		" WHERE (Attribute LIKE '%-Password') OR (Attribute='Auth-Type') order by ".$configValues['CONFIG_DB_TBL_RADCHECK'].".attribute ) as sorted ".
		" GROUP BY UserName ORDER BY $orderBy $orderType LIMIT $offset, $rowsPerPage";
	$res = $dbSocket->query($sql);
	$logDebugSQL = "";
	$logDebugSQL .= $sql . "\n";

	/* START - Related to pages_numbering.php */
	$maxPage = ceil($numrows/$rowsPerPage);
	/* END */

	echo "<form name='listallusers' method='get' action='mng-del.php' >";

	echo "<table border='0' class='table1'>\n";
	echo "
					<thead>
							<tr>
							<th colspan='10' align='left'> 
				Select:
				<a class=\"table\" href=\"javascript:SetChecked(1,'username[]','listallusers')\">All</a> 
				
				<a class=\"table\" href=\"javascript:SetChecked(0,'username[]','listallusers')\">None</a>
			<br/>
				<input class='button' type='button' value='Delete' 
					onClick='javascript:removeCheckbox(\"listallusers\",\"mng-del.php\")' />
        	                <input class='button' type='button' value='Disable'
					onClick='javascript:disableCheckbox(\"listallusers\",\"include/management/userOperations.php\")' />
        	                <input class='button' type='button' value='CSV Export'
	                        	onClick=\"javascript:window.location.href='include/management/fileExport.php?reportFormat=csv'\"
                		        />
				<br/><br/>
		";


	/* drawing the number links */
	if ($configValues['CONFIG_IFACE_TABLES_LISTING_NUM'] == "yes")
		setupNumbering($numrows, $rowsPerPage, $pageNum, $orderBy, $orderType);

	echo "
			</th>
			</tr>
			</thead>
			";

        if ($orderType == "asc") {
                $orderTypeNextPage = "desc";
        } else  if ($orderType == "desc") {
                $orderTypeNextPage = "asc";
        }
	
	echo "<thread> <tr>
		<th scope='col'> 
		<a title='Sort' class='novisit' href=\"" . $_SERVER['PHP_SELF'] . "?orderBy=id&orderType=$orderTypeNextPage\">
		".$l['all']['ID']."</a>
		</th>

		<th scope='col'> 
		<a title='Sort' class='novisit' href=\"" . $_SERVER['PHP_SELF'] . "?orderBy=Username&orderType=$orderTypeNextPage\">
		".$l['all']['Username']."</a>
		</th>

		<th scope='col'> 
		<a title='Sort' class='novisit' href=\"" . $_SERVER['PHP_SELF'] . "?orderBy=firstname&orderType=$orderTypeNextPage\">
		".$l['all']['Name']."</a>
		</th>

		<th scope='col'> 
		<a title='Sort' class='novisit' href=\"" . $_SERVER['PHP_SELF'] . "?orderBy=Value&orderType=$orderTypeNextPage\">
		".$l['all']['Password']."</a>
		</th>

		<th scope='col'> 
		<a title='Sort' class='novisit' href=\"" . $_SERVER['PHP_SELF'] . "?orderBy=Groupname&orderType=$orderTypeNextPage\">
		".$l['title']['Groups']."</a>
		</th>

		</tr> </thread>";

	while($row = $res->fetchRow()) {
		printqn("
			<tr>
			<td> <input type='checkbox' name='username[]' value='$row[0]'>$row[2]</td>
			");

		echo "<td>";

		if ( ($row[1] == "Reject") && ($row[4] == "Auth-Type") )
			echo "<img title='user is disabled' src='images/icons/userStatusDisabled.gif' alt='[disabled]'>";
		else
			echo "<img title='user is enabled' src='images/icons/userStatusActive.gif' alt='[enabled]'>";

		printqn("
			<a class='tablenovisit' href='javascript:return;'
                                onClick='javascript:ajaxGeneric(\"include/management/retUserInfo.php\",\"retBandwidthInfo\",\"divContainerUserInfo\",\"username=$row[0]\");
					javascript:__displayTooltip();'
                                tooltipText='
	                                <a class=\"toolTip\" href=\"mng-edit.php?username=$row[0]\">
						{$l['Tooltip']['UserEdit']}</a>
					<br/><br/>

					<div id=\"divContainerUserInfo\">
						Loading...
					</div>
                                        <br/>'
				>$row[0]</a>
			</td>
			");

		echo "<td>$row[5] $row[6]</td>";

		if ($configValues['CONFIG_IFACE_PASSWORD_HIDDEN'] == "yes") {
			echo "<td>[Password is hidden]</td>";
		} else {
			echo "<td>$row[1]</td>";
		}
		echo "
			<td>$row[3]</td>
		</tr>";
	}
	
	echo "
					<tfoot>
							<tr>
							<th colspan='10' align='left'> 
	";
	setupLinks($pageNum, $maxPage, $orderBy, $orderType);
	echo "							</th>
							</tr>
					</tfoot>
		";

	echo "</table>";
	echo "</form>";

	include 'library/closedb.php';
	
?>



<?php
	include('include/config/logging.php');
?>
				
		</div>
		
		<div id="footer">
		
								<?php
        include 'page-footer.php';
?>

		
		</div>
		
</div>
</div>


<script type="text/javascript">
	var tooltipObj = new DHTMLgoodies_formTooltip();
	tooltipObj.setTooltipPosition('right');
	tooltipObj.setPageBgColor('#EEEEEE');
	tooltipObj.setTooltipCornerSize(15);
	tooltipObj.initFormFieldTooltip();
</script>

</body>
</html>
