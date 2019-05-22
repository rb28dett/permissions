<?php

/*
 * This file is part of RB28DETT Dashboard.
 *
 * (c) Erik Campobadal <soc@erik.cat>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RB28DETT\Permissions;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Facade;
use Illuminate\Support\Facades\Schema;
use RB28DETT\Permissions\Models\Permission;

/**
 * This is the PermissionCheck facade class.
 *
 * @author Erik Campobadal <soc@erik.cat>
 */
class PermissionsChecker extends Facade
{
    /**
     * Return all cached permissions.
     */
    public static function allCached()
    {
        return Cache::rememberForever('rb28dett_permissions', function () {
            return Permission::all();
        });
    }

    /**
     * Checks if the permisions exists and if they dont, they will be added.
     *
     * @param array $permissions
     */
    public static function check($permissions)
    {
        if (Schema::hasTable('rb28dett_permissions')) {
            foreach ($permissions as $permission) {
                if (!self::allCached()->contains('slug', $permission['slug'])) {
                    Cache::forget('rb28dett_permissions');
                    if (!self::allCached()->contains('slug', $permission['slug'])) {
                        Permission::create([
                            'name'        => $permission['name'],
                            'slug'        => $permission['slug'],
                            'description' => $permission['desc'],
                        ]);
                    }
                }
            }
        }
        session(['rb28dett_permissions::mandatory' => array_merge(static::mandatory(), $permissions)]);
    }

    /**
     * Returns the mandatory stored permissions so far. Not recommended.
     *
     * @return array
     */
    public static function mandatory()
    {
        $permission = session('rb28dett_permissions::mandatory');

        return $permission ? $permission : [];
    }

    /**
     * Returns the if the permission is stored as mandatory. Not recommended.
     *
     * @param string $slug
     *
     * @return bool
     */
    public static function isMandatory($slug)
    {
        return collect(static::mandatory())->contains('slug', $slug);
    }
}
