<?php
require('../vendor/autoload.php');

ini_set('display_errors',1);
ini_set("error_reporting", E_ALL);

$uri = $_SERVER['REQUEST_URI'];

$REQUEST_METHOD = $_SERVER['REQUEST_METHOD'];

$DEST = getenv('DEST');

$DEST_FINAL = $DEST.$uri;

if ($REQUEST_METHOD=='POST')
{
    $baseText = (string) implode("", file('php://input'));

    $headers = getallheaders();

//    unset($headers['Host']);
//    unset($headers['Accept-Language']);

//    $headers["Content-Type"] = "application/json"
//    $headers["Content-Length"] = strlen($baseText);

    $requestHeaders = [];
    foreach($headers as $key => $value) {
        $requestHeaders[] = $key . ": " . $value;
    }

//    $requestHeaders[] = "Content-Type: application/json";




//     $requestHeaders = array(
//         'Content-Type: application/json',
//            sprintf('Content-Length: %d',  $contLenght)
//         );
//                Создать контекст и инициализировать POST запрос
    $context = stream_context_create(array(
        'http' => array(
            'method' => $REQUEST_METHOD,
            'header' => $requestHeaders,
            'content' => $baseText,
        ),
    ));

    try{

        echo file_get_contents($DEST_FINAL,false,$context);
    }

    catch (Exception $e) {
        echo 'off try';
    }
}
else
{
    $baseText = '';
 	
	 $headers = getallheaders();

//    unset($headers['Host']);
//    unset($headers['Accept-Language']);

//    $headers["Content-Type"] = "application/json"
//    $headers["Content-Length"] = strlen($baseText);

    $requestHeaders = [];
    foreach($headers as $key => $value) {
        $requestHeaders[] = $key . ": " . $value;
    }

//    $requestHeaders[] = "Content-Type: application/json";

    
    $context = stream_context_create(array(
        'http' => array(
            'method' => $REQUEST_METHOD,
            'header' => $requestHeaders,
            'content' => $baseText,
        ),
    ));

    //            Отправить запрос на себя, чтобы запустить тесты
    //        и показать результат выполнения тестов
    echo file_get_contents($DEST_FINAL,false,$context);

}




function getallheaders()
{
    $headers = '';
    foreach ($_SERVER as $name => $value)
    {
        if (substr($name, 0, 5) == 'HTTP_')
        {
            $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
        }
    }
    return $headers;
}

?>