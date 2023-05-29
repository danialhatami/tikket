<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Collection;

class UserService
{

    public function allUsers(): Collection
    {
        return User::all();
    }
}
