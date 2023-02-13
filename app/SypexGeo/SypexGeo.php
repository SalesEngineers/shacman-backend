<?php

namespace App\SypexGeo;

class SypexGeo
{
    /**
     * @var SxGeo
     */
    private $sypex;
    /**
     * @var array
     */
    private $config;
    /**
     * @var string $ip remote client IP-address
     */
    public $ip = '';
    /**
     * @var int $ipAsLong remote client IP-address as integer value
     */
    public $ipAsLong = 0;
    /**
     * @var array $city geo information about city
     */
    public $city = [];
    /**
     * @var array $region geo information about region
     */
    public $region = [];
    /**
     * @var array $country geo information about country
     */
    public $country = [];

    /**
     * SypexGeo constructor.
     *
     * @param SxGeo $sypex
     * @param array $config
     */
    public function __construct(SxGeo $sypex, array $config)
    {
        $this->sypex  = $sypex;
        $this->config = $config;
    }

    /**
     * @param string|null $ip
     *
     * @return array
     */
    public function get(?string $ip = null)
    {
        $result = $this->config['default'];

        if (is_null($ip)) {
            $ip = $this->getIP();
        } elseif (!filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
            return $this->prepareResult($result);
        }

        $this->ip       = $ip;
        $this->ipAsLong = sprintf('%u', ip2long($ip));

        $data = $this->sypex->getCityFull($this->ip);

        if ($data !== false) {
            $result = $data;
        }

        return is_array($result) ? $this->prepareResult($result) : $result;
    }

    /**
     * @param array $result
     *
     * @return array
     */
    protected function prepareResult(array $result)
    {
        if (isset($result['city']))
            $this->city = $result['city'];

        if (isset($result['region']))
            $this->region = $result['region'];

        if (isset($result['country']))
            $this->country = $result['country'];

        return $result;
    }

    /**
     * Detect client IP address
     *
     * @return string IP
     */
    public function getIP()
    {
        if(getenv('HTTP_CLIENT_IP'))
            $ip = getenv('HTTP_CLIENT_IP');
        elseif(getenv('HTTP_X_FORWARDED_FOR'))
            $ip = getenv('HTTP_X_FORWARDED_FOR');
        elseif(getenv('HTTP_X_FORWARDED'))
            $ip = getenv('HTTP_X_FORWARDED');
        elseif(getenv('HTTP_FORWARDED_FOR'))
            $ip = getenv('HTTP_FORWARDED_FOR');
        elseif(getenv('HTTP_FORWARDED'))
            $ip = getenv('HTTP_FORWARDED');
        else
            $ip = getenv('REMOTE_ADDR');

        return $ip;
    }
}
