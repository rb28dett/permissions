<?php

namespace RB28DETT\Permissions;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use RB28DETT\Permissions\Models\Permission;
use RB28DETT\Permissions\Policies\PermissionPolicy;

class PermissionsServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Permission::class => PermissionPolicy::class,
    ];

    /**
     * The mandatory permissions for the module.
     *
     * @var array
     */
    protected $permissions = [
        [
            'name' => 'Permissions Access',
            'slug' => 'rb28dett::permissions.access',
            'desc' => 'Grants access to rb28dett/permissions module',
        ],
        [
            'name' => 'Create Permissions',
            'slug' => 'rb28dett::permissions.create',
            'desc' => 'Allows creating permissions',
        ],
        [
            'name' => 'Update Permissions',
            'slug' => 'rb28dett::permissions.update',
            'desc' => 'Allows updating permissions',
        ],
        [
            'name' => 'Delete Permissions',
            'slug' => 'rb28dett::permissions.delete',
            'desc' => 'Allows delete permissions',
        ],
    ];

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        $this->loadViewsFrom(__DIR__.'/Views', 'rb28dett_permissions');
        $this->loadTranslationsFrom(__DIR__.'/Translations', 'rb28dett_permissions');

        if (!$this->app->routesAreCached()) {
            require __DIR__.'/Routes/web.php';
        }

        $this->loadMigrationsFrom(__DIR__.'/Migrations');

        // Make sure the permissions are OK
        PermissionsChecker::check($this->permissions);
    }

    /**
     * I cheated this comes from the AuthServiceProvider extended by the App\Providers\AuthServiceProvider.
     *
     * Register the application's policies.
     *
     * @return void
     */
    public function registerPolicies()
    {
        foreach ($this->policies as $key => $value) {
            Gate::policy($key, $value);
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
    }
}
