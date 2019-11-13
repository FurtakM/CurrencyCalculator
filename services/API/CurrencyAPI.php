<?php


namespace app\services\API;

use Yii;
use app\services\API\API;

class CurrencyAPI extends API
{
    /**
     * using: https://www.currencyconverterapi.com/docs
     */

    const API_BASE_URL = 'https://free.currconv.com/api/v7/';

    /**
     * example: https://free.currconv.com/api/v7/convert?q=USD_PLN&compact=ultra&apiKey=key
     */

    /**
     * @var string - auth key for API
     */
    protected $_key;

    /**
     * @var string $_baseUrl - base url using by API
     */
    protected $_baseUrl;

    /**
     * CurrencyAPI - constructor
     * @param string $baseUrl
     * @param string $key
     */
    public function __construct($baseUrl = NULL, $key = NULL)
    {
        $this->_baseUrl = (strlen($baseUrl)) ? $baseUrl : self::API_BASE_URL;
        $this->_key = (strlen($key)) ? $key : (string) Yii::$app->params['currencyAPIKey'];

        parent::__construct($this->_baseUrl, $this->_key);
    }

    /**
     * @return array
     */
    public function getCountriesList()
    {
        $prefix = 'countries';

        $params = [
            'key' => 'apiKey',
        ];

        return parent::get(parent::_buildUrl($prefix, $params));
    }

    /**
     * @return array
     */
    public function getCurrenciesList()
    {
        $prefix = 'currencies';

        $params = [
            'key' => 'apiKey',
        ];

        return parent::get(parent::_buildUrl($prefix, $params));
    }

    /**
     * @return array
     */
    public function getCurrencyConvertValue($fromCurrency, $toCurrency)
    {
        $prefix = 'convert';

        $fromCurrency = urlencode($fromCurrency);
        $toCurrency = urlencode($toCurrency);

        $params = [
            'q' => $fromCurrency . '_' . $toCurrency,
            'compact' => 'ultra',
            'key' => 'apiKey',
        ];

        return parent::get(parent::_buildUrl($prefix, $params));
    }
}
