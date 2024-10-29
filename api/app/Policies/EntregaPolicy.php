<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\Entrega;
use App\Models\User;

class EntregaPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Entrega $entrega): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Entrega $entrega): bool
    {
        return $entrega->user()->is($user);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Entrega $entrega): bool
    {
        return $this->update($user, $entrega);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Entrega $entrega): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Entrega $entrega): bool
    {
        //
    }
}
