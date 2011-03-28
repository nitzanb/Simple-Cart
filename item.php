<?php
/*
 *      item.php
 *      
 *      Copyright 2011 Nitzan Brumer <nitzan@n2b.org>
 */

class Item{
	
	var $id;
	var $price;
	var $title;
	
	
	function __construct($item_id) 
	{		
		$my_post = get_post($item_id); 		
		$this->id = $item_id;		
		$this->title = $my_post->post_title;		
		$this->price = get_post_meta($item_id, 'item_price', TRUE); ;		
	}
	
	public function __toString()
	{
		$str = '<ul class="item_box">';
		$str .='<li>Item Id: '.$this->id.'</li>';		
		$str .='<li>Item name: '.$this->title.'</li>';
		$str .='<li>Item Price: '.$this->price.'</li>';					
		$str .= '</ul>';
		return $str;
		
	}
	
	
}
