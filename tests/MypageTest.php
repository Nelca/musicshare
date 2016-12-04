<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\User;

class MypageTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @return void
     */
    public function testMypageTop()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user)
            ->visit('/mypage')
            ->see('Follow');
 
    }

    public function testLikePageWithoutLikes()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user)
            ->visit('/mypage/likes')
            ->see('There is nothing yet.');
    }
}
