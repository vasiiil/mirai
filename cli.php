<?php
/**
 * скрипт для запуска по крону или руками разных действий
 * вызывать так:
 * php -c scripts/php.ini cli.php controller/method arg1 arg2 arg3 .....
 * method можно не писать, тогда вызовется actionIndex
 *
 * все методы контрроллеров, которые хотите вызвать должны называться action...
 *
 */


if (php_sapi_name() != "cli") {
    exit('not cli interface');
}

require_once __DIR__ . "/config/config.php";

//ini_set('display_errors', 1);
//ini_set('error_reporting', E_ALL ^ E_NOTICE);

// время выполнения скрипта
ini_set('max_execution_time', 0);

// обрезаем аргументы
$argv = ArrayHelper::trim($argv);

// удаляем из аргументов название скрипта
array_shift($argv);

// get controller & method
$clme = array_shift($argv);
$clme = explode("/", $clme);

// добавляем namespace к контроллеру
$cl = $clme[0];
// метод по дефолту
$me = $clme[1] ?? 'index';

$args = $argv;

// добавляем метод в аргументы (так надо из-за роутера)
array_unshift($args, $me);

/*var_dump($cl);
var_dump($me);
var_dump($args);*/

// константа для идентификации уникального запуска скрипта
define('SCRID', mb_substr(uniqid('sc'), 6));

// вызываем роутер
$router    = new Router($cl, $me, $args, '\\scripts\\controllers\\');
$exit_code = $router->_include();

exit($exit_code);
