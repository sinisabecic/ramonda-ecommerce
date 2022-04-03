<?php


use App\Account;
use App\Category;
use App\Country;
use App\Organization;
use App\User;
use App\Contact;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Account::create(['name' => 'Ramonda LLC']);
        Country::create(['name' => 'Montenegro', 'short_name' => 'ME']);
        Category::create(['name' => 'New', 'slug' => 'new']);
        Category::create(['name' => 'Games', 'slug' => 'games']);
        Category::create(['name' => 'Mobile phones', 'slug' => 'mobile-phones']);

        // Create Permissions
        $adminPermissions = [
            'admin_access',
            'permission_create',
            'permission_edit',
            'permission_show',
            'permission_delete',
            'permission_access',
            'user_create',
            'user_edit',
            'user_show',
            'user_delete',
            'user_access',
            'product_create',
            'product_show',
            'product_edit',
            'product_delete',
            'product_access',
            'role_create',
            'role_edit',
            'role_show',
            'role_delete',
            'role_access',
            'site_access',
        ];

        // Create Roles
        $role_admin = Role::create(['name' => 'Admin']);
        $role_user = Role::create(['name' => 'User']);

        foreach ($adminPermissions as $permission) {
            Permission::create(['name' => $permission]);
            $role_admin->givePermissionTo($permission);
        }

        // Add a user namely admin
        $admin = User::create([
            'account_id' => 1,
            'first_name' => 'Admin',
            'last_name' => 'Ramonda',
            'username' => 'admin',
            'email' => 'admin@ramonda.me',
            'password' => 'password', // Model has set password attribute method
            'country_id' => 1,
        ]);

        $user = User::create([
            'account_id' => 1,
            'first_name' => 'Ava',
            'last_name' => 'Rodriguez',
            'username' => 'ava',
            'email' => 'ava@ramonda.me',
            'password' => 'password', // Model has set password attribute method
            'country_id' => 1,
        ]);
        $user->photo()->create(['url' => 'default.png']);

        // Assign role admin to user admin
        $admin->assignRole($role_admin->name);
        $user->assignRole($role_user->name);

        // User::factory(10)
        //     ->create(['account_id' => $account->id])
        //     ->each(function ($user){
        //         $user->assignRole('User');
        //     });

//        $organizations = Organization::factory(100)
//            ->create(['account_id' => $account->id]);
//
//        Contact::factory(100)
//            ->create(['account_id' => $account->id])
//            ->each(function ($contact) use ($organizations) {
//                $contact->update(['organization_id' => $organizations->random()->id]);
//            });
    }
}
