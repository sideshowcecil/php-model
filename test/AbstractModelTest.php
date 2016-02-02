<?php
namespace sideshow_bob\Model;

class AbstractModelTest extends \PHPUnit_Framework_TestCase
{
    private $record;

    protected function setUp()
    {
        $this->record = new PartialTestModel();
    }

    public function testNewlyCreatedRecord()
    {
        $record = new PartialTestModel();
        $this->assertTrue($record->isNew());
        $this->assertFalse($record->isDirty());
    }

    public function testExistingRecord()
    {
        $record = new PartialTestModel(false);
        $this->assertFalse($record->isNew());
        $this->assertFalse($record->isDirty());
    }

    public function testPrivateProperty()
    {
        $record = new PartialTestModel();
        $record->x = "test";
        $this->assertEquals("test", $record->x);
    }

    public function testProtectedProperty()
    {
        $record = new PartialTestModel();
        $record->y = "test";
        $this->assertEquals("test", $record->y);
    }

    public function testPublicProperty()
    {
        $record = new PartialTestModel();
        $record->z = "test";
        $this->assertEquals("test", $record->z);
    }

    public function testDirtyAttributes()
    {
        $record = new PartialTestModel();
        $record->x = "test";
        $this->assertTrue($record->isDirty());
    }
}
