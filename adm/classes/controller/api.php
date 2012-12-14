<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Api extends Controller {

	public function action_index(){
		$this->response->body('hello, world!');
	}
	
	public function action_candles(){
		if(!isset($_GET['day']))$_GET['day'] = 21;
		if(!isset($_GET['month']))$_GET['month'] = 8;
		if(!isset($_GET['year']))$_GET['year'] = 2009;
		$data = Model_Api::getLastCandles($_GET['symbol'],$_GET['period'],$_GET['day'],$_GET['month'], $_GET['year']);
		$c='';
		foreach($data as $k=>$a){			
			$c.="[".($k+1).', '.$a['bar_open'].', '.$a['bar_high'].', '.$a['bar_low'].', '.$a['bar_close']."],x";
		}
		
		$this->response->body('{"a":"'.rtrim($c,",").'"}');	
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
	
	public function action_importsignal(){
		$subscribers = Model_Api::getSubscribers();
		$h = round($_GET['High'],4);
		$l = round($_GET['Low'],4);
		$tpl = '
		<table>
			<tr>							
				<th>High</th>
				<th>Low</th>
				<th>TimeFrame</th>	
			</tr>
			<tr>							
				<td>'.$h.'</td>
				<td>'.$l.'</td>
				<td>'.$_GET['timeFrame'].'</td>	
			</tr>
		</table>';
		foreach($subscribers as $k=>$v){			
			$this->send($v['email'], 'alerts@trader.uz', 'H:'.$h.', L:'.$l.', R:'.round((($h-$l)*10000),0).', T:'.$_GET['timeFrame'], $tpl);		
		}
		$this->response->body('1');
	}
	
public static function send($to, $sender, $subject, $mess){	   
	  $sendmail = "/usr/sbin/sendmail -t -f $sender "; 
	  $fd = popen($sendmail, "w"); 
	  fputs($fd, "To: ".$to."\r\n"); 
	  fputs($fd, "Content-type: text/html; charset=utf-8 \r\n"); 
	  fputs($fd, "From: Signal Trader.Uz <$sender>\r\n"); 
	  fputs($fd, "Subject: ".$subject."\r\n"); 
	  fputs($fd, "X-Mailer: Mailer Name\r\n\r\n"); 
	  fputs($fd, $mess); 
	  pclose($fd);		  	        
	}

} // End Welcome
