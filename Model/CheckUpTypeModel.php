<?php
require_once PROJECT_ROOT_PATH . "./Model/database.php";
class CheckUpTypeModel extends Database
{
    public function getCheckUpType($limit)
    {   
        return $this->select("SELECT * FROM checkuptype ORDER BY type_id ASC LIMIT ?", ["i", $limit]);
    }
    public function getType($id)
    {
        return $this->select("SELECT * FROM checkuptype WHERE type_id = ?", ["i", $id]);
    }
    public function getAllType(){
        return $this->select("SELECT *FROM checkuptype", []);
    }
}
?>