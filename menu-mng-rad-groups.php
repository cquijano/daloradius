
<body>
<?php
    include_once ("lang/main.php");
?>
<div id="wrapper">
<div id="innerwrapper">

<?php
    $m_active = "Management";
    include_once ("include/menu/menu-items.php");
	include_once ("include/menu/management-subnav.php");
?>

<div id="sidebar">

	<h2>Management</h2>

	<h3>Group Reply Management</h3>
	<ul class="subnav">

		<li><a href="mng-rad-groupreply-list.php"><b>&raquo;</b><?php echo $l['button']['ListGroupReply'] ?></a></li>
		<li><a href="javascript:document.mngradgroupreplysearch.submit();""><b>&raquo;</b><?php echo $l['button']['SearchGroupReply'] ?><a>
			<form name="mngradgroupreplysearch" action="mng-rad-groupreply-search.php" method="get" 
				class="sidebar">
			<input name="groupname" type="text" 
				value="<?php if (isset($search_groupname)) echo $search_groupname; ?>" tabindex=2>
			</form></li>

		<li><a href="mng-rad-groupreply-new.php"><b>&raquo;</b><?php echo $l['button']['NewGroupReply'] ?></a></li>
		<li><a href="javascript:document.mngradgrprplyedit.submit();""><b>&raquo;</b><?php echo $l['button']['EditGroupReply'] ?><a>
			<form name="mngradgrprplyedit" action="mng-rad-groupreply-edit.php" method="get" class="sidebar">
			<input name="groupname" type="text" value="[groupname]">
			<input name="attribute" type="text" value="[attribute]">
			</form></li>
		<li><a href="mng-rad-groupreply-del.php"><b>&raquo;</b><?php echo $l['button']['RemoveGroupReply'] ?></a></li>
		
	</ul>

	<h3>Group Check Management</h3>
	<ul class="subnav">

		<li><a href="mng-rad-groupcheck-list.php"><b>&raquo;</b><?php echo $l['button']['ListGroupCheck'] ?></a></li>
		<li><a href="javascript:document.mngradgroupchecksearch.submit();""><b>&raquo;</b><?php echo $l['button']['SearchGroupCheck'] ?><a>
			<form name="mngradgroupchecksearch" action="mng-rad-groupcheck-search.php" method="get" 
				class="sidebar">
			<input name="groupname" type="text" 
				value="<?php if (isset($search_groupname)) echo $search_groupname; ?>" tabindex=2>
			</form></li>

		<li><a href="mng-rad-groupcheck-new.php"><b>&raquo;</b><?php echo $l['button']['NewGroupCheck'] ?></a></li>
		<li><a href="javascript:document.mngradgrpchkedit.submit();""><b>&raquo;</b><?php echo $l['button']['EditGroupCheck'] ?><a>
			<form name="mngradgrpchkedit" action="mng-rad-groupcheck-edit.php" method="get" class="sidebar">
			<input name="groupname" type="text" value="[groupname]">
			<input name="attribute" type="text" value="[attribute]">
			</form></li>
		<li><a href="mng-rad-groupcheck-del.php"><b>&raquo;</b><?php echo $l['button']['RemoveGroupCheck'] ?></a></li>
		
	</ul>

</div>

<?php

        if ((isset($actionStatus)) && ($actionStatus == "success")) {
                echo <<<EOF
                        <div id="contentnorightbar">
                        <h9 id="Intro"> Success </h9>
                        <br/><br/>
                        <font color='#0000FF'>
EOF;
        echo $actionMsg;

        echo "</font></div>";

        }


        if ((isset($actionStatus)) && ($actionStatus == "failure")) {
                echo <<<EOF
                        <div id="contentnorightbar">
                        <h8 id="Intro"> Failure </h8>
                        <br/><br/>
                        <font color='#FF0000'>
EOF;
        echo $actionMsg;

        echo "</font></div>";

        }


?>
