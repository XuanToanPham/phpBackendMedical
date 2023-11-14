<?php
class CatController extends BaseController
{
    public function responseData ($err, $strErrorHeader ,$response) {
        if (!$err) {
            $this->sendOutput(
                $response,
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')
            );
        } else {
            $this->sendOutput(
                json_encode(array('error' => $err)),
                array('Content-Type: application/json', $strErrorHeader)
            );
        }
    }
    public function addCat()
    {
        $strErrorDesc = '';
        $strErrorHeader = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $responseData = '';
        $cat = new CatsModel();
        if ($requestMethod === "POST") {

            try {
                $birthdate = new DateTime($_POST["birthdate"]);
                $InfoCat = [
                    "cat_id" => (int)$_POST["cat_id"],
                    "name" => strip_tags($_POST["name"]),
                    'age' => (int)$_POST["age"],
                    'weight' => (float)$_POST["weight"],
                    'birthdate' => $birthdate->format("Y-m-d H:i:s"),
                    'color' => strip_tags($_POST["color"]),
                    'gender' => strip_tags($_POST['gender']),
                    'owner_id' => $_POST['owner_id'] === '' ? null : $_POST['owner_id']
                ];
                $cat->addNewCat($InfoCat);
                $responseData = json_encode(['Message' => 'Thêm mèo thành công']);
            } catch (Error $e) {
                $strErrorDesc = $e->getMessage() . 'Something went wrong! Please contact support.';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        } else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }
        // send output 
        $this->responseData($strErrorDesc, $strErrorHeader, $responseData);
    }
    public function queryAllCat()
    {
        $strErrorDesc = '';
        $strErrorHeader = '';
        $responseData = "";
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $cat = new CatsModel();
        if ($requestMethod === "GET") {
            try {
                $catArrList =  $cat->queryFullListCat();
                $responseData = json_encode($catArrList);
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
    public function queryAllCatByIdOwner()
    {
        $strErrorDesc = '';
        $strErrorHeader = '';
        $responseData = [];
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams = $this->getQueryStringParams();
        $cat = new CatsModel();
        if ($requestMethod === "GET") {
            try {
                $owerId = 0;
                if (isset($arrQueryStringParams['id']) && $arrQueryStringParams['id']) {
                    $owerId = $arrQueryStringParams['id'];
                    $catArrList =  $cat->queryFullListCatByOwnerID($owerId);
                    if (count($catArrList) > 0 ) {
                        $responseData = json_encode($catArrList);
                    }
                    else {
                        $responseData = json_encode(['Message' => 'Tra cứu không có dữ liệu']);
                    }
                }
                else {
                    $strErrorDesc = 'Undefined Parameter';
                    $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';

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

    public function deleteInfoCatByCatID()
    {
        $strErrorDesc = '';
        $strErrorHeader = '';
        $responseData = [];
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams = $this->getQueryStringParams();
        $cat = new CatsModel();
        if($requestMethod === "DELETE") {
            try {
                $delId = 0;
                if (isset($arrQueryStringParams['id']) && $arrQueryStringParams['id']) {
                    $delId = $arrQueryStringParams['id'];
                    $cat->deleteInfoCatById($delId);
                    $responseData = json_encode(['Message'=>"Delete Successfully!"]);
                }
                else 
                {
                    $strErrorDesc = 'Undefined Parameter';
                    $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
                }
            }
            catch (Error $e) {
                $strErrorDesc = $e->getMessage() . 'Something went wrong! Please contact support.';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        } else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }
        $this->responseData($strErrorDesc, $strErrorHeader, $responseData);
    }
}
