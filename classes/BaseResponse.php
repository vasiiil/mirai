<?php

class BaseResponse
{
    private $_code = 200;
    private $_message;
    private $_data;
    private $_status = self::STATUS_OK;

    const STATUS_OK = 'OK';
    const STATUS_FAILED = 'FAILED';

    public function send()
    {
        header("Content-type: application/json; charset=utf-8");

        $response = [
            'status' => $this->_status,
        ];

        if ($this->_message) {
            $response['message'] = $this->_message;
        }

        if ($this->_data) {
            $response['data'] = $this->_data;
        }

        echo json_encode($response);
        exit();
    }

    public function setData($data)
    {
        $this->_data = $data;
        return $this;
    }

    public function setStatus($status)
    {
        $this->_status = $status;
        return $this;
    }

    public function setMessage($message)
    {
        $this->_message = $message;
        return $this;
    }

    public function setCode($code = null)
    {
        $this->_code = $code;
        switch ($code) {
            case 304:
                header("HTTP/1.1 304 Not Modified");
                break;
            case 400:
                header("HTTP/1.1 400 Bad Request");
                break;
            case 401:
                header("HTTP/1.1 401 Unauthorized");
                break;
            case 403:
                header("HTTP/1.1 403 Forbidden");
                break;
            case 404:
                header("HTTP/1.1 404 File not found");
                break;
            case 500:
                header("HTTP/1.1 500 Internal Server Error");
                break;
        }
        return $this;
    }
}
