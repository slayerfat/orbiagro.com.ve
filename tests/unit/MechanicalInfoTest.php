<?php

use App\MechanicalInfo;

class MechanicalInfoTest extends \Codeception\TestCase\Test
{
  /**
   * @var \UnitTester
   */
  protected $tester;

  protected function _before()
  {
    $this->tester = MechanicalInfo::first();
    $this->data = ['', 'a', -1];
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

  public function testUserModel()
  {
    $this->assertNotEmpty($this->tester->product->user);
  }

  public function testCorrectCylindersFormat()
  {
    $this->assertEquals(1, $this->tester->cylinders);
    $this->tester->cylinders = '2';
    $this->assertEquals(2, $this->tester->cylinders);
    foreach($this->data as $value):
      $this->tester->cylinders = $value;
      $this->assertNull($this->tester->cylinders);
    endforeach;
  }

  public function testCorrectHorsepowerFormat()
  {
    $this->assertEquals(1, $this->tester->horsepower);
    $this->tester->horsepower = '2000';
    $this->assertEquals(2000, $this->tester->horsepower);
    $this->assertEquals('2.000 HP.', $this->tester->horsepower_hp());
    foreach($this->data as $value):
      $this->tester->horsepower = $value;
      $this->assertNull($this->tester->horsepower);
    endforeach;
  }

  public function testCorrectMileageFormat()
  {
    $this->assertEquals(1, $this->tester->mileage);
    $this->tester->mileage = '2';
    $this->assertEquals(2, $this->tester->mileage);
    foreach($this->data as $value):
      $this->tester->mileage = $value;
      $this->assertNull($this->tester->mileage);
    endforeach;
    $this->tester->mileage = 1000;
    $this->assertEquals(1000, $this->tester->mileage);
    $this->assertEquals('1.000 Km.', $this->tester->mileage_km());
  }

  public function testCorrectTractionFormat()
  {
    $this->assertEquals(1, $this->tester->traction);
    $this->tester->traction = '2000';
    $this->assertEquals(2000, $this->tester->traction);
    foreach($this->data as $value):
      $this->tester->traction = $value;
      $this->assertNull($this->tester->traction);
    endforeach;
  }

  public function testCorrectLiftFormat()
  {
    $this->assertEquals(1, $this->tester->lift);
    $this->tester->lift = '2000';
    $this->assertEquals(2000, $this->tester->lift);
    foreach($this->data as $value):
      $this->tester->lift = $value;
      $this->assertNull($this->tester->lift);
    endforeach;
  }


}
