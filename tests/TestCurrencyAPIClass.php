<?php
namespace app\tests;

use PHPUnit\Framework\TestCase;
use app\services\API\CurrencyAPI;


class TestCurrencyAPIClass extends TestCase
{
    public function testGetCurrencyListMethod()
    {
    	$data = (new CurrencyAPI())->getCountriesList();

    	$this->assertArrayHasKey('response', $data);

    	$data = $data['response'];

    	$this->assertArrayHasKey('results', $data);

    	$data = $data['results'];
        
        $this->assertNotEmpty($data);
    }

    public function testGetCountriesListMethod()
    {
    	$data = (new CurrencyAPI())->getCountriesList();
    	
    	$this->assertArrayHasKey('response', $data);

    	$data = $data['response'];

    	$this->assertArrayHasKey('results', $data);

    	$data = $data['results'];
        
        $this->assertNotEmpty($data);
    }

    public function testGetCurrencyConvertValue()
    {
    	$data = (new CurrencyAPI())->getCurrencyConvertValue('PLN', 'USD');

    	$this->assertArrayHasKey('response', $data);

    	$data = $data['response'];
    	$value = $data[array_keys($data)[0]];

    	$this->assertGreaterThan(0, $value);
    }

    public function testFakeCurrencyConvertValue()
    {
    	$data = (new CurrencyAPI())->getCurrencyConvertValue('PLN', 'ABC');

    	$this->assertArrayHasKey('response', $data);

    	$data = $data['response'];

    	$this->assertArrayNotHasKey('results', $data);
    }
}
?>