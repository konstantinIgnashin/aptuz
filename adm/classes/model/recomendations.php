<?php defined('SYSPATH') or die('No direct script access.');

class Model_Recomendations extends Kohana_Model {	
	
	public static function getLastWeeks($weekCount,$cur){
		   return DB::query(Database::SELECT, "SELECT * FROM room_w1 where currency='".$cur."' ORDER BY date DESC Limit 0,".$weekCount."")->execute()->as_array();	  	      
	}
	public static function getNumQuotes($cur,$date){
		   return DB::query(Database::SELECT, "SELECT id FROM room_w1 where date='".$date."' and currency='".$cur."' ")->execute()->count();	  	      
	}
}
