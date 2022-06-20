<?php

class Factory
{
    /**
     *  конфиг со всеми параметрами приложения
     * @var Config
     */
    static $conf;

    static public function & getDB()
    {
        static $instance;

        if (!isset($instance)) {
            $instance = new DataBase();
        }

        return $instance->_db;
    }

    /**
     * @return TimeZoneService
     */
    static public function getTimeZoneService()
    {
        static $instance;
        if (!isset($instance)) {
            $instance = new TimeZoneService();
        }

        return $instance;
    }
}
