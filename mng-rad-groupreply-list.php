<?php

    include ("library/checklogin.php");
    $operator = $_SESSION['operator_user'];

	//setting values for the order by and order type variables
	isset($_REQUEST['orderBy']) ? $orderBy = $_REQUEST['orderBy'] : $orderBy = "id";
	isset($_REQUEST['orderType']) ? $orderType = $_REQUEST['orderType'] : $orderType = "asc";



	include_once('library/config_read.php');
    $log = "visited page: ";
    $logQuery = "performed query for listing of records on page: ";
    include('include/config/logging.php');


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<title>daloRADIUS</title>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="css/1.css" type="text/css" media="screen,projection" />

</head>
 
 
<?php
	include ("menu-mng-rad-groupreply.php");
?>
		
		<div id="contentnorightbar">
		
				<h2 id="Intro"><a href="#"><?php echo $l[Intro][mngradgroupreplylist.php] ?></a></h2>
				
				<p>

<?php

        
        include 'library/opendb.php';


        $sql = "select GroupName, Attribute, op, Value FROM ".$configValues['CONFIG_DB_TBL_RADGROUPREPLY']." ORDER BY $orderBy $orderType;";
        $res = mysql_query($sql) or die('<font color="#FF0000"> Query failed: ' . mysql_error() . "</font>");

        echo "<table border='2' class='table1'>\n";
        echo "
                        <thead>
                                <tr>
                                <th colspan='10'> ".$l[all][Records]."</th>
                                </tr>
                        </thead>
                ";

        echo "<thread> <tr>
                        <th scope='col'> ".$l[all][Groupname]."
						<br/>
						<a class='novisit' href=\"" . $_SERVER['PHP_SELF'] . "?orderBy=groupname&orderType=asc\"> > </a>
						<a class='novisit' href=\"" . $_SERVER['PHP_SELF'] . "?orderBy=groupname&orderType=desc\"> < </a>
						</th>
                        <th scope='col'> ".$l[all][Attribute]."
						<br/>
						<a class='novisit' href=\"" . $_SERVER['PHP_SELF'] . "?orderBy=attribute&orderType=asc\"> > </a>
						<a class='novisit' href=\"" . $_SERVER['PHP_SELF'] . "?orderBy=attribute&orderType=desc\"> < </a>
						</th>
                        <th scope='col'> ".$l[all][Operator]."
						<br/>
						<a class='novisit' href=\"" . $_SERVER['PHP_SELF'] . "?orderBy=op&orderType=asc\"> > </a>
						<a class='novisit' href=\"" . $_SERVER['PHP_SELF'] . "?orderBy=op&orderType=desc\"> < </a>
						</th>
                        <th scope='col'> ".$l[all][Value]."
						<br/>
						<a class='novisit' href=\"" . $_SERVER['PHP_SELF'] . "?orderBy=value&orderType=asc\"> > </a>
						<a class='novisit' href=\"" . $_SERVER['PHP_SELF'] . "?orderBy=value&orderType=desc\"> < </a>
						</th>
                        <th scope='col'> ".$l[all][Action]." </th>						
                </tr> </thread>";
        while($nt = mysql_fetch_array($res)) {
                echo "<tr>
                        <td> $nt[GroupName] </td>
                        <td> $nt[Attribute] </td>
                        <td> $nt[op] </td>						
                        <td> $nt[Value] </td>						
                        <td> <a href='mng-rad-groupreply-edit.php?groupname=$nt[GroupName]&value=$nt[Value]'> ".$l[all][edit]." </a>
                             <a href='mng-rad-groupreply-del.php?groupname=$nt[GroupName]&value=$nt[Value]'> ".$l[all][del]." </a>
                             </td>

                </tr>";
        }
        echo "</table>";

        mysql_free_result($res);
        include 'library/closedb.php';
?>


				</p>
				
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