<?php


abstract class AbstractLocaleTimeService
{
    /**
     * @var TimeZoneClient
     */
    protected $client;

    /**
     * @return array
     */
    public function getCityLocaleTime($params): array
    {
        $city = $this->client->getCity($params);

        if (!is_array($city)) {
            new MyError('Сервис не отвечает');
        }

        return $this->prepareResult($city);
    }

    public function prepareResult($result) {
        return $result;
    }
}
