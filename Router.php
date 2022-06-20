<?php

class Router
{
    /**
     * имя класса
     */
    protected $class_name;
    protected $method_name;
    protected $method_args;

    public function __construct($class_name = null, $method_name = null, $method_args = null, $namespace = '')
    {
        if (!$class_name) {
            $parts = explode('/', preg_replace("#\?.*#u", "", $_SERVER['REQUEST_URI']));

            $class_name  = $parts[1];
            $method_name = $parts[2] ?: 'index';
            $method_args = array_slice($parts, 2);
        }

        $this->method_name = str_replace(' ', '', ucwords(str_replace('-', ' ', $method_name)));;
        $this->method_args = $method_args;
        $this->class_name = $namespace . str_replace(' ', '', ucwords(str_replace('-', ' ', $class_name))) . 'Controller';
    }

    public function _include()
    {
        $result         = null;
        $not_controller = true;

        // тут происходит autoload контроллера
        if (
            class_exists($this->class_name)
            && method_exists($this->class_name, '__construct')
        ) {
            if (!$this->method_args) {
                $this->method_args = [$this->method_name];
            }

            // создаем экземпляр класса через рефлексию
            $reflection = new ReflectionClass($this->class_name);
            $object     = $reflection->newInstanceArgs($this->method_args);

            if (isset($this->method_name) && !empty($this->method_name)) {
                $method_args = array_slice($this->method_args, 1);

                if (mb_substr($this->method_name, 0, 6) !== 'action') {
                    $this->method_name = 'action' . $this->method_name;
                }

                if (method_exists($object, $this->method_name)) {
                    $result = call_user_func_array([$object, $this->method_name], $method_args);
                }

                $not_controller = !$result;

                if (php_sapi_name() === "cli" && !method_exists($object, $this->method_name)) {
                    echo "\nMethod {$this->method_name} not exist! Check spelling\n\n";
                    trigger_error("Method \"{$this->method_name}\" not exist! Check spelling", E_USER_ERROR);
                    exit();
                }
            } // если не указан метод, то пытаемся вызвать actionindex
            elseif (method_exists($object, "actionindex")) {
                $this->method_name = "actionindex";
                $method_args       = array_slice($this->method_args, 1);
                $result            = call_user_func_array([$object, $this->method_name], $method_args);
            }
            elseif (php_sapi_name() === "cli") {
                echo "\nMethod {$this->method_name} not exist! Check spelling\n\n";
                trigger_error("Method \"{$this->method_name}\" not exist! Check spelling", E_USER_ERROR);
                exit();
            }
        }

        if ($not_controller && $this->class_name && php_sapi_name() === "cli" && !class_exists($this->class_name, false)) {
            echo "\nClass \"{$this->class_name}\" not exist! Check spelling or controller file existing\n\n";
            trigger_error("Class \"{$this->class_name}\" not exist! Check spelling or controller file existing", E_USER_ERROR);
            exit();
        }

        if ($not_controller) {
            new MyError('Метод не найден');
        }

        return $result;
    }
}
