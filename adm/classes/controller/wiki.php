<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Wiki extends Controller {	
	public  $config = array(); 	
	private $session ='';
	private $GET =array();
	
private	function checkSession(){
		$this->config=Kohana::config('config');			
		$this->loadGETData();
		$this->session = new Controller_Session(); 	   
	    if(!$this->session->getUserID()>0){ 				
			header('Location: http://'.$_SERVER['HTTP_HOST'].'/admin/login');
			die();	
        }

	}
private function loadGETData(){

}	
	
public function action_index(){
		$this->checkSession();	 		
		$classes=Model_Wiki::getClasses();		
		$this->response->body(json_encode( array('success'=>array('classes'=>$classes)) ));					
	}
public function action_getpropetries(){
		$this->checkSession();	 		
		$classes=Model_Wiki::getPropetries(intval($_GET['pid']));		
		$this->response->body(json_encode( array('success'=>array('propetries'=>$classes)) ));					
	}
	
public function action_getfile(){
		$this->checkSession();				
		$line='';
		$fh = fopen($_GET['filepath'], "r");
 		while (! feof($fh)){ 
 			$line.= fgets($fh, 4096); 
 		}
 		fclose($fh);		
		$this->response->body(iconv('windows-1251','utf-8',$line));					
	}
	

	
	
	

	


public function action_log(){			
		$this->response->body(json_encode(array('d','s',1,2,3)));		
}


public function getIntGET($key){
		if(!isset($_GET[$key])){
			$_GET[$key] = 0;
		}
		return intval($_GET[$key]);	
}

} // End Admin
