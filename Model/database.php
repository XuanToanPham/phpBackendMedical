    <?php
    class Database
    {
        protected $connection = null;
        private $host = "127.0.0.1:2502"; // Thay đổi nếu cần
        private $db_name = "projectmewmew"; // Thay đổi thành tên cơ sở dữ liệu của bạn
        private $username = "myadmin"; // Thay đổi thành tên người dùng của bạn
        private $password = "0918891960As."; // Thay đổi thành mật khẩu của bạn
        private $port = "2502"; // Thay 2502 bằng cổng của bạ
        public $conn;

        public function __construct()
        {
            try {
                $this->connection = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE_NAME);
                if (mysqli_connect_errno()) {
                    throw new Exception("Could not connect to database");
                }
            } catch (Exception $e) {
                throw new Exception($e->getMessage());
            }
        }
        public function select($query = "", $params = [])
        {
            
            try {
                
                $stmt = $this->executeStatement($query, $params);
                $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
                $stmt->close();
                return $result;
            } catch (Exception $e) {
                throw new Exception($e->getMessage());
            }
            return false;
        }
        public function CUD($query = "", $params = [])
        {
            try {
                
                $stmt = $this->executeStatement($query, $params);
                $stmt->close();
                return $stmt;
            } catch (Exception $e) {
                throw new Exception($e->getMessage());
            }
            return false;
        }
        private function executeStatement($query = "", $params = [])
        {
            try {
                $stmt = $this->connection->prepare($query);
                if($params) {
                    $styleParam = $params[0];
                    array_splice ($params, 0 , 1);
                }
                if ($stmt === false) {
                    throw new Exception("Unable to do prepared statement: " . $query);
                }
                if ($params) {
                    $stmt->bind_param($styleParam, ...$params);
                }
                $stmt->execute(); // thực thi truy vấn
                return $stmt;
            } catch (Exception $e) {
                throw new Exception($e->getMessage());
            }
        }

        // public function getConnection () {
        //     $this -> conn = null;
        //     try {
        //         $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
        //         $this->conn->exec("set names utf8");
        //         echo "Ket noi thanh cong";
        //     }
        //     catch (PDOException $exception) {
        //         echo "Loi ket noi" . $exception ->getMessage();
        //     };

        //     return $this -> conn;
        // }
    }


    ?>