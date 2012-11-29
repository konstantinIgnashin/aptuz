<?php defined('SYSPATH') or die('No direct script access.');

class Model_Iboprovider extends Kohana_Model {	
	public $t = 'trader_signals';
	public static function insertSignal($g){
		   $s = self::checkSignal($g['symbol'], $g['tstamp'], $g['period']);
		   if($s){
		   	$update='';
			if($s[0]['direct']==0){
				if($g['ask']>$g['high']){ //run bull trend
					$update = ", direct='1' ";
				}
				if($g['ask']<$g['low']){ //run sell trend
					$update = ", direct='2' ";
				}
			}
			if($s[0]['direct']==1){
				if($g['ask']<$g['low']){ //end bull trend
					$update = ", direct='3' ";
				}
			}
			if($s[0]['direct']==2){
				if($g['ask']>$g['high']){ //end sell trend
					$update = ", direct='4' ";
				}
			}
			DB::query(Database::UPDATE, 
			"UPDATE trader_signals SET ask='".$g['ask']."' ".$update." WHERE id='".$s[0]['id']."'  ORDER BY id DESC Limit 1")->execute();		   
		   }
		   else{
		   DB::query(Database::INSERT, 
		   "INSERT INTO trader_signals (tstamp,symbol,period,direct,buy,sell,status,ask) 
		   VALUES ('".$g['tstamp']."','".$g['symbol']."','".$g['period']."','0','".$g['high']."','".$g['low']."','0','".$g['ask']."')")->execute();
		   }	   	  	      
	}
	public static function checkSignal($symbol,$tstamp,$p){
		return DB::query(Database::SELECT, 
			"SELECT * FROM trader_signals WHERE symbol='".$symbol."' and period='".$p."' and tstamp ='".$tstamp."' ORDER BY id DESC Limit 0,1")->execute()->as_array();	 
		
	}
	
}
