<?php

    include ("library/checklogin.php");
    $operator = $_SESSION['operator_user'];

	include('library/check_operator_perm.php');


	//setting values for the order by and order type variables
	isset($_REQUEST['orderBy']) ? $orderBy = $_REQUEST['orderBy'] : $orderBy = "GroupName";
	isset($_REQUEST['orderType']) ? $orderType = $_REQUEST['orderType'] : $orderType = "ASC";



	include_once('library/config_read.php');
    $log = "visited page: ";
    $logQuery = "performed query for listing of records on page: ";


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>

<script src="library/javascript/pages_common.js" type="text/javascript"></script>

<title>daloRADIUS</title>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="css/1.css" type="text/css" media="screen,projection" />

</head>
 
 
<?php
	include ("menu-mng-rad-profiles.php");
?>
		
		<div id="contentnorightbar">
		
				<h2 id="Intro"><a href="#" onclick="javascript:toggleShowDiv('helpPage')"><?php echo $l['Intro']['mngradprofiles.php'] ?>
				<h144>+</h144></a></h2>

				<div id="helpPage" style="display:none;visibility:visible" >				
					<?php echo $l['helpPage']['mngradprofileslist'] ?>
					<br/>
				</div>	
				<br/>
				
<?php

	include 'library/opendb.php';
	include 'include/management/pages_numbering.php';		// must be included after opendb because it needs to read the CONFIG_IFACE_TABLES_LISTING variable from the config file

	//orig: used as maethod to get total rows - this is required for the pages_numbering.php page	
	$sql = "(SELECT distinct(GroupName) FROM ".
		$configValues['CONFIG_DB_TBL_RADGROUPREPLY'].") UNION (SELECT distinct(GroupName)
                FROM ".$configValues['CONFIG_DB_TBL_RADGROUPCHECK'].");";
	$res = $dbSocket->query($sql);
	$numrows = $res->numRows();

	

	$sql = "(SELECT distinct(GroupName) as GroupName FROM ".
		$configValues['CONFIG_DB_TBL_RADGROUPREPLY'].") UNION (SELECT distinct(GroupName)
                as GroupName FROM ".$configValues['CONFIG_DB_TBL_RADGROUPCHECK'].")
		ORDER BY $orderBy $orderType LIMIT $offset, $rowsPerPage;";
	$res = $dbSocket->query($sql);
	$logDebugSQL = "";
	$logDebugSQL .= $sql . "\n";
	
	/* START - Related to pages_numbering.php */
	$maxPage = ceil($numrows/$rowsPerPage);
	/* END */

        echo "<form name='listprofiles' method='post' action='mng-rad-profiles-del.php'>";
	
	echo "<table border='0' class='table1'>\n";
	echo "
					<thead>
							<tr>
							<th colspan='10'>".$l['all']['Records']."</th>
							</tr>
                                                        <tr>
                                                        <th colspan='10' align='left'>

                                Select:
                                <a class=\"table\" href=\"javascript:SetChecked(1,'profile[]','listprofiles')\">All</a>

                                <a class=\"table\" href=\"javascript:SetChecked(0,'profile[]','listprofiles')\">None</a>
                                <br/>
                                <input class='button' type='button' value='Delete' onClick='javascript:removeCheckbox(\"listprofiles\",\"mng-rad-profiles-del.php\")' />
                                <br/><br/>


                ";

        if ($configValues['CONFIG_IFACE_TABLES_LISTING_NUM'] == "yes")
                setupNumbering($numrows, $rowsPerPage, $pageNum, $orderBy, $orderType);

        echo " </th></tr>
                                        </thead>

                        ";


	echo "<thread> <tr>
		<th scope='col'>
		<a class='novisit' href=\"" . $_SERVER['PHP_SELF'] . "?orderBy=groupname&orderType=asc\">
			<img src='images/icons/arrow_up.png' alt='>' border='0' /></a>
		".$l['all']['Groupname']."
		<a class='novisit' href=\"" . $_SERVER['PHP_SELF'] . "?orderBy=groupname&orderType=desc\">
			<img src='images/icons/arrow_down.png' alt='<' border='0' /></a>
		</th>
	</tr> </thread>";
	while($row = $res->fetchRow()) {
		echo "<tr>
				<td> <input type='checkbox' name='profile[]' value='$row[0]'>
					<a class='tablenovisit' href='mng-rad-profiles-edit.php?profile=$row[0]'> $row[0] </a> </td>
		</tr>";
	}

        echo "
                                        <tfoot>
                                                        <tr>
                                                        <th colspan='10' align='left'>
        ";
        setupLinks($pageNum, $maxPage, $orderBy, $orderType);
        echo "
                                                        </th>
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


</body>
</html>
