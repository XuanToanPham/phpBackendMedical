<?php
require_once PROJECT_ROOT_PATH . "./Model/database.php";
class UserModel extends Database
{
    public function getCheckUpType($limit)
    {   
        return $this->select("SELECT * FROM checkuptype ORDER BY type_id ASC LIMIT ?", ["i", $limit]);
    }
}
?>