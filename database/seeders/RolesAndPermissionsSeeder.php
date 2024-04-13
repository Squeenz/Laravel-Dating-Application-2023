<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Staff app permissions
        Permission::create(['name' => 'access dashboard']);
        Permission::create(['name' => 'access dashboard statistics']);

        //Users control
        Permission::create(['name' => 'view users']);
        Permission::create(['name' => 'view identities']);
        Permission::create(['name' => 'verify users']);
        Permission::create(['name' => 'delete users']);
        Permission::create(['name' => 'edit users']);

        //Reports control
        Permission::create(['name' => 'view reports']);
        Permission::create(['name' => 'close report']);

        //Suspensions control
        Permission::create(['name' => 'view suspensions']);
        Permission::create(['name' => 'suspend']);

        //Roles control
        Permission::create(['name' => 'assign role']);
        Permission::create(['name' => 'remove role']);
        Permission::create(['name' => 'view roles']);
        Permission::create(['name' => 'create roles']);
        Permission::create(['name' => 'edit roles']);
        Permission::create(['name' => 'delete roles']);

        //Pages controller control
        Permission::create(['name' => 'view pages controller']);
        Permission::create(['name' => 'add page controller']);
        Permission::create(['name' => 'edit page controller']);
        Permission::create(['name' => 'delete page controller']);

        //Pages control
        Permission::create(['name' => 'view page']);
        Permission::create(['name' => 'add page component']);
        Permission::create(['name' => 'edit page component']);
        Permission::create(['name' => 'delete page component']);

        //Policies control
        Permission::create(['name' => 'view policies']);
        Permission::create(['name' => 'create policy']);
        Permission::create(['name' => 'edit policy']);
        Permission::create(['name' => 'delete policy']);

        //Tickets control
        Permission::create(['name' => 'view tickets']);
        Permission::create(['name' => 'self assing ticket']);
        Permission::create(['name' => 'update tickets']);
        Permission::create(['name' => 'send ticket message']);

        //Normal app permissions
        Permission::create(['name' => 'use matchmaking']);
        Permission::create(['name' => 'add photos']);
        Permission::create(['name' => 'remove photos']);
        Permission::create(['name' => 'see matches']);
        Permission::create(['name' => 'use messages']);
        Permission::create(['name' => 'create report']);
        Permission::create(['name' => 'create ticket']);

        Role::create(['name' => 'admin'])
            ->givePermissionTo(Permission::all());

        Role::create(['name' => 'moderator'])
            ->givePermissionTo(['access dashboard', 'view tickets', 'access dashboard statistics', 'view users', 'view suspensions', 'edit users', 'delete users', 'view page', 'add page component', 'edit page component', 'delete page component', 'view pages controller', 'add page controller', 'edit page controller', 'delete page controller', 'view reports', 'view policies', 'create policy', 'edit policy', 'delete policy', 'suspend', 'close report', 'send ticket message', 'update tickets', 'self assing ticket']);

        Role::create(['name' => 'support'])
            ->givePermissionTo(['access dashboard', 'view identities', 'verify users', 'view tickets', 'view suspensions', 'view reports', 'suspend', 'view policies', 'close report', 'send ticket message', 'update tickets', 'self assing ticket']);

        Role::create(['name' => 'user'])
            ->givePermissionTo(['use matchmaking', 'create ticket', 'create report', 'send ticket message', 'add photos', 'remove photos', 'see matches', 'use messages']);

        Role::create(['name' => 'pending verification'])
            ->givePermissionTo(['create ticket', 'send ticket message']);

        Role::create(['name' => 'suspended'])
            ->givePermissionTo(['create ticket', 'send ticket message']);
    }
}
