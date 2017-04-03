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
    $contLenght = strlen($baseText);
	$requestHeaders = array(
        'Content-Type: application/json',
        sprintf('Content-Length: %d',  $contLenght)
        );
	// 	Создать контекст и инициализировать POST запрос
	 $context = stream_context_create(array(
	        'http' => array(
	            'method' => $REQUEST_METHOD,
	            'header' => $requestHeaders,
	            'content' => $baseText,
	        ),
	    ));
	
	// 	Отправить запрос на себя, чтобы запустить тесты
	    // 	и показать результат выполнения тестов
	    echo file_get_contents(
	        $file = $DEST_FINAL,
	        $use_include_path = false,
	        $context,false,$contLenght);
}
else
{
	$baseText = '';
	
	//e	cho $DEST_FINAL;
	// 	Создать контекст и инициализировать POST запрос
	 $context = stream_context_create(array(
	        'http' => array(
	            'method' => $REQUEST_METHOD,
	            'header' => 'Content-Type: application/json' . PHP_EOL,
	            'content' => $baseText,
	        ),
	    ));
	
	// 	Отправить запрос на себя, чтобы запустить тесты
	    // 	и показать результат выполнения тестов
	    echo file_get_contents(
	        $file = $DEST_FINAL,
	        $use_include_path = false,
	        $context);
	
}



?>