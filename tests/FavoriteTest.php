<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\User;
use App\Favorite;
//use Youtube;

class FavoriteTest extends TestCase
{
    use DatabaseTransactions;

    public function testNoLoginUser()
    {
        $this->visit('/favorites')
            ->seePageIs('/login');
    }

    public function testDefaultPage()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user)
            ->visit('favorites')
            ->see('There is nothing yet.');
    }
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testAddFav()
    {
        $user = factory(User::class)->create();
        $favName = "favoriteTest";
        $favUrl = "https://www.youtube.com/watch?v=ZABXtVxyJwg&t=137s";
        $this->actingAs($user)
             ->visit('/favorites')
             ->type($favName, 'name')
             ->type($favUrl, 'url')
             ->press('Add Favorite')
             ->seePageIs('/favorites')
             ->see($favName);
    }

    public function testAddFavWithoutName()
    {
        $user = factory(User::class)->create();

        $favSongKey = 'ZABXtVxyJwg&t=137s';
        //$songData = Youtube::getVideoInfo($favSongKey);
        //$favName = $songData->snippet->title; 
        $favUrl = "https://www.youtube.com/watch?v=" . $favSongKey;

        $this->actingAs($user)
             ->visit('/favorites')
             ->type($favUrl, 'url')
             ->press('Add Favorite')
             ->seePageIs('/favorites');
    }


    public function testValidateInput()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user)
             ->visit('/favorites')
             ->press('Add Favorite')
             ->see('url field is required');

    }

    public function testFavLikeUnlike()
    {
        $user = factory(User::class)->create();
        $uid = $user->id;

        $favName = "favoriteTest";
        $favUrl = "https://www.youtube.com/watch?v=ZABXtVxyJwg&t=137s";
        $favorite = $user->favorites()->create([
            'name' => $favName
            , 'url' => $favUrl
        ]);
        $favId = $favorite->id;
        $this->actingAs($user)
            ->visit('/favorites')
            ->see($favName)
            ->press('like-favorite-' . $favId)
            ->seeInDatabase('evaluates',[
                'user_id' => $uid
                , 'evaluation' => 1
                , 'evaluatable_id' => $favId
                , 'evaluatable_type' => 'App\Favorite'
            ])
            ->visit('/favorites')
            ->press('liked-favorite-' . $favId)
            ->seePageIs('/favorites');
        $this->afterTestDeleteFav($user, $favorite);
    }

    public function afterTestDeleteFav(User $user, Favorite $favorite)
    {
        $this->actingAs($user)
            ->visit('/favorites')
            ->see($favorite->name)
            ->press('delete-favorite-' . $favorite->id)
            ->seePageIs('/favorites');
    }
}
