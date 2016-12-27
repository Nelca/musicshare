<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\User;

class AuthTest extends TestCase
{
    //use DatabaseTransactions;

    public function testLoginValidate()
    {
        $this->visit('/login')
            ->press('Login')
            ->see('The email field is required.')
            ->see('The password field is required.')
            ->type('test@test.jp', 'email')
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
        $user->name = "testUser";
        $user->email = "test_b@test.jp";
        $user->password = '$2y$10$XtSdROCcDTG7XuaC.4A0reMY/hD/cOmV8txPkUdRvUbNgZqgjPad.';
        $user->save();
        $this->visit('/login')
            ->type($user->email, 'email')
            ->type("password", 'password')
            ->press('Login')
            ->seePageIs('/mypage');
    }
}
