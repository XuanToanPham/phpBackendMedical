<?php
class CatController extends BaseController
{
    public function addCat()
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        if ($requestMethod === "POST") {

            try {
                $cat = new CatsModel();
                $birthdate = new DateTime($_POST["birthdate"]);
                $InfoCat = [
                    "cat_id" => (int)$_POST["cat_id"],
                    "name" => $_POST["name"],
                    'age' => (int)$_POST["age"],
                    'weight' => (float)$_POST["weight"],
                    'birthdate' => $birthdate->format("Y-m-d H:i:s"),
                    'color' => $_POST["color"],
                    'gender' => $_POST['gender'],
                    'owner_id' => $_POST['owner_id'] === '' ? null : $_POST['owner_id']
                ];
                $cat->addNewCat($InfoCat);
            } catch (Error $e) {    
                $strErrorDesc = $e->getMessage() . 'Something went wrong! Please contact support.';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        } else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }
        // send output 
        if (!$strErrorDesc) {
            $responseData =json_encode ([
                'Message' => 'Thêm mèo thành công thành công',
            ]);
            $this->sendOutput(
                $responseData,
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')
            );
        } else {
            $this->sendOutput(
                json_encode(array('error' => $strErrorDesc)),
                array('Content-Type: application/json', $strErrorHeader)
            );
        }
    }
}
