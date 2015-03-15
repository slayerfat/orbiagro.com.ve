<?php

use App\Feature;

class FeatureTest extends \Codeception\TestCase\Test
{
  /**
   * @var \UnitTester
   */
  protected $tester;

  protected function _before()
  {
    $this->tester = Feature::first();
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

  public function testImageModel()
  {
    $this->assertNotEmpty($this->tester->images);
  }

  public function testFileModel()
  {
    $this->assertNotEmpty($this->tester->files);
  }

  public function testCorrectTitleFormat()
  {
    $this->assertEquals('tester', $this->tester->title);
    $this->tester->title = '';
    $this->assertNull($this->tester->title);
  }

  public function testCorrectDescriptionFormat()
  {
    $this->assertEquals('tester', $this->tester->description);
    $this->tester->description = '';
    $this->assertNull($this->tester->description);
  }

  public function testValidDescriptionSanitation()
  {
    $data = [
      '<script>DOOM</script>',
      '<iframe>DOOM</iframe>'
    ];
    foreach($data as $desc):
      $this->tester->description = $desc;
      $this->assertEquals('DOOM', $this->tester->description);
    endforeach;
    // DESARROLLAR
    $this->assertTrue(false);
  }

}
