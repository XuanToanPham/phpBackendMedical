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
                $userNameAlreadlExist = $owner->getInfoUser('user_name', $_POST['userName']);
                $phoneAlreadExist = $owner->getInfoUser('phone', $_POST['phone']);
                $emailAlreadExist = $owner->getInfoUser('email', $_POST['email']);
                if ($userNameAlreadlExist[0]['COUNT(*)'] > 0) {
                    $responseData =  json_encode(['Message' => 'User đã tồn tại']);
                } else if ($phoneAlreadExist[0]['COUNT(*)'] > 0) {
                    $responseData =  json_encode(['Message' => 'Số diện thoại đã tồn tại']);
                } else if ($emailAlreadExist[0]['COUNT(*)'] > 0) {
                    $responseData =  json_encode(['Message' => 'Email đã tồn tại']);
                } else {
                    $userID = null;
                    do {
                        $randomNumber = rand(1000000, 999999999);
                        $result = $owner->existUserId($randomNumber);
                        $existUserId = $result[0]['COUNT(*)'];
                    } while ($existUserId > 1);
                    $userID = $randomNumber;
                    $OwnerInfo =  [
                        'name' =>  $_POST['name'],
                        'email' => $_POST['email'],
                        'phone' => $_POST['phone'],
                        'address' => $_POST['address'],
                        'user_name' => $_POST['userName'],
                        'password' => $_POST['password'],
                        'owner_id' => $userID
                    ];
                    $owner->registerOwners($OwnerInfo);
                    $responseData = json_encode(['Message' => 'Đăng ký thành công']);
                    $owner->insertRoleOwner($userID);
                }
            } catch (Error $e) {
                $strErrorDesc = $e->getMessage() . 'Something went wrong! Please contact support.';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        } else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }
        $this->responseData($strErrorDesc, $strErrorHeader, $responseData);
    }

    public function ownerLogin()
    {
        $owner = new OwnerModel();
        $strErrorDesc = '';
        $strErrorHeader = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $responseData = '';
        if ($requestMethod === 'POST') {
            try {
                $ownerLoginInfo = [
                    'username' => $_POST['userName'],
                    'password' => $_POST['password']
                ];
                $result = $owner->login($ownerLoginInfo['username']);
                if (count($result) === 1) {
                    $getPassword = decryptString($result[0]["password"]);
                    if ($getPassword === decryptString($ownerLoginInfo['password'])) {
                        //Create Token
                        // $secretKey =  '12389k';
                        session_start();
                        $secretKey = SecretKeyManager::getSecretKey();
                        // unset($_SESSION['secretKeySession']);
                        $payload = [
                            "owner_id" => $result[0]['owner_id'],
                            "name" => $result[0]['name'],
                            "exp" => time() + (60 * 60 * 24 * 7)
                        ];
                        $algorithm = 'HS256';
                        $token = JWT::encode($payload, $secretKey, $algorithm);
                        echo $token;

                        $deToken = JWT::decode($token,  new Key($secretKey, 'HS256'));
                        print_r(json_encode($deToken));
                        $responseData = 'Đăng nhập thành công';
                        $_SESSION['user_id'] = $result[0]['owner_id'];
                    }
                } else {
                    $responseData = 'Thông tin đăng nhập không chính xác';
                }
            } catch (Error $e) {
                $strErrorDesc = $e->getMessage() . 'Something went wrong! Please contact support.';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        } else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }
        $this->responseData($strErrorDesc, $strErrorHeader, $responseData);
    }

    function ownerLogout () {
        $owner = new OwnerModel();
        $strErrorDesc = '';
        $strErrorHeader = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $responseData = '';
        if ($requestMethod === 'POST') {
            session_start();
            session_destroy();
        }
    }
}
