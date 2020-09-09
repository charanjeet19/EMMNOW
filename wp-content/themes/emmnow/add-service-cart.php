<?php

require_once("../../../wp-load.php");
global $woocommerce; 
    $woocommerce->cart->empty_cart();
    $product_id= intval($_POST['serviceId']);
    $woocommerce->cart->add_to_cart($product_id,1); 
    return true; 
?>
