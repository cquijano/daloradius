<?php

error_reporting(0);	// because we're not using a proper way for the translation variables right now we set this error_repoting to 0 level
					// in the future we will re-design it to work something like:
					//
					// define('l[Help][Max-All-Session]', "blabablabla");
					// echo constant('l[Help][Max-All-Session]');
					//
					// which is acceptiable for php without errors

$l[all][daloRADIUS] = "daloRADIUS";
$l[all][copyright1] = "Radius Reporting, Billing and Management by <a href=\"http://www.enginx.com\">Enginx</a>";
$l[all][copyright2] = "Copyright of <a href=\"http://www.enginx.com\">Enginx</a> and Liran Tal<br/>
Template design by <a href=\"http://www.sixshootermedia.com\">Six Shooter Media</a>.";
$l[all][ID] = "ID";
$l[all][NasID] = "NAS ID";
$l[all][Nas] = "NAS ";
$l[all][NasIPHost] = "NAS IP/Host";
$l[all][NasShortname] = "Краткое имя NAS";
$l[all][NasType] = "Тип NAS";
$l[all][NasPorts] = "Порты NAS";
$l[all][NasSecret] = "Секретное слово NAS";
$l[all][NasCommunity] = "SNMP-Коммьюнити NAS";
$l[all][NasDescription] = "Описание NAS";
$l[all][HotSpot] = "Точка доступа";
$l[all][HotSpots] = "Точки доступа";
$l[all][Username] = "Логин";
$l[all][Password] = "Пароль";
$l[all][IPAddress] = "IP-Адрес";
$l[all][Groupname] = "Группа";
$l[all][Priority] = "Приоритет";
$l[all][Attribute] = "Аттрибут";
$l[all][Operator] = "Оператор";
$l[all][Value] = "Значение";
$l[all][MaxTimeExpiration] = "Max Time / Expiration";
$l[all][UsedTime] = "Использовано времени";
$l[all][Status] = "Статус";
$l[all][Usage] = "Использование";
$l[all][StartTime] = "Начало";
$l[all][StopTime] = "Окончание";
$l[all][TotalTime] = "Всего времени";
$l[all][Bytes] = "Байт";
$l[all][Upload] = "Передал";
$l[all][Download] = "Принял";
$l[all][Termination] = "Разрыв";
$l[all][NASIPAddress] = "IP-Адрес NAS";
$l[all][Action] = "Действие";
$l[all][UniqueUsers] = "Уникальных пользователей";
$l[all][TotalHits] = "Всего хитов";
$l[all][AverageTime] = "Среднее время";
$l[all][Records] = "Записи";
$l[all][Summary] = "Итог";
$l[all][Statistics] = "Статистика";
$l[all][Credit] = "Кредит";
$l[all][Used] = "Использовано";
$l[all][LeftTime] = "Осталось времени";
$l[all][LeftPercent] = "Осталось %";
$l[all][TotalSessions] = "Всего сессий";
$l[all][LastLoginTime] = "Последний раз в сети";
$l[all][TotalSessionTime] = "Общее время сессий";
$l[all][Rate] = "Rate";
$l[all][Billed] = "Billed";
$l[all][TotalUsers] = "Всего пользователей";
$l[all][TotalBilled] = "Всего посчитано";
$l[all][CardBank] = "Card Bank";
$l[all][Type] = "Тип";
$l[all][CardBank] = "CardBank";
$l[all][MACAddress] = "MAC-Адрес";
$l[all][Geocode] = "Геокод";
$l[all][edit] = "править";
$l[all][del] = "удалить";

$l[Intro][acctactive.php] = "Active Records Accounting";
$l[Intro][acctall.php] = "Статистика пользователей";
$l[Intro][acctdate.php] = "Статистика пользователей";
$l[Intro][accthotspot.php] = "Статистика точек доступа";
$l[Intro][acctipaddress.php] = "Статистика пользователей";
$l[Intro][accthotspotcompare.php] = "Сравнение точек доступа";
$l[Intro][acctmain.php] = "Страница аккаунтинга";
$l[Intro][acctnasipaddress.php] = "Статистика пользователей";
$l[Intro][acctusername.php] = "Статистика пользователей";

$l[Intro][billmain.php] = "Биллинг";
$l[Intro][billpersecond.php] = "Авансовый аккаунтинг";
$l[Intro][billprepaid.php] = "Авансовый аккаунтинг";
$l[Intro][billratesdel.php] = "Удалить запись";
$l[Intro][billratesedit.php] = "Редактировать";
$l[Intro][billrateslist.php] = "Rates Table";
$l[Intro][billratesnew.php] = "New Rate entry";

$l[Intro][giseditmap.php] = "Edit MAP Mode";
$l[Intro][gismain.php] = "GIS Mapping";
$l[Intro][gisviewmap.php] = "View MAP Mode";

$l[Intro][graphmain.php] = "Introduction";
$l[Intro][graphsalltimedownload.php] = "Overall Usage";
$l[Intro][graphsalltimetrafficcompare.php] = "Overall Usage";
$l[Intro][graphsalltimelogins.php] = "Overall Usage";
$l[Intro][graphsalltimeupload.php] = "Overall Usage";
$l[Intro][graphsoveralldownload.php] = "Overall Usage";
$l[Intro][graphsoveralllogins.php] = "Overall Usage";
$l[Intro][graphsoverallupload.php] = "Overall Usage";

$l[Intro][indexlastconnect.php] = "Последние 50 попыток соединений";
$l[Intro][indexradiuslog.php] = "Лог RADIUS";
$l[Intro][indexradiusstat.php] = "Информация о процессах";
$l[Intro][indexserverstat.php] = "Статус сервера";
$l[Intro][indexsystemlog.php] = "Системный лог";

$l[Intro][repall.php] = "Список пользователей";
$l[Intro][rephsall.php] = "Список точек доступа";
$l[Intro][repmain.php] = "Отчеты";
$l[Intro][reptopusers.php] = "Рейтинг пользователей";
$l[Intro][repusername.php] = "Список пользователей";

$l[Intro][mngbatch.php] = "Create batch users";
$l[Intro][mngdel.php] = "Remove User";
$l[Intro][mngedit.php] = "Edit User Details";
$l[Intro][mnglistall.php] = "Users Listing";
$l[Intro][mngmain.php] = "Users and Hotspots Management";
$l[Intro][mngnew.php] = "New User";
$l[Intro][mngnew.php] = "New User";
$l[Intro][mngnewquick.php] = "Quick User Add";

$l[Intro][mnghsdel.php] = "Remove Hotspots";
$l[Intro][mnghsedit.php] = "Edit Hotspots Details";
$l[Intro][mnghslist.php] = "List Hotspots";

$l[Intro][mngradusergroupdel.php] = "Remove User-Group Mapping";
$l[Intro][mngradusergroup.php] = "User-Group Configuration";
$l[Intro][mngradusergroupnew.php] = "New User-Group Mapping";
$l[Intro][mngradusergrouplist] = "User-Group Mapping in Database";
$l[Intro][mngradusergrouplistuser] = "User-Group Mapping in Database";
$l[Intro][mngradusergroupedit] = "Edit User-Group Mapping for User:";

$l[Intro][mngradnas.php] = "NAS Configuration";
$l[Intro][mngradnasnew.php] = "New NAS Record";
$l[Intro][mngradnaslist.php] = "NAS Listing in Database";
$l[Intro][mngradnasedit.php] = "Edit NAS Record";
$l[Intro][mngradnasdel.php] = "Remove NAS Record";

$l[Intro][mngradgroupreply.php] = "Group Reply Configuration";
$l[Intro][mngradgroupreplynew.php] = "New Group Reply Mapping";
$l[Intro][mngradgroupreplylist.php] = "Group Reply Mapping in Database";
$l[Intro][mngradgroupreplyedit.php] = "Edit Group Reply Mapping for Group:";
$l[Intro][mngradgroupreplydel.php] = "Remove Group Reply Mapping";

$l[Intro][mngradgroupcheck.php] = "Group Check Configuration";
$l[Intro][mngradgroupchecknew.php] = "New Group Check Mapping";
$l[Intro][mngradgroupchecklist.php] = "Group Check Mapping in Database";
$l[Intro][mngradgroupcheckedit.php] = "Edit Group Check Mapping for Group:";
$l[Intro][mngradgroupcheckdel.php] = "Remove Group Check Mapping";

$l[Intro][configdb.php] = "Database Configuration";
$l[Intro][configlang.php] = "Language Configuration";
$l[Intro][configlogging.php] = "Logging Configuration";
$l[Intro][configinterface.php] = "Web Interface Configuration";

$l[FormField][all][Groupname] = "Groupname";
$l[FormField][all][Username] = "Username";
$l[FormField][all][Password] = "Password";
$l[FormField][all][Attribute] = "Attribute";
$l[FormField][all][Operator] = "Operator";
$l[FormField][all][Value] = "Value";
$l[FormField][all][NewValue] = "New Value";

$l[FormField][all][Priority] = "Priority";
$l[FormField][all][Expiration] = "Expiration";
$l[FormField][all][MaxAllSession] = "Max-All-Session";
$l[FormField][all][SessionTimeout] = "Session Timeout";
$l[FormField][all][IdleTimeout] = "Idle Timeout";
$l[FormField][all][CallingStationId] = "Calling-Station-Id";
$l[FormField][all][CalledStationId] = "Called-Station-Id";
$l[FormField][all][WISPrRedirectionURL] = "WISPr-Redirection-URL";
$l[FormField][all][WISPrBandwidthMaxUp] = "WISPr-Bandwidth-Max-Up";
$l[FormField][all][WISPrBandwidthMaxDown] = "WISPr-Bandwidth-Max-Down";
$l[FormField][all][WISPrSessionTerminateTime] = "WISPr-Session-Terminate-Time";


$l[FormField][mngbatch.php][UsernamePrefix] = "Username Prefix";
$l[FormField][mngbatch.php][NumberInstances] = "Number of instances to create";
$l[FormField][mngbatch.php][UsernameLength] = "Length of username string";
$l[FormField][mngbatch.php][PasswordLength] = "Length of password string";
$l[FormField][mngnewquick.php][MaxAllSession] = "Time Credit (Max-All-Session) ";

$l[FormField][mnghsdel.php][HotspotName] = "Hotspot name";
$l[FormField][mnghsedit.php][MACAddress] = "MAC Address";
$l[FormField][mnghsedit.php][Geocode] = "Geocode";

$l[FormField][mngradusergroupedit.php][CurrentGroupname] = "Current Groupname";
$l[FormField][mngradusergroupedit.php][NewGroupname] = "New Groupname";

$l[FormField][mngradnasnew.php][NasIPHost] = "NAS IP/Hostname";
$l[FormField][mngradnasnew.php][NasSecret] = "NAS Secret";
$l[FormField][mngradnasnew.php][NasShortname] = "NAS Shortname";
$l[FormField][mngradnasnew.php][NasType] = "NAS Type";
$l[FormField][mngradnasnew.php][NasPorts] = "NAS Ports";
$l[FormField][mngradnasnew.php][NasCommunity] = "NAS Community";
$l[FormField][mngradnasnew.php][NasDescription] = "NAS Description";

$l[FormField][configdb.php][DatabaseHostname] = "Database Hostname";
$l[FormField][configdb.php][DatabaseUser] = "Database User";
$l[FormField][configdb.php][DatabasePass] = "Database Pass";
$l[FormField][configdb.php][DatabaseName] = "Database Name";

$l[FormField][configlang.php][PrimaryLanguage] = "Primary Language";

$l[FormField][configlogging.php][PagesLogging] = "Logging of Pages (page visits)";
$l[FormField][configlogging.php][QueriesLogging] = "Logging of Queries (reports and graphs)";
$l[FormField][configlogging.php][ActionsLogging] = "Logging of Actions (form submits)";
$l[FormField][configlogging.php][FilenameLogging] = "Logging filename (full path)";

$l[FormField][configinterface.php][PasswordHidden] = "Enable Password Hiding (asterisk will be shown)";

$l[FormField][mngradgroupreplydel.php][ToolTip][Value] = "If you specify value then only the single record that matches both the groupname and the specific value which you have specified will be removed. If you omit the value then all records for that particular groupname will be removed!";
$l[FormField][mngradnasnew.php][ToolTip][NasShortname] = "(descriptive name)";
$l[FormField][mngradusergroupdel.php][ToolTip][Groupname] = "If you specify group then only the single record that matches both the username and the group which you have specified will be removed. If you omit the group then all records for that particular user will be removed!";

$l[FormField][mngradgroupcheck.php][ToolTip][Value] = "If you specify value then only the single record that matches both the groupname and the specific value which you have specified will be removed. If you omit the value then all records for that particular groupname will be removed!";

$l[captions][configdb][db] = "Settings that daloRADIUS will make use of to connect to your
				MySQL database server and manage it.";
$l[captions][configdb][tables] = "The radius database tables settings";

$l[captions][configlang] = "Below you can choose between different support languages for daloRADIUS translation.";
$l[captions][configlogging] = "Settings for daloRADIUS logging<br/>Please make sure that the filename that you specify
has write permissions by the webserver";
$l[captions][configinterface] = "Settings for Web Interface behaviour";

$l[captions][mngbatch] = "You may fill below details for new user addition to database.<br/>
							Note that these settings will apply for all the users that you are creating.<br/>";
$l[captions][mngdel] = "To remove a user from the database you must provide the username or the account id.<br/>";
$l[captions][mngedit] = "Edit the user details below.<br/>";
$l[captions][mnglistall] = "Listing users in database.<br/>";
$l[captions][mngnew] = "You may fill below details for new user addition to database<br/>";
$l[captions][mnghsdel] = "To remove a hotspot from the database you must provide the hotspot's name<br/>";
$l[captions][mnghsedit] = "You may edit below details for hotspot<br/>";
$l[captions][mnghsnew] = "You may fill below details for new hotspot addition to database";
$l[captions][mngnewquick] = "The following user/card is of type prepaid.<br/>
The amount of time specified in Time Credit will be used as the Session-Timeout and Max-All-Session
radius attributes";

$l[captions][mngradusergroupdel] = "To remove a user entry from the database you must provide the username of the account";

$l[captions][mngradnasdel] = "To remove a nas ip/host entry from the database you must provide the ip/host of the account";

$l[captions][mngradgroupreplydel] = "To remove a group entry from the database you must provide the groupname of the account";
$l[captions][mngradgroupcheckdel] = "To remove a group entry from the database you must provide the groupname of the account";


$l[captions][acctrecsforhotspot] = "Accounting records for hotspot";
$l[captions][providebillratetodel] = "Provide the rate entry type which you would like to remove";
$l[captions][detailsofnewrate] = "You may fill below details for the new rate";
$l[captions][filldetailsofnewrate] = "Fill below the details for the new rate entry";

$l[captions][gisinfo] = "GIS Mapping provides visual mappings of the hotspot location across the world's map using Google Maps API. <br/>
In the Management page you are able to add new hotspot entries to the database where there is also a field
called Geolocation, this is the numeric value that the Google Maps API uses in order to pin-point the exact 
location of that hotspot on the map.<br/><br/>

2 Modes of Operation are provided: One is the View MAP mode which enables 'surfing' through the world map 
and view the current locations of the hotspots in the database and another one - Edit MAP - which is the mode
that one can use in order to create hotspot's visually by simply left-clicking on the map or removing 
existing hotspot entries by left-clicking on existing hotspot flags.<br/><br/>

Another important issue is that each computer on the network requires a unique Registration code which you 
can obtain from Google Maps API page by providing the complete web address to the hosted directory of
daloRADIUS application on your server. Once you have obtained that code from Google, simply paste it in the
Registration box and click the 'Register code' button to write it.<br/>
Then you may be able to use Google Maps services. <br/><br/>";

$l[captions][loginpage] = "Login Page:";
$l[captions][loginrequired] = "Login Required";
$l[captions][loginplease] = "Log-in please";

$l[captions][listingusersindb] = "Listing users in database";
$l[captions][listhotspotsindb] = "Listing hotspots in database";
$l[captions][recordsfortopusers] = "Records for Top User in category of:";
$l[captions][recordsforuser] = "Records found for user:";
$l[captions][radcheckrecords] = "RADIUS radcheck Records";
$l[captions][radreplyrecords] = "RADIUS radreply Records";

$l[captions][totallogins] = "Total Logins/Hits";
$l[captions][dailyloginsdistrib] = "alltime record of logins based on daily distribution";

$l[messages][missingratetype] = "error: missing rate type to delete";
$l[messages][missingtype] = "error: missing type";
$l[messages][missingcardbank] = "error: missing cardbank";
$l[messages][missingrate] = "error: missing rate";
$l[messages][success] = "success";
$l[messages][gisedit1] = "Welcome, you are currently in Edit mode";
$l[messages][gisedit2] = "Remove current marker from map and database?";
$l[messages][gisedit3] = "Please enter name of HotSpot";
$l[messages][gisedit4] = "Add current marker to database?";
$l[messages][gisedit5] = "Please enter name of HotSpot";
$l[messages][gisedit6] = "Please enter the MAC Address of the Hotspot";

$l[messages][gismain1] = "Successfully updated GoogleMaps API Registration code";
$l[messages][gismain2] = "error: could not open the file for writing:";
$l[messages][gismain3] = "Check file permissions. The file should be writable by the webserver's user/group";
$l[messages][gisviewwelcome] = "Welcome to Enginx Visual Maps";

$l[messages][loginerror] = "<br/><br/>either of the following:<br/>
1. bad username/password<br/>
2. an administrator is already logged-in (only one instance is allowed) <br/>
3. there appears to be more than one 'administrator' user in the database <br/>
";

$l[buttons][savesettings] = "Save Settings";
$l[buttons][apply] = "Apply";

$l[menu][Home] = "<em>H</em>ome</a>";
$l[menu][Managment] = "<em>M</em>anagment</a>";
$l[menu][Reports] = "<em>R</em>eports</a>";
$l[menu][Accounting] = "<em>A</em>ccounting</a>";
$l[menu][Billing] = "<em>B</em>illing</a>";
$l[menu][Gis] = "<em>GIS</em></a>";
$l[menu][Graphs] = "<em>G</em>raphs</a>";
$l[menu][Config] = "<em>C</em>onfig</a>";
$l[menu][Help] = "<em>H</em>elp</a>";
?>