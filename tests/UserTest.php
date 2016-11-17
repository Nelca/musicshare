<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\User;

class UserTest extends TestCase
{

    use DatabaseTransactions;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testUsers()
    {
        $this->visit('/users/')
            ->see('Playlists')
            ->see('Favorites')
            ->see('User List');
    }

    public function testUserLink()
    {
        $user = factory(User::class)->create();
        $this->visit('/users/')
             ->click($user->name)
             ->seePageIs('/user/' . $user->id);
    }

    public function testUserPage()
    {
        $user = factory(User::class)->create();
        $this->visit('/user/' . $user->id)
             ->see('Follow')
             ->see('Follower')
             ->see($user->name);
    }

}
