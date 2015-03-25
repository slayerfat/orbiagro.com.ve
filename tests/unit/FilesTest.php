<?php

use App\File;

class FilesTest extends \Codeception\TestCase\Test
{
  /**
   * @var \UnitTester
   */
  protected $tester;

  protected function _before()
  {
    $this->tester  = File::first();
    $this->data    = ['', 'a', -1, 'dolares.bat'];
  }

  protected function _after()
  {
  }

  // tests
  public function testModelNotNull()
  {
    $this->assertNotNull($this->tester);
  }

  public function testPolymorphicModel()
  {
    $this->assertNotEmpty($this->tester->fileable_type);
    $this->assertNotEmpty($this->tester->fileable_id);
  }

  public function testPath()
  {
    $this->assertNotEmpty($this->tester->path);
    foreach($this->data as $path):
      $this->tester->path = $path;
      $this->assertNull($this->tester->path);
    endforeach;
  }

}
