<?php

if (!defined('DS'))
    define('DS', DIRECTORY_SEPARATOR);
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', dirname(dirname(__FILE__)) . DS);
if (!defined('CLASSES_DIR'))
    define('CLASSES_DIR', ROOT_DIR . 'classes' . DS);
if (!defined('CONTROLLERS_DIR'))
    define('CONTROLLERS_DIR', ROOT_DIR . 'controllers' . DS);
if (!defined('MODELS_DIR'))
    define('MODELS_DIR', ROOT_DIR . 'models' . DS);
if (!defined('LIBS_DIR'))
    define('LIBS_DIR', CLASSES_DIR . 'libs' . DS);
if (!defined('SERVICES_DIR'))
    define('SERVICES_DIR', ROOT_DIR . 'services' . DS);
if (!defined('HELPERS_DIR'))
    define('HELPERS_DIR', CLASSES_DIR . 'helpers' . DS);
