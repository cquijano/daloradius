<?php

    include ("library/checklogin.php");
    $operator = $_SESSION['operator_user'];

	include('library/check_operator_perm.php');
	
	//setting values for the order by and order type variables
	isset($_REQUEST['orderBy']) ? $orderBy = $_REQUEST['orderBy'] : $orderBy = "id";
	isset($_REQUEST['orderType']) ? $orderType = $_REQUEST['orderType'] : $orderType = "asc";


	include_once('library/config_read.php');
    $log = "visited page: ";
    $logQuery = "performed query for all accounting records on page: ";

?>

<?php
	
	include("menu-accounting.php");
	
?>

		<div id="contentnorightbar">
		
		<h2 id="Intro"><a href="#" onclick="javascript:toggleShowDiv('helpPage')"><? echo $l['Intro']['acctall.php']?>
		<h144>+</h144></a></h2>
				
		<div id="helpPage" style="display:none;visibility:visible" >
			<?php echo $l['helpPage']['acctall'] ?>
			<br/>
		</div>
		<br/>



<?php

	include 'library/opendb.php';
	include 'include/common/calcs.php';	
	include 'include/management/pages_common.php';	
	include 'include/management/pages_numbering.php';		// must be included after opendb because it needs to read the CONFIG_IFACE_TABLES_LISTING variable from the config file

	//orig: used as maethod to get total rows - this is required for the pages_numbering.php page
	$sql = "SELECT ".$configValues['CONFIG_DB_TBL_RADACCT'].".RadAcctId, ".$configValues['CONFIG_DB_TBL_DALOHOTSPOTS'].".name as hotspot, ".$configValues['CONFIG_DB_TBL_RADACCT'].".UserName, ".$configValues['CONFIG_DB_TBL_RADACCT'].".FramedIPAddress, ".$configValues['CONFIG_DB_TBL_RADACCT'].".AcctStartTime, ".$configValues['CONFIG_DB_TBL_RADACCT'].".AcctStopTime, ".$configValues['CONFIG_DB_TBL_RADACCT'].".AcctSessionTime, ".$configValues['CONFIG_DB_TBL_RADACCT'].".AcctInputOctets, ".$configValues['CONFIG_DB_TBL_RADACCT'].".AcctOutputOctets, ".$configValues['CONFIG_DB_TBL_RADACCT'].".AcctTerminateCause, ".$configValues['CONFIG_DB_TBL_RADACCT'].".NASIPAddress FROM ".$configValues['CONFIG_DB_TBL_RADACCT']." LEFT JOIN ".$configValues['CONFIG_DB_TBL_DALOHOTSPOTS']." ON ".$configValues['CONFIG_DB_TBL_RADACCT'].".calledstationid = ".$configValues['CONFIG_DB_TBL_DALOHOTSPOTS'].".mac;";
	$res = $dbSocket->query($sql);
	$numrows = $res->numRows();

	
	$sql = "SELECT ".$configValues['CONFIG_DB_TBL_RADACCT'].".RadAcctId, ".$configValues['CONFIG_DB_TBL_DALOHOTSPOTS'].".name as hotspot, ".$configValues['CONFIG_DB_TBL_RADACCT'].".UserName, ".$configValues['CONFIG_DB_TBL_RADACCT'].".FramedIPAddress, ".$configValues['CONFIG_DB_TBL_RADACCT'].".AcctStartTime, ".$configValues['CONFIG_DB_TBL_RADACCT'].".AcctStopTime, ".$configValues['CONFIG_DB_TBL_RADACCT'].".AcctSessionTime, ".$configValues['CONFIG_DB_TBL_RADACCT'].".AcctInputOctets, ".$configValues['CONFIG_DB_TBL_RADACCT'].".AcctOutputOctets, ".$configValues['CONFIG_DB_TBL_RADACCT'].".AcctTerminateCause, ".$configValues['CONFIG_DB_TBL_RADACCT'].".NASIPAddress FROM ".$configValues['CONFIG_DB_TBL_RADACCT']." LEFT JOIN ".$configValues['CONFIG_DB_TBL_DALOHOTSPOTS']." ON ".$configValues['CONFIG_DB_TBL_RADACCT'].".calledstationid = ".$configValues['CONFIG_DB_TBL_DALOHOTSPOTS'].".mac  ORDER BY $orderBy $orderType LIMIT $offset, $rowsPerPage;";
	$res = $dbSocket->query($sql);
	$logDebugSQL = "";
	$logDebugSQL .= $sql . "\n";

	/* START - Related to pages_numbering.php */
	$maxPage = ceil($numrows/$rowsPerPage);
	/* END */

	echo "<table border='0' class='table1'>\n";
	echo "
					<thead>
							<tr>
							<th colspan='15'>".$l['all']['Records']."</th>
							</tr>

                                                        <tr>
                                                        <th colspan='12' align='left'>
                <br/>
        ";

        if ($configValues['CONFIG_IFACE_TABLES_LISTING_NUM'] == "yes")
                setupNumbering($numrows, $rowsPerPage, $pageNum, $orderBy, $orderType);

        echo " </th></tr>
                                        </thead>

                        ";

	echo "<thread> <tr>
	<th scope='col'> ".$l['all']['ID']."
	<br/>
	<a class='novisit' href=\"" . $_SERVER['PHP_SELF'] . "?orderBy=radacctid&orderType=asc\">
		<img src='images/icons/arrow_up.png' alt='>' border='0' /></a>
	<a class='novisit' href=\"" . $_SERVER['PHP_SELF'] . "?orderBy=radacctid&orderType=desc\">
		<img src='images/icons/arrow_down.png' alt='<' border='0' /></a>
	</th>
	<th scope='col'> ".$l['all']['HotSpot']."
	<br/>
	<a class='novisit' href=\"" . $_SERVER['PHP_SELF'] . "?orderBy=hotspot&orderType=asc\">
		<img src='images/icons/arrow_up.png' alt='>' border='0' /></a>
	<a class='novisit' href=\"" . $_SERVER['PHP_SELF'] . "?orderBy=hotspot&orderType=desc\">
		<img src='images/icons/arrow_down.png' alt='<' border='0' /></a>
	</th>
	<th scope='col'> ".$l['all']['Username']."
	<br/>
	<a class='novisit' href=\"" . $_SERVER['PHP_SELF'] . "?orderBy=username&orderType=asc\">
		<img src='images/icons/arrow_up.png' alt='>' border='0' /></a>
	<a class='novisit' href=\"" . $_SERVER['PHP_SELF'] . "?orderBy=username&orderType=desc\">
		<img src='images/icons/arrow_down.png' alt='<' border='0' /></a>
	</th>
	<th scope='col'> ".$l['all']['IPAddress']."
	<br/>
	<a class='novisit' href=\"" . $_SERVER['PHP_SELF'] . "?orderBy=framedipaddress&orderType=asc\">
		<img src='images/icons/arrow_up.png' alt='>' border='0' /></a>
	<a class='novisit' href=\"" . $_SERVER['PHP_SELF'] . "?orderBy=framedipaddress&orderType=desc\">
		<img src='images/icons/arrow_down.png' alt='<' border='0' /></a>
	</th>
	<th scope='col'> ".$l['all']['StartTime']."
	<br/>
	<a class='novisit' href=\"" . $_SERVER['PHP_SELF'] . "?orderBy=acctstarttime&orderType=asc\">
		<img src='images/icons/arrow_up.png' alt='>' border='0' /></a>
	<a class='novisit' href=\"" . $_SERVER['PHP_SELF'] . "?orderBy=acctstarttime&orderType=desc\">
		<img src='images/icons/arrow_down.png' alt='<' border='0' /></a>
	</th>
	<th scope='col'> ".$l['all']['StopTime']."
	<br/>
	<a class='novisit' href=\"" . $_SERVER['PHP_SELF'] . "?orderBy=acctstoptime&orderType=asc\">
		<img src='images/icons/arrow_up.png' alt='>' border='0' /></a>
	<a class='novisit' href=\"" . $_SERVER['PHP_SELF'] . "?orderBy=acctstoptime&orderType=desc\">
		<img src='images/icons/arrow_down.png' alt='<' border='0' /></a>
	</th>
	<th scope='col'> ".$l['all']['TotalTime']."
	<br/>
	<a class='novisit' href=\"" . $_SERVER['PHP_SELF'] . "?orderBy=acctsessiontime&orderType=asc\">
		<img src='images/icons/arrow_up.png' alt='>' border='0' /></a>
	<a class='novisit' href=\"" . $_SERVER['PHP_SELF'] . "?orderBy=acctsessiontime&orderType=desc\">
		<img src='images/icons/arrow_down.png' alt='<' border='0' /></a>
	</th>
	<th scope='col'> ".$l['all']['Upload']." (".$l['all']['Bytes'].")
	<br/>
	<a class='novisit' href=\"" . $_SERVER['PHP_SELF'] . "?orderBy=acctinputoctets&orderType=asc\">
		<img src='images/icons/arrow_up.png' alt='>' border='0' /></a>
	<a class='novisit' href=\"" . $_SERVER['PHP_SELF'] . "?orderBy=acctinputoctets&orderType=desc\">
		<img src='images/icons/arrow_down.png' alt='<' border='0' /></a>
	</th>
	<th scope='col'> ".$l['all']['Download']." (".$l['all']['Bytes'].")
	<br/>
	<a class='novisit' href=\"" . $_SERVER['PHP_SELF'] . "?orderBy=acctoutputoctets&orderType=asc\">
		<img src='images/icons/arrow_up.png' alt='>' border='0' /></a>
	<a class='novisit' href=\"" . $_SERVER['PHP_SELF'] . "?orderBy=acctoutputoctets&orderType=desc\">
		<img src='images/icons/arrow_down.png' alt='<' border='0' /></a>
	</th>
	<th scope='col'> ".$l['all']['Termination']."
	<br/>
	<a class='novisit' href=\"" . $_SERVER['PHP_SELF'] . "?orderBy=acctterminatecause&orderType=asc\">
		<img src='images/icons/arrow_up.png' alt='>' border='0' /></a>
	<a class='novisit' href=\"" . $_SERVER['PHP_SELF'] . "?orderBy=acctterminatecause&orderType=desc\">
		<img src='images/icons/arrow_down.png' alt='<' border='0' /></a>
	</th>
	<th scope='col'> ".$l['all']['NASIPAddress']."
	<br/>
	<a class='novisit' href=\"" . $_SERVER['PHP_SELF'] . "?orderBy=nasipaddress&orderType=asc\">
		<img src='images/icons/arrow_up.png' alt='>' border='0' /></a>
	<a class='novisit' href=\"" . $_SERVER['PHP_SELF'] . "?orderBy=nasipaddress&orderType=desc\">
		<img src='images/icons/arrow_down.png' alt='<' border='0' /></a>
	</th>
			</tr> </thread>";
	while($row = $res->fetchRow()) {
		echo "<tr>
				<td> $row[0] </td>
				<td> $row[1] </td>
	                        <td> <a class='tablenovisit' href='mng-edit.php?username=$row[2]'> $row[2] </a> </td>
				<td> $row[3] </td>
				<td> $row[4] </td>
				<td> $row[5] </td>
				<td> ".seconds2time($row[6])."</td>
				<td> ".toxbyte($row[7])."</td>
				<td> ".toxbyte($row[8])."</td>
				<td> $row[9] </td>
				<td> $row[10] </td>
		</tr>";
	}

        echo "
                                        <tfoot>
                                                        <tr>
                                                        <th colspan='12' align='left'>
        ";
        setupLinks($pageNum, $maxPage, $orderBy, $orderType);
        echo "
                                                        </th>
                                                        </tr>
                                        </tfoot>
                ";

	echo "</table>";

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
