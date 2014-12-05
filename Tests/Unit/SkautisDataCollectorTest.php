<?php

use Skautis\Skautis;
use SkautisBundle\Profiler\SkautisDataCollector;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SkautisDataCollectorTest extends \PHPUnit_Framework_TestCase
{
    public function testCollect()
    {
	$logoutDate = new \DateTime();

        $skautis = new Skautis("id123", false, true);
        $skautis->setToken("tok_en");
	$skautis->setUnitId(456);
	$skautis->setRoleId(789);
	$skautis->setLogoutDate($logoutDate);

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
	$logoutDate = new \DateTime();

        $skautis = new Skautis("id123", false, true);
        $skautis->setToken("tok_en");
	$skautis->setUnitId(456);
	$skautis->setRoleId(789);
	$skautis->setLogoutDate($logoutDate);

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
