<?php
namespace Controllers;


class IndexTest extends \Codeception\TestCase\Test
{
  /**
   * @var \UnitTester
   */
  protected $tester;

  protected function _before()
  {
  }

  protected function _after()
  {
  }

  // tests
  public function testCantSeeIndexPage()
  {
    $this->tester->amOnPage('/');
    $this->tester->dontSee('Whoops, looks like something went wrong.');
    $this->tester->seeInCurrentUrl('/auth/login');
  }

  public function testCanSeeIndexPage()
  {
    $this->tester->amLoggedAs(['email' => 'tester@tester.com', 'password' => 'tester']);
    $this->tester->amOnPage('/');
    $this->tester->seeInCurrentUrl('/');
    $this->tester->dontSee('404');
  }

}
