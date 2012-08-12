<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Session extends Controller
{
    private $php_session_id;
    private $native_session_id;
    private $logged_in;
    private $user_id;
    private $session_timeout=3600;   // 1 chasovoyi тайм-аут
    private $session_lifespan= 86400; // длительность сеанса 24*3600 (24 * 1 час)
    private $maxlifetime=86400; // длительность сеанса  24*3600 (24 * 1 час)
	

    public function __construct()
    {
        // Установка обработчика
        session_set_save_handler(
            array(&$this, '_session_open_method'),
            array(&$this, '_session_close_method'),
            array(&$this, '_session_read_method'),
            array(&$this, '_session_write_method'),
            array(&$this, '_session_destroy_method'),
            array(&$this, '_session_gc_method')
        );
        // Проверяем cookie: переданы ли эти данные и корректны ли они
        $strUserAgent=addslashes($_SERVER["HTTP_USER_AGENT"]);

        if(isset($_COOKIE["PHPSESSID"]))
        {
            // Проверяем сроки давности + юзерагент (чисто для безопасности)
            $this->php_session_id=$_COOKIE["PHPSESSID"];

            $model = new Model_Session();
            $session_array = array(
                'php_session_id'    => $this->php_session_id,
                'session_lifespan'  => $this->session_lifespan,
                'session_timeout'   => $this->session_timeout,
                'strUserAgent'      => $strUserAgent,
            );
          
            $result=$model->kontrol_date_session($session_array);
            if(count($result)==0)
            {
                 // Удаляем из базы данных всякий мусор - периодическая сборка мусорa
                $result=$model->delete_garbage_session($session_array);
                
                // Отчистка переменных сеанса
                $result=$model->delete_variable_session();
             
                // Удаляем идентификатор.. получаем новый
                unset($_COOKIE["PHPSESSID"]);
            }
        }
        
        $domain = 'trader.uz';
		if(preg_match('/t\.uz/i',$_SERVER['HTTP_HOST'],$a)){
			$domain = 't.uz';
		}
		ini_set('session.cookie_domain', '.'.$domain);
		if(!isset($_REQUEST[session_name()])){
			session_start(); 
			setcookie('PHPSESSID', session_id(), 0, '/', '.'.$domain); 
		}
		else{
			session_start(); 
		}
		
		
		//session_set_cookie_params($this->session_lifespan);        
		//session_start();
        
    }

   /*
    *  Метод, проверяющий - есть ли у этого пользователя
    * текущая валидная сессия или нет
    * если est', то апдейтим время последнего визита
    */
    public function Impress()
    {
        if($this->native_session_id)
        {
            $model = new Model_Session();
            $result = $model->update_session_time($this->native_session_id);
        }
    }

  
    public function IsLoggedIn()
    {
        return  ($this->logged_in);
    }

    // Узнаем id пользователя
    public function getUserID()
    {
        if($this->logged_in)
        {
            return ($this->user_id);
        }
        else
        {
            return false;
        }
    }

    public function getUserObject()
    {
        if($this->logged_in)
        {
            if(class_exists("user"))
            {
                $objUser=new User($this->user_id);
                return ($objUser);
            }
            else
            {
                return false;
            }
        }
    }

    public function GetSessionIdentifier()
    {
        return ($this->php_session_id);
    }

    public function login($strUsername, $strPlainPassword)
    {
        
        $strMD5Password=md5($strPlainPassword);
        $model = new Model_Session();
        $result = $model->isset_user(array(
            'strUsername'      => $strUsername,
            'strMD5Password'   => $strMD5Password,
        ));        
     	//print_r($result); echo $this->php_session_id; exit();
        if(count($result)>0)
        {
            $this->user_id=$result[0]['id'];
            $this->logged_in=1;
            $result = $model->login(array(
                'native_session_id' => $this->native_session_id,
                'user_id'           => $this->user_id,
            ));
            return true;
        }
        else
        {
            return false;
        }
    }

    public function LogOut()
    {
        
        if($this->logged_in=='1')
        {
            $model = new Model_Session();
            $result = $model->logout($this->native_session_id);

            $this->user_id=0;
            $this->logged_in=0;
            return true;
        }
        else
        {
            return false;
        }
    }

    public function __get($nm)
    {
        $model = new Model_Session();
        $result = $model->get(array(
            'native_session_id' => $this->native_session_id,
            'nm'                => $nm,
         ));
       
       if(count($result)>0)
        {
            return (unserialize($result[0]['variable_value']));
        }
        else
        {
            return false;
        }
    }

    public function __set($nm, $val)
    {
         $strSer=serialize($val);
        $model = new Model_Session();
        $result = $model->set(array(
            'native_session_id' => $this->native_session_id,
            'nm'                => $nm,
            'strSer'            => $strSer,
        ));
    }

    private function _session_open_method()
    {
       return true;
    }

    public function _session_close_method()
    {
        // типо заккрытие ДБ
        return true;
    }

    private function _session_read_method($id)
    {
        
        // Используется для проверки существования сеанса
        $strUserAgent=addslashes($_SERVER["HTTP_USER_AGENT"]);
        $this->php_session_id=$id;
        //echo $id; exit();
        // Проверяем наличие в БД
        $model = new Model_Session();
        $result = $model->isset_bd($id);
        //print_r($result); exit();
	    if(count($result)>0)
        {
            $this->native_session_id=$result[0]['id'];
            if(@$result[0]['logged_in']==1)
            {
                $this->logged_in='1';
                $this->user_id=@$result[0]['user_id'];
            }
            else
            {
                $this->logged_in='0';
            }
        }
        else
        {
            $this->logged_in='0';
            
            // Необходимо создать запись в БД
            $result = $model->insert_new_session(array(
                    'id'            =>$id,
                    'strUserAgent'  =>$strUserAgent,
                ));
            
            // Получение истинного идентификатора
            $result=$model->last_id($id);
            $this->native_session_id=@$result[0]['id'];
        }
        // Возвращаем пстую строку
    }

    public function _session_write_method($id, $sess_data)
    {
        return true;
    }

    private function _session_destroy_method($id)
    {
       $model = new Model_Session();
       $result = $model->delete_session($id);
       return $result;
    }

    private function _session_gc_method($maxlifetime)
    {
        return true;
    } 
	public function get_user(){
	   $model = new Model_Session();
       //echo '--'.$this->user_id.'--<br>';
	   return $model->get_user($this->user_id); 
	} 
	public function getUserGroupID(){
	   $model = new Model_Session();
       //echo '--'.$this->user_id.'--<br>';
	   return $model->getUserGroupID($this->user_id); 
	}    
} // End Session


