
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
	
	<h3>NAS Management</h3>
	<ul class="subnav">
	
		<li><a href="mng-rad-nas-list.php" tabindex=1><b>&raquo;</b><?php echo $l['button']['ListNAS'] ?></a></li>
		<li><a href="mng-rad-nas-new.php" tabindex=2><b>&raquo;</b><?php echo $l['button']['NewNAS'] ?></a></li>
		<li><a href="javascript:document.mngradnasedit.submit();" tabindex=3 ><b>&raquo;</b><?php echo $l['button']['EditNAS'] ?></a>
			<form name="mngradnasedit" action="mng-rad-nas-edit.php" method="get" class="sidebar">
			<input name="nashost" type="text" tabindex=4>
			</form></li>
		<li><a href="mng-rad-nas-del.php" tabindex=5><b>&raquo;</b><?php echo $l['button']['RemoveNAS'] ?></a></li>
		
	</ul>

</div>
