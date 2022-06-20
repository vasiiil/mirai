<?php

function autoload($class_name)
{
    if (mb_strpos($class_name, '\\') !== false) {
        $file = ROOT_DIR . str_replace('\\', DS, $class_name) . '.php';

        // if the file exists, require it
        if (file_exists($file)) {
            require_once $file;
        }

        return;
    }

    $dirs = [
        CONTROLLERS_DIR,
        MODELS_DIR,
        CLASSES_DIR,
        LIBS_DIR,
        SERVICES_DIR,
        HELPERS_DIR,
    ];

    foreach ($dirs as $dir) {
        if (file_exists($file = $dir . $class_name . '.php')) {
            require_once $file;
            return;
        }
    }

    if (file_exists($file = SERVICES_DIR . 'LocaleTime' . DS . $class_name . '.php')) {
        require_once $file;
        return;
    }

    if (file_exists($file = SERVICES_DIR . 'LocaleTime' . DS . 'TimeZone' . DS . $class_name . '.php')) {
        require_once $file;
        return;
    }
}

spl_autoload_register('autoload');

require ROOT_DIR . 'vendor' . DS . 'autoload.php';
