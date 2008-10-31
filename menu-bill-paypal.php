<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<title>daloRADIUS</title>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="css/1.css" type="text/css" media="screen,projection" />

<link rel="stylesheet" type="text/css" href="library/js_date/datechooser.css">
<!--[if lte IE 6.5]>
<link rel="stylesheet" type="text/css" href="library/js_date/select-free.css"/>
<![endif]-->
</head>

<script src="library/js_date/date-functions.js" type="text/javascript"></script>
<script src="library/js_date/datechooser.js" type="text/javascript"></script>
<script src="library/javascript/pages_common.js" type="text/javascript"></script>

<body>
<?php
    include_once ("lang/main.php");
?>
<div id="wrapper">
<div id="innerwrapper">

<?php
    $m_active = "Billing";
    include_once ("include/menu/menu-items.php");
	include_once ("include/menu/billing-subnav.php");
?>

<div id="sidebar">

                                <h2>Billing</h2>

                                <h3>Track PayPal Transactions</h3>
	<ul class="subnav">

		<h109><?php echo $l['button']['BetweenDates']; ?></h109> <br/>
                        <form name="billpaypaltransactions" action="bill-paypal-transactions.php" method="get" class="sidebar">

                        <input name="startdate" type="text" id="startdate"
                                value="<?php if (isset($billing_date_startdate)) echo $billing_date_startdate;
                        else echo date("Y-m-d"); ?>">

                        <img src="library/js_date/calendar.gif"
                                onclick="showChooser(this, 'startdate', 'chooserSpan', 1950, 2010, 'Y-m-d', false);">
                        <div id="chooserSpan" class="dateChooser select-free"
                                style="display: none; visibility: hidden;       width: 160px;"></div>

                        <input name="enddate" type="text" id="enddate"
                                value="<?php if (isset($billing_date_enddate)) echo $billing_date_enddate;
                                else echo date("Y-m-d", mktime(0, 0, 0, date("m")  , date("d")+1,
                                date("Y"))); ?>">

                        <img src="library/js_date/calendar.gif"
                                onclick="showChooser(this, 'enddate', 'chooserSpan', 1950, 2010, 'Y-m-d', false);">
                        <div id="chooserSpan" class="dateChooser select-free"
                                style="display: none; visibility: hidden; width: 160px;"></div>
			<br/><br/>


		<h109><?php echo $l['all']['PayerEmail']; ?></h109> <br/>
                        <input name="payer_email" type="text"
                                value="<?php if (isset($billing_paypal_payeremail)) echo $billing_paypal_payeremail; else echo "*"; ?>">
			<br/>

		<h109><?php echo $l['all']['PaymentStatus']; ?></h109> <br/>
                        <select name="payment_status" size="1">
                                <option value="<?php if (isset($billing_paypal_paymentstatus)) echo $billing_paypal_paymentstatus; else echo "Completed"; ?>">
                                        <?php if (isset($billing_paypal_paymentstatus)) echo $billing_paypal_paymentstatus; else echo "Completed"; ?>
                                </option>
				<option value=""></option>
				<option value="Completed">Completed</option>
				<option value="Denied">Denied</option>
				<option value="Expired">Expired</option>
				<option value="Failed">Failed</option>
				<option value="In-Progress">In-Progress</option>
				<option value="Pending">Pending</option>
				<option value="Processed">Processed</option>
				<option value="Refunded">Refunded</option>
				<option value="Reversed">Reversed</option>
				<option value="Canceled-Reversal">Canceled-Reversal</option>
				<option value="Voided">Voided</option>
                        </select>
			<br/><br/>

		<h109><?php echo $l['all']['PayerStatus']; ?></h109> <br/>
                        <select name="payer_status" size="1">
                                <option value="<?php if (isset($billing_paypal_payerstatus)) echo $billing_paypal_payerstatus; else echo "verified"; ?>">
                                        <?php if (isset($billing_paypal_payerstatus)) echo $billing_paypal_payerstatus; else echo "Verified"; ?>
                                </option>
				<option value=""></option>
				<option value="verified">Verified</option>
				<option value="unverified">Unverified</option>
                        </select>
			<br/><br/>

		<h109><?php echo $l['all']['PaymentAddressStatus']; ?></h109> <br/>
                        <select name="payment_address_status" size="1">
                                <option value="<?php if (isset($billing_paypal_paymentaddressstatus)) echo $billing_paypal_paymentaddressstatus; else echo "confirmed"; ?>">
                                        <?php if (isset($billing_paypal_paymentaddressstatus)) echo $billing_paypal_paymentaddressstatus; else echo "Confirmed"; ?>
                                </option>
				<option value=""></option>
				<option value="confirmed">Confirmed</option>
				<option value="unconfirmed">Unconfirmed</option>
                        </select>
			<br/><br/>


                <br/><br/><br/>
                <h109><?php echo $l['button']['AccountingFieldsinQuery']; ?></h109><br/>
                <input type="checkbox" name="sqlfields[]" value="id" checked /> <h109> <?php echo $l['all']['ID']; ?> </h109> <br/>
                <input type="checkbox" name="sqlfields[]" value="username" checked /> <h109><?php echo $l['all']['Username']; ?> </h109> <br/>
                <input type="checkbox" name="sqlfields[]" value="password"  /> <h109><?php echo $l['all']['Password']; ?></h109> <br/>
                <input type="checkbox" name="sqlfields[]" value="txnId"  /> <h109><?php echo $l['all']['TxnId']; ?> </h109> <br/>
                <input type="checkbox" name="sqlfields[]" value="planName" checked /> <h109><?php echo $l['all']['PlanName']; ?> </h109> <br/>
                <input type="checkbox" name="sqlfields[]" value="planId"  /> <h109><?php echo $l['all']['PlanId']; ?> </h109> <br/>
                <input type="checkbox" name="sqlfields[]" value="quantity"  /> <h109><?php echo $l['all']['Quantity']; ?> </h109> <br/>
                <input type="checkbox" name="sqlfields[]" value="receiver_email"  /> <h109><?php echo $l['all']['ReceiverEmail']; ?> </h109> <br/>
                <input type="checkbox" name="sqlfields[]" value="business"  /> <h109><?php echo $l['all']['Business']; ?> </h109> <br/>
                <input type="checkbox" name="sqlfields[]" value="tax" checked /> <h109><?php echo $l['all']['Tax']; ?> </h109> <br/>
                <input type="checkbox" name="sqlfields[]" value="mc_gross" checked /> <h109><?php echo $l['all']['Cost']; ?> </h109> <br/>
                <input type="checkbox" name="sqlfields[]" value="mc_fee" checked /> <h109><?php echo $l['all']['TransactionFee']; ?> </h109> <br/>
                <input type="checkbox" name="sqlfields[]" value="mc_currency" checked /> <h109><?php echo $l['all']['PaymentCurrency']; ?> </h109> <br/>
                <input type="checkbox" name="sqlfields[]" value="first_name" checked /> <h109><?php echo $l['all']['FirstName']; ?> </h109> <br/>
                <input type="checkbox" name="sqlfields[]" value="last_name" checked /> <h109><?php echo $l['all']['LastName']; ?> </h109> <br/>
                <input type="checkbox" name="sqlfields[]" value="payer_email" checked /> <h109><?php echo $l['all']['PayerEmail']; ?> </h109> <br/>
                <input type="checkbox" name="sqlfields[]" value="address_name"  /> <h109><?php echo $l['all']['AddressRecipient']; ?> </h109> <br/>
                <input type="checkbox" name="sqlfields[]" value="address_street"  /> <h109><?php echo $l['all']['Street']; ?> </h109> <br/>
                <input type="checkbox" name="sqlfields[]" value="address_country" checked /> <h109><?php echo $l['all']['Country']; ?> </h109> <br/>
                <input type="checkbox" name="sqlfields[]" value="address_country_code"  /> <h109><?php echo $l['all']['CountryCode']; ?> </h109> <br/>
                <input type="checkbox" name="sqlfields[]" value="address_city" checked /> <h109><?php echo $l['all']['City']; ?> </h109> <br/>
                <input type="checkbox" name="sqlfields[]" value="address_state" checked /> <h109><?php echo $l['all']['State']; ?> </h109> <br/>
                <input type="checkbox" name="sqlfields[]" value="address_zip"  /> <h109><?php echo $l['all']['Zip']; ?> </h109> <br/>
                <input type="checkbox" name="sqlfields[]" value="payment_date" checked /> <h109><?php echo $l['all']['PaymentDate']; ?> </h109> <br/>
                <input type="checkbox" name="sqlfields[]" value="payment_status" checked /> <h109><?php echo $l['all']['PaymentStatus']; ?> </h109> <br/>
                <input type="checkbox" name="sqlfields[]" value="payer_status" checked /> <h109><?php echo $l['all']['PayerStatus']; ?> </h109> <br/>
                <input type="checkbox" name="sqlfields[]" value="payment_address_status" checked /> <h109><?php echo $l['all']['PaymentAddressStatus']; ?> </h109> <br/>
                Select:
                <a class="table" href="javascript:SetChecked(1,'sqlfields[]','billpaypaltransactions')">All</a>
                <a class="table" href="javascript:SetChecked(0,'sqlfields[]','billpaypaltransactions')">None</a>


                <br/><br/>
                <h109><?php echo $l['button']['OrderBy'] ?><h109> <br/>
                        <center>
                        <select name="orderBy" size="1">
                                <option value="id"> Id </option>
                                <option value="username"> username </option>
                                <option value="txnId"> txnId </option>
			</select>

                        <select name="orderType" size="1">
                                <option value="ASC"> Ascending </option>
                                <option value="DESC"> Descending </option>
                        </select>
                        </center>

        <br/>
        <input type="submit" name="submit" value="<?php echo $l['button']['ProcessQuery'] ?>" tabindex=3 />



                        </form></li>

		</ul>


                                <br/><br/>
                                <h2>Search</h2>

			<input name="" type="text" value="Search" tabindex=4 />

                </div>

