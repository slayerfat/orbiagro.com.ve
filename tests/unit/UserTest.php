<?php
use App\User;

class UserTest extends \Codeception\TestCase\Test
{
  /**
   * @var \UnitTester
   */
  protected $tester;

  protected function _before()
  {
    $this->tester = User::where('name', 'tester')->first();
  }

  protected function _after()
  {
  }

  // tests

  public function testUserInModelNotNull()
  {
    $this->assertNotNull($this->tester);
  }

  public function testSeeMatchingNamesInUserModel()
  {
    $this->assertEquals('tester', $this->tester->name);
    $this->assertNotEquals('Neo', $this->tester->name);
  }

  public function testReturnTrueIfAdmin()
  {
    $this->assertTrue($this->tester->isAdmin());
  }

  public function testReturnfalseIfNotUser()
  {
    $this->assertfalse($this->tester->isUser());
  }

  public function testReturnfalseIfNotDisabled()
  {
    $this->assertfalse($this->tester->isDisabled());
  }

  public function testRelatedPersonModel()
  {
    $this->assertNotEmpty($this->tester->person);
    $this->assertEquals('Tester', $this->tester->person->first_name);
    $this->assertEquals('Tester', $this->tester->person->first_surname);
  }

  public function testRelatedDirectionModel()
  {
    $this->assertNotEmpty($this->tester->person->direction);
    $this->assertEquals(1, $this->tester->person->direction->first()->parish_id);
  }

  public function testRelatedProfileModel()
  {
    $this->assertNotEmpty($this->tester->profile);
    $this->assertEquals('Administrador', $this->tester->profile->description);
  }

  public function testRelatedGenderModel()
  {
    $this->assertNotEmpty($this->tester->person->gender);
    $this->assertEquals('Masculino', $this->tester->person->gender->description);
  }

  public function testRelatedNationalityModel()
  {
    $this->assertNotEmpty($this->tester->person->nationality);
    $this->assertEquals('Venezolano', $this->tester->person->nationality->description);
  }

  public function testRelatedProductVisitsModel()
  {
    $this->assertNotEmpty($this->tester->product_visits);
    $this->assertGreaterThan(0, $this->tester->product_visits->total);
  }

  public function testRelatedCategoryVisitsModel()
  {
    $this->assertNotEmpty($this->tester->category_visits);
    $this->assertGreaterThan(0, $this->tester->category_visits->total);
  }

  public function testRelatedBillingModel()
  {
    $this->assertNotEmpty($this->tester->Billing);
    $this->assertEquals('Sin Banco Asociado', $this->tester->billing->bank->description);
    $this->assertEquals('Sin Tarjeta Asociada', $this->tester->billing->card->description);
  }

  public function testRelatedProductModel()
  {
    $this->assertNotEmpty($this->tester->Products);
  }

  public function testRelatedBuyModel()
  {
    $this->assertNotEmpty($this->tester->buy);
    $this->assertGreaterThan(0, $this->tester->buy->quantity);
  }

}
