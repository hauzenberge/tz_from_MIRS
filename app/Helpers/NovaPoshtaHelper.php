<?php

namespace App\Helpers;

class NovaPoshtaHelper
{
    private static $api_key = '';

    private static $url = 'https://api.novaposhta.ua/v2.0/json/';

    private static function request($modelName, $calledMethod, $params = null)
    {
        $data = [
            "apiKey" => self::$api_key,
            "modelName" => $modelName,
            "calledMethod" => $calledMethod
        ];
        
        if ($params != null) {
            $data["methodProperties"] = $params;            
        }
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => self::$url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: text/plain',
                'Cookie: PHPSESSID=tsclur3pqn6mt2e8itj6ns385p; YIICSRFTOKEN=61d1afc640894ccda1fe47bf4028dcccd6da987es%3A88%3A%22bkx1TjE1TUFpdE95MFFzaXo1OElUNHdSfnplbVY1RUiewYyDPuD-0j4lP3HV0kuo-i-NnBsgxCb064oShIK57g%3D%3D%22%3B'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        $success = json_decode($response, true)["success"];
        if ($success === true) {
            $return = collect(json_decode($response, true)['data']);
        } else {
            $return = json_decode($response, true)["success"];
        }
        return $return;
    }

    public static function getCities()
    {
        if (self::request("Address", "getCities") !== false) {
            $return = self::request("Address", "getCities");
        } else $return = 'Error';

        return $return;
    }
    
    public static function getWarehouses($cityName, $lang)
    {
        $params = [
            "CityName" => $cityName,
            "Page" => "1",
            "Limit" => "1000",
            "Language" => $lang
        ];

        return self::request("Address", "getWarehouses", $params);
    }
}
