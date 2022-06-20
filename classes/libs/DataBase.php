<?php

class DataBase
{
    public $_db;

    public function __construct()
    {
        $params = Factory::$conf['db'];
        $db     = new PDO("mysql:host={$params['host']};port=3306;dbname={$params['name']};charset=utf8", $params['user'], $params['pass']);

        $db->setAttribute(PDO::ATTR_STRINGIFY_FETCHES, false);

        $this->_db = $db;
    }
}
