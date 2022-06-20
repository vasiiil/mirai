<?php


class MyError
{
    public function __construct($error, $userMessage = 'Извините, что-то пошло не так')
    {
        (new BaseResponse())
            ->setStatus(BaseResponse::STATUS_FAILED)
            ->setData((Factory::$conf['dev'] ?? null) === true ? $error : $userMessage)
            ->send();
    }
}
