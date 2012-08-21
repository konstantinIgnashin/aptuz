<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Importquotes extends Controller {

	public function action_index()	{

		$model = new Model_Importquotes();
		if($model->getNumQuotes($_GET['currency'],$_GET['date'])==0){ 			
			DB::query(Database::INSERT, "
		  	INSERT INTO room_w1(currency,high,low,open,close,volume,year,date,week) VALUES ('".$_GET['currency']."','".$_GET['high']."','".$_GET['low']."','".$_GET['open']."','".$_GET['close']."', '".$_GET['volume']."','".$_GET['year']."','".$_GET['date']."','".$_GET['week']."')")->execute();	  	 
		}
		else{			
			$query = "UPDATE room_w1 SET high='".$_GET['high']."', low='".$_GET['low']."', open='".$_GET['open']."', close='".$_GET['close']."', volume='".$_GET['volume']."' WHERE  date='".$_GET['date']."' and currency='".$_GET['currency']."' ";	
			DB::query(Database::UPDATE, $query)->execute();
		}


		$this->response->body('hello, world!');
	}
	
	public function action_do_view()
	{
		$this->response->body('my view hello');
	}

} // End ImportQuotes
