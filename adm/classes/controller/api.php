<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Api extends Controller {

	public function action_index(){
		$this->response->body('hello, world!');
	}
	
	public function action_richmedia(){		
		if($_GET['action']=='start'){
			Model_Api::insertLoad($_SERVER['REMOTE_ADDR']);
		}elseif ($_GET['action']=='click') {
			Model_Api::updateAction(1,$_SERVER['REMOTE_ADDR']);		
		}elseif($_GET['action']=='cancel'){
			Model_Api::updateAction(2,$_SERVER['REMOTE_ADDR']);				
		}			
		$this->response->body('{}');
	}

} // End Welcome
