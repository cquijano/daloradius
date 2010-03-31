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
 * Description:
 *              returns user billing information (rates, plans, etc)
 *
 * Authors:     Liran Tal <liran@enginx.com>
 *
 *********************************************************************************************************
 */

/*
 *********************************************************************************************************
 * userBillingRatesSummary
 * $username            username to provide information of
 * $startdate		starting date, first accounting session
 * $enddate		ending date, last accounting session
 * $ratename		the rate to use for calculations
 * $drawTable           if set to 1 (enabled) a toggled on/off table will be drawn
 * 
 * returns user connection information: uploads, download, session time, total billed, etc...
 *
 *********************************************************************************************************
 */
function userBillingRatesSummary($username, $startdate, $enddate, $ratename, $drawTable) {

	include_once('include/management/pages_common.php');
	include 'library/opendb.php';

	$username = $dbSocket->escapeSimple($username);			// sanitize variable for sql statement
    $startdate = $dbSocket->escapeSimple($startdate);
    $enddate = $dbSocket->escapeSimple($enddate);
    $ratename = $dbSocket->escapeSimple($ratename);

    // get rate type
    $sql = "SELECT rateType FROM ".$configValues['CONFIG_DB_TBL_DALOBILLINGRATES']." WHERE ".$configValues['CONFIG_DB_TBL_DALOBILLINGRATES'].".rateName = '$ratename'";
    $res = $dbSocket->query($sql);

	if ($res->numRows() == 0)
		return;

        $row = $res->fetchRow();
        list($ratetypenum, $ratetypetime) = split("/",$row[0]);

        switch ($ratetypetime) {                                        // we need to translate any kind of time into seconds, so a minute is 60 seconds, an hour is 3600,
                case "second":                                          // and so on...
                        $multiplicate = 1;
                        break;
                case "minute":
                        $multiplicate = 60;
                        break;
                case "hour":
                        $multiplicate = 3600;
                        break;
                case "day":
                        $multiplicate = 86400;
                        break;
                case "week":
                        $multiplicate = 604800;
                        break;
                case "month":
                        $multiplicate = 187488000;                      // a month is 31 days
                        break;
                default:
                        $multiplicate = 0;
                        break;
        }

        // then the rate cost would be the amount of seconds times the prefix multiplicator thus:
        $rateDivisor = ($ratetypenum * $multiplicate);

        $sql = "SELECT distinct(".$configValues['CONFIG_DB_TBL_RADACCT'].".username), ".$configValues['CONFIG_DB_TBL_RADACCT'].".NASIPAddress, ".
                $configValues['CONFIG_DB_TBL_RADACCT'].".AcctStartTime, SUM(".$configValues['CONFIG_DB_TBL_RADACCT'].".AcctSessionTime) AS AcctSessionTime, ".
                $configValues['CONFIG_DB_TBL_DALOBILLINGRATES'].".rateCost, SUM(".$configValues['CONFIG_DB_TBL_RADACCT'].".AcctInputOctets) AS AcctInputOctets, ".
		" SUM(".$configValues['CONFIG_DB_TBL_RADACCT'].".AcctOutputOctets) AS AcctOutputOctets ".
                " FROM ".$configValues['CONFIG_DB_TBL_RADACCT'].", ".$configValues['CONFIG_DB_TBL_DALOBILLINGRATES']." WHERE (AcctStartTime >= '$startdate') and (AcctStartTime <= '$enddate') and (UserName = '$username') and (".$configValues['CONFIG_DB_TBL_DALOBILLINGRATES'].".rateName = '$ratename') GROUP BY UserName";
	$res = $dbSocket->query($sql);
	$row = $res->fetchRow(DB_FETCHMODE_ASSOC);

	$rateCost = $row['rateCost'];
	$userUpload = toxbyte($row['AcctInputOctets']);
	$userDownload = toxbyte($row['AcctOutputOctets']);
	$userOnlineTime = time2str($row['AcctSessionTime']);
	$sessionTime = $row['AcctSessionTime'];

	$sumBilled = (($sessionTime/$rateDivisor)*$rateCost);

        include 'library/closedb.php';

        if ($drawTable == 1) {

                echo "<table border='0' class='table1'>";
                echo "
        		<thead>
        			<tr>
        	                <th colspan='10' align='left'> 
        				<a class=\"table\" href=\"javascript:toggleShowDiv('divBillingRatesSummary')\">Billing Summary</a>
        	                </th>
        	                </tr>
        		</thead>
        		</table>
        	";
        
                echo "
                        <div id='divBillingRatesSummary' style='display:none;visibility:visible'>
               		<table border='0' class='table1'>
        		<thread>

                        <tr>        
                        <th scope='col' align='right'>
                        Username
                        </th> 
        
                        <th scope='col' align='left'>
                        $username
                        </th>
                        </tr>

                        <tr>
                        <th scope='col' align='right'>
                        Billing for period of
                        </th> 
        
                        <th scope='col' align='left'>
                        $startdate until $enddate (inclusive)
                        </th>
                        </tr>

                        <tr>
                        <th scope='col' align='right'>
                        Online Time
                        </th> 
        
                        <th scope='col' align='left'>
                        $userOnlineTime
                        </th>
                        </tr>

                        <tr>
                        <th scope='col' align='right'>
                        User Upload
                        </th> 
        
                        <th scope='col' align='left'>
                        $userUpload
                        </th>
                        </tr>


                        <tr>
                        <th scope='col' align='right'>
                        User Download
                        </th> 
        
                        <th scope='col' align='left'>
                        $userDownload
                        </th>
                        </tr>


                        <tr>
                        <th scope='col' align='right'>
                        Rate Name
                        </th> 
        
                        <th scope='col' align='left'>
                        $ratename
                        </th>
                        </tr>


                        <tr>
                        <th scope='col' align='right'>
                        Total Billed
                        </th> 
        
                        <th scope='col' align='left'>
                        $sumBilled
                        </th>
                        </tr>

                        </table>

        		</div>
        	";

	}		


}



/*
 *********************************************************************************************************
 * userBillingPayPalSummary
 * $startdate		starting date, first accounting session
 * $enddate		ending date, last accounting session
 * $drawTable           if set to 1 (enabled) a toggled on/off table will be drawn
 * 
 * returns user connection information: uploads, download, session time, total billed, etc...
 *
 *********************************************************************************************************
 */
function userBillingPayPalSummary($startdate, $enddate, $payer_email, $payment_address_status, $payer_status, $payment_status, $vendor_type, $drawTable) {

	include_once('include/management/pages_common.php');
	include 'library/opendb.php';

        $startdate = $dbSocket->escapeSimple($startdate);
        $enddate = $dbSocket->escapeSimple($enddate);
        $payer_email = $dbSocket->escapeSimple($payer_email);
        $payment_address_status = $dbSocket->escapeSimple($payment_address_status);
        $payer_status = $dbSocket->escapeSimple($payer_status);
        $payment_status = $dbSocket->escapeSimple($payment_status);

        $sql = "SELECT ".$configValues['CONFIG_DB_TBL_DALOBILLINGMERCHANT'].".Username AS Username, business_email, ".
        $configValues['CONFIG_DB_TBL_DALOBILLINGPLANS'].".planName, ".$configValues['CONFIG_DB_TBL_DALOBILLINGMERCHANT'].".planId, SUM(payment_total) AS total, SUM(payment_fee) ".
		" AS fee, SUM(payment_tax) AS tax, payment_currency, SUM(AcctSessionTime) AS AcctSessionTime, SUM(AcctInputOctets) AS AcctInputOctets, ".
		" SUM(AcctOutputOctets) AS AcctOutputOctets ".
		" FROM ".$configValues['CONFIG_DB_TBL_DALOBILLINGMERCHANT'].
		" LEFT JOIN ".$configValues['CONFIG_DB_TBL_RADACCT']." ON ".
		$configValues['CONFIG_DB_TBL_DALOBILLINGMERCHANT'].".Username=".$configValues['CONFIG_DB_TBL_RADACCT'].".Username ".
		" LEFT JOIN ".$configValues['CONFIG_DB_TBL_DALOBILLINGPLANS']." ON ".
		$configValues['CONFIG_DB_TBL_DALOBILLINGMERCHANT'].".planId=".$configValues['CONFIG_DB_TBL_DALOBILLINGPLANS'].".id ".
		" WHERE ".
	        " (business_email LIKE '$payer_email') AND ".
                " (payment_address_status LIKE '$payment_address_status') AND ".
                " (payer_status LIKE '$payer_status') AND ".
                " (payment_status LIKE '$payment_status') AND ".
                " (vendor_type LIKE '$vendor_type') AND ".
                " (payment_date>'$startdate' AND payment_date<'$enddate')".
		" GROUP BY Username";
        $res = $dbSocket->query($sql);

	if ($res->numRows() == 0)
		return;

	$row = $res->fetchRow(DB_FETCHMODE_ASSOC);

	$planTotalCost = $row['total'];
	$planTotalTax = $row['tax'];
	$planTotalFee = $row['fee'];
	$userUpload = toxbyte($row['AcctInputOctets']);
	$userDownload = toxbyte($row['AcctOutputOctets']);
	$userOnlineTime = time2str($row['AcctSessionTime']);
	$sessionTime = $row['AcctSessionTime'];
	$planCurrency = $row['payment_currency'];
	$planName = $row['planName'];
	$planId = $row['planId'];
	$payer_email = $row['business_email'];
	$username = $row['Username'];

	$grossGain = ($planTotalCost-($planTotalTax+$planTotalFee));

        include 'library/closedb.php';

        if ($drawTable == 1) {

                echo "<table border='0' class='table1'>";
                echo "
        		<thead>
        			<tr>
        	                <th colspan='10' align='left'> 
        				<a class=\"table\" href=\"javascript:toggleShowDiv('divBillingPayPalSummary')\">Billing Summary</a>
        	                </th>
        	                </tr>
        		</thead>
        		</table>
        	";
        
                echo "
                        <div id='divBillingPayPalSummary' style='display:none;visibility:visible'>
               		<table border='0' class='table1'>
        		<thread>

                        <tr>        
                        <th scope='col' align='right'>
                        Username
                        </th> 
        
                        <th scope='col' align='left'>
                        $username (email: $payer_email)
                        </th>
                        </tr>

                        <tr>
                        <th scope='col' align='right'>
                        Billing for period of
                        </th> 
        
                        <th scope='col' align='left'>
                        $startdate until $enddate (inclusive)
                        </th>
                        </tr>

                        <tr>
                        <th scope='col' align='right'>
                        Online Time
                        </th> 
        
                        <th scope='col' align='left'>
                        $userOnlineTime
                        </th>
                        </tr>

                        <tr>
                        <th scope='col' align='right'>
                        User Upload
                        </th> 
        
                        <th scope='col' align='left'>
                        $userUpload
                        </th>
                        </tr>


                        <tr>
                        <th scope='col' align='right'>
                        User Download
                        </th> 
        
                        <th scope='col' align='left'>
                        $userDownload
                        </th>
                        </tr>


                        <tr>
                        <th scope='col' align='right'>
                        Plan name
                        </th> 
        
                        <th scope='col' align='left'>
                        $planName (planId: $planId)
                        </th>
                        </tr>


                        <tr>
                        <th scope='col' align='right'>
                        Total Plans Cost <br/> Total Transaction Fees <br/> Total Transaction Taxs
                        </th> 
        
                        <th scope='col' align='left'>
                        $planTotalCost <br/> $planTotalFee <br/> $planTotalTax
                        </th>
                        </tr>


                        <tr>
                        <th scope='col' align='right'>
                        Gross Gain
                        </th> 
        
                        <th scope='col' align='left'>
                        $grossGain $planCurrency
                        </th>
                        </tr>

                        </table>

        		</div>
        	";

	}		


}

