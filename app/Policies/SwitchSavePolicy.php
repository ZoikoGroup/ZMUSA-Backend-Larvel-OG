<?php

namespace App\Policies;

use App\Models\User;
use App\Models\SwitchSave;
use Illuminate\Auth\Access\HandlesAuthorization;

class SwitchSavePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_switch::save');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, SwitchSave $switchSave): bool
    {
        return $user->can('view_switch::save');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_switch::save');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, SwitchSave $switchSave): bool
    {
        return $user->can('update_switch::save');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, SwitchSave $switchSave): bool
    {
        return $user->can('delete_switch::save');
    }

    /**
     * Determine whether the user can bulk delete.
     */
    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_switch::save');
    }

    /**
     * Determine whether the user can permanently delete.
     */
    public function forceDelete(User $user, SwitchSave $switchSave): bool
    {
        return $user->can('force_delete_switch::save');
    }

    /**
     * Determine whether the user can permanently bulk delete.
     */
    public function forceDeleteAny(User $user): bool
    {
        return $user->can('force_delete_any_switch::save');
    }

    /**
     * Determine whether the user can restore.
     */
    public function restore(User $user, SwitchSave $switchSave): bool
    {
        return $user->can('restore_switch::save');
    }

    /**
     * Determine whether the user can bulk restore.
     */
    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any_switch::save');
    }

    /**
     * Determine whether the user can replicate.
     */
    public function replicate(User $user, SwitchSave $switchSave): bool
    {
        return $user->can('replicate_switch::save');
    }

    /**
     * Determine whether the user can reorder.
     */
    public function reorder(User $user): bool
    {
        return $user->can('reorder_switch::save');
    }
}
