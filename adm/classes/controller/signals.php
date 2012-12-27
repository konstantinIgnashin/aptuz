<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Signals extends Controller {
	public $rowsPerPage = 23;
	public $pairs = array('EURUSD','GBPUSD','AUDUSD','USDJPY','USDCAD','USDCHF','NZDUSD','AUDCAD','AUDJPY','AUDNZD','CADJPY','CHFJPY','EURAUD','EURCAD','EURCHF','EURGBP','EURJPY','GBPCHF','GBPJPY','NZDJPY');
	public $periods = array('D1'=>1440,'H4'=>240,'H1'=>60,'M30'=>30/*,15,5,1*/);
	public $GET = array();
	public function action_index(){
			$this->setVars();
			$m = new Model_Signals();				
			$this->ajaxResponse('log',$m->getSignals($this->GET['page']*$this->rowsPerPage, $this->rowsPerPage, $this->GET['pair'], $this->GET['period'] ));
			$logPaging = array('onPage'=>$this->rowsPerPage,'ns'=>$m->getSignalsNs(),'activePage'=>$this->GET['page']);
			$this->ajaxResponse('logPaging',$logPaging);
			$this->ajaxResponse('activeTrends',$this->getActiveTrends($m));
			$this->ajaxResponse('pairs',$this->pairs);
			$this->ajaxResponse('periods',$this->periods);
			$this->ajaxResponse('pair',$this->GET['pair']);
			$this->ajaxResponse('period',$this->GET['period']);
			$this->ajaxOutput();
		
	}
	private function setVars(){
		(isset($_GET['page'])) ? $this->GET['page']=intval($_GET['page']) : $this->GET['page'] = 0;
		(isset($_GET['pair'])) ? $this->GET['pair']=$_GET['pair'] : $this->GET['pair'] = 0;
		(isset($_GET['period'])) ? $this->GET['period']=$_GET['period'] : $this->GET['period'] = 0;
	}
	
	function getActiveTrends($m){
		$data = array();
		$pairs = $this->pairs;
		$periods = $this->periods;
		foreach($pairs as $pair){
			foreach($periods as $k=> $period){
				$result = $m->getLastTrend($pair,$period);
				if(!$result){
					$result[0] = $period;
				}
				$data[$pair][$period] = @$result[0];
			}			
		}
		
		return $data;
	}
	
	public function action_iframe(){
		$view = View::factory('admin/iframe');			
		$this->response->body($view->render());	
	}
	
	public function action_in(){
		$symbol = $_GET['symbol'];
		$period = $_GET['period'];
		$tstamp = $_GET['tstamp'];
		$pub_date = $this->getDate($_GET['tstamp']);
		$o = $_GET['o'];
		$h = $_GET['h'];
		$l = $_GET['l'];
		$c = $_GET['c'];
		$volume = $_GET['volume'];
		$m = new Model_Signals();		
		if(!$id = $m->quoteExists($symbol, $period, $tstamp)){
			$m->qouteInsert($symbol, $period, $tstamp, $pub_date, $o, $h, $l, $c, $volume);
		}
		else{
			$m->qouteUpdate($id,$period, $o, $h, $l, $c, $volume);
		}		
	}
	
	public function getDate($tstamp){
		return date('Y-m-d H:i:s',$tstamp);
	}
	
	
	
	
	
	
	
	
	
	
	function ajaxResponse($key,$data){
		$this->ajaxSuccess['success'][$key] = $data;		
	}
	
	function ajaxOutput(){
		$this->response->body(json_encode($this->ajaxSuccess));		
	}

} // End Welcome
