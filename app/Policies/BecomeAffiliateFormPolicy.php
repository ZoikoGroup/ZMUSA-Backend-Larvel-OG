<?php

namespace App\Policies;

use App\Models\User;
use App\Models\BecomeAffiliateForm;
use Illuminate\Auth\Access\HandlesAuthorization;

class BecomeAffiliateFormPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_become::affiliate::form');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, BecomeAffiliateForm $becomeAffiliateForm): bool
    {
        return $user->can('view_become::affiliate::form');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_become::affiliate::form');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, BecomeAffiliateForm $becomeAffiliateForm): bool
    {
        return $user->can('update_become::affiliate::form');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, BecomeAffiliateForm $becomeAffiliateForm): bool
    {
        return $user->can('delete_become::affiliate::form');
    }

    /**
     * Determine whether the user can bulk delete.
     */
    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_become::affiliate::form');
    }

    /**
     * Determine whether the user can permanently delete.
     */
    public function forceDelete(User $user, BecomeAffiliateForm $becomeAffiliateForm): bool
    {
        return $user->can('force_delete_become::affiliate::form');
    }

    /**
     * Determine whether the user can permanently bulk delete.
     */
    public function forceDeleteAny(User $user): bool
    {
        return $user->can('force_delete_any_become::affiliate::form');
    }

    /**
     * Determine whether the user can restore.
     */
    public function restore(User $user, BecomeAffiliateForm $becomeAffiliateForm): bool
    {
        return $user->can('restore_become::affiliate::form');
    }

    /**
     * Determine whether the user can bulk restore.
     */
    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any_become::affiliate::form');
    }

    /**
     * Determine whether the user can replicate.
     */
    public function replicate(User $user, BecomeAffiliateForm $becomeAffiliateForm): bool
    {
        return $user->can('replicate_become::affiliate::form');
    }

    /**
     * Determine whether the user can reorder.
     */
    public function reorder(User $user): bool
    {
        return $user->can('reorder_become::affiliate::form');
    }
}
