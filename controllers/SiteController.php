<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use app\models\CalculatorForm;
use app\services\API\CurrencyAPI;

class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $model = new CalculatorForm();
        
        $data = [
            'model' => $model,
            'countries' => $this->_getCountriesData(),
        ];

        if ($model->load(Yii::$app->request->post()) && $model->validate())
        {
            $amount = floatval($model['value']);
            $fromCurrency = $model['baseCountry'];
            $toCurrency = $model['destinationCountry'];

            $results = $this->_getCurrencyConvertedValue($amount, $fromCurrency, $toCurrency);

            if (count($results))
            {
                $data['results'] = $results;

                $details = $this->_getCurrencyDetails([$fromCurrency, $toCurrency]);
                
                if (count($details))
                    $data['currencies'] = $details;
            }
            
        }

        return $this->render('index', $data);
    }

    /**
     * @param float $amount
     * @param string $fromCurrency
     * @param string $toCurrency
     * @return float
     */
    private function _getCurrencyConvertedValue($amount, $fromCurrency, $toCurrency)
    {
        if (!floatval($amount) || !$fromCurrency || !$toCurrency)
            return [];

        $data = (new CurrencyAPI())->getCurrencyConvertValue($fromCurrency, $toCurrency);

        if (!count($data['response']))
            return [];

        $value = $data['response'][array_keys($data['response'])[0]];

        return [
            'fromCurrency' => $fromCurrency,
            'toCurrency' => $toCurrency,
            'baseAmount' => $amount,
            'resultAmount' => round($amount * $value, 2),
        ];
    }

    /**
     * Get filtered countries data
     * 
     * @return array
     */
    private function _getCountriesData()
    {
        $data = (new CurrencyAPI())->getCountriesList();

        if (!isset($data) || !isset($data['response']['results']))
            return [];

        $data = $data['response']['results'];
        $countries = [];

        foreach ($data as $country)
        {
            $countries[$country['currencyId']] = $country['name'];
        }

        asort($countries);

        return $countries;
    }

    /**
     * @param array
     * @return array
     */
    private function _getCurrencyDetails($currencies)
    {
        if (!count($currencies))
            return [];

        $data = (new CurrencyAPI())->getCurrenciesList();

        if (!isset($data) || !isset($data['response']['results']))
            return [];

        $data = $data['response']['results'];

        $details = [];

        foreach ($currencies as $currency)
        {
            $details[$currency] = $data[$currency];
        }

        return $details;
    }
}
