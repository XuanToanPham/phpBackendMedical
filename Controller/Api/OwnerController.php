<?php

include_once './inc/models/DataCryption.php';
class OwnerController extends BaseController
{
    public function registerOwner()
    {
        $owner = new OwnerModel();
        $errorDesc = '';
        $errorHeader = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $responseData = '';
        if ($requestMethod === 'POST') {
            $OwnerInfo =  [
                'name' =>  $_POST['name'],
                'email' => $_POST['email'],
                'phone' => $_POST['phone'],
                'address' => $_POST['address'],
                'user_name' => $_POST['userName'],
                'password' => decryptString($_POST['passWord'])
            ];
            $userNameAlreadlExist = $owner-> getUserName ($OwnerInfo['user_name']);
            echo json_encode($userNameAlreadlExist);

        }
        

    }
}
