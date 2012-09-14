<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Alllists extends Controller {
	public $ajaxSuccess = array();
	public $GET = array();
	public function action_index(){
			$this->ajaxResponse('tpl','1');
			$this->ajaxOutput();
	}
	
	public function action_room(){
			$this->setVars();
			$m = new Model_Alllists();	
			$this->ajaxResponse('log',$m->getRoomUsers($this->GET['page']*20));
			$logPaging = array('onPage'=>20,'ns'=>$m->getRoomUsersNs(),'activePage'=>$this->GET['page']);
			$this->ajaxResponse('logPaging',$logPaging);
			$this->ajaxOutput();
	}
	
	function ajaxResponse($key,$data){
		$this->ajaxSuccess['success'][$key] = $data;		
	}
	
	function ajaxOutput(){
		$this->response->body(json_encode($this->ajaxSuccess));		
	}
	private function setVars(){		
		(isset($_GET['page'])) ? $this->GET['page']=intval($_GET['page']) : $this->GET['page'] = 0;
	}	
	
	
	public function action_do_view()
	{
		$this->response->body('my view hello');
	}
	

	


} // End ImportQuotes
