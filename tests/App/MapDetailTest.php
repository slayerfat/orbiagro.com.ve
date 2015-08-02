<?php namespace Tests\App;

use App\MapDetail;
use Tests\TestCase;

class MapDetailTest extends TestCase {

  /**
   * https://phpunit.de/manual/current/en/fixtures.html
   * @method setUp
   */
  public function setUp()
  {
    parent::setUp();

    $this->tester = new MapDetail;
  }

  public function testCorrectFormattedAttributes()
  {
    foreach (['longitude', 'latitude', 'zoom'] as $attr)
    {
      $this->tester->$attr = '1';
      $this->assertEquals(1, $this->tester->$attr);
    }
  }

  /**
   * @dataProvider dataProvider
   */
  public function testIncorrectAttributesValueShouldBeNull($data)
  {
    foreach (['longitude', 'latitude', 'zoom'] as $attr)
    {
      $this->tester->$attr = $data;
      $this->assertNull($this->tester->$attr);
    }
  }

  public function dataProvider()
  {
    return [
      [''],
      ['a'],
      [200],
      [-200]
    ];
  }

}
