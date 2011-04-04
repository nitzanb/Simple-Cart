<?php
/*
 *      cart_widget.php
 *      
 *      Copyright 2011 Nitzan Brumer <nitzan@n2b.org>
 *      
 */

class My_Cart_Widget extends WP_Widget {
	function My_Cart_Widget() {
		parent::WP_Widget(false, $name = 'CartWidget');	
	}

	function form($instance) {
		// outputs the options form on admin
	}

	function update($new_instance, $old_instance) {
		// processes widget options to be saved
	}

	function widget($args, $instance) {
		extract( $args );
        $title = apply_filters('widget_title', $instance['title']);
        echo $before_widget;
		if ( $title )
			echo $before_title . $title . $after_title; 
                  echo (string) $_SESSION['simple_cart'];	
			echo $after_widget;
        
	}

}
add_action('widgets_init', create_function('', 'return register_widget("My_Cart_Widget");'));

