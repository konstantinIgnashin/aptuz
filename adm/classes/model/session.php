<?php defined('SYSPATH') or die('No direct script access.');

class Model_Session extends Model
{
   public function kontrol_date_session($array)
   {
       $query="SELECT id FROM user_session "
                    ." WHERE ascii_session_id = '" . $array['php_session_id']. "'"
                    ." AND DATE_SUB(NOW(), INTERVAL " .$array['session_lifespan'] . " SECOND) < created"
                    ." AND user_agent = '".$array['strUserAgent']."'"
                    //." AND user_ip = '" . $strUserIP . "'"
                    ." AND DATE_SUB(now(), INTERVAL " . $array['session_timeout']. " SECOND) <= last_impression"
                    ." OR last_impression IS NULL "
                    ." LIMIT 1";
                 //   die($query);
         return DB::query(Database::SELECT,$query)
               ->execute();
    }


   public function delete_garbage_session($array)
   {
         $query="DELETE FROM user_session"
                        ." WHERE (ascii_session_id='".$array['php_session_id']."')"
                        ." OR (DATE_SUB(NOW(), INTERVAL " . $array['session_lifespan'] . " SECOND) > created)";
         return DB::query(Database::DELETE,$query)
            ->execute();
   }

   public function delete_variable_session()
   {
         $query="DELETE FROM user_session_variable"
                        ." WHERE session_id NOT IN (SELECT id FROM user_session)";
         return DB::query(Database::DELETE,$query)
            ->execute();
   }

   public function isset_bd($id)
   {
        $query="SELECT id, logged_in, user_id FROM user_session"
                ." WHERE ascii_session_id='".$id."'"
                ." LIMIT 1";
               // die($query);
         return DB::query(Database::SELECT,$query)
           // ->as_array()
            ->execute();//$this->_db
   }

   public function insert_new_session($array)
   {
        $query="INSERT INTO user_session(ascii_session_id, logged_in, user_id, created, user_agent)"
                    ."VALUES('".$array['id']."','1','0',now(),'".$array['strUserAgent']."')";
         return DB::query(Database::INSERT,$query)
            ->execute();//$this->_db
   }

   public function last_id($id)
   {
        $query="SELECT id FROM user_session"
                    ." WHERE ascii_session_id='".$id."'"
                    ." LIMIT 1";
         return DB::query(Database::SELECT,$query)
            ->execute();
   }

   public function delete_session($id)
   {
        $query="DELETE FROM user_session WHERE ascii_session_id='".$id."'";
        return DB::query(Database::DELETE,$query)
            ->execute();
   }

   public function set($array)
   {
          $query="INSERT INTO user_session_variable (session_id, variable_name, variable_value)"
                ." VALUES('".$array['native_session_id']."', '".$array['nm']."', '".$array['strSer']."')";
        return DB::query(Database::INSERT,$query)
            ->execute();
   }

   public function get($array)
   {
          $query="SELECT id,variable_value FROM user_session_variable"
            ." WHERE session_id='".$array['native_session_id']."'"
            ." AND variable_name='".$array['nm']."'"
            ." ORDER BY id DESC"
            ." LIMIT 1";
        $data= DB::query(Database::SELECT,$query)->execute()->as_array();					
		return $data;
   }

   public function logout($native_session_id)
   {
          $query="UPDATE user_session SET"
                    ." logged_in='0',"
                    ." user_id='0'"
                    ." WHERE id='".$native_session_id."'";
        return DB::query(Database::UPDATE,$query)
            ->execute();
   }

   public function isset_user($array)
   {
        $query="SELECT id FROM user"
               ." WHERE username='".$array['strUsername']."'"
               ." AND md5_pw='".$array['strMD5Password']."'"
               ." LIMIT 1";
        return DB::query(Database::SELECT,$query)
            ->execute()->as_array();
   }

   public function login($array)
   {
        $query="UPDATE user_session SET"
                    ." logged_in='1',"
                    ." user_id='".$array['user_id']."'"
                    ." WHERE id='".$array['native_session_id']."'";
        return DB::query(Database::UPDATE,$query)
            ->execute();
   }

   public function update_session_time($native_session_id)
   {
       $query="UPDATE user_session SET"
                ." last_impression=NOW()"
                ." WHERE id='".$native_session_id."'";
       return DB::query(Database::UPDATE,$query)
            ->execute();
   }
   
   public function get_user($user_id)
   {
        $query="SELECT * FROM user"
               ." WHERE id='".$user_id."'"              
               ." LIMIT 1";
        return DB::query(Database::SELECT,$query)
            ->execute()->as_array(); 
   }
   
     public function getUserGroupID($user_id)
   {
        $query="SELECT group_id FROM user"
               ." WHERE id='".$user_id."'"              
               ." LIMIT 1";
        return DB::query(Database::SELECT,$query)
            ->execute()->as_array(); 
   }
}