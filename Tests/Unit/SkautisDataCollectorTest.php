<?php

namespace Test\SkautisBundle;

use Skautis\Skautis;
use Skautis\Config;
use Skautis\User;
use Skautis\SessionAdapter\FakeAdapter;
use Skautis\Wsdl\WsdlManager;
use Skautis\Wsdl\WebServiceFactory;
use SkautisBundle\Profiler\SkautisDataCollector;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SkautisDataCollectorTest extends \PHPUnit_Framework_TestCase
{

    protected function makeSkautis()
    {
	$config = new Config('id123');
	$sessionAdapter = new FakeAdapter();
	$factory = new WebServiceFactory();
	$wsdlManager = new WsdlManager($factory, $config);
	$user = new user($wsdlManager, $sessionAdapter);

	return new Skautis($wsdlManager, $user);
    }


    public function testCollect()
    {
        $data = [
                'skautIS_Token' => 'tok_en',
		'skautIS_IDUnit' => 456,
		'skautIS_IDRole' => 789,
   		'skautIS_DateLogout' => '2. 12. 2014 23:56:02'
        ];

	$skautis = $this->makeSkautis();
	$skautis->setLoginData($data);

	$dataCollector = new SkautisDataCollector($skautis);
	$request = new Request();
	$response = new Response();
	$dataCollector->collect($request, $response);

	$this->assertEquals("id123", $dataCollector->app_id());
	$this->assertEquals("tok_en", $dataCollector->token());
	$this->assertEquals(false, $dataCollector->test_mode());
	$this->assertEquals(789, $dataCollector->role_id());
    }


    public function testSerialize()
    {
        $data = [
                'skautIS_Token' => 'tok_en',
		'skautIS_IDUnit' => 456,
		'skautIS_IDRole' => 789,
   		'skautIS_DateLogout' => '2. 12. 2014 23:56:02'
        ];

	$skautis = $this->makeSkautis();
	$skautis->setLoginData($data);

	$dataCollector = new SkautisDataCollector($skautis);
	$request = new Request();
	$response = new Response();
	$dataCollector->collect($request, $response);

	// Symfony uklada data do souboru -> vyzaduje serialize
	$serialized = serialize($dataCollector);
	unset($dataCollector);
	unset($skautis);

	$unserializedCollector = unserialize($serialized);
	$this->assertEquals("id123", $unserializedCollector->app_id());
	$this->assertEquals("tok_en", $unserializedCollector->token());
	$this->assertEquals(false, $unserializedCollector->test_mode());
	$this->assertEquals(789, $unserializedCollector->role_id());
    }
}
