<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RegisterTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * regist success test.
     *
     * @return void
     */
    public function testRegistSuccess()
    {
        $this->visit('/register')
             ->type('Test User', 'name')
             ->type('test-user@tesst.jp', 'email')
             ->type('password', 'password')
             ->type('password', 'password_confirmation')
             ->press('Register')
             ->seePageIs('/mypage');
    }

    public function testRegistReuqire()
    {
        $this->visit('/register')
             ->press('Register')
             ->see('The name field is required.')
             ->see('The email field is required.')
             ->see('The password field is required.')
             ->see('The name field is required.');
    }

    public function testRegistPasswordCheck()
    {
        $this->visit('/register')
             ->type('Test User', 'name')
             ->type('test-user@tesst.jp', 'email')
             ->type('password', 'password')
             ->type('passwor', 'password_confirmation')
             ->press('Register')
             ->see('The password confirmation does not match.');
    }


}
