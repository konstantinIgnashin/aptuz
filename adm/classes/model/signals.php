<?php defined('SYSPATH') or die('No direct script access.');

class Model_Signals extends Kohana_Model {	
	public static $t = 'trader_signals';		
	public $q = '';
	public function getSignals($offset,$rowsPerPage, $pair,$period){
		
		if($pair!='0'){
			$this->q.=" and symbol='".$pair."'";
		}	
		if($period!='0'){
			$this->q.=" and period='".$period."'";
		}		
		return  DB::query(Database::SELECT, "SELECT * FROM trader_signals WHERE 1=1 ".$this->q." ORDER BY tstamp DESC Limit  ".$offset.', '.$rowsPerPage)->execute()->as_array();	
	}
	
	public function getSignalsNS(){		   
		   return DB::query(Database::SELECT, "SELECT id FROM trader_signals WHERE 1=1 ".$this->q."")->execute()->count();		   
	}
	
	public function getLastTrend($pair,$period){
		return  DB::query(Database::SELECT, "SELECT * FROM trader_signals WHERE symbol='".$pair."' and period='".$period."' ORDER BY id DESC Limit  0,1")->execute()->as_array();		
	}
	
	// signals in
	public function quoteExists($symbol, $period, $tstamp) {
		$data = DB::query(Database::SELECT, "SELECT id,symbol FROM trader_quotes_".$period." WHERE tstamp='".$tstamp."' ORDER BY id DESC")->execute()->as_array();
		foreach($data as $k=>$v){
			if($v['symbol']==$symbol)	return $v['id'];			
		}		
		return false;
	}
	
	public function qouteInsert($symbol, $period, $tstamp, $pub_date, $o, $h, $l, $c, $volume){
		DB::query(Database::INSERT, "INSERT INTO trader_quotes_".$period." (symbol,tstamp,pub_date,o,h,l,c,volume) 
		VALUES ('".$symbol."','".$tstamp."','".$pub_date."','".$o."','".$h."','".$l."','".$c."','".$volume."')")->execute();		
	}
	
	public function qouteUpdate($id, $period, $o, $h, $l, $c, $volume){
		DB::query(Database::UPDATE, "UPDATE trader_quotes_".$period." 
		SET o='".$o."',	h='".$h."',	l='".$l."',	c='".$c."',	volume='".$volume."'	WHERE id='".$id."' LIMIT 1")->execute();		
	}
}
