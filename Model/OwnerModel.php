<?php

require_once PROJECT_ROOT_PATH . "./Model/database.php";
class OwnerModel extends Database {
    public function getUserName($username) {
        return $this->select("SELECT user_name FROM owners WHERE user_name = ?" , ['s', $username]);
    }
}
?>