<?php 
    require_once PROJECT_ROOT_PATH . "./Model/database.php";
    class CatsModel extends Database {
        public function addNewCat ($catInfo) {
            return $this ->CUD("INSERT INTO cats (name, birthdate, color, gender, weight, owner_id)
            VALUES (?, ?, ?, ?, ?, ?)", 
            ["ssssii", $catInfo['name'], $catInfo['birthdate'], $catInfo['color'], $catInfo['gender'], $catInfo['weight'], $catInfo['owner_id']]);
        }
        public function queryFullListCat () {
            return $this -> select("SELECT * FROM cats", []);
        }

        public function queryFullListCatByOwnerID ($id) {
            return $this -> select("SELECT * FROM cats WHERE owner_id = ?", ['i', $id]);
        }
        public function deleteInfoCatById($id) {
            return $this -> CUD('DELETE FROM cats WHERE cat_id = ?', ['i', $id]);
        }
    }

?>