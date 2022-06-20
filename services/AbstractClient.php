<?php


use GuzzleHttp\Psr7\Response;

abstract class AbstractClient
{

    /**
     * @var \GuzzleHttp\Client
     */
    protected $http_client;

    /**
     * @var mixed
     */
    protected $api_url;
    /**
     * @var mixed
     */
    protected $api_token;
    /**
     * @var mixed
     */
    protected $timeout;

    /**
     * @var array
     */
    protected $headers;

    /**
     * @var bool
     */
    protected $authorized = false;

    /**
     * @var array
     */
    protected $options;


    /**
     * @var string
     */
    protected $api_token_conf_key;

    /**
     * AbstractClient constructor.
     *
     * @param array $config
     */
    public function __construct($config = [])
    {
        if (!empty($config['api_token'])) {
            $this->api_token = $config['api_token'];
        }
        else {
            $this->api_token = Factory::$conf[$this->api_token_conf_key];
        }
        if (!empty($config['api_url'])) {
            $this->api_url = $config['api_url'];
        }
        if (!empty($config['timeout'])) {
            $this->timeout = $config['timeout'];
        }

        $this->http_client = new \GuzzleHttp\Client([
            'base_uri' => $this->api_url,
            'timeout'  => $this->timeout,
            'debug' => !empty($config['debug']) ? $config['debug'] : false
        ]);
    }

    /**
     * @return bool
     */
    abstract protected function authorization(): bool;

    /**
     * @param $url
     *
     * @return string
     */
    abstract protected function prepareApiUrl($url): string;

    /**
     * @param $params
     *
     * @return array
     */
    abstract protected function prepareApiParams($params): array;

    /**
     * @param Response $response
     *
     * @return mixed
     */
    abstract protected function prepareResponse($response);

    /**
     * @return bool
     */
    protected function checkAuthorization(): bool
    {
        if(!$this->authorized) {
            $this->authorized = $this->authorization();
        }
        return $this->authorized;
    }


    /**
     * Инициализирует вызов к API
     *
     * @param string $type GET POST PUT DELETE
     * @param string $method
     * @param array $params
     *
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException|\Exception
     */
    protected function callApi($type, $method, $params = [])
    {
        if (!$this->checkAuthorization()) {
            new MyError('Not authorized');
        }

        $method = $this->prepareApiUrl($method);
        $params = $this->prepareApiParams($params);

        $data = [
            ($type === 'POST' ? 'form_params' : ($type === 'POSTJSON' ? 'json' : 'query')) => $params,
        ];

        if ($type === 'POSTJSON') {
            $type = 'POST';
        }

        if(!empty($this->headers)) {
            $data['headers'] = $this->headers;
        }

        if (!empty($this->options)) {
            $data = array_merge($data, $this->options);
        }

        $response = $this->http_client->request($type, $method, $data);

        return $this->prepareResponse($response);
    }
}
