<?php defined('SYSPATH') or die('No direct script access.');

class Model_Alllists extends Kohana_Model {
	public function getRoomUsers($offset){
		  return DB::query(Database::SELECT, "SELECT * from room_users ORDER BY id DESC Limit ".$offset.', 20')->execute()->as_array();			   
	}
	
	public function getRoomUsersNS(){
		   return DB::query(Database::SELECT, "SELECT id from room_users")->execute()->count();		   
	}
	//downloads
	public function getDownloadsUsers($offset){
		  return  DB::query(Database::SELECT, "SELECT d.id, d.file_id, d.crdate, d.email, c.title, c.static_url, c.downloads FROM forex_downloads d, forex_content c where d.file_id = c.id ORDER BY d.id DESC Limit ".$offset.', 20')->execute()->as_array();		   
	}
	
	public function getDownloadsUsersNS(){
		   return DB::query(Database::SELECT, "SELECT id from forex_downloads")->execute()->count();		   
	}
	//buys
	public function getBuysUsers($offset){
		  return  DB::query(Database::SELECT, "SELECT * FROM api_users ORDER BY id DESC Limit ".$offset.', 20')->execute()->as_array();		   
	}
	
	public function getBuysUsersNS(){
		   return DB::query(Database::SELECT, "SELECT id from api_users")->execute()->count();		   
	}







	

}
