<?php
require_once("../../../wp-load.php");
  global $wpdb;
  
  
	$row_count = $wpdb->get_var("SELECT COUNT(*) FROM utility_form_data WHERE user_id = ".$_POST['lguser_id']);

if($row_count == 0){
	$wpdb->query("INSERT INTO utility_form_data (user_id, cep, accno, action, cgp, accno1, action1, gsstartdate, gsenddate, water, action2, fourdigit) VALUES ('".$_POST['lguser_id']."','".$_POST['cep']."','".$_POST['accno']."','".$_POST['action']."','".$_POST['cgp']."','".$_POST['accno1']."','".$_POST['action1']."','".$_POST['gsstartdate']."','".$_POST['gsenddate']."','".$_POST['water']."','".$_POST['action2']."','".$_POST['fourdigit']."')");
}
else {

	$wpdb->query("UPDATE utility_form_data SET cep='".$_POST['cep']."',accno='".$_POST['accno']."',action='".$_POST['action']."',cgp='".$_POST['cgp']."',accno1='".$_POST['accno1']."',action1='".$_POST['action1']."',gsstartdate='".$_POST['gsstartdate']."',gsenddate='".$_POST['gsenddate']."',water='".$_POST['water']."',action2='".$_POST['action2']."',fourdigit='".$_POST['fourdigit']."' WHERE user_id=".$_POST['lguser_id']);
}	
			   
   ?>
   