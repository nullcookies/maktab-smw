<?php

namespace models\objects;

use \system\ActiveRecord;

use SQLBuilder\ArgumentArray;
use SQLBuilder\Bind;
use SQLBuilder\ParamMarker;
use SQLBuilder\Criteria;
use SQLBuilder\Driver\MySQLDriver;
use SQLBuilder\Universal\Query\SelectQuery;
use SQLBuilder\Universal\Query\InsertQuery;
use SQLBuilder\Universal\Query\UpdateQuery;
use SQLBuilder\Universal\Query\DeleteQuery;

class User extends ActiveRecord
{
    protected $secureAssignColumns = ['password'];
    
    public function save($secure = true)
    {
    	if(
            $secure &&
        	(
                empty($_SESSION['usergroup']) ||
                empty($_SESSION['user_id']) ||
                $this->usergroup < $_SESSION['usergroup'] || 
                (
                    !empty($this->id) &&
                    $this->usergroup == $_SESSION['usergroup'] && 
                    $this->id != $_SESSION['user_id']
                ) 
            )
    	){
    		exit('Access Error');
    	}
    	
    	return parent::save();
    }

    public function find($id, $secure = true)
    {
        $found = parent::find($id, $secure);

        if($found){

            $this->icon = $this->linker->getIcon($this->media->resize($this->image, 150, 150));

            //set date birth
            $this->date_birth = date('d-m-Y', $this->date_birth);
        }

        return $found;
    }

    public function findByAuthkey($key, $secure = true)
    {
        $found = false;
        if(!empty($key)){
            $args = new ArgumentArray;
            $query = new SelectQuery;
            $query->select('*')
                ->from($this->tableName)
                ->where()
                    ->equal('authkey', new Bind('authkey', $key));
            $sql = $query->toSql($this->driver, $args);
            $sth = $this->db->prepare($sql);
            if($sth !== false){
                $result = $sth->execute((array)$args);
                if($result && $sth->rowCount() > 0){
                    $userRow = $sth->fetch(\PDO::FETCH_ASSOC);
                    $found = $this->find($userRow[$this->primaryKey], $secure);
                }
            }
        }
        return $found;
    }

    public function findByUsername($username, $secure = true)
    {
        $found = false;
        if(!empty($username)){
            $args = new ArgumentArray;
            $query = new SelectQuery;
            $query->select('*')
                ->from($this->tableName)
                ->where()
                    ->equal('username', new Bind('username', $username));
            $sql = $query->toSql($this->driver, $args);
            $sth = $this->db->prepare($sql);
            if($sth !== false){
                $result = $sth->execute((array)$args);
                if($result && $sth->rowCount() > 0){
                    $userRow = $sth->fetch(\PDO::FETCH_ASSOC);
                    $found = $this->find($userRow[$this->primaryKey], $secure);
                }
            }
        }
        return $found;
    }

    public function generateAuthkey($string)
    {
        return md5($this->config['params']['salt'] . $string);
    }

    public function login()
    {
        if($this->id && $this->usergroup){
            setcookie('AUTH', $authkey, time() + 86400 * 30, '/');
            $_SESSION['user_id'] = $this->id;
            $_SESSION['usergroup'] = $this->usergroup;
            $_SESSION['username'] = $this->username;
            $_SESSION['external_userid'] = $this->external_userid;
            $_SESSION['external_password'] = $this->external_password;
            $this->phpsessid = $_COOKIE['PHPSESSID'];
            $this->last_ip = $_SERVER['REMOTE_ADDR'];
            $this->last_login = time();
            $this->date_activity = time();
            $this->save(false);
            
            if($this->savedSuccess){
                return true;
            }
        }
            
        return false;
    }

    public function logout()
    {
        setcookie('AUTH', $authkey, time() - 86400, '/');
        unset($_SESSION['user_id']);
        unset($_SESSION['usergroup']);
        unset($_SESSION['username']);
        unset($_SESSION['external_userid']);
        unset($_SESSION['external_password']);
        session_destroy();
        return true;
    }

}
