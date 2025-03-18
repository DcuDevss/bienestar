<?php

namespace App\Policies;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Auth\Access\HandlesAuthorization;

class RolePolicy
{
    use HandlesAuthorization;
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function canDeleteRole(User $user, Role $role){
        return true;
       return $user->can('roles.destroy','roles.update','roles.edit') && $role->id>12;
    }
}
