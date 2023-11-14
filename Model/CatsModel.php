<?php 
    require_once PROJECT_ROOT_PATH . "./Model/database.php";
    class CatsModel extends Database {
        public function addNewCat ($catInfo) {
            return $this ->insert("INSERT INTO cats (name, birthdate, color, gender, weight, owner_id)
            VALUES (?, ?, ?, ?, ?, ?)", 
            ["ssssii", $catInfo['name'], $catInfo['birthdate'], $catInfo['color'], $catInfo['gender'], $catInfo['weight'], $catInfo['owner_id']]);
        }
    }

?>