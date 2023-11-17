<?php 
    require_once PROJECT_ROOT_PATH . "./Model/database.php";
    class CatsModel extends Database {
        public function addNewCat ($catInfo) {
            return $this ->CUD("INSERT INTO pets (pet_name, birthdate, color, gender, age, weight, owner_id, species_id)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)", 
            ["ssssiiii", $catInfo['pet_name'], $catInfo['birthdate'], $catInfo['color'], $catInfo['gender'], $catInfo['age'], $catInfo['weight'], $catInfo['owner_id'], $catInfo['species_id']]);
        }
        public function queryFullListCat () {
            return $this -> select("SELECT * FROM pets", []);
        }

        public function queryFullListCatByOwnerID ($id) {
            return $this -> select("SELECT * FROM pets WHERE owner_id = ?", ['i', $id]);
        }
        public function deleteInfoCatById($id) {
            return $this -> CUD('DELETE FROM pets WHERE cat_id = ?', ['i', $id]);
        }
        public function updateCatInfo ($catInfo, $catId) {
            return $this ->CUD("UPDATE pets SET pet_name = ?, birthdate = ?, color = ?, gender = ?, age = ?, weight = ?, owner_id = ?, species_id = ? WHERE cat_id = ?", 
            ["ssssiiiii", $catInfo['pet_name'], $catInfo['birthdate'], $catInfo['color'], $catInfo['gender'], $catInfo['age'], $catInfo['weight'], $catInfo['owner_id'], $catInfo['species_id'] ,$catId]);
        }
    }

?>