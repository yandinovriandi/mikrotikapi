<?php

namespace App\Services\Impl;

use App\Services\PayDiSiniServiceInterface;

class PayDiSiniServiceImpl implements PayDiSiniServiceInterface
{

    const URL = 'https://paydisini.co.id/api/';

    static $apiKey;

    static array $cmd = [
        'order' => 'NewTransaction',
        'status' => 'StatusTransaction',
        'cancel' => 'CancelTransaction',
        'chanel' => 'PaymentChannel',
        'guide' => 'PaymentGuide',
        'call' => 'CallbackStatus'
    ];

    public function __construct($apiKey)
    {
        Paydisini::$apiKey = $apiKey;
    }

    public function transaction($code, $service, $amount, $note = null, $wallet = null)
    {
        return Paydisini::Request(self::URL, [
            'key' => Paydisini::$apiKey,
            'request' => 'new',
            'unique_code' => $code,
            'service' => $service,
            'amount' => $amount,
            'note' => $note,
            'valid_time' => 10800,
            'ewallet_phone' => $wallet,
            'type_fee' => 2,
            'signature' => md5(
                Paydisini::$apiKey .
                $code .
                $service .
                $amount .
                '10800' .
                self::$cmd['order']
            )
        ]);
    }

    public function status($code)
    {
        return Paydisini::Request(self::URL, [
            'key' => Paydisini::$apiKey,
            'request' => 'status',
            'unique_code' => $code,
            'signature' => md5(
                Paydisini::$apiKey .
                $code .
                self::$cmd['status']
            )
        ]);
    }

    public function chanel()
    {
        return Paydisini::Request(self::URL, [
            'key' => Paydisini::$apiKey,
            'request' => 'payment_channel',
            'signature' => md5(
                Paydisini::$apiKey .
                self::$cmd['chanel']
            )
        ]);
    }

    public function guide($service)
    {
        return Paydisini::Request(self::URL, [
            'key' => Paydisini::$apiKey,
            'request' => 'payment_guide',
            'service' => $service,
            'signature' => md5(
                Paydisini::$apiKey .
                $service .
                self::$cmd['guide']
            )
        ]);
    }

    /**
     * @throws \Exception
     */
    public static function Request($url, $params = [])
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($params));
        curl_setopt($curl, CURLOPT_ENCODING, 'gzip, deflate');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        if (curl_errno($curl)) {
            throw new \Exception('[ERROR] Cannot get server response!');
        } else {
            $result = curl_exec($curl);
            curl_close($curl);
            return json_decode($result, true);
        }
    }
}
