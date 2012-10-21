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
}
