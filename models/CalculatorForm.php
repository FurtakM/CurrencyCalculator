<?php

namespace app\models;

use Yii;
use yii\base\Model;

class CalculatorForm extends Model
{
    public $value;
    public $baseCountry;
    public $destinationCountry;

    public function attributeLabels()
	{
	    return [
	        'value' => 'Amount',
	        'baseCountry' => 'Base Country',
	        'destinationCountry' => 'Destination Country',
	    ];
	}

    public function rules()
    {
        return [
            [['value', 'baseCountry', 'destinationCountry'], 'required'],
            [['value'], 'number', 'numberPattern' => '/^\s*[-+]?[0-9]*[.,]?[0-9]+([eE][-+]?[0-9]+)?\s*$/'],
        ];
    }
}