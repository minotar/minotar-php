<?php
/**
 * Created by PhpStorm.
 * User: Connor
 * Date: 3/8/14
 * Time: 1:39 AM
 */

namespace Minotar;


class MinotarDl
{

    /**
     * URL to the base of Minotar's server
     */
    const BASE_URL = 'https://minotar.net/';

    /**
     * Response code required to say "okay" on the image
     */
    const CODE_OKAY = 200;

    public static function makeUrl($path)
    {
        $minotar = rtrim(self::BASE_URL, '/');
        $path = trim($path, '/');

        return $minotar . '/' . $path;
    }

    /**
     * Downloads a path via Curl
     * @param $config array
     * @param $path string
     * @return bool|mixed
     */
    public function download($config, $path)
    {
        $this->checksIfHasCurl();

        $ch = curl_init(self::makeUrl($path));
        curl_setopt($ch, CURLOPT_TIMEOUT, $config['timeout']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $data = curl_exec($ch);

        if (curl_getinfo($ch, CURLINFO_HTTP_CODE) != self::CODE_OKAY) {
            curl_close($ch);
            return false;
        }

        curl_close($ch);
        return $data;
    }

    /**
     * Throws an exception is Curl isn't installed on the system
     * @throws Exception\MissingExtensionException
     */
    protected function checksIfHasCurl()
    {
        if (!function_exists('curl_version')) {
            throw new Exception\MissingExtensionException('You must have Curl installed in order to retrieve Minotars.');
        }
    }
}
