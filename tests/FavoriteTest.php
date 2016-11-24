<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\User;

class FavoriteTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testShowFavPage()
    {
        $user = factory(User::class)->create();
        $favName = "favoriteTest";
        $favUrl = "https://www.youtube.com/watch?v=ZABXtVxyJwg&t=137s";
        $this->actingAs($user)
             ->visit('/favorites')
             ->type($favName, 'name')
             ->type($favUrl, 'url')
             ->seePageIs('/favorites');
    }
}
