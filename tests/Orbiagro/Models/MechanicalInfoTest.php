<?php namespace Tests\Orbiagro\Models;

use \Mockery;
use Tests\TestCase;
use Orbiagro\Models\Product;
use Orbiagro\Models\MechanicalInfo;
use Tests\Orbiagro\Traits\TearsDownMockery;

class MechanicalInfoTest extends TestCase
{

    use TearsDownMockery;

    /**
     * https://phpunit.de/manual/current/en/fixtures.html
     * @method setUp
     */
    public function setUp()
    {
        parent::setUp();

        $this->tester = new MechanicalInfo;
        $this->mock = Mockery::mock(MechanicalInfo::class)->makePartial();
    }

    public function testProductRelationship()
    {
        $this->mock
            ->shouldReceive('belongsTo')
            ->once()
            ->with(Product::class)
            ->andReturn('mocked');

        $this->assertEquals('mocked', $this->mock->product());
    }

    public function testCorrectFormattedCylinders()
    {
        $this->tester->cylinders = '2';
        $this->assertEquals(2, $this->tester->cylinders);
    }

    /**
     * @dataProvider defaultDataProvider
     */
    public function testIncorrectCylindersValueShouldBeNull($data)
    {
        $this->tester->cylinders = $data;
        $this->assertNull($this->tester->cylinders);
    }

    public function testCorrectFormattedHorsepower()
    {
        $this->tester->horsepower = '2000';
        $this->assertEquals(2000, $this->tester->horsepower);
        $this->assertEquals('2.000 HP.', $this->tester->horsepowerHP());
    }

    /**
     * @dataProvider defaultDataProvider
     */
    public function testIncorrectHorsepowerValueShouldBeNull($data)
    {
        $this->tester->horsepower = $data;
        $this->assertNull($this->tester->horsepower);
    }

    public function testCorrectFormattedMileage()
    {
        $this->tester->mileage = 1000;
        $this->assertEquals(1000, $this->tester->mileage);
        $this->assertEquals('1.000 Km.', $this->tester->mileageKm());
    }

    /**
     * @dataProvider defaultDataProvider
     */
    public function testIncorrectMileageValueShouldBeNull($data)
    {
        $this->tester->mileage = $data;
        $this->assertNull($this->tester->mileage);
    }

    public function testCorrectFormattedTraction()
    {
        $this->tester->traction = 1000;
        $this->assertEquals(1000, $this->tester->traction);
    }

    /**
     * @dataProvider defaultDataProvider
     */
    public function testIncorrectTractionValueShouldBeNull($data)
    {
        $this->tester->traction = $data;
        $this->assertNull($this->tester->traction);
    }

    public function testCorrectFormattedLift()
    {
        $this->tester->lift = 1000;
        $this->assertEquals(1000, $this->tester->lift);
    }

    /**
     * @dataProvider defaultDataProvider
     */
    public function testIncorrectLiftValueShouldBeNull($data)
    {
        $this->tester->lift = $data;
        $this->assertNull($this->tester->lift);
    }
}
