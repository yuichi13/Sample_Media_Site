<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;


class ExampleTest extends DuskTestCase
{
    /**
     * A basic browser test example.
     *
     * @return void
     */
    public function testBasicExample()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('user/login')
                    ->assertSee('ログイン')
                    ->type('email','example2@gmail.com')
                    ->type('pass', 'secret')
                    ->press('送信');
        });
    }
}
