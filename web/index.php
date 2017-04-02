<?php
require('../vendor/autoload.php');

ini_set('display_errors',1);
ini_set("error_reporting", E_ALL);

$REQUEST_METHOD = $_SERVER['REQUEST_METHOD'];

$DEST = getenv('DEST');

$DEST_FINAL = $DEST.'';

if ($REQUEST_METHOD=='POST')
{
	$baseText = (string) implode("", file('php://input'));
}
else
{
	$baseText = '';
}

// Создать контекст и инициализировать POST запрос
 $context = stream_context_create(array(
        'http' => array(
            'method' => $REQUEST_METHOD,
            'header' => 'Content-Type: application/json' . PHP_EOL,
            'content' => $baseText,
        ),
    ));

// Отправить запрос на себя, чтобы запустить тесты
    // и показать результат выполнения тестов
    echo file_get_contents(
        $file = $DEST_FINAL,
        $use_include_path = false,
        $context);

?>