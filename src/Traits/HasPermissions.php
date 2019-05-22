<?php

namespace RB28DETT\Permissions\Traits;

use RB28DETT\Permissions\Models\Permission;

trait HasPermissions
{
    /**
     * Return all the role permissions.
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'rb28dett_permission_role');
    }

    /**
     * Returns if the user has a permission.
     *
     * @param mixed $permision
     *
     * @return bool
     */
    public function hasPermission($permission)
    {
        $permission = !is_string($permission) ?: Permission::where(['slug' => $permission])->first();

        if ($permission) {
            foreach ($this->permissions as $p) {
                if ($p->id == $permission->id) {
                    return true;
                }
            }
        }

        return false;
    }
}
