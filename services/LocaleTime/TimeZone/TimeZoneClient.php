<?php


use GuzzleHttp\Psr7\Response;

class TimeZoneClient extends AbstractClient implements CityLocaleTimeInterface
{
    /**
     * @var string
     */
    protected $api_url = 'http://api.timezonedb.com/v2.1/get-time-zone?';

    /**
     * @var string
     */
    protected $api_token_conf_key = 'time_zone_token';
    protected $url = 'http://api.timezonedb.com/v2.1/get-time-zone?';

    protected $defaultParams = [
        'format' => 'json',
        'by' => 'position',
    ];

    /**
     * @return bool
     */
    protected function authorization(): bool
    {
        return true;
    }

    /**
     * @param $params
     *
     * @return array
     */
    protected function prepareApiParams($params): array
    {
        $params = array_merge($this->defaultParams, $params);
        $params['key'] = $this->api_token;

        return $params;
    }

    /**
     * @param $url
     *
     * @return string
     */
    protected function prepareApiUrl($url): string
    {
        return $url;
    }

    /**
     * @param Response $response
     * @return mixed|string
     */
    protected function prepareResponse($response)
    {
        return $response->getBody()->getContents();
    }

    public function getCity(array $params): ?array
    {
        try {
            $city = $this->callApi('GET', '', $params);
        } catch (\GuzzleHttp\Exception\GuzzleException $e) {
            new MyError($e->getMessage());
        }

        $result = json_decode($city, true);

        return is_array($result) ? $result : null;
    }
}
