<?php
/*********************************************************************
* Name: attributes.php
* Author: Liran tal <liran.tal@gmail.com>
* 
* This file is used by the management page (edit user) 
* and it's general purpose is to return the table string
* for a given attribute name
*
*********************************************************************/

function drawAttributes() {

	$arraySessionAttr = array(
	 'Max-All-Session' => 'seconds',
	 'Session-Timeout' => 'seconds',
	 'Idle-Timeout' => 'seconds'
	 );

	 
	$arrayNasAttr = array(
	 'Calling-Station-Id' => 'none',
	 'Called-Station-Id' => 'none'
	 );	 
	 
	 
	$arrayWISPrAttr = array(
	 'WISPr-Redirection-URL' => 'none',
	 'WISPr-Bandwidth-Max-Up' => 'speed',
	 'WISPr-Bandwidth-Max-Down' => 'speed',
	 'WISPr-Session-Terminate-Time' => 'date'
	 );	 

	$arrayChillispotAttr = array(
	 'ChilliSpot-Max-Input-Octets' => 'none',
	 'ChilliSpot-Max-Output-Octets' => 'none',
	 'ChilliSpot-Max-Total-Octets' => 'none',
	 'ChilliSpot-UAM-Allowed' => 'none',
	 'ChilliSpot-MAC-Allowed' => 'none',
	 'ChilliSpot-MAC-Interval' => 'none'
	 );	 
	 
echo "<br/><table border='2' class='table1' width='600'>";
echo <<<EOF
	<tr><td>		
    <input type="checkbox" onclick="javascript:toggleShowDiv('categorySession')">
    <b> Session Attributes </b> <br/>
    <div id="categorySession" style="display:none;visibility:visible" >
EOF;
	 $cnt = 0;
	foreach ( $arraySessionAttr as $attrib => $help ) {
		drawAttributesHtml($attrib);
		if ($help == "seconds") 
			drawSelectSeconds($attrib, $cnt);
		if ($help == "speed") 
			drawSelectSpeed($attrib, $cnt);
		if ($help == "date") 
			drawDateHtml($attrib);			
		echo "
		<br/><br/></font>
		</div>
		";
		$cnt++;
	}
	echo "</td></tr>
		</div>";
	
	
echo <<<EOF
	<tr><td>	
    <input type="checkbox" onclick="javascript:toggleShowDiv('categoryNas')">
    <b> NAS Attributes </b> <br/>
    <div id="categoryNas" style="display:none;visibility:visible" >
EOF;
	
	$cnt = 0;
	foreach ( $arrayNasAttr as $attrib => $help ) {
		drawAttributesHtml($attrib);
		if ($help == "seconds") 
			drawSelectSeconds($attrib, $cnt);
		if ($help == "speed") 
			drawSelectSpeed($attrib, $cnt);
		if ($help == "date") 
			drawDateHtml($attrib);			
		echo "
		<br/><br/></font>
		</div>
		";
		$cnt++;
	}	
echo "</td></tr>
		</div>";
	

echo <<<EOF
	<table border='2' class='table1' width='600'>
	<tr><td>
    <input type="checkbox" onclick="javascript:toggleShowDiv('categoryWISPr')">
    <b> WISPr Attributes </b> <br/>
    <div id="categoryWISPr" style="display:none;visibility:visible" >
EOF;
	
	$cnt = 0;
	foreach ( $arrayWISPrAttr as $attrib => $help ) {
		drawAttributesHtml($attrib);
		if ($help == "seconds") 
			drawSelectSeconds($attrib, $cnt);
		if ($help == "speed") 
			drawSelectSpeed($attrib, $cnt);
		if ($help == "date") 
			drawDateHtml($attrib);			
		echo "
		<br/><br/></font>
		</div>
		";
		$cnt++;
	}		
	echo "</td></tr>
		</div>";	



echo <<<EOF
	<tr><td>	
    <input type="checkbox" onclick="javascript:toggleShowDiv('categoryChillispot')">
    <b> Chillispot Attributes </b> <br/>
    <div id="categoryChillispot" style="display:none;visibility:visible" >
EOF;
	
	$cnt = 0;
	foreach ( $arrayChillispotAttr as $attrib => $help ) {
		drawAttributesHtml($attrib);
		if ($help == "seconds") 
			drawSelectSeconds($attrib, $cnt);
		if ($help == "speed") 
			drawSelectSpeed($attrib, $cnt);
		if ($help == "date") 
			drawDateHtml($attrib);			
		echo "
		<br/><br/></font>
		</div>
		";
		$cnt++;
	}	
echo "</td></tr>
		</div>";










echo "</table>";

	
}


function drawAttributesHtml($attrib) {

        include_once ('op_select_options.php');
        echo <<<EOA
                <font color='#FF0000'>
                <input type="checkbox" onclick="javascript:toggleShowDiv('attributes$attrib')">
                <b>$attrib</b><br/>
                <div id="attributes$attrib" style="display:none;visibility:visible" >
EOA;
        echo "<input value='' id='$attrib' name='$attrib" . "[]'" . ">";
        echo "
                <select name=\"".$attrib."[]\">";
        drawOptions();
        echo "</select>";
        echo "";


}


function drawSelectSpeed($attribute, $counter) {

	echo <<<EOS
		<select onChange="javascript:setText(this.id,'$attribute')" id="option$attribute">
		<option value="1">calculate speed</option>
		<option value="1">bits</option>
		<option value="1024">kilobits</option>
		<option value="1048576">megabits</option>
		</select>
EOS;

}


function drawDateHtml($attribute) {

	echo <<<EOS
		<img src="library/js_date/calendar.gif" onclick="showChooser(this, '$attribute', 'chooserSpan', 1950, 2010, 'd M Y', false);">
<div id="chooserSpan" class="dateChooser select-free" style="display: none; visibility: hidden; width: 160px;"></div>
EOS;

}


function drawSelectSeconds($attribute, $counter) {

	echo <<<EOS
		<select onChange="javascript:setText(this.id,'$attribute')" id="option$attribute">
		<option value="1">calculate time</option>
		<option value="1">seconds</option>
		<option value="60">minutes</option>
		<option value="3600">hours</option>
		<option value="86400">days</option>
		<option value="604800">weeks</option>
		<option value="2592000">months (30 days)</option>
		</select>
EOS;

}


function checkTables($attribute) {
/*
* @param $attribute	The attribute name, Session-Timeout for example
* @return $table		The table name, either radcheck or radreply
*/
    include ('library/config_read.php');
	$table = $configValues['CONFIG_DB_TBL_RADCHECK'];
	
	switch ($attribute) {
		case "Session-Timeout":
			$table = $configValues['CONFIG_DB_TBL_RADREPLY'];
			break;
		case "Idle-Timeout":
			$table = $configValues['CONFIG_DB_TBL_RADREPLY'];
			break;
		case "WISPr-Redirection-URL":
			$table = $configValues['CONFIG_DB_TBL_RADREPLY'];
			break;
		case "WISPr-Bandwidth-Max-Up":
			$table = $configValues['CONFIG_DB_TBL_RADREPLY'];
			break;
		case "WISPr-Bandwidth-Max-Down":
			$table = $configValues['CONFIG_DB_TBL_RADREPLY'];
			break;
		case "WISPr-Session-Terminate-Time":
			$table = $configValues['CONFIG_DB_TBL_RADREPLY'];
			break;
		case "ChilliSpot-Max-Input-Octets":
			$table = $configValues['CONFIG_DB_TBL_RADREPLY'];
			break;
		case "ChilliSpot-Max-Output-Octets":
			$table = $configValues['CONFIG_DB_TBL_RADREPLY'];
			break;
		case "ChilliSpot-Max-Total-Octets":
			$table = $configValues['CONFIG_DB_TBL_RADREPLY'];
			break;
		case "ChilliSpot-UAM-Allowed":
			$table = $configValues['CONFIG_DB_TBL_RADREPLY'];
			break;
		case "ChilliSpot-MAC-Allowed":
			$table = $configValues['CONFIG_DB_TBL_RADREPLY'];
			break;
		case "ChilliSpot-MAC-Interval":
			$table = $configValues['CONFIG_DB_TBL_RADREPLY'];
			break;
	}


	return $table;


}



?>
