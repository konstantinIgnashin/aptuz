<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Recomendations extends Controller {

	public function action_index(){
		$spread['EURUSD'] = 0.0002;
		$spread['GBPUSD'] = 0.0003;
		$spread['AUDUSD'] = 0.0003;
		$spread['USDJPY'] = 0.02;
		$spread['USDCAD'] = 0.0003;
		$spread['USDCHF'] = 0.0003;
		$spread['NZDUSD'] = 0.0012;
		
		$spread['AUDCAD'] = 0.0011;
		$spread['AUDJPY'] = 0.05;
		$spread['AUDNZD'] = 0.0035;
		$spread['CADJPY'] = 0.08;
		$spread['CHFJPY'] = 0.08;
		
		$spread['EURAUD'] = 0.0011;	
		$spread['EURCAD'] = 0.0013;	
		$spread['EURCHF'] = 0.0003;	
		$spread['EURGBP'] = 0.0006;		
		$spread['EURJPY'] = 0.05;
			
		$spread['GBPCHF'] = 0.0017;	
		$spread['GBPJPY'] = 0.10;	
		$spread['NZDJPY'] = 0.12;
		$model = new Model_Recomendations();
		$this->calcupdater($spread);
		foreach($spread as $currency=>$v){
			$weeks[$currency] = $model->getLastWeeks(5,$currency);			
			//$color[$currency] = $this->calcDirect($weeks[$currency], $spread[$currency]);
		}
		
		$this->response->body(json_encode(array('success'=>array('currencies'=>$weeks,'spread'=>$spread) )));
	}
	
	public function action_do_view()
	{
		$this->response->body('my view hello');
	}
	
	/*return color*/
	function calcDirect($weeks, $spread){
			  $i=0;
			  foreach($weeks as $k=>$v){			
				$newWeeks[$i]=$v;
				$i++;
			  }
			
			foreach($newWeeks as $k=>$v){	
				$color[$k] = 'gray';
				if(!isset($newWeeks[$k+1]['open'])){
					break;
				}				
				if(($newWeeks[$k]['open']-$newWeeks[$k+1]['close'])>(0.0001*2*5) ){  //SELL         
					$color[$k] = 'red';
				}
				if(($newWeeks[$k]['open']-$newWeeks[$k+1]['close'])<(0.0001*(-2)*5) ){   //BUY      
					$color[$k] = 'green';        
				}				
			}      	  
			return $color;
	}
	
	function calcupdater($spread){
		$model = new Model_Recomendations();
		foreach($spread as $k=>$v){
			$model->weekUpdater($k,$v);
		}	
	}

} // End ImportQuotes
