<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\User;

class AuthTest extends TestCase
{
    use DatabaseTransactions;

    private $testUserName = "testUser";
    private $testUserEmail = "asdf@asdf.jp";
    private $testUserPassword = "password";
    private $testUserEncodedPass = '$2y$10$XtSdROCcDTG7XuaC.4A0reMY/hD/cOmV8txPkUdRvUbNgZqgjPad.';

    public function testLoginValidate()
    {
        $this->visit('/login')
            ->press('Login')
            ->see('The email field is required.')
            ->see('The password field is required.')
            ->type($this->testUserEmail, 'email')
            ->press('Login')
            ->see('The password field is required.')
            ->type('', 'email')
            ->type("testUser", 'password')
            ->press('Login')
            ->see('The email field is required.');
    }
    public function testUserLogin()
    {
        $user = new User();
        $user->name = $this->testUserName;
        $user->email = $this->testUserName;
        $user->password = $this->testUserEncodedPass;
        $user->save();
        $this->visit('/login')
            ->type($user->email, 'email')
            ->type($this->testUserPassword, 'password')
            ->press('Login')
            ->seePageIs('/mypage');
    }

    public function testRegistValidate()
    {
        $this->visit('/register')
            ->press('Register')
            ->see('The name field is required.')
            ->see('The email field is required.')
            ->see('The password field is required.');
    }
    public function testRegistUser()
    {
        $this->visit('/register')
            ->type($this->testUserName, 'name')
            ->type($this->testUserEmail, 'email')
            ->type($this->testUserPassword, 'password')
            ->type($this->testUserPassword, 'password_confirmation')
            ->press('Register')
            ->seePageIs('/mypage')
            ->seeInDatabase('users',[
                'name' => $this->testUserName
                , 'email' => $this->testUserEmail
                // cant't check because escaped.
                //, 'password' => $this->testUserEncodedPass
            ]);
    }
}
