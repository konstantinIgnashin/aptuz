<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Recomendations extends Controller {

	public function action_index(){
		$spread['EURUSD'] = 0.0002;
		$spread['GBPUSD'] = 0.0003;
		$spread['AUDUSD'] = 0.0003;
		$spread['USDJPY'] = 0.02;
		$spread['USDCAD'] = 0.0003;
		$spread['USDCHF'] = 0.0003;
		
		
		$this->response->body(json_encode(array('success'=>'')));
	}
	
	public function action_do_view()
	{
		$this->response->body('my view hello');
	}

} // End ImportQuotes
