<?php defined('SYSPATH') or die('No direct script access.');

class Model_Alllists extends Kohana_Model {


public function getRoomUsers($offset){
	  $data = DB::query(Database::SELECT, "SELECT * from room_users ORDER BY id DESC Limit ".$offset.', 20')->execute()->as_array();
		foreach ($data as $k=>$v){

		}
		return $data;		   
}

public function getRoomUsersNS(){
	   return DB::query(Database::SELECT, "SELECT id from room_users")->execute()->count();		   
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



public function getErrors($offset){
	   return DB::query(Database::SELECT, 'SELECT * FROM errors   WHERE 1=1  ORDER BY id DESC Limit '.$offset.', 10')->execute()->as_array();		   
}
public function getErrorsNS(){
	   return DB::query(Database::SELECT, 'SELECT id FROM errors   WHERE 1=1  ORDER BY id DESC')->execute()->count();		   
}
public static function calcData($c){
		return DB::query(Database::SELECT, "SELECT * FROM last_quotes WHERE currency='".$c."' ORDER BY id DESC Limit 1")->execute()->as_array();	  	 
}




	

}
