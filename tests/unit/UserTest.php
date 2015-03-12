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
      $this->user = User::where('name', 'tester')->first();
    }

    protected function _after()
    {
    }

    // tests
    public function testSeeMatchingNamesInUserModel()
    {
      $this->assertEquals('tester', $this->user->name);
      $this->assertNotEquals('neo', $this->user->name);
    }

    public function testReturnTrueIfAdmin()
    {
      $this->assertTrue($this->user->isAdmin());
    }

    public function testReturnfalseIfNotUser()
    {
      $this->assertfalse($this->user->isUser());
    }

    public function testReturnfalseIfNotDisabled()
    {
      $this->assertfalse($this->user->isDisabled());
    }

    public function testRelatedPersonModel()
    {
      $this->assertNotEmpty($this->user->person);
      $this->assertEquals('tester', $this->user->person->first_name);
    }

    public function testRelatedDirectionModel()
    {
      $this->assertNotEmpty($this->user->person->direction);
      $this->assertEquals(1, $this->user->person->direction->parish_id);
    }

    public function testRelatedProfileModel()
    {
      $this->assertNotEmpty($this->user->person->profile);
      $this->assertEquals('Administrador', $this->user->profile->description);
    }

    public function testRelatedGenderModel()
    {
      $this->assertNotEmpty($this->user->person->gender);
      $this->assertEquals('Masculino', $this->user->person->gender->description);
    }

    public function testRelatedNationalityModel()
    {
      $this->assertNotEmpty($this->user->person->nationality);
      $this->assertEquals('Venezolano', $this->user->person->nationality->description);
    }

    public function testRelatedProductVisitsModel()
    {
      $this->assertNotEmpty($this->user->product_visits);
      $this->assertGreaterThan(0, $this->user->product_visits->total);
    }

    public function testRelatedCategoryVisitsModel()
    {
      $this->assertNotEmpty($this->user->category_visits);
      $this->assertGreaterThan(0, $this->user->category_visits->total);
    }

    public function testRelatedBillingModel()
    {
      $this->assertNotEmpty($this->user->Billing);
      $this->assertEquals('Sin Banco Asociado', $this->user->billing->bank->description);
      $this->assertEquals('Sin Tarjeta Asociada', $this->user->billing->card->description);
    }

    public function testRelatedBuyModel()
    {
      $this->assertNotEmpty($this->user->buy);
      $this->assertGreaterThan(0, $this->user->buy->quantity);
    }

}
