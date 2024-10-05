<?php

namespace App\Policies;

use App\Models\User;

class ProductPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        
    }
    function update(User $user): bool {
        return $user->isAdministrator();
        }
        
}
