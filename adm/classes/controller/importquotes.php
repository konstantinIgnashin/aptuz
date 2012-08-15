<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Importquotes extends Controller {

	public function action_index()
	{
		$model = new Model_Importquotes();
		if($model->getNumQuotes($_GET['currency'],$_GET['date'])==0){ 
		
		DB::query(Database::INSERT, "
		  INSERT INTO room_w1(currency,high,low,open,close,volume,year,date,week) VALUES ('".$_GET['currency']."','".$_GET['high']."','".$_GET['low']."','".$_GET['open']."','".$_GET['close']."', '".$_GET['volume']."','".$_GET['year']."','".$_GET['date']."','".$_GET['week']."')")->execute();	  	 
		}
		$this->response->body('hello, world!');
	}
	
	public function action_do_view()
	{
		$this->response->body('my view hello');
	}

} // End Welcome
