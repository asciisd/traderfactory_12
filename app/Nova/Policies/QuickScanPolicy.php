<?php

namespace App\Nova\Policies;

use App\Models\Admin;
use App\Nova\Course;

class QuickScanPolicy
{
    protected string $key = 'QuickScan';

    public function before(Admin $admin, string $ability): ?bool
    {
        if ($admin->isSuper()) {
            return true;
        }

        return null;
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(Admin $admin): bool
    {
        return $admin->hasPermissionTo(__FUNCTION__.$this->key, 'admin');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(Admin $admin, Course $course): bool
    {
        return $admin->hasPermissionTo(__FUNCTION__.$this->key, 'admin');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(Admin $admin): bool
    {
        return $admin->hasPermissionTo(__FUNCTION__.$this->key, 'admin');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(Admin $admin, Course $course): bool
    {
        return $admin->hasPermissionTo(__FUNCTION__.$this->key, 'admin');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Admin $admin, Course $course): bool
    {
        return $admin->hasPermissionTo(__FUNCTION__.$this->key, 'admin');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(Admin $admin, Course $course): bool
    {
        return $admin->hasPermissionTo(__FUNCTION__.$this->key, 'admin');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(Admin $admin, Course $course): bool
    {
        return $admin->hasPermissionTo(__FUNCTION__.$this->key, 'admin');
    }
}
