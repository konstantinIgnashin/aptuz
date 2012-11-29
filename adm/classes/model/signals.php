<?php defined('SYSPATH') or die('No direct script access.');

class Model_Signals extends Kohana_Model {	
	public static $t = 'trader_signals';		
	
	public static function getSignals($offset){
		return  DB::query(Database::SELECT, "SELECT * FROM trader_signals ORDER BY id DESC Limit  ".$offset.', 20')->execute()->as_array();	
	}
	
	public function getSignalsNS(){
		   return DB::query(Database::SELECT, "SELECT id FROM trader_signals")->execute()->count();		   
	}
}
