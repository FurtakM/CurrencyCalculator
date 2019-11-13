<?php


namespace app\services\API;


abstract class API
{
    /**
     * @var string - auth key for API
     */
    protected $_key;

    /**
     * @var string $_baseUrl - base url using by API
     */
    protected $_baseUrl;

    /**
     * API constructor.
     * @param string $baseUrl
     * @param string $key
     */
    public function __construct($baseUrl = NULL, $key = NULL)
    {
        $this->_baseUrl = $baseUrl;
        $this->_key = $key;
    }

    /**
     * @param string $requestUrl
     * @return array
     */
    public function get($requestUrl)
    {
        if (!strlen($requestUrl))
        {
            return [
                'response' => [],
            ];
        }

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $requestUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "cache-control: no-cache"
            ],
        ]);

        $response = curl_exec($curl);
        $error = curl_error($curl);

        curl_close($curl);

        return [
            'response' => json_decode($response, true),
        ];
    }

    /**
     * @param string $prefix
     * @param array $params
     * @return string
     */
    protected function _buildUrl($prefix = NULL, $params = [])
    {
        if (count($params) == 0)
            return '';

        if (strlen($params['key']))
            $params[$params['key']] = $this->_key;

        $url = $this->_baseUrl .
               $prefix .
               '?' .
               http_build_query($params);

        return $url;
    }
}
