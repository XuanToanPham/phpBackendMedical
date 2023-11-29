<?php

require_once PROJECT_ROOT_PATH . "./Model/database.php";
class OwnerModel extends Database {
    public function getUserName($username) {
        return $this->select("SELECT user_name FROM owners WHERE user_name = ?" , ['s', $username]);
    }
    
    public function registerOwners($OwnerInfo) {
        return $this->CUD('INSERT INTO owners (name, email, phone, address, user_name, password) 
        VALUE (?, ?, ?, ?, ?, ?)', ["ssisss", $OwnerInfo['name'], $OwnerInfo['email'], $OwnerInfo['phone'], $OwnerInfo['address'], $OwnerInfo['user_name'], $OwnerInfo['password']]);
    }

    public function login($username) {
        return $this->select("SELECT * FROM owners WHERE user_name LIKE ?" ,['s' ,$username]);
    }
}
?>