<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserTest extends TestCase
{
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
        $this->visit('/users/')
             ->click('minato')
             ->seePageIs('/user/1');
    }

    public function testUserPage()
    {
        $this->visit('/user/1')
             ->see('Follow')
             ->see('Follower')
             ->see('Playlists')
             ->see('Favorites')
             ->see('View Songs');
    }
}
