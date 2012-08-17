<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Recomendations extends Controller {

	public function action_index(){
		$spread['EURUSD'] = 0.0002;
		$spread['GBPUSD'] = 0.0003;
		$spread['AUDUSD'] = 0.0003;
		$spread['USDJPY'] = 0.02;
		$spread['USDCAD'] = 0.0003;
		$spread['USDCHF'] = 0.0003;
		$spread['NZDUSD'] = 0.0003;
		
		$spread['AUDCAD'] = 0.0003;
		$spread['AUDJPY'] = 0.0003;
		$spread['AUDNZD'] = 0.0003;
		$spread['CADJPY'] = 0.0003;
		$spread['CHFJPY'] = 0.0003;
		
		$spread['EURAUD'] = 0.0003;	
		$spread['EURCAD'] = 0.0003;	
		$spread['EURCHF'] = 0.0003;	
		$spread['EURGBP'] = 0.0003;
		
		$spread['EURJPY'] = 0.0003;	
		$spread['GBPCHF'] = 0.0003;	
		$spread['GBPJPY'] = 0.0003;	
		$spread['NZDJPY'] = 0.0003;
		$model = new Model_Recomendations();
		foreach($spread as $currency=>$v){
			$weeks[$currency] = $model->getLastWeeks(5,$currency);			
			$color[$currency] = $this->calcDirect($weeks[$currency], $spread[$currency]);
		}
		
		$this->response->body(json_encode(array('success'=>array('weeks'=>$spread,'spread'=>$spread) )));
	}
	
	public function action_do_view()
	{
		$this->response->body('my view hello');
	}
	
	/*return color*/
	function calcDirect($weeks, $spread){
		  foreach($weeks as $k=>$v){
			   $color = 'gray';
			   if((Open[i]-Close[i+1])>(0.0001*2*5) ){  //SELL         
	       		$color = 'red';
	       }
	       if((Open[i]-Close[i+1])<(0.0001*(-2)*5) ){   //BUY      
						$color = 'green';        
	       }
      }
			return $color;
	}

} // End ImportQuotes
