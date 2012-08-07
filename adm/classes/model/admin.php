<?php defined('SYSPATH') or die('No direct script access.');

class Model_Admin extends Kohana_Model {

public function getpages(){
	   $data = DB::query(Database::SELECT, "
		   SELECT *
		   FROM pages 		   
		   WHERE 1=1    
           ORDER BY id ASC 	Limit 200")->execute()->as_array();	  	   
	return $data;         
}


public function getDown($limit, $startStamp=0, $endStamp=0,$page){
	   $s='';
	   $e='';
	   $p='';
	   if($startStamp>0){
	   	$s=" and d.startTime>=".$startStamp;
	   }
	   if($endStamp>0){
	   		$e=" and d.startTime<=".$endStamp;
	   }
	   if($page>0){
		  $p=" and d.page_id=".$page;
	   }
	   $data = DB::query(Database::SELECT, "
		   SELECT   d.startTime as startTime, d.endTime as endTime, p.url as pageUrl, p.name as pageName
		   FROM pages_down d
 		   INNER JOIN pages p ON d.page_id = p.id 		   
		   WHERE 1=1   ".$s." ".$e." ".$p."     
           ORDER BY d.id ASC Limit ".$limit)->execute()->as_array();	  	   
	return $data;         
}

public function getCurrent(){
	   $data = DB::query(Database::SELECT, "
		   SELECT id as id, name as pageName, url as pageUrl, auth as auth, status_down as status_down, date_status_down as date_status_down, date_status_up as date_status_up
		   FROM pages 		   
		   WHERE 1=1    
           ORDER BY id ASC 	Limit 200")->execute()->as_array();	  	   
	return $data;         
}

public function getLog($offset){
	   $data = DB::query(Database::SELECT, "SELECT referer, ip, id, DATE_FORMAT( FROM_UNIXTIME( tstamp ),'%Y.%m.%d %H:%i' ) AS date
	    FROM stat_referers   WHERE referer LIKE '%google%' ORDER BY id DESC Limit ".$offset.', 20')->execute()->as_array();
		foreach ($data as $k=>$v){
			$data[$k]['query']= $this->findQuery($v['referer']);
			$data[$k]['url']= $this->findUrl($v['referer']);
			$data[$k]['country']= $this->findCountry($v['ip']);
			$data[$k]['title']='';
			if($data[$k]['url']!=''){
				$data[$k]['title'] = $this->findName($data[$k]['url']);
			}
			unset($data[$k]['referer']);
		}
		return $data;		   
}

public function getPopulary(){
	   $data = DB::query(Database::SELECT, "SELECT * FROM content WHERE 1=1 ORDER BY id DESC ")->execute()->as_array();
		foreach ($data as $k=>$v){
			$data[$k]['count']= $this->findCount($v['id']);
			$data[$k]['nsComments']= $this->findComments($v['id']);	
			$data[$k]['nsNotActiveComments']= $this->findNsNotActiveComments($v['id']);	
			$data[$k]['category'] = $this->findCategory($v['pid']);		
			DB::query(Database::INSERT, "REPLACE INTO stat_populary(id, pid, title, count,gID,nsComments,category, notActiveComments) 
			VALUES('".$data[$k]['id']."','".$data[$k]['pid']."','".$data[$k]['title']."','".$data[$k]['count']."',
			'".base64_encode($data[$k]['id'])."','".$data[$k]['nsComments']."','".$data[$k]['category'][0]['chpu']."',
			'".$data[$k]['nsNotActiveComments']."')")->execute();
		}		
		return DB::query(Database::SELECT, "SELECT * FROM stat_populary WHERE 1=1 ORDER BY count DESC ")->execute()->as_array();;		   
}
public function getPopularyQueries($page){

	 $data = DB::query(Database::SELECT, "SELECT referer, ip, id, DATE_FORMAT( FROM_UNIXTIME( tstamp ),'%Y.%m.%d %H:%i' ) AS date
	    FROM stat_referers   WHERE referer LIKE '%google%' and url LIKE '%".base64_encode($page)."' ORDER BY id DESC ")->execute()->as_array();
		foreach ($data as $k=>$v){
			$data[$k]['query']= $this->findQuery($v['referer']);
			$data[$k]['url']= $this->findUrl($v['referer']);
			$data[$k]['country']= $this->findCountry($v['ip']);
			$data[$k]['title']='';
			if($data[$k]['url']!=''){
				$data[$k]['title'] = $this->findName($data[$k]['url']);
			}
			unset($data[$k]['referer']);
		}
		return $data;	
}

public function getLogNS(){
	   return DB::query(Database::SELECT, "SELECT id FROM stat_referers WHERE referer LIKE '%google%' ")->execute()->count();		   
}

public function getErrors($offset){
	   return DB::query(Database::SELECT, 'SELECT * FROM errors   WHERE 1=1  ORDER BY id DESC Limit '.$offset.', 10')->execute()->as_array();		   
}
public function getErrorsNS(){
	   return DB::query(Database::SELECT, 'SELECT id FROM errors   WHERE 1=1  ORDER BY id DESC')->execute()->count();		   
}
public static function calcData($c){
		return DB::query(Database::SELECT, "SELECT * FROM last_quotes WHERE currency='".$c."' ORDER BY id DESC Limit 1")->execute()->as_array();	  	 
}

/* keyword tools*/

function findQuery($referer){
	$a = parse_url($referer);
	@parse_str($a['query'],$query);
	if(!isset($query['q'])){
		return '---';
	}		
	if($this->detect_cyr_charset($query['q'])=='i'){
		$query['q'] = iconv('utf-8','windows-1251',$query['q']);
	}		
	return urldecode($query['q']);				
}
function findUrl($referer){
	$a = parse_url($referer);
	@parse_str($a['query'],$query);
	if(!isset($query['url'])){
		return '&nbsp;';
	}			
	return urldecode($query['url']);				
}

function findCategory($id){
	return DB::query(Database::SELECT, "SELECT chpu FROM sys_pages WHERE pid='".$id."' Limit 1")->execute()->as_array();	  
}

function detect_cyr_charset($str) {
   //define('LOWERCASE',3); 
   //define('UPPERCASE',1);
   $charsets = array('k' => 0, 'w' => 0, 'd' => 0, 'i' => 0, 'm' => 0);
   for ( $i = 0, $length = strlen($str); $i < $length; $i++ ) {
	   $char = ord($str[$i]);
	   //non-russian characters
	   if ($char < 128 || $char > 256) continue;

	   //CP866
	   if (($char > 159 && $char < 176) || ($char > 223 && $char < 242)) $charsets['d']+=3;
	   if (($char > 127 && $char < 160)) $charsets['d']+=1;

	   //KOI8-R
	   if (($char > 191 && $char < 223)) $charsets['k']+=3;
	   if (($char > 222 && $char < 256)) $charsets['k']+=1;

	   //WIN-1251
	   if ($char > 223 && $char < 256) $charsets['w']+=3;
	   if ($char > 191 && $char < 224) $charsets['w']+=1;

	   //MAC
	   if ($char > 221 && $char < 255) $charsets['m']+=3;
	   if ($char > 127 && $char < 160) $charsets['m']+=1;

	   //ISO-8859-5
	   if ($char > 207 && $char < 240) $charsets['i']+=3;
	   if ($char > 175 && $char < 208) $charsets['i']+=1;

   }
   arsort($charsets);
   return key($charsets);
}

function findCountry($ip){	
	require_once '../engine/storage/geoip/geobaza.php';
	$query = new GeobazaQuery();
	$obj = $query->get($ip);	
	$geobaza = $query->get_path($ip);
	@$geobaza->country->name;	
	return @$geobaza->country->translations[1]->ru.', '.$obj->name;
}

function findName($url){
	$a = parse_url($url);
	@parse_str($a['query'],$query);
	if(!isset($query['gID'])){
		return '';
	}
	$data = DB::query(Database::SELECT, "SELECT title FROM content WHERE id='".base64_decode($query['gID'])."' ORDER BY id DESC Limit 1")->execute()->as_array();
	//echo @$data['title'];	 
	return @$data[0]['title'];
}
/* keyword tools*/

/*populary tools*/

function findCount($id){
	 return DB::query(Database::SELECT, "SELECT id FROM stat_referers WHERE url LIKE '%gID=".base64_encode($id)."'")->execute()->count();
}

function findComments($id){
	 return DB::query(Database::SELECT, "SELECT id FROM content_comments WHERE pid='".$id."'")->execute()->count();
}

function findNsNotActiveComments ($id){
	 return DB::query(Database::SELECT, "SELECT id FROM content_comments WHERE pid='".$id."' and disable=1")->execute()->count();
}
/*comments*/
public function getComments($offset,$sword,$disable){
	   $add='';
	   if($disable>-1){
	   	$add.=' and c.disable='.$disable;
	   }
	   if($sword>0){
	   	$add.=' and c.id='.$sword;
	   }
	   $data = DB::query(Database::SELECT, " SELECT *, 
	   DATE_FORMAT( FROM_UNIXTIME( c.tstamp ),'%Y.%m.%d %H:%i' ) AS comment_date, c.id as comment_id, c.title as comment_title, 
	   			p.title as news_title, p.id as news_id
	    FROM base p, room_comments c WHERE  p.id=c.content_id and c.place_id=1 ".$add." ORDER BY c.id DESC Limit ".$offset.', 20')->execute()->as_array();			
		return $data;		   
}

public function getCommentsNS($sword,$disable){
	   $add='';
	   if($disable>-1){
	   		$add=' and disable='.$disable;
	   }
	   if($sword>0){
	   	$add.=' and id='.$sword;
	   }
	   return DB::query(Database::SELECT, "SELECT id FROM room_comments WHERE 1=1 ".$add."")->execute()->count();		   
}

static function comment_status($status, $id ){
	return DB::query(Database::UPDATE, "UPDATE room_comments SET disable='".$status."' WHERE id='".$id."' Limit 1")->execute();
}

static function comment_edit($name, $text, $id ){
	return DB::query(Database::UPDATE, "UPDATE room_comments SET title='".$text."' WHERE id='".$id."' Limit 1")->execute();
}

	

}
