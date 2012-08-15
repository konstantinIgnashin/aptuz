<?php defined('SYSPATH') or die('No direct script access.');

class Model_Importquotes extends Kohana_Model {	
	
	public static function getClasses(){
		   return DB::query(Database::SELECT, "SELECT * FROM wiki_classes ORDER BY title ASC")->execute()->as_array();	  	      
	}
	public static function getNumQuotes($cur,$date){
		   return DB::query(Database::SELECT, "SELECT id FROM room_w1 where date='".$date."' and currency='".$cur."' ")->execute()->count();	  	      
	}
}
