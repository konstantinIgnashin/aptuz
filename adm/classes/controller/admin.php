<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin extends Controller {	
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
		$this->GET['startStamp'] = $this->getDate(date("d.m.Y 00:00",time()));
		$this->GET['endStamp']   = $this->getDate(date("d.m.Y 23:59",time()));
		$this->GET['page'] = 0;
		if(isset($_GET['start_date']) && $_GET['start_date']!='')$this->GET['startStamp'] =$this->getDate($_GET['start_date']);		
		if(isset($_GET['end_date']) && $_GET['end_date']!='')$this->GET['endStamp']   =$this->getDate($_GET['end_date']);		
		if(isset($_GET['page']))$this->GET['page']=intval($_GET['page']);
}	
	
public function action_index(){
		$this->checkSession();	 		
		$view = View::factory('admin/index');			
		$view->user=$this->session->get_user();
		$this->response->body($view->render());			
	}	

	
public function action_login(){			
        $this->session = new Controller_Session();		
		$view = View::factory('auth/login');
		$view->error='';
		if(isset($_POST['login']) && isset($_POST['password'])){ 		
			$result = $this->session->login($_POST['login'],$_POST['password']);
			if($result==TRUE){				
				header('Location: http://'.$_SERVER['HTTP_HOST'].'/admin/index');
				die();
			}
			else{
				$view->error='Неверный логин / пароль.';
			} 
		}		
		if($this->session->getUserID()>0){ 		
			header('Location: http://'.$_SERVER['HTTP_HOST'].'/admin/index');
			die();	
        }		
		$this->response->body($view->render());			
}
	
public function action_logout(){			
        $this->checkSession();		 
		$this->session->LogOut();	
		header('Location: http://'.$_SERVER['HTTP_HOST'].'/admin/login');	
		die();			
}

private function getDate($date){
		$a=explode(' ',$date);		
		list($day,$month,$year)=explode('.',$a[0]);
		list($hour,$min)=explode(':',$a[1]);
		$d=array('day'=>$day,'month'=>$month,'year'=>$year,'hour'=>$hour,'min'=>$min,'sec'=>0);		
		return mktime(intval($d['hour']), intval($d['min']), intval($d['sec']),intval($d['month']),intval($d['day']),intval($d['year']));
}


public function action_log(){			
		$this->response->body(json_encode(array('d','s',1,2,3)));		
}
public function action_summary(){			
		$this->checkSession();
		$model = new Model_Admin();	
		$newArray = array_merge( $this->get_summary_logs() );		
		$this->response->body(json_encode( array('success'=>$newArray) ));		
}

public function action_summary_logs(){			
		$this->checkSession();
		$this->response->body(json_encode( array('success'=>$this->get_summary_logs() ) ));				
}

public function get_summary_logs(){			
		$model = new Model_Admin();		
		$logPaging = array('onPage'=>20,'ns'=>$model->getLogNS(),'activePage'=>$this->getIntGET('page'));
		return array('log'=>$model->getLog(20*$this->getIntGET('page')) , 'logPaging'=>$logPaging);			
}

public function get_summary_errors(){			
		$model = new Model_Admin();		
		$errorsPaging = array('onPage'=>10,'ns'=>$model->getErrorsNS(),'activePage'=>$this->getIntGET('page'));
		return array('errors'=>$model->getErrors(10*$this->getIntGET('page')) , 'errorsPaging'=>$errorsPaging);			
}
public function action_summary_errors(){			
		$this->checkSession();
		$this->ajaxResponse( array('success'=>$this->get_summary_errors() ));				
}

public function action_calculator(){			
		$this->checkSession();
		$data = Model_Admin::calcData('EURUSD');
		$this->ajaxResponse(array('success'=>$data));				
}

public function getIntGET($key){
		if(!isset($_GET[$key])){
			$_GET[$key] = 0;
		}
		return intval($_GET[$key]);	
}

public function ajaxResponse($a){
		$this->response->body(json_encode($a));	
}

public function action_populary(){			
		$this->checkSession();
		$model = new Model_Admin();	
		if(!isset($_GET['page'])){
			$newArray = array_merge( $model->getPopulary() );		
		}
		else{
			$newArray = $model->getPopularyQueries(intval($_GET['page'])) ;	
		}
		$this->response->body(json_encode( array('success'=>array('log'=>$newArray)) ));		
}

public function action_comments(){			
		$this->checkSession();
		$this->response->body(json_encode( array('success'=>$this->get_comments() ) ));				
}

public function get_comments(){			
		$sword='';
		$disable=-1;	
		if(isset($_GET['sword']) && $_GET['sword']!=''){
			$sword=$_GET['sword'];
		}
		if(isset($_GET['disable']) && $_GET['disable']!=''){
			$disable=$_GET['disable'];
		}
		$model = new Model_Admin();		
		$logPaging = array('onPage'=>20,'ns'=>$model->getCommentsNS($sword,$disable),
		'activePage'=>$this->getIntGET('page'));	
		return array('log'=>$model->getComments(20*$this->getIntGET('page'),$sword,$disable) , 
		'logPaging'=>$logPaging,'getInfo'=>array('sword'=>$sword,'disable'=>$disable));			
}

public function action_comments_status(){			
		$this->checkSession();
		Model_Admin::comment_status($_GET['status'],$_GET['id']);
		$this->response->body(json_encode( array('success'=>'1' ) ));				
}

public function action_comment_edit(){			
		$this->checkSession();
		Model_Admin::comment_edit($_GET['name'], $_GET['text'], $_GET['id'] );
		$this->response->body(json_encode( array('success'=>'1' ) ));				
}




} // End Admin
