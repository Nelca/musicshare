<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\User;

class MypageTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testMypageTop()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user)
            ->visit('/mypage')
            ->see('Follow');
 
    }
}
