<?php
namespace frontend\services\api;

use GuzzleHttp\Client;

class UkrposhtaService
{

    private $httpClient;


    public function __construct(
        Client $httpClient
    ) {
        $this->httpClient = $httpClient;

    }




    public function getHotels(
        $country = null,
        $hotel_rating = null,
        $meal_type = null,
        array $searchData = [],
        $paramsForm = []
    ) {

        $defaultData = $this->getDefaultParams($country, $hotel_rating, $meal_type);



        if (!empty($searchData)) {
            $resultData = $paramsForm + (array_intersect_key($searchData, $defaultData) + $defaultData);
        } else {
            $paramsForm = array_filter($paramsForm);
            $resultData = $paramsForm + $defaultData;
        }


        $url = $this->generateUrl($resultData);


        $return =  $this->sendRequest($url);


        return $return;
    }


    private function getDefaultParams( $country = null, $hotel_rating = null, $meal_type = null)
    {

        return [
            "postcode"=> 12345,
            "country"=> "UA",
            "region"=> "Київська",
            "city"=> "Бровари",
            "istrict"=> "Київський",
            "street"=> "Котляревськ",
            "houseNumber"=> 12,
            "apartmentNumber"=> 33
        ];
    }

    public function sendRequest(
        $url,
        $useCache = true,
        $cacheDuration = 0,
        callable $funcIfWriteCache = null
    ) {

       // $cacheDuration = $this->getCacheDuration($cacheDuration);
       // $urlCache = $this->language.'/'.$url;

        $data = $this->getResult($this->getData($url));

        return $data;
    }


    private function getData($url)
    {
        $headers = array();
        //$headers[] = 'Content-length: 0';
        $headers[] = 'Content-Type:application/json';
        $headers[] = "Authorization:Bearer cd041849-06c9-38ff-aeb7-98cf19f25c26";
        //$headers[] = "Accept-Language: ".'ru';
        $res = $this->httpClient->request('POST', $url, [
            // 'headers' => $headers,
            'headers' => [
                'Content-Type' => "application/json",
                'Authorization' => "Bearer cd041849-06c9-38ff-aeb7-98cf19f25c26",
                //'Accept-Language' => 'ru',
            ],
            //  'curl.options' => [CURLOPT_INTERFACE => 'xxx.xxx.xxx.xxx']
        ]);



        return $res->getBody()->getContents();

    }


    private function getResult($result)
    {

        if (is_string($result)) {
            return json_decode($result, $this->returnAsArray);
        }

        return $result;
    }

    public function generateUrl(array $data)
    {

        $url='https://dev.ukrposhta.ua/ecom/0.0.1/addresses/';
        return  $url.http_build_query($data);


    }

    private function fillProperties(array $data)
    {
        foreach ($data as $name=>$datum)
        {

            if(property_exists($this,$name))
            {

                $this->{$name}=$datum;
            }

        }

    }




}