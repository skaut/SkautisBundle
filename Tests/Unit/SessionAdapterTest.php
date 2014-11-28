<?php

namespace Test\SkautisBundle;

use SkautisBundle\SessionAdapter as SymfonyAdapter;

use Symfony\Component\HttpFoundation\Session\Storage\MockArraySessionStorage;
use Symfony\Component\HttpFoundation\Session\Session as SymfonySession;

class SessionAdapterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @return void
     */
    public function testSymfonyAdapter()
    {
	$symfonySession = new SymfonySession(new MockArraySessionStorage());
	$adapter = new SymfonyAdapter($symfonySession);

        $name = "asd";
        $data = new \StdClass();

        $data->data['user_id'] = 123;
        $data->data['token'] = 'asdqwe';



        $this->assertFalse($adapter->has($name));

        $adapter->set($name, $data);

        $this->assertTrue($adapter->has($name));
        $this->assertEquals($data, $adapter->get($name));


        $object = $adapter->get($name);
        $this->assertEquals(123, $object->data['user_id']);
        $this->assertEquals("asdqwe", $object->data['token']);
    }
}
