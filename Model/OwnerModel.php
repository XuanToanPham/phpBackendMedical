<?php

require_once PROJECT_ROOT_PATH . "./Model/database.php";
class OwnerModel extends Database {
    public function getInfoUser($row, $rowData) {
        return $this->select("SELECT COUNT(*) FROM owners WHERE $row = ?" , ['s', $rowData]);
    }
    
    public function registerOwners($OwnerInfo) {
        return $this->CUD('INSERT INTO owners (owner_id, name, email, phone, address, user_name, password) 
        VALUE (?, ?, ?, ?, ?, ?, ?)', ["ississs", $OwnerInfo['owner_id'], $OwnerInfo['name'], $OwnerInfo['email'], $OwnerInfo['phone'], $OwnerInfo['address'], $OwnerInfo['user_name'], $OwnerInfo['password']]);
    }

    public function login($username) {
        return $this->select("SELECT * FROM owners WHERE user_name LIKE ?" ,['s' ,$username]);
    }

    public function insertRoleOwner($userId) {
        return $this->CUD('INSERT INTO owner_roles (owner_id) VALUE (?)', ["i", $userId]);
    }

    public function existUserId($userId) {
        return $this->select('SELECT COUNT(*) FROM owners WHERE owner_id = ?', ['i', $userId]);
    }
}
?>