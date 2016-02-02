<?php
namespace sideshow_bob\Model\Connection;

class ConnectionManagerTest extends \PHPUnit_Framework_TestCase
{
    public function testConnectionNotFound()
    {
        $this->setExpectedException(__NAMESPACE__ . "\\ConnectionManagerException");
        $this->assertEmpty(ConnectionManager::get("non-existing"));
    }

    public function testDefaultConnectionFound()
    {
        ConnectionManager::add("default");
        $this->assertEquals("default", ConnectionManager::get());
    }

    public function testCustomConnectionFound()
    {
        ConnectionManager::add("custom", "custom");
        $this->assertEquals("custom", ConnectionManager::get("custom"));
    }

    public function testAddAndGetConnection()
    {
        ConnectionManager::add("custom2", "custom2");
        $this->assertEquals("custom2", ConnectionManager::get("custom2"));
    }

    public function testClosureConnection()
    {
        ConnectionManager::add(
            function () {
                return "closure";
            },
            "closure"
        );
        $this->assertEquals("closure", ConnectionManager::get("closure"));
    }
}
