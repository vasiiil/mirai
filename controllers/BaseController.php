<?php


abstract class BaseController
{
    public function __construct($method = null)
    {
    }

    protected function response($data, $status = BaseResponse::STATUS_OK)
    {
        (new BaseResponse())
            ->setData($data)
            ->setStatus($status)
            ->send();
    }

    protected function errorResponse($code, $message)
    {
        (new BaseResponse())
            ->setCode($code)
            ->setMessage($message)
            ->setStatus(BaseResponse::STATUS_FAILED)
            ->send();
    }
}
