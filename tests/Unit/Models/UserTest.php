<?php

namespace Tests\Unit\Models;

use App\Models\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    /** @test */
    public function it_has_fillable_attributes()
    {
        $fillable = ['name', 'email', 'password'];

        $user = new User();

        $this->assertEquals($fillable, $user->getFillable());
    }

    /** @test */
    public function it_has_hidden_attributes()
    {
        $hidden = ['password', 'remember_token'];

        $user = new User();

        $this->assertEquals($hidden, $user->getHidden());
    }

    /** @test */
    public function it_has_casts_attributes()
    {
        $casts = [
            "id" => "int",
            "email_verified_at" => "datetime",
            "password" => "hashed",
        ];

        $user = new User();

        $this->assertEquals($casts, $user->getCasts());
    }
}
