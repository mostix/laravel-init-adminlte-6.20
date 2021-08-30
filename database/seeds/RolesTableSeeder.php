<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $roles = config('roles.roles');

      foreach ($roles as $roleName) {
        if (!Role::where('name', $roleName)->first()) {
          $role = Role::create(['name' => $roleName]);
          $this->command->info("Role: ".$roleName." save in db");
        } else {
          $this->command->comment("Role: ".$roleName." already exist in DB");
        }
      }

      $permissions = config('roles.permissions');

      foreach ($permissions as $roleName => $permsArray) {

        $role = Role::where('name', $roleName)->first();

        if (!$role) {
          $this->command->error($roleName . " does not exists in DB! continue..");
          continue;
        }

        foreach ($permsArray as $permission) {
          $permissionModel = Permission::where('name', $permission)->first();

          if (!$permissionModel) {
            $permissionModel = Permission::create(['name' => $permission]);
            $this->command->info("Permission $permission was created in db");
          }

          if (!$role->hasPermissionTo($permissionModel)) {
            $role->givePermissionTo($permissionModel);
            $this->command->info("Permission $permission was assigned to role $role->name");
          } else {
            $this->command->comment("Role $role->name already has perm. $permission");
          }

        }

      }
    }
}
