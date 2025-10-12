<?php

namespace App\Policies;

use App\Models\State;
use App\Models\User;

class StatePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(?User $user): bool
    {
        // Anyone can view states (including guests)
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(?User $user, State $state): bool
    {
        // Anyone can view a state (including guests)
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Default deny - admin users bypass via Gate::before
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, State $state): bool
    {
        // Default deny - admin users bypass via Gate::before
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, State $state): bool
    {
        // Default deny - admin users bypass via Gate::before
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, State $state): bool
    {
        // Default deny - admin users bypass via Gate::before
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, State $state): bool
    {
        // Default deny - admin users bypass via Gate::before
        return false;
    }
}
