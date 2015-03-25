<?php

use App\Nutritional;

class NutritionalTest extends \Codeception\TestCase\Test
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    protected function _before()
    {
      $this->tester = Nutritional::first();
    }

    protected function _after()
    {
    }

    // tests
    public function testModelNotNull()
    {
      $this->assertNotNull($this->tester);
    }

    public function testProductModel()
    {
      $this->assertNotEmpty($this->tester->product);
    }

    public function testCorrectDateFormat()
    {
      $this->assertEquals('1999-09-09', $this->tester->due);
      $this->tester->due = '';
      $this->assertNull($this->tester->due);
    }

}
