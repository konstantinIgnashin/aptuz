<?php defined('SYSPATH') or die('No direct script access.');

class Model_Wiki extends Kohana_Model {	
	
	public static function getClasses(){
		   return DB::query(Database::SELECT, "SELECT * FROM wiki_classes ORDER BY title ASC")->execute()->as_array();	  	      
	}
	public static function getPropetries($pid){
		   return DB::query(Database::SELECT, "SELECT * FROM wiki_classes_elements where pid='".$pid."' ORDER BY title ASC")->execute()->as_array();	  	      
	}
}
