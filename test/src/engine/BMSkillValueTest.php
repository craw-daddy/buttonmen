<?php

class BMSkillValueTest extends PHPUnit_Framework_TestCase {
    /**
     * @var BMSkillValue
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new BMSkillValue;
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    }

    /**
     * @covers BMSkillValue::score_value
     */
    public function testValue() {
        $die = BMDie::create(4);
        $die->add_skill('Value');
        $this->assertNull($die->value);

        $this->assertCount(2, $die->hookList);
        $this->assertEquals(array('score_value', 'capture'), array_keys($die->hookList));
        $this->assertEquals(array('BMSkillValue'), $die->hookList['score_value']);
        $this->assertEquals(array('BMSkillValue'), $die->hookList['capture']);
        $this->assertNull($die->get_scoreValueTimesTen());
        $die->captured = TRUE;
        $this->assertNull($die->get_scoreValueTimesTen());

        $die->captured = FALSE;
        $die->value = 3;
        $this->assertEquals(15, $die->get_scoreValueTimesTen());

        $die->captured = TRUE;
        $this->assertEquals(30, $die->get_scoreValueTimesTen());
    }
}

?>
