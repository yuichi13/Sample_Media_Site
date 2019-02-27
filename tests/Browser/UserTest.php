<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\User;

class UserTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testExample()
    {
        $user = factory(User::class)->create();
        
        $this->browse(function ($browser) use ($user) {
            $browser->visit('user/login')
                    ->type('email', $user->email)
                    ->type('pass', $user->password)
                    ->press('送信');
        });
        $this->browse(function (Broser $browser) {
            $browser->assertPathIs('user/mypage');
        });
    }
}
