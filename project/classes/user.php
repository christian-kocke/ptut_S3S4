<?php
class user {

    private $_db, // instance de la connexion a la bd
            $_data, // donnees de l'utilisateur
            $_sessionName, // nom de la session utilisateur
            $_cookieName, // nom du cookie si 'remember'
            $_isLoggedIn = false; 


    public function __construct($user = null) { // constructeur de la classe
        $this->_db = db::getInstance();
        $this->_sessionName = config::get('session/session_name');
        $this->_cookieName = config::get('remember/cookie_name');

        if(!$user) {
            if(session::exists($this->_sessionName)) {
                $user = session::get($this->_sessionName);

                if($this->find($user)) {
                    $this->_isLoggedIn = true;
                }
            }
        } else {
            $this->find($user);
        }
    }
    // crée un utilisateur
    public function create($fields = array()) { 
        if(!$this->_db->insert('users', $fields)) {
            throw new Exception('There was a problem creating an account.');
        }
    }
    // modifier des valeurs de l'utilisateur
    public function update($fields = array(), $id = null){

        if(!$id && $this->isLoggedIn()){
            $id = $this->data()->id;
        }

        if(!$this->_db->update('users', $id, $fields)){
            throw new Exception('There was a problem updating');
        }
    }

    // trouver toutes les données d'un utilisateur et les mettre dans data
    public function find($user = null) {
        if($user) {
            $field = (is_numeric($user)) ? 'id' : 'username';
            $data = $this->_db->get('users', array($field, '=', $user));

            if($data->count() == 1) {
                $this->_data = $data->first();
                return true;
            }
        }
        return false;
    }

    // connecter l'utilisateur
    public function login($username = null, $password = null, $remember = false) {
        $user = $this->find($username);
        if(!$username && !$password && $this->exists()){
            session::set($this->_sessionName, $this->data()->id);
        }else{
            if($user) {
                if($this->data()->password === hash::generate($password, $this->data()->salt)) {
                    session::set($this->_sessionName, $this->data()->id);

                    if($remember){
                        $hash = hash::unique();
                        $hashCheck = $this->_db->get('users_session', array('user_id', '=', $this->data()->id));

                        if(!$hashCheck->count()){
                            $this->_db->insert('users_session', array(
                                'user_id' => $this->data()->id,
                                'hash' => $hash
                                ));
                        }else{
                            $hash = $hashCheck->first()->hash;
                        }

                        cookie::set($this->_cookieName, $hash, config::get('remember/cookie_expiry'));

                    }
                    return true;
                }
            }
        }
        return false;
    }

    // tester si l'utilisateur a la permisions $key
    public function hasPermission($key){
        if($this->isLoggedIn()){
            $group = $this->_db->get('groups', array('id', '=', $this->data()->group));
            if($group->count()){
                $permissions = json_decode($group->first()->permissions, true);
                if($permissions[$key] === 1){
                    return true;
                }
            }
        }
        return false;
    }

    // tester si l'utilisateur existe
    public function exists(){
        return (!empty($this->_data) ? true : false);
    }

    // déconnnecter l'utilisateur
    public function logout(){

        $this->_db->delete('users_session', array('user_id', '=', $this->data()->id));
        cookie::delete(config::get('remember/cookie_name'));
        session::delete($this->_sessionName);
        session::delete('basket');
    }

    // recuperer les données utilisateurs dans $_data
    public function data() {
        return $this->_data;
    }

    // tester si l'utilisateur est connecter
    public function isLoggedIn() {
        return $this->_isLoggedIn;
    }
}