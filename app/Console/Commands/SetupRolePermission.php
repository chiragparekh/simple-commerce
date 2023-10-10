<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class SetupRolePermission extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'commerce:setup-role-permission';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Setup roles and permissions';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $adminRole = Role::create([
            'name' => 'admin'
        ]);

        $customerRole = Role::create([
            'name' => 'customer'
        ]);

        $createCategoryPermission = Permission::create(['name' => 'create category']);
        $updateCategoryPermission = Permission::create(['name' => 'update category']);
        $deleteCategoryPermission = Permission::create(['name' => 'delete category']);
        $viewCategoryPermission = Permission::create(['name' => 'view category']);

        $adminRole->syncPermissions([
            $createCategoryPermission,
            $updateCategoryPermission,
            $deleteCategoryPermission,
            $viewCategoryPermission,
        ]);

        $customerRole->syncPermissions([
            $viewCategoryPermission,
        ]);
    }
}
