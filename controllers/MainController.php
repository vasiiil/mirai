<?php


class MainController extends BaseController
{
    public function actionIndex()
    {
        /** @var City $cities */
        $cities = City::getModel();

        $this->response(['cities' => $cities->getAll()]);
    }

    public function actionGetLocaleTime($id = null, $time = null)
    {
        if (!($id = Checker::string($id))) {
            $this->response(['message' => 'Некорректный идентификатор города'], BaseResponse::STATUS_FAILED);
        }

        if (is_null(Checker::string($time))) {
            $time = time();
        }
        elseif (!($time = Checker::positiveInt($time))) {
            $this->response(['message' => 'Некорректная метка времени'], BaseResponse::STATUS_FAILED);
        }

        $city = City::getModel()->getById($id);

        if (!$city) {
            $this->response(['message' => 'Город не найден'], BaseResponse::STATUS_FAILED);
        }

        $service  = Factory::getTimeZoneService();
        $cityTime = $service->getCityLocaleTime([
            'lat' => $city['latitude'],
            'lng' => $city['longitude'],
            'time' => $time,
        ]);

        $city = array_merge($city, [
            'localeTime' => $cityTime['formatted'],
            'requestTime' => date('Y-m-d H:i:s', $time),
            'localeTimestamp' => $cityTime['timestamp'],
            'requestTimestamp' => $time,
            'localeGMT' => $cityTime['gmtOffset'],
            'localeDST' => $cityTime['dst'],
        ]);
        $this->response($city);
    }

    public function actionGetUnixFromLocaleTime($id = null, $time = null)
    {
        if (!($id = Checker::string($id))) {
            $this->response(['message' => 'Некорректный идентификатор города'], BaseResponse::STATUS_FAILED);
        }

        if (is_null($time)) {
            $time = time();
        }
        else {
            $time = urldecode($time);

            if (
                !preg_match('/^\d{4}-\d{2}-\d{2}\s\d{2}:\d{2}:\d{2}$/', $time)
                || !($time = strtotime($time))
            ) {
                $this->response(['message' => 'Некорректная метка времени'], BaseResponse::STATUS_FAILED);
            }
        }

        $city = City::getModel()->getById($id);

        if (!$city) {
            $this->response(['message' => 'Город не найден'], BaseResponse::STATUS_FAILED);
        }

        $service  = Factory::getTimeZoneService();
        $cityTime = $service->getCityLocaleTime([
            'lat' => $city['latitude'],
            'lng' => $city['longitude'],
            'time' => $time,
        ]);

        $result = $time - $cityTime['gmtOffset'];

        $firstDst = $cityTime['dst'];
        $cityTime = $service->getCityLocaleTime([
            'lat' => $city['latitude'],
            'lng' => $city['longitude'],
            'time' => $result,
        ]);

        $secondDst = $cityTime['dst'];

        if ($secondDst !== $firstDst) {
            if ($firstDst === '0') {
                $result -= 3600;
            }
            else {
                $result += 3600;
            }
        }

        $city = array_merge($city, [
            'requestTime' => date('Y-m-d H:i:s', $time),
            'resultTimestamp' => $result,
        ]);
        $this->response($city);
    }
}
