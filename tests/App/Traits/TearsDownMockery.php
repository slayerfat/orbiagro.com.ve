<?php namespace Tests\App\Traits;

use \Mockery;

trait TearsDownMockery
{
    public function tearDown()
    {
        Mockery::close();

        unset($this->tester);
        unset($this->mock);

        parent::tearDown();
    }
}
