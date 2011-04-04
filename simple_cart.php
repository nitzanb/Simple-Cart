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

define('DEV', TRUE);
//define('DEV', FALSE);

// uncomment next line if you need functions in external PHP script;
include_once(dirname(__FILE__).'/cart.php');
include_once(dirname(__FILE__).'/item.php');
include_once(dirname(__FILE__).'/cart_widget.php');

simple_cart_load_session();

function simple_cart_load_session() {
	if ( !isset( $_SESSION ) )
		$_SESSION = null;
	if ( ( !is_array( $_SESSION ) ) xor ( !isset( $_SESSION['simple_cart'] ) ) xor ( !$_SESSION ) )
		session_start();
}

function add_items_to_cart($id, $count)
{
	if(empty($_SESSION['simple_cart']) || !isset($_SESSION['simple_cart'])):
		$c = new Cart;	
		$c->add_item($id, $count);
		$_SESSION['simple_cart'] = $c;
	else:	
		$_SESSION['simple_cart']->add_item($id, $count);
	endif;	
	
}

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

 // initialise the cart session, if it exist, unserialize it, otherwise make it
if(isset($_SESSION['simple_cart'])) {
	if(is_object($_SESSION['simple_cart'])) {
		$GLOBALS['simple_cart'] = $_SESSION['simple_cart'];
	} else {
		$GLOBALS['simple_cart'] = unserialize($_SESSION['simple_cart']);
	}
	if(!is_object($GLOBALS['simple_cart']) || (get_class($GLOBALS['simple_cart']) != "wpsc_cart")) {
		$GLOBALS['simple_cart'] = new Cart;
	}
} else {
	$GLOBALS['simple_cart'] = new Cart;
}


/*
 * At the bottom of each post(single) we need to display the add to cart button
 */ 
 
function output_cart_box()
{
	global $post;
	
	if(isset($_POST['qtty']) && !empty($_POST['qtty']) && isset($_POST['add_me'])):
		$qtty = $_POST['qtty'];
		add_items_to_cart($post->ID, $qtty);
	else:
		$qtty = 1;
	endif;
	
	$str ="";
	
	if(DEV):
		$str .=  "<div id='dev_info'>\r\n";
		$str .="Session Id: ".session_id();
	
	
		$str .= "</div>\r\n";
	endif;
	
	
	
		$str.='<form name="add_to_cart" id="form_add_to_cart" method="post">';
		$str.='<label for="qtty">'.__('Qantty:').'</label>';
		$str.='<input type="text" name="qtty" id="qtty" value="'.$qtty.'"/>';
		$str.='<input type="submit" name="add_me" id="add_item_btn" value="'.__('Add to cart').'"/>';
		$str.='</form>';
	
	
	
	return $str;	
}

function simple_cart_box_filter($content) 
{
	global $wpdb;

	$content = $content . output_cart_box() ;
	return $content;
}

add_filter('the_content', 'simple_cart_box_filter');


// add_filter('the_excerpt', 'myplugin_filter');
