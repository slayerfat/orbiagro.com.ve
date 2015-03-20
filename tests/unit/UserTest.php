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

  public function testRelatedVisitsModel()
  {
    $this->assertNotEmpty($this->tester->visits);
    $this->assertGreaterThan(0, $this->tester->visits->first()->total);
  }

  public function testRelatedBillingsModel()
  {
    $this->assertNotEmpty($this->tester->billings);
    $this->assertEquals('Sin Banco Asociado', $this->tester->billings()->first()->bank->description);
    $this->assertEquals('Sin Tarjeta Asociada', $this->tester->billings()->first()->card_type->description);
  }

  public function testRelatedProductModel()
  {
    $this->assertNotEmpty($this->tester->Products);
    $this->assertGreaterThan(0, $this->tester->Products->first()->id);
  }

  public function testRelatedPurchaseModel()
  {
    $this->assertNotEmpty($this->tester->purchases);
    $this->assertGreaterThan(0, $this->tester->purchases->first()->quantity);
  }

}
