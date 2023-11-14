
<?php
require __DIR__ . "/inc/bootstrap.php";
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode('/', $uri);
require PROJECT_ROOT_PATH . "/Controller/Api/CheckUpTypeController.php";
require PROJECT_ROOT_PATH . "/Controller/Api/CatController.php";

$routes = [
    'checkuptype' => [
        'listType' => 'CheckUpTypeController@listType',
        'typeID' => 'CheckUpTypeController@getTypeByID'
    ],
    'cat' => [
        'addCat' => 'CatController@addCat'
    ]
];

if (isset($uri[3]) && isset($uri[4]) && isset($routes[$uri[3]][$uri[4]])) {
    list($controller, $method) = explode('@', $routes[$uri[3]][$uri[4]]);
    $controllerInstance = new $controller();
    $controllerInstance->{$method}();
} else {
    header("HTTP/1.1 404 Not Found");
    exit();
}
?>