<?php

namespace Source\Core;

class Service
{
    private static $instance;

    private function __construct()
    {
    }

    public static function getInstance(): Service
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function get(string $endpoint)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $endpoint,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6ImNvbnRhdG9Ad2ViYXYuY29tLmJyIn0=.0hZqrJNpMFOqMPtfWUMHGbaCbqxunhj9m/KAu2V6jv4='
            ),
        ));
        $response = curl_exec($curl);
        if ($response === false) {
            $error = curl_error($curl);
            echo "cURL error: " . $error . "\n";
        }
        curl_close($curl);
        return json_decode($response)->data[0];
    }
}
