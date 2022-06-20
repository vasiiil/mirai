<?php

class TimeZoneService extends AbstractLocaleTimeService
{
    public function __construct()
    {
        $this->client = new TimeZoneClient();
    }

    public function prepareResult($result) {
        if ($result['status'] === 'OK') {
            return $result;
        }

        new MyError($result['message']);
    }
}
