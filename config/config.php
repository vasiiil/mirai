<?php

require 'constants.php';
require ROOT_DIR . 'autoload.php';
require ROOT_DIR . 'Router.php';
$app_params = array_merge(
    (array)require __DIR__ . '/params.php',
    (array)include __DIR__ . '/params-local.php'
);

require CLASSES_DIR . "Factory.php";

Factory::$conf = new Config($app_params);
