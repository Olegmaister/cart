<?php

namespace common\services;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use yii\helpers\Json;

/**
 * Class SmsClubJsonSender
 */
class SmsClubJsonSender
{
    /**
     * @var Client
     */
    private $httpClient;

    public function __construct()
    {
        $this->httpClient = new Client([
            RequestOptions::HEADERS => [
                'Authorization' => 'Bearer ' . '6EEqPk_dWXIqzbt',
            ]
        ]);
    }

    /**
     * @param string $text
     * @param $phone
     * @return mixed|null
     */
    function send(string $text, string $phone)
    {
        $data = [
            'phone' => [$phone],
            'message' => $text,
            'src_addr' => 'Shop Zakaz',
        ];

        $response = $this->httpClient->post(
            'https://im.smsclub.mobi/sms/send',
            [
                RequestOptions::JSON => $data
            ]
        );

        $return = $response->getBody()->getContents();

        return Json::decode($return, true);
    }
}