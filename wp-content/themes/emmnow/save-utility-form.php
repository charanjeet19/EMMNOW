<?php
require_once("../../../wp-load.php");
  global $wpdb;
  
  
	$row_count = $wpdb->get_var("SELECT COUNT(*) FROM utility_form_data WHERE user_id = ".$_POST['lguser_id']);

if($row_count == 0){
	$wpdb->query("INSERT INTO utility_form_data (user_id, cep, accno, action, cgp, accno1, action1, gsstartdate, gsenddate, water, action2, fourdigit, utfirstName, utlastName, utemailAddress, utphoneNumber, utturnOffDate, utturnOnDate, utoldZipCode, utoldCity, utoldState, utoldStreet, utnewZipCode, utnewCity, utnewState, utnewStreet) VALUES ('".$_POST['lguser_id']."','".$_POST['cep']."','".$_POST['accno']."','".$_POST['action']."','".$_POST['cgp']."','".$_POST['accno1']."','".$_POST['action1']."','".$_POST['gsstartdate']."','".$_POST['gsenddate']."','".$_POST['water']."','".$_POST['action2']."','".$_POST['fourdigit']."','".$_POST['utfirstName']."','".$_POST['utlastName']."','".$_POST['utemailAddress']."','".$_POST['utphoneNumber']."','".$_POST['utturnOffDate']."','".$_POST['utturnOnDate']."','".$_POST['utoldZipCode']."','".$_POST['utoldCity']."','".$_POST['utoldState']."','".$_POST['utoldStreet']."','".$_POST['utnewZipCode']."','".$_POST['utnewCity']."','".$_POST['utnewState']."','".$_POST['utnewStreet']."')");
}
else {

	$wpdb->query("UPDATE utility_form_data SET cep='".$_POST['cep']."',accno='".$_POST['accno']."',action='".$_POST['action']."',cgp='".$_POST['cgp']."',accno1='".$_POST['accno1']."',action1='".$_POST['action1']."',gsstartdate='".$_POST['gsstartdate']."',gsenddate='".$_POST['gsenddate']."',water='".$_POST['water']."',action2='".$_POST['action2']."',fourdigit='".$_POST['fourdigit']."',utfirstName='".$_POST['utfirstName']."',utlastName='".$_POST['utlastName']."',utemailAddress='".$_POST['utemailAddress']."',utphoneNumber='".$_POST['utphoneNumber']."',utturnOffDate='".$_POST['utturnOffDate']."',utturnOnDate='".$_POST['utturnOnDate']."',utoldZipCode='".$_POST['utoldZipCode']."',utoldCity='".$_POST['utoldCity']."',utoldState='".$_POST['utoldState']."',utoldStreet='".$_POST['utoldStreet']."',utnewZipCode='".$_POST['utnewZipCode']."',utnewCity='".$_POST['utnewCity']."',utnewState='".$_POST['utnewState']."',utnewStreet='".$_POST['utnewStreet']."' WHERE user_id=".$_POST['lguser_id']);
}	
	   
   ?>
   