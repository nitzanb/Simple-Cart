<?php
/*
 *      cart.php
 *      
 *      Copyright 2011 Nitzan Brumer <nitzan@n2b.org>
 *      
 * 
 */

//These settings really should be moved to option screen
define('VAT',0.16); 
define('CURENCY','$'); 
 


class Cart{
	
	//Total cart cost
	var $sum; 
	//Order Lines - Counts the lines in the cart
	var $lines; 
	//Item count - Counts single items in the cart
	var $items; 
	//The cart lines themselves
	var $item_array;
	//The vat calculation
	var $vat;
	
	
	function __construct() 
	{		
		$this->sum = 0;
		$this->vat = 0;
		$this->lines = 0;
		$this->items = 0;
		$this->item_array = array();		
	}
	
	
	/*	The function gets an item id (which is a post id) and 
	 * 	the amounts of items and adds it to the cart
	 */ 
	function add_item($item_id, $count)
	{		
		if (isset($this->item_array["$item_id"])):
			$this->update_item($item_id, $count);
		else:
			$this->item_array["$item_id"] = $count;
			$this->lines++;
			$this->items += $count;		
		endif;
		$this->calculate_cart_sum();
	}
	
	
	function remove_item($item_id)
	{
		$this->items -= $this->item_array[$item_id];
		unset($this->item_array["$item_id"]);
		$this->lines--;		
		$this->calculate_cart_sum();
	}
	
	function update_item($item_id, $diff)
	{
		if( $this->item_array[$item_id] + $diff == 0):
			$this->remove_item($item_id);
		elseif($this->item_array[$item_id] + $diff < 0):
			throw new Exception('You can not Substract more than you have');
		else:		
			$this->item_array["$item_id"] += $diff;
			$this->items += $diff;		
		endif;
		$this->calculate_cart_sum();
	}
	
	function calculate_cart_sum()
	{
		$this->sum = 0;
		foreach($this->item_array as $item_id=>$item_count):
			$it = new Item($item_id);
			$this->sum += ($it->price) * $item_count;
		
		endforeach;
		$this->calculate_vat();	
	}
	
	function calculate_vat()
	{
			$this->vat = ($this->sum) * VAT;
	}
	
	public function __toString()
	{
		$str = '<div id="cart_sum"><ul id="item_list">';	
		foreach($this->item_array as $id=>$amount):
			$i = new Item($id);
			$str .=	"<li class='line'><ul class='line_items'><li> $id</li><li>".$i->title."</li><li>$amount</li><li>".$amount * $i->price."</li></ul></li>\r\n";		
		endforeach;
		$str.="</ul><ul id='cart_totals'>";	
		$str .= "<li class='cart_sum'>Sum: ".$this->sum. CURENCY ."</li>";
		$str .= "<li class='cart_vat'>Vat: ".$this->vat.CURENCY."</li>";
		$str .= "<li class='cart_total'><span class='caption'>Total:</span>".($this->vat + $this->sum).CURENCY."</li>";
		$str.="</ul>";
		return $str;	
	}
}
/*
$c = new Cart();
print_r($c);
$c->add_item(32,2);
$c->add_item(32,2);
print_r($c);
$c->update_item(32,5);
print_r($c);

echo (string)$c;
*/
