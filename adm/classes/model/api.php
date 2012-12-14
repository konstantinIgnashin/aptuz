<?php defined('SYSPATH') or die('No direct script access.');

class Model_Api extends Kohana_Model {	
	public static $t = 'trader_banners_statistic';	
	public static function updateAction($action,$ip){
		   return DB::query(Database::UPDATE, "UPDATE ".self::$t." SET status='".$action."' WHERE ip='".$ip."' order by id desc Limit 1")->execute();		        
	}
	public static function insertLoad($ip){
		   return DB::query(Database::INSERT, "INSERT INTO ".self::$t." (tstamp,ip) VALUES ('".time()."','".$ip."')")->execute();	   	  	      
	}
	
	public static function getSubscribers(){
		return  DB::query(Database::SELECT, "SELECT * FROM api_users ORDER BY id DESC Limit 0, 20")->execute()->as_array();		
	}
	
	public static function getLastCandles($symbol, $period, $day, $month, $year){
	if($day<10)$day='0'.$day;
	if($month<10)$month='0'.$month;
	return  DB::query(Database::SELECT, "SELECT * FROM history_eur_usd WHERE public_date LIKE '".$year.'.'.$month.'.'.$day."%' ORDER BY id ASC Limit 0, 24")->execute()->as_array();		
	}
}
