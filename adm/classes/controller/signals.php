<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Signals extends Controller {
	public $GET = array();
	public function action_index(){
			$this->setVars();
			$m = new Model_Signals();				
			$this->ajaxResponse('log',$m->getSignals($this->GET['page']*20));
			$logPaging = array('onPage'=>20,'ns'=>$m->getSignalsNs(),'activePage'=>$this->GET['page']);
			$this->ajaxResponse('logPaging',$logPaging);
			$this->ajaxOutput();
		
	}
	private function setVars(){		
		(isset($_GET['page'])) ? $this->GET['page']=intval($_GET['page']) : $this->GET['page'] = 0;
	}
	function ajaxResponse($key,$data){
		$this->ajaxSuccess['success'][$key] = $data;		
	}
	
	function ajaxOutput(){
		$this->response->body(json_encode($this->ajaxSuccess));		
	}

} // End Welcome
