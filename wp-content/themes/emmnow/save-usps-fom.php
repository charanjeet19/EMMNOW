<?php
require_once("../../../wp-load.php");
  global $wpdb;
  
	$row_count = $wpdb->get_var("SELECT COUNT(*) FROM usps_form_data WHERE user_id = ".$_POST['lguser_id']);

if($row_count == 0){
	$wpdb->query("INSERT INTO usps_form_data (user_id, whoIsMoving, firstName, middleName, lastName, Suffix, emailAddress, confirmEmailAddress, phoneNumber, phoneType, moveType, startDate, endDate, oldZipCode, oldCity, oldState, oldStreet, newZipCode, newCity, newState, newStreet) VALUES ('".$_POST['lguser_id']."','".$_POST['whoismoving']."','".$_POST['firstName']."','".$_POST['middleName']."','".$_POST['lastName']."','".$_POST['Suffix']."','".$_POST['emailAddress']."','".$_POST['confirmEmailAddress']."','".$_POST['phoneNumber']."','".$_POST['phoneType']."','".$_POST['moveType']."','".$_POST['startDate']."','".$_POST['endDate']."','".$_POST['oldZipCode']."','".$_POST['oldCity']."','".$_POST['oldState']."','".$_POST['oldStreet']."','".$_POST['newZipCode']."','".$_POST['newCity']."','".$_POST['newState']."','".$_POST['newStreet']."')");
}
else {

	$wpdb->query("UPDATE usps_form_data SET whoIsMoving='".$_POST['whoismoving']."',firstName='".$_POST['firstName']."',middleName='".$_POST['middleName']."',lastName='".$_POST['lastName']."',Suffix='".$_POST['Suffix']."',emailAddress='".$_POST['emailAddress']."',confirmEmailAddress='".$_POST['confirmEmailAddress']."',phoneNumber='".$_POST['phoneNumber']."',phoneType='".$_POST['phoneType']."',moveType='".$_POST['moveType']."',startDate='".$_POST['startDate']."',endDate='".$_POST['endDate']."',oldZipCode='".$_POST['oldZipCode']."',oldCity='".$_POST['oldCity']."',oldState='".$_POST['oldState']."',oldStreet='".$_POST['oldStreet']."',newZipCode='".$_POST['newZipCode']."',newCity='".$_POST['newCity']."',newState='".$_POST['newState']."',newStreet='".$_POST['newStreet']."' WHERE user_id=".$_POST['lguser_id']);
}	
			   
   ?>
