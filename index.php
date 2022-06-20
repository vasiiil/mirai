<?php
require 'config/config.php';

$router    = new Router();
$exit_code = $router->_include();

(new BaseResponse())
    ->setCode(404)
    ->setMessage('Метод не найден')
    ->send();
