<?php
/*
Plugin Name: simple_cart
Plugin Script: simple_cart.php
Plugin URI: http://.../simple_cart (where should people go for this plugin?)
Description: (...)
Version: 0.1
License: GPL
Author: Nitzan Brumer
Author URI: http://twodiv.com 

=== RELEASE NOTES ===
2011-03-28 - v1.0 - first version
*/

// uncomment next line if you need functions in external PHP script;
include_once(dirname(__FILE__).'/cart.php');
include_once(dirname(__FILE__).'/item.php');


// ------------------
// simple_cart parameters will be saved in the database
function simple_cart_add_options() {
// simple_cart_add_options: add options to DB for this plugin
add_option('simple_cart_nb_widgets', '75');
// add_option('simple_cart_...','...');
}
simple_cart_add_options();

// ------------------
// simple_cart_showhtml will generate the (HTML) output
function simple_cart_showhtml($param1 = 0, $param2 = "test") {
global $wpdb;
// get your parameter values from the database
$simple_cart_nb_widgets = get_option('simple_cart_nb_widgets');
// generate $simple_cart_html based on ...
// (your code)
// content will be added when function 'simple_cart_showhtml()' is called
return $simple_cart_html;
}


?>
