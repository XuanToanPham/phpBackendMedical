<?php
class CheckUpTypeController extends BaseController
{
    
    public function listType ()
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams = $this->getQueryStringParams();
        if (strtoupper($requestMethod) == 'GET') {
            try {
                $CheckUpType = new CheckUpTypeModel();
                $intLimit = 0;
                if (isset($arrQueryStringParams['limit']) && $arrQueryStringParams['limit']) {
                    $intLimit = $arrQueryStringParams['limit'];
                }
                $arrUsers = $CheckUpType->getCheckUpType($intLimit);
                $responseData = json_encode($arrUsers);
                session_start();
                // $secretKey = SecretKeyManager::getSecretKey();
                if(isset($_SESSION['user_id'])) {
                    echo "đã đăng nhập";
                }
                else {
                    echo "chưa đăng nhập";
                }
                
            } catch (Error $e) {
                $strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        } else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }
        // send output 
        if (!$strErrorDesc) {
            $this->sendOutput(
                $responseData,
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')
            );
        } else {
            $this->sendOutput(json_encode(array('error' => $strErrorDesc)), 
                array('Content-Type: application/json', $strErrorHeader)
            );
        }
    }
    public function getTypeByID()
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams = $this->getQueryStringParams();
        if(strtoupper($requestMethod) == "GET") {
            try {
                $CheckUpType = new CheckUpTypeModel();
                $idCheck = 1;
                if (isset($arrQueryStringParams['id']) && $arrQueryStringParams['id']) {
                    $idCheck = $arrQueryStringParams['id'];
                }
                $type = $CheckUpType->getType($idCheck);
                $responseData = json_encode($type);
                
            }
            catch (Error $e) {
                $strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        } else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }
        // send output 
        if (!$strErrorDesc) {
            $this->sendOutput(
                $responseData,
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')
            );
        } else {
            $this->sendOutput(json_encode(array('error' => $strErrorDesc)), 
                array('Content-Type: application/json', $strErrorHeader)
            );
        }
    }
    // private $db;
    // public function __construct()
    // {
    //     $this->db = (new Database())->getConnection();
    // }
    // public function getData()
    // {
    //     // Your code for creating a record in 'cats' table
    //     $query = "SELECT * FROM checkuptype";
    //     $stmt = $this->db->prepare($query);
    //     $stmt->execute();
    //     return $stmt->fetchAll(PDO::FETCH_ASSOC);
    // }
}
?>
