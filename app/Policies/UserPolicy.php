<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    //$currentUser为当前登录用户实例
    public function update(User $currentUser, User $user)
    {
        return $currentUser->id === $user->id;
    }
    

}
