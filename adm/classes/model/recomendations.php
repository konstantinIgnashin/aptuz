<?php defined('SYSPATH') or die('No direct script access.');

class Model_Recomendations extends Kohana_Model {	
	
	public static function getLastWeeks($weekCount,$cur){
		   return DB::query(Database::SELECT, "SELECT * FROM room_w1 where currency='".$cur."' ORDER BY date DESC Limit 0,".$weekCount."")->execute()->as_array();	  	      
	}
	public static function getNumQuotes($cur,$date){
		   return DB::query(Database::SELECT, "SELECT id FROM room_w1 where date='".$date."' and currency='".$cur."' ")->execute()->count();	  	      
	}
	
	public static function weekUpdater($cur,$spread){
		$prev = true;
		$i = 0;
		while($prev){
			if($i==10){
				break;
			}
			$spread = 0.0002;
			if(substr_count($cur,'JPY')>0){
				$spread = 0.02;
			}
			$last = DB::query(Database::SELECT, "SELECT * FROM room_w1 where currency='".$cur."' ORDER BY date DESC Limit ".$i.",1")->execute()->as_array();
			$prev = DB::query(Database::SELECT, "SELECT * FROM room_w1 where currency='".$cur."' ORDER BY date DESC Limit ".($i+1).",1")->execute()->as_array();
			if($prev){
				$color = 'gray';
				if(($last[0]['open']-$prev[0]['close'])>($spread*5) ){  //SELL         
					$color = 'red';
				}
				if(($last[0]['open']-$prev[0]['close'])<($spread*(-1)*5) ){   //BUY      
					$color = 'green';        
				}
				DB::query(Database::UPDATE, "UPDATE room_w1 SET direct='".$color."' WHERE id='".$last[0]['id']."' ")->execute();
			}
			$i++;
		}	
	}
}
