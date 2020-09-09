<?php 
global $woocommerce;
$woocommerce->cart->empty_cart();
$product_id	= intval( $_POST['service']); 
$woocommerce->cart->add_to_cart($product_id,1);
  
 ?>  



