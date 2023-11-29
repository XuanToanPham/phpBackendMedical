<?php
require 'vendor/autoload.php';
require_once './helper/jwt-helperKey.php';
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
include_once './inc/models/DataCryption.php';
class OwnerController extends BaseController
{
    public function registerOwner()
    {
        $owner = new OwnerModel();
        $strErrorDesc = '';
        $strErrorHeader = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $responseData = '';
        if ($requestMethod === 'POST') {
            try {
                $OwnerInfo =  [
                    'name' =>  $_POST['name'],
                    'email' => $_POST['email'],
                    'phone' => $_POST['phone'],
                    'address' => $_POST['address'],
                    'user_name' => $_POST['userName'],
                    'password' => $_POST['passWord']
                ];
                $userNameAlreadlExist = $owner-> getUserName($OwnerInfo['user_name']);
                if (count($userNameAlreadlExist) === 1) {
                    $responseData =  json_encode(['Message' => 'User đã tồn tại']);
                }
                else {
                    $owner->registerOwners($OwnerInfo);
                    $responseData = json_encode(['Message' => 'Đăng ký thành công']);
                }
                
            } catch (Error $e) {
                $strErrorDesc = $e->getMessage() . 'Something went wrong! Please contact support.';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        }
        else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }
        $this->responseData($strErrorDesc, $strErrorHeader, $responseData);
    
    }

    public function ownerLogin () {
        $owner = new OwnerModel();
        $strErrorDesc = '';
        $strErrorHeader = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $responseData = '';
        if($requestMethod === 'POST') {
            try {
                $ownerLoginInfo = [
                    'username'=>$_POST['username'],
                    'password'=>$_POST['password']
                ];
                $result = $owner->login($ownerLoginInfo['username']);
                if(count($result) === 1) {
                    print_r (json_encode($result[0]));
                    $getPassword = decryptString($result[0]["password"]);
                    if ($getPassword === decryptString($ownerLoginInfo['password'])) {
                        //Create Token
                        $secretKey = getSecretKey();
                        echo $secretKey;

                        $payload = [
                            "owner_id" => $result[0]['owner_id'],
                            "name" => $result[0]['name'],
                            "exp" => time() + (60 * 60 * 24 * 7) 
                        ];
                        $algorithm = 'HS256';
                        $token = JWT::encode($payload, $secretKey, $algorithm);
                        echo $token;

                        $deToken = JWT::decode($token,  new Key($secretKey, 'HS256'));
                        print_r ($deToken);
                    }
                }
            } catch (Error $e) {
                echo $e;
            }
        }
    }
}
